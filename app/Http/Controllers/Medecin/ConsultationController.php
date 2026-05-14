<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
use App\Models\Consultation;

class ConsultationController extends Controller
{
    public function index()
    {
        $medecinId = Auth::user()->medecin->id;

        $consultations = Consultation::whereHas('rendezvous', function($q) use ($medecinId) {
                $q->where('medecin_id', $medecinId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('medecin.consultations.index', compact('consultations'));
    }

    public function create(RendezVous $rendezvous)
    {
        if ($rendezvous->medecin_id !== Auth::user()->medecin->id) {
            abort(403);
        }

        // Vérifier qu'une consultation n'existe pas déjà
        if ($rendezvous->consultation) {
            return redirect()->route('medecin.consultations.show', $rendezvous->consultation)
                ->with('info', 'Une consultation existe déjà pour ce rendez-vous.');
        }

        return view('medecin.consultations.create', compact('rendezvous'));
    }

    public function store(Request $request, RendezVous $rendezvous)
    {
        $request->validate([
            'diagnostic' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'prochain_rdv' => 'nullable|date',
        ]);

        if ($rendezvous->medecin_id !== Auth::user()->medecin->id) {
            abort(403);
        }

        $consultation = Consultation::create([
            'patient_id' => $rendezvous->patient_id,
            'rendezvous_id' => $rendezvous->id,
            'diagnostic' => $request->diagnostic,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
            'prochain_rdv' => $request->prochain_rdv,
        ]);

        // Optionnel : marquer le rendez-vous comme "termine"
        $rendezvous->update(['statut' => 'termine']);

        return redirect()->route('medecin.consultations.show', $consultation)
            ->with('success', 'Consultation enregistrée.');
    }

    public function show(Consultation $consultation)
    {
        $medecinId = Auth::user()->medecin->id;
        if ($consultation->rendezvous->medecin_id !== $medecinId) {
            abort(403);
        }

        return view('medecin.consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        $medecinId = Auth::user()->medecin->id;
        if ($consultation->rendezvous->medecin_id !== $medecinId) {
            abort(403);
        }

        return view('medecin.consultations.edit', compact('consultation'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'diagnostic' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'prochain_rdv' => 'nullable|date',
        ]);

        $medecinId = Auth::user()->medecin->id;
        if ($consultation->rendezvous->medecin_id !== $medecinId) {
            abort(403);
        }

        $consultation->update([
            'diagnostic' => $request->diagnostic,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
            'prochain_rdv' => $request->prochain_rdv,
        ]);

        return redirect()->route('medecin.consultations.show', $consultation)
            ->with('success', 'Consultation mise à jour.');
    }
}