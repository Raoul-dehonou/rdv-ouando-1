<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\Medecin;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function index()
    {
        $rendezVous = RendezVous::with(['patient.user', 'medecin.user'])
            ->orderBy('date', 'desc')
            ->orderBy('heure', 'desc')
            ->paginate(15);
        
        return view('admin.rendez-vous.index', compact('rendezVous'));
    }

    public function calendar()
    {
        $events = RendezVous::with(['patient.user', 'medecin.user'])
            ->get()
            ->map(function($rdv) {
                return [
                    'id' => $rdv->id,
                    'title' => $rdv->patient->user->name ?? 'Patient',
                    'start' => $rdv->date . 'T' . $rdv->heure,
                    'end' => $rdv->date . 'T' . date('H:i', strtotime($rdv->heure) + 1800),
                    'backgroundColor' => $this->getStatutColor($rdv->statut),
                    'borderColor' => $this->getStatutColor($rdv->statut),
                    'extendedProps' => [
                        'medecin' => $rdv->medecin->user->name ?? 'Dr. Inconnu',
                        'statut' => $rdv->statut,
                        'motif' => $rdv->motif,
                        'patient_id' => $rdv->patient_id,
                    ]
                ];
            });
        
        return view('admin.rendez-vous.calendar', compact('events'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->where('is_active', true)->get();
        return view('admin.rendez-vous.create', compact('patients', 'medecins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'date' => 'required|date',
            'heure' => 'required',
            'motif' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        RendezVous::create([
            'patient_id' => $request->patient_id,
            'medecin_id' => $request->medecin_id,
            'date' => $request->date,
            'heure' => $request->heure,
            'motif' => $request->motif,
            'notes' => $request->notes,
            'statut' => 'en_attente',
        ]);
        
        return redirect()->route('admin.rendez-vous.index')
            ->with('success', 'Rendez-vous créé avec succès');
    }

    public function show($id)
    {
        $rdv = RendezVous::with(['patient.user', 'medecin.user'])->findOrFail($id);
        return view('admin.rendez-vous.show', compact('rdv'));
    }

    public function edit($id)
    {
        $rdv = RendezVous::with(['patient.user', 'medecin.user'])->findOrFail($id);
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->where('is_active', true)->get();
        return view('admin.rendez-vous.edit', compact('rdv', 'patients', 'medecins'));
    }

    public function update(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'date' => 'required|date',
            'heure' => 'required',
            'motif' => 'nullable|string',
            'notes' => 'nullable|string',
            'statut' => 'required|in:en_attente,confirme,annule,termine',
        ]);
        
        $rdv->update([
            'patient_id' => $request->patient_id,
            'medecin_id' => $request->medecin_id,
            'date' => $request->date,
            'heure' => $request->heure,
            'motif' => $request->motif,
            'notes' => $request->notes,
            'statut' => $request->statut,
        ]);
        
        return redirect()->route('admin.rendez-vous.index')
            ->with('success', 'Rendez-vous modifié avec succès');
    }

    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->delete();
        
        return redirect()->route('admin.rendez-vous.index')
            ->with('success', 'Rendez-vous supprimé avec succès');
    }

    private function getStatutColor($statut)
    {
        switch($statut) {
            case 'confirme': return '#10B981';
            case 'en_attente': return '#F59E0B';
            case 'annule': return '#DC2626';
            case 'termine': return '#3B82F6';
            default: return '#1761e0';
        }
    }
}