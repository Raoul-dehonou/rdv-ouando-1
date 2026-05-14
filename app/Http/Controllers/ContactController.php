<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telephone' => 'nullable|string|max:20',
                'sujet' => 'required|string|max:100',
                'message' => 'required|string|max:5000',
            ]);

            // Enregistrement en base de données
            $contact = Contact::create([
                'nom' => $validated['nom'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'] ?? null,
                'sujet' => $validated['sujet'],
                'message' => $validated['message'],
                'lu' => false,
                'traite' => false,
                'date_envoi' => now(),
            ]);

            // Log du message
            Log::info('Nouveau message de contact enregistré', [
                'id' => $contact->id,
                'nom' => $validated['nom'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'] ?? 'Non renseigné',
                'sujet' => $validated['sujet'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Optionnel : Envoyer un email de notification à l'admin
            // Mail::to('admin@santerdv.bj')->send(new ContactNotification($validated));

            return response()->json([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez vérifier les champs du formulaire.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du message de contact : ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue. Veuillez réessayer plus tard.'
            ], 500);
        }
    }
}