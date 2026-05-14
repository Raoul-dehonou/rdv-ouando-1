<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Consultation;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    public function index(Request $request)
    {
        // Liste des médecins pour le filtre
        $medecins = Medecin::with('user')->where('is_active', true)->get();

        // Requête de base pour les rendez-vous
        $query = RendezVous::with(['patient.user', 'medecin.user']);

        // Application des filtres
        if ($request->filled('medecin_id')) {
            $query->where('medecin_id', $request->medecin_id);
        }
        if ($request->filled('date_debut')) {
            $query->whereDate('date', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('date', '<=', $request->date_fin);
        }

        // Statistiques générales
        $totalMedecins = Medecin::count();
        $totalPatients = Patient::count();
        $totalRendezVous = $query->count();
        $totalConsultations = Consultation::count();
        $rendezvousEnAttente = (clone $query)->where('statut', 'en_attente')->count();

        // Top 5 médecins (par nombre de consultations)
        $topMedecins = Medecin::with('user')
            ->withCount('consultations')
            ->orderBy('consultations_count', 'desc')
            ->limit(5)
            ->get();

        // Derniers rendez-vous (avec pagination)
        $derniersRendezVous = (clone $query)
            ->orderBy('date', 'desc')
            ->orderBy('heure', 'desc')
            ->paginate(15);

        // Données pour le graphique d'évolution mensuelle (année en cours)
        $chartData['monthly'] = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData['monthly'][] = RendezVous::whereMonth('date', $i)
                ->whereYear('date', date('Y'))
                ->count();
        }

        // Répartition par statut
        $statusCounts = [
            'confirme' => RendezVous::where('statut', 'confirme')->count(),
            'en_attente' => RendezVous::where('statut', 'en_attente')->count(),
            'termine' => RendezVous::where('statut', 'termine')->count(),
            'annule' => RendezVous::where('statut', 'annule')->count(),
        ];

        // Rendez-vous par jour (7 derniers jours)
        $dailyLabels = [];
        $dailyCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyLabels[] = $date->format('d/m');
            $dailyCounts[] = RendezVous::whereDate('date', $date)->count();
        }

        return view('admin.statistiques', compact(
            'medecins',
            'totalMedecins',
            'totalPatients',
            'totalRendezVous',
            'totalConsultations',
            'rendezvousEnAttente',
            'topMedecins',
            'derniersRendezVous',
            'chartData',
            'statusCounts',
            'dailyLabels',
            'dailyCounts'
        ));
    }

    /**
     * Récupération AJAX des rendez-vous filtrés (optionnel)
     */
    public function filter(Request $request)
    {
        $query = RendezVous::with(['patient.user', 'medecin.user']);

        if ($request->filled('medecin_id')) {
            $query->where('medecin_id', $request->medecin_id);
        }
        if ($request->filled('date_debut')) {
            $query->whereDate('date', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('date', '<=', $request->date_fin);
        }

        $rendezvous = $query->orderBy('date', 'desc')
            ->orderBy('heure', 'desc')
            ->paginate(15);

        if ($request->ajax()) {
            $html = view('admin.statistiques.partials.table', compact('rendezvous'))->render();
            return response()->json(['html' => $html]);
        }

        return back();
    }

    /**
     * Top médecins (AJAX pour le filtre période)
     */
    public function topMedecins(Request $request)
    {
        $period = $request->get('period', 'mois');
        $query = Medecin::with('user');

        if ($period == 'mois') {
            $query->withCount(['consultations' => function($q) {
                $q->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            }]);
        } elseif ($period == 'annee') {
            $query->withCount(['consultations' => function($q) {
                $q->whereYear('created_at', now()->year);
            }]);
        } else {
            $query->withCount('consultations');
        }

        $topMedecins = $query->orderBy('consultations_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function($medecin) {
                return [
                    'id' => $medecin->id,
                    'name' => $medecin->user->name,
                    'specialite' => $medecin->specialite,
                    'initial' => strtoupper(substr($medecin->user->name, 0, 1)),
                    'count' => $medecin->consultations_count
                ];
            });

        return response()->json($topMedecins);
    }
}