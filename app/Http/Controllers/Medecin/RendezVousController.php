<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
use App\Notifications\RendezVousConfirme;
use App\Notifications\RendezVousAnnuleParMedecin;

class RendezVousController extends Controller
{
    public function index(Request $request)
    {
        $medecin = Auth::user()->medecin;
        if (!$medecin) {
            abort(403, 'Aucun médecin associé à cet utilisateur.');
        }

        $query = RendezVous::where('medecin_id', $medecin->id);

        if ($request->filled('date_debut')) {
            $query->whereDate('date', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('date', '<=', $request->date_fin);
        }
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $rendezvous = $query->orderBy('date', 'desc')->orderBy('heure')->paginate(15);
        return view('medecin.rendezvous.index', compact('rendezvous'));
    }

    public function show($id)
    {
        $rendezvous = RendezVous::findOrFail($id);
        $medecin = Auth::user()->medecin;
        if (!$medecin) {
            abort(403, 'Aucun médecin associé à votre compte.');
        }
        if ($rendezvous->medecin_id !== $medecin->id) {
            abort(403, 'Ce rendez-vous n\'appartient pas à votre cabinet. Votre ID médecin : ' . $medecin->id . ', ID médecin du RDV : ' . ($rendezvous->medecin_id ?? 'null'));
        }
        return view('medecin.rendezvous.show', compact('rendezvous'));
    }

    public function updateStatut(Request $request, $id)
    {
        $rendezvous = RendezVous::findOrFail($id);
        $request->validate(['statut' => 'required|in:en_attente,confirme,termine,annule']);

        $medecin = Auth::user()->medecin;
        if (!$medecin || $rendezvous->medecin_id !== $medecin->id) {
            abort(403);
        }

        $ancienStatut = $rendezvous->statut;
        $rendezvous->update(['statut' => $request->statut]);

        if ($request->statut === 'confirme' && $ancienStatut !== 'confirme') {
            $rendezvous->patient->user->notify(new RendezVousConfirme($rendezvous));
        }
        if ($request->statut === 'annule' && $ancienStatut !== 'annule') {
            $rendezvous->patient->user->notify(new RendezVousAnnuleParMedecin($rendezvous));
        }

        return back()->with('success', 'Statut mis à jour.');
    }
}