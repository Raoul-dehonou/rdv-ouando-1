<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SanteRDV')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .logo-text {
            font-family: 'Inter', sans-serif;
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
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header simple pour les pages légales -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('accueil') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] flex items-center justify-center shadow-md">
                        <i class="fas fa-heartbeat text-white text-lg md:text-xl"></i>
                    </div>
                    <div class="logo-text">Sante<span>RDV</span></div>
                </a>
                <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-[#1a6fff] transition text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer simple -->
    <footer class="bg-white border-t border-gray-200 py-4">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-500 text-xs">&copy; {{ date('Y') }} SanteRDV. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
