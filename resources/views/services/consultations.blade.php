@extends('layouts.legal')

@section('title', 'Consultations médicales - SanteRDV')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        <nav class="text-sm mb-6">
            <a href="{{ route('accueil') }}" class="text-[#1E88E5] hover:underline">Accueil</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-600">Consultations médicales</span>
        </nav>

        <div class="bg-gradient-to-r from-[#1E88E5] to-[#0d5ae0] rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-stethoscope text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold">Consultations médicales</h1>
            </div>
            <p class="text-white/90 text-lg">Des consultations de qualité avec des médecins expérimentés, pour toute la famille.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Pourquoi choisir nos consultations ?</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Chez SanteRDV, nous mettons un point d'honneur à offrir des consultations médicales de qualité, 
                accessibles à tous. Notre équipe de médecins généralistes et spécialistes est à votre écoute 
                pour répondre à tous vos besoins de santé.
            </p>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Médecine générale</h3>
                        <p class="text-gray-500 text-sm">Consultations pour adultes et enfants, suivi régulier, prescriptions.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Spécialistes</h3>
                        <p class="text-gray-500 text-sm">Cardiologie, dermatologie, gynécologie, pédiatrie et plus.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Téléconsultation</h3>
                        <p class="text-gray-500 text-sm">Consultez à distance depuis chez vous, en toute simplicité.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Prise de RDV en ligne</h3>
                        <p class="text-gray-500 text-sm">Réservez votre créneau 24h/24, sans attente téléphonique.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-gray-800 mb-3">📍 Tarifs indicatifs</h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Consultation générale</span>
                        <span class="font-semibold">5 000 FCFA</span>
                    </li>
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Consultation spécialiste</span>
                        <span class="font-semibold">10 000 FCFA</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Téléconsultation</span>
                        <span class="font-semibold">4 000 FCFA</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-gradient-to-r from-[#1E88E5]/10 to-transparent rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Prêt à prendre rendez-vous ?</h3>
            <p class="text-gray-600 mb-4">Inscrivez-vous gratuitement et réservez votre consultation en quelques clics.</p>
            <a href="{{ route('register') }}" class="inline-block bg-[#43A047] hover:bg-[#2E7D32] text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300">
                Créer mon compte
            </a>
        </div>
    </div>
</div>
@endsection
