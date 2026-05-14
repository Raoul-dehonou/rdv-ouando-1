<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            // Récupérer le mot de passe en clair pour l'email
            $plainPassword = $request->password;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($plainPassword),
                'role' => 'patient',
            ]);

            // Créer le profil patient associé
            $patient = Patient::create([
                'user_id' => $user->id,
            ]);

            event(new Registered($user));

            // ========== ENVOI DE L'EMAIL DE BIENVENUE ==========
            try {
                Mail::to($user->email)->send(new WelcomeMail($user, $plainPassword));
                \Log::info('Email de bienvenue envoyé à: ' . $user->email);
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email de bienvenue: ' . $e->getMessage());
            }

            Auth::login($user);

            return redirect()->route('patient.dashboard')
                ->with('success', 'Bienvenue sur SanteRDV ! Un email de confirmation vous a été envoyé.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'inscription: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.'])->withInput();
        }
    }
}