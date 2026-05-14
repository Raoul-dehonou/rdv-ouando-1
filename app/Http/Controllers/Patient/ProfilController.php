<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Patient;

class ProfilController extends Controller
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

    public function edit()
    {
        $user = Auth::user();
        $patient = $this->getPatient();
        return view('patient.profile', compact('user', 'patient'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $patient = $this->getPatient();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'contact_urgence' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'email']));
        $patient->update($request->only(['telephone', 'date_naissance', 'adresse', 'contact_urgence']));

        return redirect()->route('patient.dashboard')->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Mot de passe modifié.');
    }
}