<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $message = strtolower(trim($request->message));
        
        // Analyse simple
        if (strpos($message, 'rdv') !== false || strpos($message, 'rendez') !== false) {
            $response = "📅 Pour prendre un rendez-vous, cliquez sur le bouton 'Prendre RDV' sur notre page d'accueil.";
        } elseif (strpos($message, 'urgence') !== false || strpos($message, 'grave') !== false) {
            $response = "🚨 En cas d'urgence, appelez immédiatement le 112 !";
        } elseif (strpos($message, 'prix') !== false || strpos($message, 'tarif') !== false) {
            $response = "💰 Consultation générale : 5 000 FCFA, Spécialiste : 10 000 FCFA";
        } else {
            $response = "🤔 Je suis l'assistant de SanteRDV. Dites-moi : 'rendez-vous', 'tarifs', 'horaires', 'adresse' ou décrivez vos symptômes.";
        }

        return response()->json([
            'success' => true,
            'response' => $response
        ]);
    }
}