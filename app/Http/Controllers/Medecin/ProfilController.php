<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $medecin = $user->medecin;
        return view('medecin.profile', compact('user', 'medecin'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $medecin = $user->medecin;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'specialite' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'email']));
        $medecin->update($request->only(['specialite', 'telephone']));

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe modifié.');
    }
}