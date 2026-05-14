<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $conseil['titre'] }} - SanteRDV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .prose p { margin-bottom: 1rem; line-height: 1.6; }
        .prose h3 { font-size: 1.25rem; font-weight: bold; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #1f2937; }
        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1a6fff 0%, #0d5ae0 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
        }
        .logo-text span {
            background: linear-gradient(135deg, #0d5ae0 0%, #1a6fff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header simple -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('accueil') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] flex items-center justify-center shadow-md">
                        <i class="fas fa-heartbeat text-white text-lg md:text-xl"></i>
                    </div>
                    <div class="logo-text">Sante<span>RDV</span></div>
                </a>
                <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-[#1a6fff] transition">
                    <i class="fas fa-home mr-1"></i> Accueil
                </a>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <div class="bg-gradient-to-br from-white to-gray-50 py-16">
        <div class="container mx-auto px-6 max-w-4xl">
            <a href="{{ route('conseils.index') }}" class="inline-flex items-center gap-2 text-[#1a6fff] hover:text-[#0d5ae0] mb-6 transition">
                <i class="fas fa-arrow-left"></i>
                <span>Retour aux conseils</span>
            </a>
            
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl">
                <div class="relative h-64 md:h-96 overflow-hidden">
                    <img src="{{ $conseil['image'] }}" alt="{{ $conseil['titre'] }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6">
                        <span class="text-white text-sm px-4 py-1.5 rounded-full" style="background-color: {{ $conseil['couleur_categorie'] }}">{{ $conseil['categorie'] }}</span>
                    </div>
                </div>
                <div class="p-6 md:p-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">{{ $conseil['titre'] }}</h1>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {!! $conseil['contenu'] !!}
                    </div>
                    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                        <a href="{{ route('conseils.index') }}" class="inline-flex items-center gap-2 bg-[#1a6fff] hover:bg-[#0d5ae0] text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-book-open"></i>
                            <span>Voir tous les conseils</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer simple -->
    <footer class="bg-gray-900 text-gray-300 py-6">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} SanteRDV. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>
