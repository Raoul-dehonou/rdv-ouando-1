@extends('layouts.legal')

@section('title', 'Kinésithérapie - SanteRDV')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        <nav class="text-sm mb-6">
            <a href="{{ route('accueil') }}" class="text-[#1E88E5] hover:underline">Accueil</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-600">Kinésithérapie</span>
        </nav>

        <div class="bg-gradient-to-r from-[#1E88E5] to-[#0d5ae0] rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-hand-holding-heart text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold">Kinésithérapie</h1>
            </div>
            <p class="text-white/90 text-lg">Des séances de rééducation et de thérapie manuelle pour retrouver votre mobilité.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Retrouvez votre bien-être</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Nos kinésithérapeutes vous accompagnent dans votre rééducation, que ce soit après un accident, 
                une chirurgie ou pour soulager des douleurs chroniques.
            </p>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Rééducation fonctionnelle</h3>
                        <p class="text-gray-500 text-sm">Après fracture, entorse, ou chirurgie.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Massages thérapeutiques</h3>
                        <p class="text-gray-500 text-sm">Soulagement des douleurs musculaires.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Rééducation sportive</h3>
                        <p class="text-gray-500 text-sm">Retour au sport après blessure.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Rééducation respiratoire</h3>
                        <p class="text-gray-500 text-sm">Pour adultes et enfants.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-gray-800 mb-3">📍 Tarifs des séances</h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Séance de kinésithérapie</span>
                        <span class="font-semibold">7 500 FCFA</span>
                    </li>
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Forfait 10 séances</span>
                        <span class="font-semibold">65 000 FCFA</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Massage thérapeutique</span>
                        <span class="font-semibold">10 000 FCFA</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-gradient-to-r from-[#1E88E5]/10 to-transparent rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Besoin d'une rééducation ?</h3>
            <p class="text-gray-600 mb-4">Prenez rendez-vous avec nos kinésithérapeutes.</p>
            <a href="{{ route('register') }}" class="inline-block bg-[#43A047] hover:bg-[#2E7D32] text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300">
                Prendre rendez-vous
            </a>
        </div>
    </div>
</div>
@endsection
