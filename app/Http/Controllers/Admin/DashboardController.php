<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Consultation;

class DashboardController extends Controller
{
    public function index()
    {
        $medecinsCount = Medecin::count();
        $patientsCount = Patient::count();
        $rendezVousCount = RendezVous::where('date', '>=', now()->toDateString())->count();
        
        // Taux d'occupation : pourcentage de médecins ayant au moins un rendez-vous aujourd'hui
        $totalMedecins = Medecin::count();
        $medecinsOccupes = RendezVous::where('date', now()->toDateString())
            ->distinct('medecin_id')
            ->count('medecin_id');
        $tauxOccupation = $totalMedecins > 0 ? round(($medecinsOccupes / $totalMedecins) * 100) : 0;

        $derniersRendezVous = RendezVous::with(['patient.user', 'medecin.user'])
            ->orderBy('date', 'desc')
            ->orderBy('heure', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'medecinsCount', 'patientsCount', 'rendezVousCount', 'tauxOccupation', 'derniersRendezVous'
        ));
    }
}