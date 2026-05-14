<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
use App\Models\Consultation;

class DashboardController extends Controller
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
        $user = Auth::user();

        $nextAppointment = RendezVous::where('patient_id', $patient->id)
            ->where('date', '>=', today())
            ->where('statut', '!=', 'annule')
            ->orderBy('date')
            ->orderBy('heure')
            ->first();

        $pastConsultationsCount = Consultation::where('patient_id', $patient->id)->count();
        $lastConsultation = Consultation::where('patient_id', $patient->id)->latest()->first();
        $unreadNotificationsCount = $user->unreadNotifications->count();

        return view('patient.dashboard', compact('nextAppointment', 'pastConsultationsCount', 'lastConsultation', 'unreadNotificationsCount'));
    }
}