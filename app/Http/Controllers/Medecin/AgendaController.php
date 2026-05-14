<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
use App\Models\Disponibilite;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $medecinId = Auth::user()->medecin->id;

        // Semaine actuelle (lundi à dimanche)
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd   = Carbon::now()->endOfWeek();

        // Jours de la semaine (7 jours)
        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $weekDays[] = (clone $weekStart)->addDays($i);
        }

        // Plages horaires de 8h à 18h (par heure pleine)
        $hours = range(8, 18);

        // Rendez-vous de la semaine (non annulés)
        $appointments = RendezVous::where('medecin_id', $medecinId)
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->where('statut', '!=', 'annule')
            ->with('patient.user')
            ->get();

        $appointmentsBySlot = [];
        foreach ($appointments as $rdv) {
            $dateKey = $rdv->date->format('Y-m-d');
            $heureKey = substr($rdv->heure, 0, 5);
            $slotKey = $dateKey . '|' . $heureKey;
            $appointmentsBySlot[$slotKey] = $rdv;
        }

        // Disponibilités du médecin pour la semaine (créneaux où il reçoit)
        $disponibilites = Disponibilite::where('medecin_id', $medecinId)
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->where('is_active', true)
            ->get();

        // Organiser les disponibilités par date et heure
        $dispoSlots = [];
        foreach ($disponibilites as $dispo) {
            $dateKey = $dispo->date->format('Y-m-d');
            $debut = Carbon::parse($dispo->heure_debut);
            $fin   = Carbon::parse($dispo->heure_fin);
            $duree = $dispo->duree ?? 30;
            while ($debut < $fin) {
                $heure = $debut->format('H:i');
                $slotKey = $dateKey . '|' . $heure;
                $dispoSlots[$slotKey] = true;
                $debut->addMinutes($duree);
            }
        }

        return view('medecin.agenda', compact('weekDays', 'hours', 'appointmentsBySlot', 'dispoSlots'));
    }
}