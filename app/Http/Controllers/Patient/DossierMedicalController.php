<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Consultation;
use App\Models\Document;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DossierMedicalController extends Controller
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
            ->paginate(15);
        
        $consultationsCetteAnnee = Consultation::where('patient_id', $patient->id)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $documentsCount = Document::where('patient_id', $patient->id)->count();
        
        return view('patient.dossier.index', compact('consultations', 'consultationsCetteAnnee', 'documentsCount'));
    }

    public function show(Consultation $consultation)
    {
        $patient = $this->getPatient();
        if ($consultation->patient_id !== $patient->id) abort(403);
        return view('patient.dossier.show', compact('consultation'));
    }

    // ✅ Méthode pour télécharger tout le dossier en PDF
    public function downloadPdf()
    {
        $patient = $this->getPatient();
        
        $consultations = Consultation::where('patient_id', $patient->id)
            ->with(['rendezvous.medecin.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $documents = Document::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'total_consultations' => $consultations->count(),
            'consultations_cette_annee' => Consultation::where('patient_id', $patient->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
            'total_documents' => $documents->count(),
            'date_generation' => Carbon::now()->format('d/m/Y à H:i'),
        ];
        
        $pdf = Pdf::loadView('patient.dossier.pdf', compact('patient', 'consultations', 'documents', 'stats'));
        
        return $pdf->download('dossier_medical_' . $patient->id . '_' . Carbon::now()->format('Ymd') . '.pdf');
    }

    // ✅ Méthode pour télécharger une consultation spécifique en PDF
    public function downloadConsultationPdf(Consultation $consultation)
    {
        $patient = $this->getPatient();
        if ($consultation->patient_id !== $patient->id) abort(403);
        
        $pdf = Pdf::loadView('patient.dossier.consultation_pdf', compact('consultation', 'patient'));
        
        return $pdf->download('consultation_' . $consultation->id . '_' . Carbon::now()->format('Ymd') . '.pdf');
    }

    // ✅ Méthode pour télécharger un document
    public function downloadDocument(Document $document)
    {
        $patient = $this->getPatient();
        if ($document->patient_id !== $patient->id) abort(403);
        
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'Document non trouvé');
        }
        
        return response()->download($filePath, $document->nom_fichier);
    }
}