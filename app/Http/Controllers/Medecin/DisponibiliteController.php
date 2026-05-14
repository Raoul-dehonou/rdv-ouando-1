<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disponibilite;

class DisponibiliteController extends Controller
{
    public function index()
    {
        $disponibilites = Disponibilite::where('medecin_id', Auth::user()->medecin->id)
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->get();

        return view('medecin.disponibilites.index', compact('disponibilites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'duree' => 'nullable|integer|min:15',
        ]);

        Disponibilite::create([
            'medecin_id' => Auth::user()->medecin->id,
            'date' => $request->date,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'duree' => $request->duree ?? 30,
        ]);

        return back()->with('success', 'Disponibilité ajoutée.');
    }

    public function destroy(Disponibilite $disponibilite)
    {
        if ($disponibilite->medecin_id !== Auth::user()->medecin->id) {
            abort(403);
        }
        $disponibilite->delete();
        return back()->with('success', 'Disponibilité supprimée.');
    }
}