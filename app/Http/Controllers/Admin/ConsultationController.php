<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Medecin;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['patient.user', 'medecin.user'])
            ->orderBy('date_consultation', 'desc')
            ->paginate(15);
        
        $medecins = Medecin::with('user')->get();
        
        return view('admin.consultations.index', compact('consultations', 'medecins'));
    }
    
    public function create()
    {
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->where('is_active', true)->get();
        return view('admin.consultations.create', compact('patients', 'medecins'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'date_consultation' => 'required|date',
            'diagnostic' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        Consultation::create([
            'patient_id' => $request->patient_id,
            'medecin_id' => $request->medecin_id,
            'date_consultation' => $request->date_consultation,
            'diagnostic' => $request->diagnostic,
            'prescription' => $request->prescription,
            'remarques' => $request->notes,
        ]);
        
        return redirect()->route('admin.consultations.index')
            ->with('success', 'Consultation créée avec succès');
    }
    
    public function show($id)
    {
        $consultation = Consultation::with(['patient.user', 'medecin.user'])
            ->findOrFail($id);
        
        return view('admin.consultations.show', compact('consultation'));
    }
    
    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();
        
        return view('admin.consultations.edit', compact('consultation', 'patients', 'medecins'));
    }
    
    public function update(Request $request, $id)
    {
        $consultation = Consultation::findOrFail($id);
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'date_consultation' => 'required|date',
            'diagnostic' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        $consultation->update([
            'patient_id' => $request->patient_id,
            'medecin_id' => $request->medecin_id,
            'date_consultation' => $request->date_consultation,
            'diagnostic' => $request->diagnostic,
            'prescription' => $request->prescription,
            'remarques' => $request->notes,
        ]);
        
        return redirect()->route('admin.consultations.index')
            ->with('success', 'Consultation modifiée avec succès');
    }
    
    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultation->delete();
        
        return redirect()->route('admin.consultations.index')
            ->with('success', 'Consultation supprimée avec succès');
    }
}