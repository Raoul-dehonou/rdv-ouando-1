@extends('layouts.legal')

@section('title', 'Politique des cookies - SanteRDV')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Politique des cookies</h1>
            <div class="w-20 h-1 bg-[#1E88E5] mb-6 rounded-full"></div>
            
            <div class="space-y-6 text-gray-700">
                <p class="text-sm">Dernière mise à jour : {{ date('d/m/Y') }}</p>
                
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">1. Qu'est-ce qu'un cookie ?</h2>
                    <p class="text-sm leading-relaxed">Un cookie est un petit fichier texte déposé sur votre ordinateur lors de la visite d'un site. Il permet d'améliorer votre expérience de navigation.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">2. Cookies utilisés sur SanteRDV</h2>
                    <p class="text-sm leading-relaxed">Nous utilisons uniquement des cookies essentiels au bon fonctionnement de la plateforme :</p>
                    <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                        <li>Cookies de session (maintien de votre connexion)</li>
                        <li>Cookies de préférences (mémorisation de vos paramètres)</li>
                        <li>Cookies de sécurité (protection contre les accès frauduleux)</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">3. Gestion des cookies</h2>
                    <p class="text-sm leading-relaxed">Vous pouvez configurer votre navigateur pour refuser les cookies. Cependant, certaines fonctionnalités de SanteRDV pourraient ne plus être disponibles.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">4. Durée de conservation</h2>
                    <p class="text-sm leading-relaxed">Les cookies de session sont supprimés à la fermeture de votre navigateur. Les cookies de préférences sont conservés au maximum 13 mois.</p>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg mt-4">
                    <p class="text-sm text-gray-700">🍪 En utilisant SanteRDV, vous acceptez l'utilisation de ces cookies essentiels au fonctionnement du service.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
