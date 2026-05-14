@extends('layouts.legal')

@section('title', 'Vaccinations - SanteRDV')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        <nav class="text-sm mb-6">
            <a href="{{ route('accueil') }}" class="text-[#1E88E5] hover:underline">Accueil</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-600">Vaccinations</span>
        </nav>

        <div class="bg-gradient-to-r from-[#1E88E5] to-[#0d5ae0] rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-vaccine text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold">Vaccinations</h1>
            </div>
            <p class="text-white/90 text-lg">Calendrier vaccinal complet pour enfants et adultes, avec rappels automatiques.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Protégez-vous et protégez vos proches</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                La vaccination est l'un des moyens les plus efficaces de prévenir les maladies. 
                Chez SanteRDV, nous proposons un suivi vaccinal personnalisé avec rappels automatiques.
            </p>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Vaccins enfants</h3>
                        <p class="text-gray-500 text-sm">BCG, Penta, ROR, Polio, etc.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Vaccins adultes</h3>
                        <p class="text-gray-500 text-sm">Tétanos, Grippe, Hépatite B, etc.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Vaccins voyage</h3>
                        <p class="text-gray-500 text-sm">Fièvre jaune, Typhoïde, Choléra, etc.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Rappels automatiques</h3>
                        <p class="text-gray-500 text-sm">SMS et email pour ne rien oublier.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-gray-800 mb-3">📍 Tarifs des vaccins</h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Vaccin grippe</span>
                        <span class="font-semibold">5 000 FCFA</span>
                    </li>
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Vaccin tétanos</span>
                        <span class="font-semibold">4 000 FCFA</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Vaccin fièvre jaune</span>
                        <span class="font-semibold">8 000 FCFA</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-gradient-to-r from-[#1E88E5]/10 to-transparent rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Vaccinez-vous en toute sérénité</h3>
            <p class="text-gray-600 mb-4">Prenez rendez-vous dès aujourd'hui.</p>
            <a href="{{ route('register') }}" class="inline-block bg-[#43A047] hover:bg-[#2E7D32] text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300">
                Prendre rendez-vous
            </a>
        </div>
    </div>
</div>
@endsection
