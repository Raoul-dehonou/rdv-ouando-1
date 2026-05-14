@extends('layouts.legal')

@section('title', 'Conditions d\'utilisation - SanteRDV')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Conditions générales d'utilisation</h1>
            <div class="w-20 h-1 bg-[#1E88E5] mb-6 rounded-full"></div>
            
            <div class="space-y-6 text-gray-700">
                <p class="text-sm">Dernière mise à jour : {{ date('d/m/Y') }}</p>
                
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">1. Acceptation des conditions</h2>
                    <p class="text-sm leading-relaxed">En utilisant la plateforme SanteRDV, vous acceptez pleinement les présentes conditions générales d'utilisation. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser nos services.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">2. Description des services</h2>
                    <p class="text-sm leading-relaxed">SanteRDV propose une plateforme de prise de rendez-vous médicaux en ligne, de gestion de dossiers médicaux numériques et de messagerie sécurisée entre patients et professionnels de santé.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">3. Responsabilités de l'utilisateur</h2>
                    <p class="text-sm leading-relaxed">Vous vous engagez à fournir des informations exactes et à jour. Vous êtes responsable de la confidentialité de votre compte et de toutes les activités qui s'y déroulent.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">4. Annulation et modification</h2>
                    <p class="text-sm leading-relaxed">Vous pouvez annuler ou modifier votre rendez-vous jusqu'à 24 heures avant l'heure prévue. Passé ce délai, veuillez contacter directement votre médecin.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">5. Limitation de responsabilité</h2>
                    <p class="text-sm leading-relaxed">SanteRDV agit comme intermédiaire entre les patients et les professionnels de santé. La responsabilité de SanteRDV ne peut être engagée pour les actes médicaux réalisés par les professionnels de santé.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">6. Modification des conditions</h2>
                    <p class="text-sm leading-relaxed">Nous nous réservons le droit de modifier ces conditions à tout moment. Les modifications entrent en vigueur dès leur publication sur la plateforme.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
