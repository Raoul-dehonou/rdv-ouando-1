<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Disponibilite;
use App\Mail\RendezVousConfirmation;
use App\Notifications\RappelRendezVousNotification;
use Carbon\Carbon;

class RendezVousController extends Controller
{
    private function getPatient()
    {
        $user = Auth::user();
        $patient = $user->patient;
        if (!$patient) {
            $patient = $user->patient()->create();
        }
        return $patient;
    }

    public function create()
    {
        $this->getPatient();
        $medecins = Medecin::where('is_active', true)
            ->with('user')
            ->get();
        
        return view('patient.rendez-vous.create', compact('medecins'));
    }

    public function getMedecinsBySpecialite(Request $request)
    {
        $medecins = Medecin::where('specialite', $request->specialite)
            ->where('is_active', true)
            ->with('user')
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'nom' => $m->user->name,
                'specialite' => $m->specialite
            ]);
        return response()->json($medecins);
    }

    public function getCreneauxPublic($medecinId)
    {
        $medecin = Medecin::where('is_active', true)->find($medecinId);
        
        if (!$medecin) {
            return response()->json([]);
        }
        
        $today = now()->startOfDay();

        $disponibilites = Disponibilite::where('medecin_id', $medecinId)
            ->where('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->get();

        if ($disponibilites->isEmpty()) {
            return response()->json([]);
        }

        $rendezvousPris = RendezVous::where('medecin_id', $medecinId)
            ->where('date', '>=', $today)
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->get()
            ->mapWithKeys(function ($rdv) {
                $dateKey = $rdv->date instanceof Carbon ? $rdv->date->format('Y-m-d') : date('Y-m-d', strtotime($rdv->date));
                $heureKey = substr($rdv->heure, 0, 5);
                return [$dateKey . '|' . $heureKey => true];
            });

        $creneaux = [];
        $seen = [];

        foreach ($disponibilites as $dispo) {
            $date = $dispo->date instanceof Carbon ? $dispo->date->format('Y-m-d') : date('Y-m-d', strtotime($dispo->date));
            $debut = Carbon::parse($dispo->heure_debut);
            $fin = Carbon::parse($dispo->heure_fin);
            $duree = $dispo->duree ?: 30;

            while ($debut < $fin) {
                $heure = $debut->format('H:i');
                $key = $date . '|' . $heure;

                if (!isset($rendezvousPris[$key]) && !in_array($key, $seen)) {
                    $dateTime = Carbon::parse($date . ' ' . $heure);
                    if ($dateTime->isFuture() || $dateTime->isToday()) {
                        $creneaux[] = [
                            'date' => $date,
                            'heure_debut' => $heure,
                            'heure_fin' => $debut->copy()->addMinutes($duree)->format('H:i'),
                        ];
                        $seen[] = $key;
                    }
                }
                $debut->addMinutes($duree);
            }
        }

        usort($creneaux, fn($a, $b) => $a['date'] . $a['heure_debut'] <=> $b['date'] . $b['heure_debut']);
        
        return response()->json($creneaux);
    }

    public function getCreneauxDisponibles(Request $request)
    {
        $medecinId = $request->get('medecin_id');
        $date = $request->get('date');

        if (!$medecinId || !$date) {
            return response()->json([], 400);
        }

        $medecin = Medecin::where('is_active', true)->find($medecinId);
        if (!$medecin) {
            return response()->json([], 404);
        }

        $disponibilites = Disponibilite::where('medecin_id', $medecinId)
            ->whereDate('date', $date)
            ->where('is_active', true)
            ->orderBy('heure_debut')
            ->get();

        if ($disponibilites->isEmpty()) {
            return response()->json([]);
        }

        $rendezvousPris = RendezVous::where('medecin_id', $medecinId)
            ->whereDate('date', $date)
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->pluck('heure')
            ->map(fn($h) => substr($h, 0, 5))
            ->toArray();

        $creneaux = [];
        foreach ($disponibilites as $dispo) {
            $debut = Carbon::parse($dispo->heure_debut);
            $fin = Carbon::parse($dispo->heure_fin);
            $duree = $dispo->duree ?? 30;
            while ($debut < $fin) {
                $heure = $debut->format('H:i');
                if (!in_array($heure, $rendezvousPris)) {
                    $creneaux[] = ['heure' => $heure];
                }
                $debut->addMinutes($duree);
            }
        }

        return response()->json($creneaux);
    }

    public function store(Request $request)
    {
        \Log::info('Tentative de création rendez-vous', $request->all());

        $patient = $this->getPatient();

        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date'       => 'required|date|after_or_equal:today',
            'heure'      => 'required|date_format:H:i',
            'motif'      => 'nullable|string|max:255',
        ]);

        $dejaPris = RendezVous::where('medecin_id', $validated['medecin_id'])
            ->whereDate('date', $validated['date'])
            ->where('heure', $validated['heure'])
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->exists();

        if ($dejaPris) {
            return back()->withErrors(['heure' => 'Ce créneau n\'est plus disponible.'])->withInput();
        }

        try {
            $rendezvous = RendezVous::create([
                'patient_id'  => $patient->id,
                'medecin_id'  => $validated['medecin_id'],
                'date'        => $validated['date'],
                'heure'       => $validated['heure'],
                'motif'       => $validated['motif'] ?? null,
                'statut'      => 'confirme',
            ]);

            try {
                Mail::to($patient->user->email)->send(new RendezVousConfirmation($rendezvous));
                \Log::info('Email de confirmation envoyé au patient: ' . $patient->user->email);
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email confirmation patient: ' . $e->getMessage());
            }

            try {
                if ($rendezvous->medecin && $rendezvous->medecin->user && $rendezvous->medecin->user->email) {
                    Mail::to($rendezvous->medecin->user->email)->send(new RendezVousConfirmation($rendezvous));
                    \Log::info('Email de confirmation envoyé au médecin: ' . $rendezvous->medecin->user->email);
                }
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email confirmation médecin: ' . $e->getMessage());
            }

            try {
                $patient->user->notify(new RappelRendezVousNotification($rendezvous, 'database'));
                \Log::info('Notification de rappel ajoutée pour le patient: ' . $patient->user->email);
            } catch (\Exception $e) {
                \Log::error('Erreur ajout notification rappel: ' . $e->getMessage());
            }

            if (class_exists(\App\Notifications\NouveauRendezVous::class)) {
                try {
                    $rendezvous->medecin->user->notify(new \App\Notifications\NouveauRendezVous($rendezvous));
                    \Log::info('Notification envoyée au médecin: ' . $rendezvous->medecin->user->email);
                } catch (\Exception $e) {
                    \Log::error('Erreur notification médecin: ' . $e->getMessage());
                }
            }

            return redirect()->route('patient.rendez-vous.index')
                ->with('success', 'Rendez-vous confirmé avec succès ! Un email de confirmation vous a été envoyé.');

        } catch (\Exception $e) {
            \Log::error('Erreur création rendez-vous: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Une erreur technique est survenue. Veuillez réessayer.'])->withInput();
        }
    }

    public function index(Request $request)
    {
        $patient = $this->getPatient();
        
        $query = RendezVous::where('patient_id', $patient->id)
            ->whereNotIn('statut', ['termine', 'annule'])
            ->whereDate('date', '>=', now()->startOfDay());

        if ($request->filled('date_debut')) {
            $query->whereDate('date', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('date', '<=', $request->date_fin);
        }
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $rendezvous = $query->orderBy('date', 'asc')->orderBy('heure', 'asc')->paginate(15);
        
        return view('patient.rendez-vous.index', compact('rendezvous'));
    }

    public function show($id)
    {
        $patient = $this->getPatient();
        $rendezvous = RendezVous::findOrFail($id);
        
        if ($rendezvous->patient_id !== $patient->id) {
            abort(403, 'Ce rendez-vous ne vous appartient pas.');
        }
        
        return view('patient.rendez-vous.show', compact('rendezvous'));
    }

    public function destroy($id)
    {
        $patient = $this->getPatient();
        $rendezvous = RendezVous::findOrFail($id);
        
        if ($rendezvous->patient_id !== $patient->id) {
            abort(403);
        }
        
        $rendezvous->update(['statut' => 'annule']);
        
        try {
            if (class_exists(\App\Mail\RendezVousAnnulation::class)) {
                Mail::to($patient->user->email)->send(new \App\Mail\RendezVousAnnulation($rendezvous));
                \Log::info('Email d\'annulation envoyé au patient: ' . $patient->user->email);
            }
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email annulation: ' . $e->getMessage());
        }
        
        try {
            $patient->user->notify(new RappelRendezVousNotification($rendezvous, 'database'));
            \Log::info('Notification d\'annulation ajoutée pour le patient: ' . $patient->user->email);
        } catch (\Exception $e) {
            \Log::error('Erreur ajout notification annulation: ' . $e->getMessage());
        }
        
        return redirect()->route('patient.rendez-vous.index')
            ->with('success', 'Rendez-vous annulé.');
    }

    public function rappelDemain()
    {
        if (!class_exists(\App\Notifications\RappelRendezVousNotification::class)) {
            return response()->json(['error' => 'La notification RappelRendezVousNotification n\'existe pas.'], 500);
        }

        $demain = Carbon::tomorrow()->toDateString();
        $rendezvous = RendezVous::whereDate('date', $demain)
            ->where('statut', 'confirme')
            ->with('patient.user')
            ->get();

        $count = 0;
        foreach ($rendezvous as $rdv) {
            if ($rdv->patient && $rdv->patient->user) {
                $rdv->patient->user->notify(new RappelRendezVousNotification($rdv, 'email'));
                $rdv->patient->user->notify(new RappelRendezVousNotification($rdv, 'database'));
                $count++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$count} rappel(s) envoyé(s) pour les rendez-vous du " . Carbon::tomorrow()->format('d/m/Y')
        ]);
    }

    public function sendRappelManuel(RendezVous $rendezvous)
    {
        try {
            $patient = $rendezvous->patient->user;
            
            if (!$patient) {
                return back()->with('error', 'Patient non trouvé');
            }
            
            $patient->notify(new RappelRendezVousNotification($rendezvous, 'email'));
            $patient->notify(new RappelRendezVousNotification($rendezvous, 'database'));
            
            \Log::info('Rappel manuel envoyé pour le RDV #' . $rendezvous->id);
            
            return back()->with('success', 'Rappel envoyé avec succès');
            
        } catch (\Exception $e) {
            \Log::error('Erreur envoi rappel manuel: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'envoi du rappel');
        }
    }
}