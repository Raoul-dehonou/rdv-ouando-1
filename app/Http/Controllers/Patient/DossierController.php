<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Consultation;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DossierController extends Controller
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

    public function index()
    {
        $patient = $this->getPatient();
        
        $consultations = Consultation::where('patient_id', $patient->id)
            ->with(['rendezvous.medecin.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('patient.dossier.index', compact('consultations'));
    }

    public function showConsultation($id)
    {
        $patient = $this->getPatient();
        $consultation = Consultation::where('patient_id', $patient->id)
            ->with(['rendezvous.medecin.user'])
            ->findOrFail($id);
        
        return view('patient.dossier.show', compact('consultation'));
    }

    /**
     * Télécharger une consultation en PDF
     */
    public function downloadConsultationPdf($id)
    {
        $patient = $this->getPatient();
        $consultation = Consultation::where('patient_id', $patient->id)
            ->with(['rendezvous.medecin.user', 'patient.user'])
            ->findOrFail($id);
        
        $pdf = Pdf::loadView('patient.dossier.consultation_pdf', compact('consultation'));
        
        return $pdf->download('consultation_' . $consultation->id . '_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Télécharger tout le dossier médical du patient en PDF
     */
    public function downloadAllPdf()
    {
        $patient = $this->getPatient();
        
        $consultations = Consultation::where('patient_id', $patient->id)
            ->with(['rendezvous.medecin.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'total_consultations' => $consultations->count(),
            'date_generation' => Carbon::now()->format('d/m/Y à H:i'),
        ];
        
        $pdf = Pdf::loadView('patient.dossier.all_consultations_pdf', compact('patient', 'consultations', 'stats'));
        
        return $pdf->download('dossier_medical_' . $patient->id . '_' . date('Y-m-d') . '.pdf');
    }
}