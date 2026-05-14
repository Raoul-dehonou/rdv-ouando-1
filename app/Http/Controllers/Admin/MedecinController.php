<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medecin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\MedecinCredentialsMail;

class MedecinController extends Controller
{
    public function index()
    {
        $medecins = Medecin::with('user')->paginate(15);
        return view('admin.medecins.index', compact('medecins'));
    }

    public function create()
    {
        return view('admin.medecins.create');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'specialite' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Création de l'utilisateur (user) avec le rôle 'medecin'
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'medecin', // Important: attribuer le rôle médecin
            ]);

            // Création du médecin lié à l'utilisateur
            $medecin = Medecin::create([
                'user_id' => $user->id,
                'specialite' => $validated['specialite'] ?? null,
                'is_active' => $request->has('is_active') ? $request->is_active : true,
            ]);

            DB::commit();

            // Envoi de l'email au médecin avec ses identifiants
            try {
                Mail::to($user->email)->send(new MedecinCredentialsMail($user, $validated['password']));
            } catch (\Exception $e) {
                // L'email n'a pas pu être envoyé, mais le médecin est créé
                // Vous pouvez logger l'erreur si nécessaire
                \Log::error('Erreur envoi email médecin: ' . $e->getMessage());
            }

            return redirect()
                ->route('admin.medecins.index')
                ->with('success', 'Médecin "' . $user->name . '" créé avec succès. Un email lui a été envoyé avec ses identifiants.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du médecin : ' . $e->getMessage());
        }
    }

    public function edit(Medecin $medecin)
    {
        // Charger la relation user pour l'affichage
        $medecin->load('user');
        return view('admin.medecins.edit', compact('medecin'));
    }

    public function update(Request $request, Medecin $medecin)
    {
        // Charger l'utilisateur associé
        $user = $medecin->user;

        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'specialite' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Mise à jour de l'utilisateur
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $passwordChanged = false;
            $newPassword = null;

            // Mise à jour du mot de passe si fourni
            if (!empty($validated['password'])) {
                $newPassword = $validated['password'];
                $user->update([
                    'password' => Hash::make($newPassword),
                ]);
                $passwordChanged = true;
            }

            // Mise à jour du médecin
            $medecin->update([
                'specialite' => $validated['specialite'] ?? null,
                'is_active' => $request->has('is_active') ? $request->is_active : $medecin->is_active,
            ]);

            DB::commit();

            // Envoi de l'email avec le nouveau mot de passe si modifié
            if ($passwordChanged) {
                try {
                    Mail::to($user->email)->send(new MedecinCredentialsMail($user, $newPassword));
                } catch (\Exception $e) {
                    \Log::error('Erreur envoi email modification médecin: ' . $e->getMessage());
                }
                $message = 'Médecin "' . $user->name . '" mis à jour avec succès. Un email contenant son nouveau mot de passe lui a été envoyé.';
            } else {
                $message = 'Médecin "' . $user->name . '" mis à jour avec succès.';
            }

            return redirect()
                ->route('admin.medecins.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour du médecin : ' . $e->getMessage());
        }
    }

    public function destroy(Medecin $medecin)
    {
        try {
            DB::beginTransaction();

            // Récupérer l'utilisateur avant suppression
            $userName = $medecin->user->name;
            
            // Supprimer le médecin (la relation sera automatiquement gérée)
            $medecin->delete();
            
            // Supprimer l'utilisateur associé
            $medecin->user()->delete();

            DB::commit();

            return redirect()
                ->route('admin.medecins.index')
                ->with('success', 'Médecin "' . $userName . '" supprimé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}