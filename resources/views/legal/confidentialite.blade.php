@extends('layouts.legal')

@section('title', 'Politique de confidentialité - SanteRDV')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Politique de confidentialité</h1>
            <div class="w-20 h-1 bg-[#1E88E5] mb-6 rounded-full"></div>
            
            <div class="space-y-6 text-gray-700">
                <p class="text-sm">Dernière mise à jour : {{ date('d/m/Y') }}</p>
                
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">1. Collecte des informations</h2>
                    <p class="text-sm leading-relaxed">SanteRDV collecte les informations nécessaires à la gestion de vos rendez-vous médicaux : nom, prénom, email, numéro de téléphone, historique médical (avec votre consentement). Toutes les données sont collectées de manière légale et transparente.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">2. Utilisation des données</h2>
                    <p class="text-sm leading-relaxed">Vos données sont utilisées exclusivement pour : la prise de rendez-vous, le suivi médical, l'envoi de rappels, l'amélioration de nos services. Elles ne sont jamais vendues à des tiers.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">3. Protection des données</h2>
                    <p class="text-sm leading-relaxed">Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles pour protéger vos données contre tout accès non autorisé, perte ou divulgation. Toutes les données sont hébergées sur des serveurs sécurisés conformes aux normes HDS.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">4. Vos droits</h2>
                    <p class="text-sm leading-relaxed">Conformément à la réglementation, vous disposez d'un droit d'accès, de rectification, d'effacement et de portabilité de vos données. Pour exercer ces droits, contactez-nous à <a href="mailto:dpo@santerdv.bj" class="text-[#1E88E5] hover:underline">dpo@santerdv.bj</a>.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">5. Conservation des données</h2>
                    <p class="text-sm leading-relaxed">Vos données sont conservées pour la durée nécessaire à la gestion de votre relation avec SanteRDV, conformément aux obligations légales.</p>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg mt-4">
                    <p class="text-sm text-gray-700">📧 Pour toute question relative à vos données personnelles : <strong>dpo@santerdv.bj</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
