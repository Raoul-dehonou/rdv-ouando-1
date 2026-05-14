@extends('layouts.legal')

@section('title', 'Soins infirmiers - SanteRDV')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        <nav class="text-sm mb-6">
            <a href="{{ route('accueil') }}" class="text-[#1E88E5] hover:underline">Accueil</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-600">Soins infirmiers</span>
        </nav>

        <div class="bg-gradient-to-r from-[#1E88E5] to-[#0d5ae0] rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-syringe text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold">Soins infirmiers</h1>
            </div>
            <p class="text-white/90 text-lg">Des soins infirmiers à domicile ou en centre par des professionnels dévoués.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Des soins de qualité à domicile</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Nos infirmiers diplômés interviennent à domicile ou dans notre centre pour vous prodiguer 
                des soins de qualité, dans le respect et la bienveillance.
            </p>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Pansements</h3>
                        <p class="text-gray-500 text-sm">Soins des plaies, escarres, brûlures.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Injections</h3>
                        <p class="text-gray-500 text-sm">Injections intramusculaires, sous-cutanées.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Prélèvements</h3>
                        <p class="text-gray-500 text-sm">Prise de sang, analyses diverses.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#1E88E5] text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800">Soins post-opératoires</h3>
                        <p class="text-gray-500 text-sm">Suivi après intervention chirurgicale.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="font-bold text-gray-800 mb-3">📍 Forfaits de soins</h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Visite à domicile (base)</span>
                        <span class="font-semibold">7 500 FCFA</span>
                    </li>
                    <li class="flex justify-between pb-2 border-b border-gray-200">
                        <span>Pansement simple</span>
                        <span class="font-semibold">3 000 FCFA</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Forfait mensuel (4 visites)</span>
                        <span class="font-semibold">25 000 FCFA</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-gradient-to-r from-[#1E88E5]/10 to-transparent rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Besoin d'une intervention à domicile ?</h3>
            <p class="text-gray-600 mb-4">Contactez-nous pour organiser une visite.</p>
            <a href="{{ route('register') }}" class="inline-block bg-[#43A047] hover:bg-[#2E7D32] text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300">
                Prendre rendez-vous
            </a>
        </div>
    </div>
</div>
@endsection
