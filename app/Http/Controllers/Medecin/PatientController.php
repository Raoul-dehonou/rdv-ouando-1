<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\RendezVous;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $medecinId = Auth::user()->medecin->id;

        // Récupérer les IDs des patients ayant eu un rendez-vous avec ce médecin
        $patientIds = RendezVous::where('medecin_id', $medecinId)
            ->where('statut', 'termine')
            ->distinct('patient_id')
            ->pluck('patient_id');

        $patients = Patient::whereIn('id', $patientIds)
            ->with(['user', 'consultations' => function($q) use ($medecinId) {
                $q->whereHas('rendezvous', function($r) use ($medecinId) {
                    $r->where('medecin_id', $medecinId);
                });
            }])
            ->paginate(15);

        // Ajouter une propriété virtuelle "last_consultation"
        foreach ($patients as $patient) {
            $last = $patient->consultations->sortByDesc('created_at')->first();
            $patient->last_consultation = $last ? $last->created_at : null;
        }

        return view('medecin.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $medecinId = Auth::user()->medecin->id;

        // Vérifier que ce patient a bien consulté ce médecin
        $hasConsulted = RendezVous::where('medecin_id', $medecinId)
            ->where('patient_id', $patient->id)
            ->exists();

        if (!$hasConsulted) {
            abort(403, 'Vous n\'avez pas accès à ce patient.');
        }

        $patient->load(['user', 'consultations' => function($q) use ($medecinId) {
            $q->whereHas('rendezvous', function($r) use ($medecinId) {
                $r->where('medecin_id', $medecinId);
            })->orderBy('created_at', 'desc');
        }]);

        return view('medecin.patients.show', compact('patient'));
    }
}