<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
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
        $documents = Document::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('patient.documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $patient = $this->getPatient();
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'fichier' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        
        $path = $request->file('fichier')->store('documents/' . $patient->id, 'public');
        
        Document::create([
            'patient_id' => $patient->id,
            'titre' => $request->titre,
            'fichier' => $path,
            'type' => $request->type ?? 'autre',
            'description' => $request->description,
        ]);
        
        return redirect()->route('patient.documents.index')->with('success', 'Document ajouté avec succès');
    }

    public function destroy(Document $document)
    {
        $patient = $this->getPatient();
        if ($document->patient_id !== $patient->id) abort(403);
        
        // Supprimer le fichier physique
        Storage::disk('public')->delete($document->fichier);
        $document->delete();
        
        return redirect()->route('patient.documents.index')->with('success', 'Document supprimé');
    }
    
    public function download(Document $document)
    {
        $patient = $this->getPatient();
        if ($document->patient_id !== $patient->id) abort(403);
        
        return Storage::disk('public')->download($document->fichier, $document->titre . '.pdf');
    }
}