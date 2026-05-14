<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
use App\Models\Consultation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Vérifier si le médecin existe
        $user = Auth::user();
        $medecin = $user->medecin ?? null;
        
        if (!$medecin) {
            return view('medecin.dashboard', [
                'todayAppointments' => collect([]),
                'todayAppointmentsCount' => 0,
                'monthlyPatients' => 0,
                'nextAppointment' => null,
                'prochainRendezVous' => null,
                'minutesRestantes' => 0,
                'satisfaction' => 0,
                'consultationsParMois' => array_fill(0, 12, 0),
                'consultationsGenerales' => 0,
                'teleconsultations' => 0,
                'consultationsSuivi' => 0,
                'urgences' => 0,
                'consultationsParJour' => array_fill(0, 6, 0),
            ]);
        }
        
        $medecinId = $medecin->id;
        
        // Rendez-vous du jour
        $todayAppointments = RendezVous::where('medecin_id', $medecinId)
            ->whereDate('date', today())
            ->with(['patient.user'])
            ->orderBy('heure', 'asc')
            ->get();

        $todayAppointmentsCount = $todayAppointments->count();

        // Patients vus ce mois-ci (via consultations)
        $monthlyPatients = Consultation::whereHas('rendezvous', function($q) use ($medecinId) {
                $q->where('medecin_id', $medecinId);
            })
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->distinct('patient_id')
            ->count('patient_id');

        // Prochain rendez-vous
        $nextAppointment = RendezVous::where('medecin_id', $medecinId)
            ->where('date', '>=', today())
            ->where('statut', 'confirme')
            ->orderBy('date', 'asc')
            ->orderBy('heure', 'asc')
            ->with(['patient.user'])
            ->first();
        
        // Alias pour la vue (pour utiliser $prochainRendezVous)
        $prochainRendezVous = $nextAppointment;
        
        // Calculer les minutes restantes avant le prochain rendez-vous (CORRIGÉ)
        $minutesRestantes = 0;
        if ($nextAppointment) {
            try {
                // CORRECTION : S'assurer que la date est bien formatée
                $dateString = $nextAppointment->date;
                $heureString = $nextAppointment->heure;
                
                // Vérifier si la date est déjà un objet Carbon ou une string
                if ($dateString instanceof Carbon) {
                    $dateTime = Carbon::parse($dateString->format('Y-m-d') . ' ' . $heureString);
                } else {
                    $dateTime = Carbon::parse($dateString . ' ' . $heureString);
                }
                $minutesRestantes = Carbon::now()->diffInMinutes($dateTime, false);
                if ($minutesRestantes < 0) $minutesRestantes = 0;
            } catch (\Exception $e) {
                $minutesRestantes = 0;
            }
        }
        
        // Taux de satisfaction (moyenne des notes)
        $satisfaction = Consultation::whereHas('rendezvous', function($q) use ($medecinId) {
                $q->where('medecin_id', $medecinId);
            })
            ->whereNotNull('note')
            ->avg('note') ?? 0;
        $satisfaction = round($satisfaction, 1);
        
        // Évolution des consultations (par mois sur 12 mois)
        $consultationsParMois = [];
        for ($i = 11; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $count = Consultation::whereHas('rendezvous', function($q) use ($medecinId) {
                    $q->where('medecin_id', $medecinId);
                })
                ->whereYear('created_at', $mois->year)
                ->whereMonth('created_at', $mois->month)
                ->count();
            $consultationsParMois[] = $count;
        }
        
        // Répartition par type de consultation (si le champ existe)
        $consultationsGenerales = Consultation::whereHas('rendezvous', function($q) use ($medecinId) {
            $q->where('medecin_id', $medecinId);
        })->where('type', 'consultation')->count();
        
        $teleconsultations = Consultation::whereHas('rendezvous', function($q) use ($medecinId) {
            $q->where('medecin_id', $medecinId);
        })->where('type', 'teleconsultation')->count();
        
        $consultationsSuivi = Consultation::whereHas('rendezvous', function($q) use ($medecinId) {
            $q->where('medecin_id', $medecinId);
        })->where('type', 'suivi')->count();
        
        $urgences = Consultation::whereHas('rendezvous', function($q) use ($medecinId) {
            $q->where('medecin_id', $medecinId);
        })->where('type', 'urgence')->count();
        
        // Consultations par jour de la semaine
        $joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $consultationsParJour = [];
        foreach ($joursSemaine as $index => $jour) {
            $dayOfWeek = $index + 1; // Lundi = 1
            $count = Consultation::whereHas('rendezvous', function($q) use ($medecinId, $dayOfWeek) {
                    $q->where('medecin_id', $medecinId);
                })
                ->whereRaw('WEEKDAY(created_at) = ?', [$dayOfWeek - 1])
                ->count();
            $consultationsParJour[] = $count;
        }

        return view('medecin.dashboard', compact(
            'todayAppointments',
            'todayAppointmentsCount',
            'monthlyPatients',
            'nextAppointment',
            'prochainRendezVous',  // ← AJOUTÉ : alias pour la vue
            'minutesRestantes',
            'satisfaction',
            'consultationsParMois',
            'consultationsGenerales',
            'teleconsultations',
            'consultationsSuivi',
            'urgences',
            'consultationsParJour'
        ));
    }
}