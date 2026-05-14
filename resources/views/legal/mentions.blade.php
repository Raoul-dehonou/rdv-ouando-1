@extends('layouts.legal')

@section('title', 'Mentions légales - SanteRDV')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Mentions légales</h1>
            <div class="w-20 h-1 bg-[#1E88E5] mb-6 rounded-full"></div>
            
            <div class="space-y-6 text-gray-700">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Éditeur du site</h2>
                    <p class="text-sm leading-relaxed">
                        <strong>SanteRDV</strong><br>
                        Centre de santé de Ouando<br>
                        Porto-Novo, Bénin<br>
                        Tél : +229 21 30 00 00<br>
                        Email : <a href="mailto:contact@santerdv.bj" class="text-[#1E88E5] hover:underline">contact@santerdv.bj</a><br>
                        Directeur de publication : Dr. Koffi Mensah
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Hébergement</h2>
                    <p class="text-sm leading-relaxed">
                        <strong>Serveurs sécurisés (HDS)</strong><br>
                        Hébergement conforme aux normes de santé<br>
                        Données hébergées en France / Union Européenne
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Propriété intellectuelle</h2>
                    <p class="text-sm leading-relaxed">L'ensemble du contenu du site SanteRDV (textes, logos, images, vidéos) est protégé par le droit d'auteur. Toute reproduction est interdite sans autorisation préalable.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Agrément</h2>
                    <p class="text-sm leading-relaxed">Le Centre de santé de Ouando est agréé par le Ministère de la Santé du Bénin. Numéro d'agrément : 2024/SAN/001.</p>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg mt-4">
                    <p class="text-sm text-gray-700">🔒 Plateforme conforme aux bonnes pratiques de e-santé (HDS)</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
