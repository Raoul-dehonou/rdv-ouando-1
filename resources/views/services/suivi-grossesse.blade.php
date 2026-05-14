@extends('layouts.legal')

@section('title', 'Suivi de grossesse - SanteRDV')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        <nav class="text-sm mb-6">
            <a href="{{ route('accueil') }}" class="text-[#1E88E5] hover:underline">Accueil</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-600">Suivi de grossesse</span>
        </nav>

        <div class="bg-gradient-to-r from-[#1E88E5] to-[#0d5ae0] rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-baby-carriage text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold">Suivi de grossesse</h1>
            </div>
            <p class="text-white/90 text-lg">Un accompagnement personnalisé pour les futures mamans et leur bébé.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Un suivi complet de A à Z</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Notre équipe de gynécologues et sages-femmes vous accompagne tout au long de votre grossesse, 
                de la conception à l'accouchement, pour vivre cette période unique en toute sérénité.
            </p>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Consultations prénatales</h3>
                        <p class="text-gray-500 text-sm">Suivi mensuel de la grossesse.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Échographies</h3>
                        <p class="text-gray-500 text-sm">Échographies de datation, morphologique et de bien-être.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Préparation à l'accouchement</h3>
                        <p class="text-gray-500 text-sm">Cours de préparation, sophrologie.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Suivi post-natal</h3>
                        <p class="text-gray-500 text-sm">Consultations post-accouchement et rééducation.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-gray-800 mb-3">📍 Forfait suivi grossesse</h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Consultation prénatale</span>
                        <span class="font-semibold">10 000 FCFA</span>
                    </li>
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Échographie</span>
                        <span class="font-semibold">15 000 FCFA</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Forfait complet (grossesse)</span>
                        <span class="font-semibold">150 000 FCFA</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-gradient-to-r from-[#1E88E5]/10 to-transparent rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Préparez l'arrivée de bébé en toute sérénité</h3>
            <p class="text-gray-600 mb-4">Prenez rendez-vous avec nos spécialistes.</p>
            <a href="{{ route('register') }}" class="inline-block bg-[#43A047] hover:bg-[#2E7D32] text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300">
                Prendre rendez-vous
            </a>
        </div>
    </div>
</div>
@endsection
