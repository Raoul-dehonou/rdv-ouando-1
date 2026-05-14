<?php

namespace App\Http\Controllers;

use App\Models\AlerteUrgence;
use App\Notifications\NouvelleAlerteUrgence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB; // Ajouté

class UrgenceController extends Controller
{
    /**
     * Enregistrer une nouvelle alerte urgence (public)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'description' => 'required|string',
        ]);

        $alerte = AlerteUrgence::create($request->only(['nom', 'telephone', 'description']));

        // Notifier les administrateurs et médecins
        $usersToNotify = User::whereIn('role', ['admin', 'medecin'])->get();
        Notification::send($usersToNotify, new NouvelleAlerteUrgence($alerte));

        return response()->json([
            'success' => true,
            'message' => 'Alerte envoyée avec succès. Notre équipe vous recontactera rapidement.'
        ]);
    }

    /**
     * Afficher la liste des alertes (admin)
     */
    public function index()
    {
        // Vérification de l'existence de la table
        if (!DB::connection()->getSchemaBuilder()->hasTable('alertes_urgences')) {
            abort(500, 'La table des alertes urgences n\'existe pas. Exécutez la migration.');
        }

        $alertes = DB::table('alertes_urgences')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.urgences.index', compact('alertes'));
    }

    /**
     * Marquer une alerte comme traitée (admin)
     */
    public function markAsTreated($id)
    {
        $alerte = AlerteUrgence::findOrFail($id);
        $alerte->update([
            'traitee' => true,
            'traitee_le' => now(),
            'traitee_par' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Alerte marquée comme traitée.');
    }
}