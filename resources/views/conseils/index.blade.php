<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tous nos conseils santé - SanteRDV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .main-header {
            background-color: rgba(255,255,255,0.98);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(229,231,235,1);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .sticky-header { position: sticky; top: 0; z-index: 1000; background-color: rgba(255,255,255,0.98); backdrop-filter: blur(10px); box-shadow: 0 4px 20px rgba(0,0,0,0.05); transition: all 0.3s ease; }
        .logo-text { font-family: 'Poppins', sans-serif; font-size: 1.6rem; font-weight: 800; background: linear-gradient(135deg, #1a6fff 0%, #0d5ae0 100%); -webkit-background-clip: text; background-clip: text; color: transparent; letter-spacing: -0.5px; }
        .logo-text span { background: linear-gradient(135deg, #0d5ae0 0%, #1a6fff 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: linear-gradient(90deg, #1a6fff, #0d5ae0); transition: width 0.3s ease; border-radius: 2px; }
        .nav-link:hover::after { width: 100%; }
        .menu-open .burger-line:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .menu-open .burger-line:nth-child(2) { opacity: 0; }
        .menu-open .burger-line:nth-child(3) { transform: rotate(-45deg) translate(7px, -7px); }
        .sticky-header.scrolled { padding-top: 0.5rem; padding-bottom: 0.5rem; background-color: rgba(255,255,255,0.98); box-shadow: 0 4px 25px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="bg-white font-sans antialiased" style="font-family: 'Poppins', sans-serif;">

    <!-- Header / Navbar -->
    <header class="main-header sticky-header">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('accueil') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] flex items-center justify-center shadow-md">
                        <i class="fas fa-heartbeat text-white text-lg md:text-xl"></i>
                    </div>
                    <div class="logo-text">Sante<span>RDV</span></div>
                </a>
            </div>
            <nav class="hidden md:flex items-center space-x-10 font-medium">
                <a href="{{ route('accueil') }}#accueil" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Accueil</a>
                <a href="{{ route('accueil') }}#services" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Services</a>
                <a href="{{ route('accueil') }}#specialistes" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Spécialistes</a>
                <a href="{{ route('accueil') }}#conseils" class="nav-link text-[#1a6fff] transition duration-300 relative font-semibold">Conseils</a>
                <a href="{{ route('accueil') }}#contact" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Contact</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="hidden md:inline-block text-[#4a5568] hover:text-[#1a6fff] transition font-medium text-sm">Connexion</a>
                <a href="{{ route('register') }}" class="hidden md:inline-block bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Inscription</a>
                <button id="menuBurger" class="md:hidden flex flex-col items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition duration-300">
                    <span class="burger-line w-6 h-0.5 bg-gray-600 mb-1.5 rounded-full transition-all duration-300"></span>
                    <span class="burger-line w-6 h-0.5 bg-gray-600 mb-1.5 rounded-full transition-all duration-300"></span>
                    <span class="burger-line w-6 h-0.5 bg-gray-600 rounded-full transition-all duration-300"></span>
                </button>
            </div>
        </div>
        <div id="mobileMenu" class="md:hidden hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="container mx-auto px-6 py-4 flex flex-col space-y-3">
                <a href="{{ route('accueil') }}#accueil" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Accueil</a>
                <a href="{{ route('accueil') }}#services" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Services</a>
                <a href="{{ route('accueil') }}#specialistes" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Spécialistes</a>
                <a href="{{ route('accueil') }}#centre" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Le centre</a>
                <a href="{{ route('accueil') }}#conseils" class="mobile-nav-link text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300 font-semibold">Conseils</a>
                <a href="{{ route('accueil') }}#contact" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Contact</a>
                <div class="border-t border-gray-100 my-2"></div>
                <a href="{{ route('login') }}" class="text-[#4a5568] hover:text-[#1a6fff] px-4 py-3 rounded-xl transition duration-300">Connexion</a>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white text-center px-4 py-3 rounded-xl font-semibold transition duration-300">Inscription</a>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <div class="bg-gradient-to-br from-white to-gray-50 py-16">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
                <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider bg-[#1a6fff]/10 px-4 py-1.5 rounded-full inline-block mb-4">Bien-être et prévention</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Tous nos <span class="text-[#1a6fff]">conseils santé</span></h1>
                <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-4"></div>
                <p class="text-gray-600 text-lg">Retrouvez tous nos articles pour prendre soin de votre santé au quotidien</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($conseils as $conseil)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-2 flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $conseil['image'] }}" alt="{{ $conseil['titre'] }}" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="text-white text-xs px-3 py-1 rounded-full" style="background-color: {{ $conseil['couleur_categorie'] }}">{{ $conseil['categorie'] }}</span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $conseil['titre'] }}</h3>
                        <p class="text-gray-500 text-sm mb-6 flex-1">{{ $conseil['resume'] }}</p>
                        <div class="text-center">
                            <a href="{{ route('conseil.show', $conseil['id']) }}" class="inline-flex items-center justify-center gap-2 bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold px-6 py-2.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg">
                                <span>Lire la suite</span>
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $conseils->links() }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-xl font-bold text-[#1a6fff]">SanteRDV</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Rendez-vous médical simplifié, suivi intelligent.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('accueil') }}#accueil" class="text-gray-400 text-sm hover:text-[#1a6fff] transition">Accueil</a></li>
                        <li><a href="{{ route('accueil') }}#services" class="text-gray-400 text-sm hover:text-[#1a6fff] transition">Services</a></li>
                        <li><a href="{{ route('accueil') }}#specialistes" class="text-gray-400 text-sm hover:text-[#1a6fff] transition">Spécialistes</a></li>
                        <li><a href="{{ route('accueil') }}#centre" class="text-gray-400 text-sm hover:text-[#1a6fff] transition">Notre centre</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3">Informations légales</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('legal.confidentialite') }}" class="text-gray-400 text-sm hover:text-[#1a6fff] transition">Confidentialité</a></li>
                        <li><a href="{{ route('legal.conditions') }}" class="text-gray-400 text-sm hover:text-[#1a6fff] transition">Conditions d'utilisation</a></li>
                        <li><a href="{{ route('legal.mentions') }}" class="text-gray-400 text-sm hover:text-[#1a6fff] transition">Mentions légales</a></li>
                        <li><a href="{{ route('legal.cookies') }}" class="text-gray-400 text-sm hover:text-[#1a6fff] transition">Cookies</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3">Contact</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-gray-400 text-sm"><i class="fas fa-phone-alt text-[#1a6fff] text-xs"></i> +229 21 30 00 00</li>
                        <li class="flex items-center gap-2 text-gray-400 text-sm"><i class="fas fa-envelope text-[#1a6fff] text-xs"></i> contact@santerdv.bj</li>
                        <li class="flex items-center gap-2 text-gray-400 text-sm"><i class="fas fa-map-marker-alt text-[#1a6fff] text-xs"></i> Porto-Novo, Bénin</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center">
                <p class="text-gray-500 text-xs">&copy; {{ date('Y') }} SanteRDV. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800, easing: 'ease-in-out', offset: 100 });
        
        // Menu burger
        const menuBurger = document.getElementById('menuBurger');
        const mobileMenu = document.getElementById('mobileMenu');
        if (menuBurger && mobileMenu) {
            menuBurger.addEventListener('click', () => {
                menuBurger.classList.toggle('menu-open');
                mobileMenu.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            });
        }
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (mobileMenu) mobileMenu.classList.add('hidden');
                if (menuBurger) menuBurger.classList.remove('menu-open');
                document.body.classList.remove('overflow-hidden');
            });
        });

        // Sticky header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.sticky-header');
            if (header) {
                if (window.scrollY > 50) header.classList.add('scrolled');
                else header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
