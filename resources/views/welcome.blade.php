<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SanteRDV – Centre de santé de Ouando</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Livewire Styles pour le chatbot -->
    @livewireStyles
    
    <style>
        /* Animations et styles généraux */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fadeInLeft { animation: fadeInLeft 0.8s ease-out forwards; }
        .animate-fadeInRight { animation: fadeInRight 0.8s ease-out forwards; }
        .animate-scaleIn { animation: scaleIn 0.6s ease-out forwards; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
        .delay-5 { animation-delay: 0.5s; opacity: 0; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -12px rgba(0,0,0,0.15); }
        .emergency-btn { transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3); }
        .emergency-btn:hover { transform: scale(1.05); box-shadow: 0 8px 20px rgba(229, 57, 53, 0.4); }
        html { scroll-behavior: smooth; }
        .main-header {
            background-color: rgba(255,255,255,0.98);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(229,231,235,1);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.3s;
        }
        .modal-overlay.active { visibility: visible; opacity: 1; }
        .modal-container {
            background: white;
            border-radius: 1.5rem;
            max-width: 700px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 35px rgba(0,0,0,0.2);
        }
        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            transition: color 0.2s;
        }
        .modal-close:hover { color: #ef4444; }
        body { animation: fadeInUp 0.5s ease-out; }
        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a6fff;
            letter-spacing: -0.5px;
        }
        .logo-text span { color: #1a6fff; }
        .souligne-bleu {
            text-decoration: underline;
            text-decoration-color: #1a6fff;
            text-underline-offset: 8px;
            text-decoration-thickness: 3px;
        }
        .card { transition: all 0.3s ease; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 20px 30px -10px rgba(26, 111, 255, 0.2); }
        
        /* Styles pour le chatbot */
        @keyframes bounce { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-10px); } }
        .animate-bounce { animation: bounce 1.4s ease-in-out infinite; }
        @keyframes typing { 0%, 60%, 100% { transform: translateY(0); opacity: 0.4; } 30% { transform: translateY(-5px); opacity: 1; } }
        .typing-dot { animation: typing 1.4s ease-in-out infinite; }
        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        
        /* Style pour l'icône coeur avec ligne horizontale */
        .heart-icon {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #1a6fff;
            margin-right: 0.5rem;
        }
        .heart-icon .fa-heart {
            font-size: 1.8rem;
            color: #1a6fff;
        }
        .heart-icon .horizontal-line {
            position: absolute;
            width: 70%;
            height: 2px;
            background-color: #1a6fff;
            top: 50%;
            left: 15%;
            transform: translateY(-50%);
            border-radius: 2px;
        }
        
        /* Style pour la carte */
        .map-container {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        }
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
        .image-container {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-white font-sans antialiased" style="font-family: 'Poppins', sans-serif;">

    <!-- ==================== HEADER / NAVBAR ==================== -->
    <header class="main-header sticky-header">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
    <a href="#accueil" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] flex items-center justify-center shadow-md">
            <i class="fas fa-heartbeat text-white text-lg md:text-xl"></i>
        </div>
        <div class="logo-text">Sante<span>RDV</span></div>
    </a>
</div>
            <nav class="hidden md:flex items-center space-x-10 font-medium">
                <a href="#accueil" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Accueil</a>
                <a href="#services" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Services</a>
                <a href="#specialistes" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Spécialistes</a>
                <a href="#conseils" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Conseils</a>
                <a href="#contact" class="nav-link text-[#4a5568] hover:text-[#1a6fff] transition duration-300 relative">Contact</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="hidden md:inline-block text-[#4a5568] hover:text-[#1a6fff] transition font-medium text-sm">Connexion</a>
                <a href="{{ route('register') }}" class="hidden md:inline-block bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Inscription</a>
                <a href="#" id="emergency-nav" class="bg-[#E53935] text-white px-4 py-2.5 rounded-xl flex items-center gap-2 hover:bg-[#C62828] transition-all duration-300 shadow-md">
                    <i class="fas fa-phone-alt text-sm"></i>
                    <span class="hidden md:inline text-sm font-medium">RDV rapide</span>
                </a>
                <button id="menuBurger" class="md:hidden flex flex-col items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition duration-300">
                    <span class="burger-line w-6 h-0.5 bg-gray-600 mb-1.5 rounded-full transition-all duration-300"></span>
                    <span class="burger-line w-6 h-0.5 bg-gray-600 mb-1.5 rounded-full transition-all duration-300"></span>
                    <span class="burger-line w-6 h-0.5 bg-gray-600 rounded-full transition-all duration-300"></span>
                </button>
            </div>
        </div>
        <div id="mobileMenu" class="md:hidden hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="container mx-auto px-6 py-4 flex flex-col space-y-3">
                <a href="#accueil" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Accueil</a>
                <a href="#services" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Services</a>
                <a href="#specialistes" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Spécialistes</a>
                <a href="#centre" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Le centre</a>
                <a href="#conseils" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Conseils</a>
                <a href="#contact" class="mobile-nav-link text-[#4a5568] hover:text-[#1a6fff] hover:bg-gray-50 px-4 py-3 rounded-xl transition duration-300">Contact</a>
                <div class="border-t border-gray-100 my-2"></div>
                <a href="{{ route('login') }}" class="text-[#4a5568] hover:text-[#1a6fff] px-4 py-3 rounded-xl transition duration-300">Connexion</a>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white text-center px-4 py-3 rounded-xl font-semibold transition duration-300">Inscription</a>
            </div>
        </div>
    </header>

    <div class="fixed bottom-6 right-6 z-50">
        <a href="#" id="emergency-fab" class="emergency-btn bg-[#E53935] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-xl hover:bg-[#C62828] transition-all duration-300 hover:scale-105">
            <i class="fas fa-phone-alt text-xl"></i>
        </a>
    </div>

    <style>
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

    <script>
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
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.sticky-header');
            if (header) {
                if (window.scrollY > 50) header.classList.add('scrolled');
                else header.classList.remove('scrolled');
            }
        });
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        function updateActiveLink() {
            let current = '';
            const scrollPosition = window.scrollY + 100;
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionBottom = sectionTop + section.offsetHeight;
                if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) current = section.getAttribute('id');
            });
            navLinks.forEach(link => {
                const href = link.getAttribute('href').substring(1);
                if (href === current) { link.style.color = '#1a6fff'; link.style.fontWeight = '600'; }
                else { link.style.color = '#4a5568'; link.style.fontWeight = '500'; }
            });
        }
        window.addEventListener('scroll', updateActiveLink);
        window.addEventListener('load', updateActiveLink);
    </script>

   <!-- ==================== BANNIÈRE HERO ==================== -->
<section id="accueil" class="relative overflow-hidden" style="background: linear-gradient(135deg, #f0f5ff 0%, #e8f0fe 100%);">
    <div class="absolute top-20 left-10 w-64 h-64 bg-[#1a6fff]/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-80 h-80 bg-[#1a6fff]/5 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-radial from-transparent to-[#f4f8ff] opacity-50"></div>
    <div class="relative z-10 container mx-auto px-6 py-10 md:py-14">
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <div class="lg:w-1/2" data-aos="fade-right" data-aos-duration="1000">
                <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm px-4 py-1.5 rounded-full shadow-sm mb-4">
                    <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span></span>
                    <span class="text-xs font-semibold text-gray-700">Plateforme n°1 au Bénin</span>
                    <span class="text-xs text-gray-400">•</span>
                    <i class="fas fa-clock text-[10px] text-[#1a6fff]"></i>
                    <span class="text-xs text-gray-600">Disponible 24h/24</span>
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight mb-4">
                    <span class="text-gray-900">Prenez soin de votre santé</span>
                    <span class="text-gray-900"> avec </span>
                    <span class="text-[#1a6fff] relative inline-block">SanteRDV<svg class="absolute -bottom-2 left-0 w-full" height="3" viewBox="0 0 200 3" fill="none"><path d="M0 1.5 L200 1.5" stroke="#1a6fff" stroke-width="2" stroke-linecap="round" stroke-dasharray="6 6"/></svg></span>
                </h1>
                <p class="text-gray-600 text-base mb-5 leading-relaxed max-w-lg">La première plateforme de prise de rendez-vous médicaux en ligne au Bénin. Trouvez votre médecin, consultez en toute simplicité et suivez votre parcours de soins.</p>
                <div class="grid grid-cols-3 gap-3 mb-5">
                    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-3 text-center shadow-sm hover:shadow-md transition-all duration-300"><div class="flex items-center justify-center gap-1 mb-1"><i class="fas fa-calendar-alt text-[#1a6fff] text-xs"></i><div class="text-xl font-bold text-gray-800">15<span class="text-[#1a6fff]">+</span></div></div><p class="text-[11px] text-gray-500">Années d'expertise</p></div>
                    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-3 text-center shadow-sm hover:shadow-md transition-all duration-300"><div class="flex items-center justify-center gap-1 mb-1"><i class="fas fa-smile text-[#1a6fff] text-xs"></i><div class="text-xl font-bold text-gray-800">5k<span class="text-[#1a6fff]">+</span></div></div><p class="text-[11px] text-gray-500">Patients accompagnés</p></div>
                    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-3 text-center shadow-sm hover:shadow-md transition-all duration-300"><div class="flex items-center justify-center gap-1 mb-1"><i class="fas fa-user-md text-[#1a6fff] text-xs"></i><div class="text-xl font-bold text-gray-800">{{ isset($medecins) ? $medecins->count() : 0 }}<span class="text-[#1a6fff]">+</span></div></div><p class="text-[11px] text-gray-500">Médecins experts</p></div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-lg mb-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="relative">
                            <i class="fas fa-stethoscope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                            <select id="specialite" class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent bg-white text-gray-700 shadow-sm">
                                <option value="">Spécialité</option>
                                @if(isset($medecins) && $medecins->count())
                                    @foreach($medecins->pluck('specialite')->unique()->filter() as $specialite)
                                        <option value="{{ $specialite }}">{{ $specialite }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="relative">
                            <i class="fas fa-user-md absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                            <select id="medecin" class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent bg-white text-gray-700 shadow-sm">
                                <option value="">Médecin</option>
                                @if(isset($medecins) && $medecins->count())
                                    @foreach($medecins as $medecin)
                                        <option value="{{ $medecin->id }}" data-specialite="{{ $medecin->specialite ?? 'Généraliste' }}">Dr. {{ $medecin->user->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <button id="btnRechercher" class="w-full mt-3 bg-[#1a6fff] text-white font-semibold py-2.5 rounded-lg hover:bg-[#0d5ae0] transition-all duration-300 shadow-md hover:shadow-lg text-sm flex items-center justify-center gap-2 group">
                        <i class="fas fa-search group-hover:scale-110 transition-transform"></i><span>Rechercher un médecin</span>
                    </button>
                </div>

                <div class="flex flex-wrap items-center justify-start gap-4">
                    <div class="flex items-center gap-2"><div class="w-7 h-7 bg-white rounded-full shadow-sm flex items-center justify-center"><i class="fas fa-shield-alt text-[#1a6fff] text-[10px]"></i></div><span class="text-[10px] text-gray-500">Certifié HDS</span></div>
                    <div class="flex items-center gap-2"><div class="w-7 h-7 bg-white rounded-full shadow-sm flex items-center justify-center"><i class="fas fa-lock text-[#1a6fff] text-[10px]"></i></div><span class="text-[10px] text-gray-500">Données sécurisées</span></div>
                    <div class="flex items-center gap-2"><div class="w-7 h-7 bg-white rounded-full shadow-sm flex items-center justify-center"><i class="fas fa-hand-holding-heart text-[#1a6fff] text-[10px]"></i></div><span class="text-[10px] text-gray-500">Approuvé par médecins</span></div>
                </div>
                <div class="flex flex-wrap gap-3 mt-5">
                    <button onclick="openModal()" class="bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2 text-sm group">
                        <i class="fas fa-calendar-check group-hover:scale-110 transition-transform"></i><span>Prendre rendez-vous</span>
                    </button>
                    <a href="#specialistes" class="border-2 border-[#1a6fff] text-[#1a6fff] hover:bg-[#1a6fff] hover:text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-300 flex items-center gap-2 text-sm group">
                        <i class="fas fa-play-circle group-hover:translate-x-0.5 transition-transform"></i><span>Voir les spécialistes</span>
                    </a>
                </div>
            </div>
            <div class="lg:w-2/5 relative" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="absolute -top-8 -right-8 w-32 h-32 bg-[#1a6fff]/20 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-[#1a6fff]/20 rounded-full blur-2xl"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl animate-float"><img src="{{ asset('images/hero-doctor.jpg') }}" alt="Médecin SanteRDV" class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-700"><div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div></div>
                <div class="absolute -bottom-5 left-1/2 transform -translate-x-1/2 bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-2.5 flex items-center gap-2 min-w-[180px]"><div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center"><i class="fas fa-check-circle text-green-600 text-base"></i></div><div><p class="font-bold text-gray-800 text-xs">Certifié HDS</p><p class="text-[10px] text-gray-500">Hébergement sécurisé</p></div></div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes float{0%{transform:translateY(0px)}50%{transform:translateY(-8px)}100%{transform:translateY(0px)}}
    .animate-float{animation:float 5s ease-in-out infinite}
    .bg-gradient-radial{background:radial-gradient(ellipse at center,var(--tw-gradient-stops))}
    
    /* Styles pour la modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s, opacity 0.3s;
    }
    .modal-overlay.active { visibility: visible; opacity: 1; }
    .modal-container {
        background: white;
        border-radius: 1.5rem;
        max-width: 700px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 35px rgba(0,0,0,0.2);
    }
    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
        transition: color 0.2s;
    }
    .modal-close:hover { color: #ef4444; }
</style>

<div id="modalCreneaux" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-close" id="closeModal">&times;</div>
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center"><i class="fas fa-calendar-alt text-[#1a6fff] mr-2"></i>Créneaux disponibles</h3>
            <div id="creneauxList" class="space-y-3 max-h-96 overflow-y-auto"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const specialiteSelect = document.getElementById('specialite');
        const medecinSelect = document.getElementById('medecin');
        const btnRechercher = document.getElementById('btnRechercher');
        const modal = document.getElementById('modalCreneaux');
        const closeModal = document.getElementById('closeModal');
        const creneauxList = document.getElementById('creneauxList');

        // Filtrer les médecins par spécialité
        function filterMedecins() {
            const selectedSpecialite = specialiteSelect.value;
            if (!medecinSelect) return;
            let hasVisible = false;
            for (let i = 0; i < medecinSelect.options.length; i++) {
                const option = medecinSelect.options[i];
                const specialite = option.getAttribute('data-specialite') || '';
                if (selectedSpecialite === '' || specialite === selectedSpecialite) {
                    option.style.display = '';
                    hasVisible = true;
                } else {
                    option.style.display = 'none';
                }
            }
            // Réinitialiser la sélection si l'option sélectionnée est cachée
            if (medecinSelect.selectedOptions[0] && medecinSelect.selectedOptions[0].style.display === 'none') {
                medecinSelect.value = '';
            }
        }

        if (specialiteSelect) {
            specialiteSelect.addEventListener('change', filterMedecins);
            filterMedecins();
        }

        // Recherche des créneaux
        function rechercherCreneaux() {
            const medecinId = medecinSelect.value;
            if (!medecinId) {
                alert('Veuillez sélectionner un médecin.');
                return;
            }

            // Afficher le chargement dans la modal
            if (creneauxList) creneauxList.innerHTML = '<div class="text-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-blue-600"></i><p class="mt-2 text-gray-500">Chargement des créneaux...</p></div>';
            if (modal) modal.classList.add('active');

            // Appel AJAX
            fetch(`/medecin/${medecinId}/creneaux`)
                .then(response => {
                    if (!response.ok) throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(creneaux => {
                    if (!creneauxList) return;
                    if (creneaux.length === 0) {
                        creneauxList.innerHTML = '<div class="text-center py-8 text-gray-500">Aucun créneau disponible pour ce médecin pour le moment.</div>';
                        return;
                    }
                    let html = '';
                    creneaux.forEach(creneau => {
                        html += `
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 flex justify-between items-center flex-wrap gap-3">
                                <div>
                                    <p class="font-semibold text-gray-800">${creneau.date ? new Date(creneau.date).toLocaleDateString('fr-FR') : 'Date non définie'}</p>
                                    <p class="text-sm text-gray-600">${creneau.heure_debut} - ${creneau.heure_fin}</p>
                                </div>
                                <a href="{{ route('register') }}?medecin_id=${medecinId}&date=${creneau.date}&heure=${creneau.heure_debut}" class="bg-[#43A047] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#2E7D32] transition">Prendre rendez-vous</a>
                            </div>
                        `;
                    });
                    creneauxList.innerHTML = html;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    if (creneauxList) creneauxList.innerHTML = '<div class="text-center py-8 text-red-500">Impossible de charger les créneaux. Veuillez réessayer plus tard.</div>';
                });
        }

        if (btnRechercher) {
            btnRechercher.addEventListener('click', rechercherCreneaux);
        }

        // Fermeture de la modal
        if (closeModal) {
            closeModal.addEventListener('click', () => modal.classList.remove('active'));
        }
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.remove('active');
            });
        }

        // Fonction openModal (pour le bouton "Prendre rendez-vous")
        window.openModal = function() {
            if (modal) modal.classList.add('active');
            // Optionnel : on peut aussi charger tous les médecins par défaut, mais on laisse l'utilisateur choisir.
        };
    });
</script>

 

    <!-- ==================== SECTION INSPIRANTE ==================== -->
    <section class="py-20 bg-gradient-to-br from-[#F8FAFC] to-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#1a6fff]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#43A047]/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-2/5 relative" data-aos="fade-right" data-aos-duration="1000">
                    <div class="absolute -top-6 -left-6 w-40 h-40 bg-gradient-to-br from-[#1a6fff]/20 to-transparent rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-gradient-to-tl from-[#43A047]/20 to-transparent rounded-full blur-2xl"></div>
                    <svg class="absolute -top-10 -right-10 w-32 h-32 text-[#1a6fff]/10" viewBox="0 0 200 200" fill="currentColor"><path d="M100,0 C155,0 200,45 200,100 C200,155 155,200 100,200 C45,200 0,155 0,100 C0,45 45,0 100,0Z"/></svg>
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl group"><img src="{{ asset('images/inspiration-sante.jpg') }}" alt="Professionnel de santé" class="w-full h-auto object-cover transition-transform duration-700 group-hover:scale-105"><div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div></div>
                    <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-white rounded-full px-4 py-2 shadow-lg flex items-center gap-2"><i class="fas fa-heartbeat text-[#E53935] text-xs animate-pulse"></i><span class="text-xs font-semibold text-gray-700">Soins de qualité</span></div>
                </div>
                <div class="lg:w-3/5 space-y-8" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="inline-flex items-center gap-2 bg-[#1a6fff]/10 px-5 py-2 rounded-full shadow-sm"><i class="fas fa-heartbeat text-[#1a6fff] text-xs"></i><span class="text-xs font-bold text-[#1a6fff] uppercase tracking-wider">Notre engagement</span></div>
                    <p class="text-gray-700 text-xl leading-relaxed">SanteRDV est la première plateforme de prise de rendez-vous médicaux en ligne au <strong class="text-[#E53935] font-bold relative inline-block">Bénin<svg class="absolute -bottom-1 left-0 w-full" height="2" viewBox="0 0 100 2" fill="none"><path d="M0 1 L100 1" stroke="#E53935" stroke-width="2" stroke-linecap="round"/></svg></strong>. Notre mission : améliorer l'accès aux soins de santé pour tous.</p>
                    <div class="space-y-4">
                        <div class="group bg-white rounded-xl p-5 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer"><div class="flex items-start gap-4"><div class="w-12 h-12 bg-gradient-to-br from-[#1a6fff]/15 to-[#1a6fff]/5 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300"><i class="fas fa-map-marker-alt text-[#1a6fff] text-lg"></i></div><div class="flex-1"><h3 class="text-lg font-bold text-gray-800 mb-2">Un accès facilité aux soins</h3><p class="text-gray-500 text-sm leading-relaxed">Trouvez rapidement un cardiologue, dentiste, pédiatre ou laboratoire près de chez vous et prenez rendez-vous en ligne.</p></div></div></div>
                        <div class="group bg-white rounded-xl p-5 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer"><div class="flex items-start gap-4"><div class="w-12 h-12 bg-gradient-to-br from-[#1a6fff]/15 to-[#1a6fff]/5 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300"><i class="fas fa-folder-open text-[#1a6fff] text-lg"></i></div><div class="flex-1"><h3 class="text-lg font-bold text-gray-800 mb-2">Un meilleur suivi médical</h3><p class="text-gray-500 text-sm leading-relaxed">Gérez votre parcours de santé, partagez vos documents médicaux et recevez des rappels automatiques.</p></div></div></div>
                        <div class="group bg-white rounded-xl p-5 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer"><div class="flex items-start gap-4"><div class="w-12 h-12 bg-gradient-to-br from-[#1a6fff]/15 to-[#1a6fff]/5 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300"><i class="fas fa-clock text-[#1a6fff] text-lg"></i></div><div class="flex-1"><h3 class="text-lg font-bold text-gray-800 mb-2">Une santé accessible 24h/24</h3><p class="text-gray-500 text-sm leading-relaxed">Plus d'attente au téléphone. Prenez le contrôle de votre santé en quelques clics.</p></div></div></div>
                        <div class="group bg-white rounded-xl p-5 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer"><div class="flex items-start gap-4"><div class="w-12 h-12 bg-gradient-to-br from-[#43A047]/15 to-[#43A047]/5 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300"><i class="fas fa-user-md text-[#43A047] text-lg"></i></div><div class="flex-1"><h3 class="text-lg font-bold text-gray-800 mb-2">Votre espace patient connecté</h3><p class="text-gray-500 text-sm leading-relaxed">Gérez votre santé en toute simplicité depuis un seul endroit.</p></div></div></div>
                    </div>
                    <div class="pt-4"><a href="{{ route('register') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 group hover:-translate-y-0.5"><span>Créer un compte gratuitement</span><i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i></a></div>
                </div>
            </div>
        </div>
    </section>

<!-- ==================== SECTION URGENCE ==================== -->
    <section class="py-20 bg-gradient-to-b from-[#F8FAFC] to-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#E53935]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#1a6fff]/5 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-6xl mx-auto">
                
                <!-- BANDE ROUGE APPEL URGENT -->
                <div class="mb-10" data-aos="fade-up" data-aos-duration="800">
                    <div class="bg-gradient-to-r from-[#E53935] to-[#C62828] rounded-2xl shadow-xl overflow-hidden">
                        <div class="flex flex-col md:flex-row items-center justify-between p-6 md:p-8">
                            <div class="flex items-center gap-4 mb-4 md:mb-0">
                                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center animate-pulse">
                                    <i class="fas fa-phone-alt text-white text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-white/80 text-xs uppercase tracking-wider font-semibold">Urgence médicale 24h/24</p>
                                    <h3 class="text-white text-xl md:text-2xl font-bold">Appeler notre service médical </h3>
                                </div>
                            </div>
                            <a href="tel:+22921300000" class="flex items-center gap-3 bg-white text-[#E53935] px-6 py-3 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group">
                                <i class="fas fa-phone-alt text-[#E53935] group-hover:animate-pulse"></i>
                                <span>+229 21 30 00 00</span>
                                <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mb-14" data-aos="fade-up" data-aos-duration="800">
                    <div class="inline-flex items-center gap-2 bg-[#E53935]/10 px-5 py-2 rounded-full mb-4"><i class="fas fa-bell text-[#E53935] text-xs animate-pulse"></i><span class="text-xs font-bold text-[#E53935] uppercase tracking-wider">Urgence 24h/24</span></div>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Besoin d'une prise en charge <span class="text-[#E53935]">urgente</span> ?</h2>
                    <div class="w-20 h-1 bg-[#E53935] mx-auto rounded-full mb-5"></div>
                    <p class="text-gray-500 text-lg max-w-2xl mx-auto">Une prise en charge rapide peut sauver des vies. Si vous ou un proche présentez des symptômes graves, n'attendez pas.</p>
                </div>
                <div class="grid lg:grid-cols-2 gap-10">
                    <div class="space-y-6" data-aos="fade-right" data-aos-duration="800" data-aos-delay="100">
                        <div class="group relative bg-gradient-to-br from-red-50 to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 overflow-hidden border-2 border-red-200"><div class="p-6"><div class="flex items-center justify-between mb-4"><div class="flex items-center gap-3"><div class="w-14 h-14 bg-gradient-to-br from-[#E53935] to-[#C62828] rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300"><i class="fas fa-ambulance text-white text-2xl"></i></div><div><p class="text-xs font-semibold text-[#E53935] uppercase tracking-wider">Numéro principal</p><p class="font-bold text-gray-800">Numéro d'urgence unique</p></div></div><div class="text-5xl font-black text-[#E53935]">112</div></div><p class="text-xs text-gray-500">Gratuit - Disponible 24h/24</p><div class="mt-4"><a href="tel:112" class="inline-flex items-center gap-2 text-[#E53935] font-semibold text-sm group/link"><span>Appeler immédiatement</span><i class="fas fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i></a></div></div></div>
                        <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1 overflow-hidden"><div class="p-5"><div class="flex items-center justify-between"><div class="flex items-center gap-3"><div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300"><i class="fas fa-shield-alt text-blue-600 text-xl"></i></div><div><p class="font-semibold text-gray-800">Police / Gendarmerie</p><p class="text-xs text-gray-500">Intervention rapide</p></div></div><div class="text-4xl font-bold text-blue-600">117</div></div><div class="mt-3"><a href="tel:117" class="inline-flex items-center gap-2 text-blue-600 text-sm group/link"><span>Appeler</span><i class="fas fa-phone-alt text-xs group-hover/link:translate-x-1 transition-transform"></i></a></div></div></div>
                        <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1 overflow-hidden"><div class="p-5"><div class="flex items-center justify-between"><div class="flex items-center gap-3"><div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300"><i class="fas fa-fire-extinguisher text-orange-600 text-xl"></i></div><div><p class="font-semibold text-gray-800">Pompiers</p><p class="text-xs text-gray-500">Incendie - Secours</p></div></div><div class="text-4xl font-bold text-orange-600">118</div></div><div class="mt-3"><a href="tel:118" class="inline-flex items-center gap-2 text-orange-600 text-sm group/link"><span>Appeler</span><i class="fas fa-phone-alt text-xs group-hover/link:translate-x-1 transition-transform"></i></a></div></div></div>
                        <div class="bg-white rounded-2xl shadow-md p-6 mt-6"><div class="flex items-center gap-2 mb-4"><i class="fas fa-exclamation-triangle text-[#E53935] text-lg"></i><h4 class="font-bold text-gray-800">Symptômes graves</h4><span class="text-xs bg-red-100 text-[#E53935] px-2 py-0.5 rounded-full">Urgence</span></div><div class="grid grid-cols-1 sm:grid-cols-2 gap-3"><div class="space-y-2"><div class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 transition"><i class="fas fa-circle text-[#E53935] text-[6px]"></i><span class="text-sm text-gray-700">Difficulté à respirer</span></div><div class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 transition"><i class="fas fa-circle text-[#E53935] text-[6px]"></i><span class="text-sm text-gray-700">Douleur thoracique soudaine</span></div><div class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 transition"><i class="fas fa-circle text-[#E53935] text-[6px]"></i><span class="text-sm text-gray-700">Perte de connaissance</span></div><div class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 transition"><i class="fas fa-circle text-[#E53935] text-[6px]"></i><span class="text-sm text-gray-700">Convulsions</span></div></div><div class="space-y-2"><div class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 transition"><i class="fas fa-circle text-[#E53935] text-[6px]"></i><span class="text-sm text-gray-700">Saignement abondant</span></div><div class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 transition"><i class="fas fa-circle text-[#E53935] text-[6px]"></i><span class="text-sm text-gray-700">Intoxication</span></div><div class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 transition"><i class="fas fa-circle text-[#E53935] text-[6px]"></i><span class="text-sm text-gray-700">Traumatisme grave</span></div><div class="flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 transition"><i class="fas fa-circle text-[#E53935] text-[6px]"></i><span class="text-sm text-gray-700">Douleurs abdominales intenses</span></div></div></div></div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                        <div class="bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] px-6 py-5"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center animate-pulse"><i class="fas fa-ambulance text-white text-lg"></i></div><h3 class="text-xl font-bold text-white">Signaler une urgence</h3></div></div>
                        <div class="p-6">
                            <div class="bg-blue-50 rounded-xl p-4 mb-6 flex items-start gap-3 border-l-4 border-[#1a6fff] shadow-sm"><div class="w-8 h-8 bg-[#1a6fff]/15 rounded-lg flex items-center justify-center"><i class="fas fa-info-circle text-[#1a6fff] text-base"></i></div><div><p class="text-sm font-semibold text-gray-800">Information importante</p><p class="text-xs text-gray-600">Ce formulaire est destiné aux situations qui ne relèvent pas des secours immédiats. Notre équipe vous recontactera dans les plus brefs délais.</p></div></div>
                            <form id="urgentForm" class="space-y-5">
                                <div><label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-user text-[#1a6fff] mr-2"></i> Votre nom complet</label><input type="text" id="urgentName" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent transition-all duration-300 outline-none" placeholder="Ex: Jean Dupont"></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-phone text-[#1a6fff] mr-2"></i> Numéro de téléphone</label><input type="tel" id="urgentPhone" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent transition-all duration-300 outline-none" placeholder="+229 XX XX XX XX"></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-notes-medical text-[#1a6fff] mr-2"></i> Description de la situation</label><textarea id="urgentDesc" rows="4" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent transition-all duration-300 outline-none resize-none" placeholder="Décrivez les symptômes ou la situation..."></textarea></div>
                                <button type="button" id="sendUrgentBtn" class="w-full bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] hover:shadow-xl text-white font-bold py-3.5 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-md group/btn hover:-translate-y-0.5"><i class="fas fa-paper-plane group-hover/btn:translate-x-1 transition-transform"></i><span>Envoyer l'alerte</span></button>
                            </form>
                            <p class="text-xs text-gray-400 mt-4 text-center flex items-center justify-center gap-1"><i class="fas fa-lock text-[10px]"></i> Vos informations sont confidentielles et sécurisées.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="fixed bottom-6 right-6 z-50 group">
        <a href="#" id="emergency-fab" class="relative flex items-center justify-center w-14 h-14 bg-gradient-to-r from-[#E53935] to-[#C62828] text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group"><i class="fas fa-phone-alt text-xl animate-pulse"></i><span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-gray-800 text-white text-xs px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none"><i class="fas fa-phone-alt mr-1"></i> Appeler les secours</span></a>
    </div>

    <!-- ==================== SECTION : VOTRE ESPACE PATIENT CONNECTÉ ==================== -->
    <section class="py-20 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="800">
                    <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider">Plateforme sécurisée</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-4">Votre espace patient connecté</h2>
                    <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-4"></div>
                    <p class="text-gray-500 text-base max-w-2xl mx-auto">Gérez votre santé en toute simplicité depuis un seul endroit</p>
                </div>
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="flex flex-col lg:flex-row items-stretch">
                        <div class="lg:w-1/2 p-8 lg:p-10">
                            <div class="flex items-center gap-3 mb-6"><div class="w-12 h-12 bg-[#1a6fff]/10 rounded-xl flex items-center justify-center"><i class="fas fa-notes-medical text-2xl text-[#1a6fff]"></i></div><h3 class="text-2xl font-bold text-gray-800">Espace patient</h3></div>
                            <p class="text-gray-600 mb-6 leading-relaxed">Créez votre compte gratuitement et accédez à tous vos services de santé : prise de rendez-vous, historique médical, documents partagés et bien plus encore.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-300"><div class="w-10 h-10 bg-[#1a6fff]/10 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-comments text-lg text-[#1a6fff]"></i></div><div><h4 class="font-semibold text-gray-800 text-sm">Communication directe</h4><p class="text-gray-500 text-xs">Échangez avec vos praticiens en toute sécurité.</p></div></div>
                                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-300"><div class="w-10 h-10 bg-[#1a6fff]/10 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-history text-lg text-[#1a6fff]"></i></div><div><h4 class="font-semibold text-gray-800 text-sm">Historique médical</h4><p class="text-gray-500 text-xs">Consultez votre parcours de soins.</p></div></div>
                                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-300"><div class="w-10 h-10 bg-[#1a6fff]/10 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-share-alt text-lg text-[#1a6fff]"></i></div><div><h4 class="font-semibold text-gray-800 text-sm">Partage de documents</h4><p class="text-gray-500 text-xs">Ordonnances, examens, résultats.</p></div></div>
                                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-300"><div class="w-10 h-10 bg-[#1a6fff]/10 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-bell text-lg text-[#1a6fff]"></i></div><div><h4 class="font-semibold text-gray-800 text-sm">Rappels automatiques</h4><p class="text-gray-500 text-xs">Notifications avant vos rendez-vous.</p></div></div>
                            </div>
                            <div class="flex items-center gap-2 p-3 bg-green-50 rounded-xl border border-green-100"><i class="fas fa-shield-alt text-green-600"></i><p class="text-xs text-gray-600">Toutes vos données sont hébergées de manière sécurisée et conforme HDS.</p></div>
                            <div class="mt-8"><a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg group"><span>Créer mon compte gratuitement</span><i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i></a></div>
                        </div>
                        <div class="lg:w-1/2 bg-gradient-to-br from-[#1a6fff]/5 to-transparent flex items-center justify-center p-8 lg:p-10"><div class="relative"><div class="absolute -top-10 -right-10 w-32 h-32 bg-[#1a6fff]/10 rounded-full"></div><div class="absolute -bottom-10 -left-10 w-24 h-24 bg-[#1a6fff]/5 rounded-full"></div><img src="{{ asset('images/espace-patient-connecte.png') }}" alt="Espace patient connecté" class="relative z-10 w-full max-w-md mx-auto rounded-2xl shadow-lg" onerror="this.src='https://placehold.co/500x400/1a6fff/white?text=Espace+Patient'"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION : COMMENT ÇA MARCHE ==================== -->
    <section class="py-20" style="background-color: #f4f8ff;">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-duration="800">
                <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider">Processus simple</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-4">Comment ça marche ?</h2>
                <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-4"></div>
                <p class="text-gray-600">Prenez rendez-vous en ligne en seulement quelques étapes simples</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <div class="relative" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"><div class="flex flex-col items-center text-center"><div class="relative mb-4"><div class="w-20 h-20 rounded-full bg-white shadow-lg flex items-center justify-center" style="box-shadow:0 10px 25px -5px rgba(26,111,255,0.2)"><i class="fas fa-user-plus text-[#1a6fff] text-2xl"></i></div><div class="absolute -top-2 -right-2 w-7 h-7 bg-[#1a6fff] rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">1</div></div><h3 class="font-bold text-gray-800 mb-2">Créer un compte</h3><p class="text-gray-500 text-sm">Inscrivez-vous gratuitement en quelques minutes</p></div></div>
                <div class="relative" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"><div class="flex flex-col items-center text-center"><div class="relative mb-4"><div class="w-20 h-20 rounded-full bg-white shadow-lg flex items-center justify-center" style="box-shadow:0 10px 25px -5px rgba(26,111,255,0.2)"><i class="fas fa-search text-[#1a6fff] text-2xl"></i></div><div class="absolute -top-2 -right-2 w-7 h-7 bg-[#1a6fff] rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">2</div></div><h3 class="font-bold text-gray-800 mb-2">Rechercher</h3><p class="text-gray-500 text-sm">Trouvez un médecin par spécialité ou par nom</p></div></div>
                <div class="relative" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300"><div class="flex flex-col items-center text-center"><div class="relative mb-4"><div class="w-20 h-20 rounded-full bg-white shadow-lg flex items-center justify-center" style="box-shadow:0 10px 25px -5px rgba(26,111,255,0.2)"><i class="fas fa-calendar-check text-[#1a6fff] text-2xl"></i></div><div class="absolute -top-2 -right-2 w-7 h-7 bg-[#1a6fff] rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">3</div></div><h3 class="font-bold text-gray-800 mb-2">Choisir un créneau</h3><p class="text-gray-500 text-sm">Sélectionnez la date et l'heure qui vous arrangent</p></div></div>
                <div class="relative" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400"><div class="flex flex-col items-center text-center"><div class="relative mb-4"><div class="w-20 h-20 rounded-full bg-white shadow-lg flex items-center justify-center" style="box-shadow:0 10px 25px -5px rgba(26,111,255,0.2)"><i class="fas fa-check-circle text-[#1a6fff] text-2xl"></i></div><div class="absolute -top-2 -right-2 w-7 h-7 bg-[#1a6fff] rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">4</div></div><h3 class="font-bold text-gray-800 mb-2">Confirmer</h3><p class="text-gray-500 text-sm">Validez votre rendez-vous en un clic</p></div></div>
                <div class="relative" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500"><div class="flex flex-col items-center text-center"><div class="relative mb-4"><div class="w-20 h-20 rounded-full bg-white shadow-lg flex items-center justify-center" style="box-shadow:0 10px 25px -5px rgba(26,111,255,0.2)"><i class="fas fa-envelope text-[#1a6fff] text-2xl"></i></div><div class="absolute -top-2 -right-2 w-7 h-7 bg-[#1a6fff] rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">5</div></div><h3 class="font-bold text-gray-800 mb-2">Confirmation</h3><p class="text-gray-500 text-sm">Recevez une confirmation par SMS et email</p></div></div>
            </div>
            <div class="text-center mt-12" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600"><a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold px-8 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl group"><span>Commencer maintenant</span><i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i></a></div>
        </div>
    </section>

    <!-- ==================== SECTION SERVICES ==================== -->
    <section id="services" class="py-16 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up" data-aos-duration="800">
                <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider">Ce que nous proposons</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-3">Nos services</h2>
                <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-3"></div>
                <p class="text-gray-600">Des soins de qualité pour toute la famille</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 flex flex-col h-full" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"><div class="relative h-36 overflow-hidden"><img src="{{ asset('images/services/consultations.jpg') }}" alt="Consultations médicales" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/400x200/1a6fff/white?text=Consultations'"><div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div><div class="absolute bottom-3 left-3"><div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center"><i class="fas fa-stethoscope text-white text-base"></i></div></div></div><div class="p-4 flex-1 flex flex-col"><h3 class="text-lg font-bold text-gray-800 mb-1">Consultations médicales</h3><p class="text-gray-500 text-xs mb-3 flex-1 leading-relaxed">Des consultations généralistes et spécialisées pour toute la famille.</p><div class="flex flex-wrap gap-1.5 mb-4"><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Médecine générale</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Spécialistes</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Téléconsultation</span></div><a href="{{ route('service.consultations') }}" class="w-full bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold py-2 rounded-lg transition-all duration-300 text-center text-sm flex items-center justify-center gap-2 group/btn"><span>En savoir plus</span><i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i></a></div></div>
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 flex flex-col h-full" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"><div class="relative h-36 overflow-hidden"><img src="{{ asset('images/services/soins-dentaires.jpg') }}" alt="Soins dentaires" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/400x200/1a6fff/white?text=Soins+Dentaires'"><div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div><div class="absolute bottom-3 left-3"><div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center"><i class="fas fa-tooth text-white text-base"></i></div></div></div><div class="p-4 flex-1 flex flex-col"><h3 class="text-lg font-bold text-gray-800 mb-1">Soins dentaires</h3><p class="text-gray-500 text-xs mb-3 flex-1 leading-relaxed">Des soins dentaires complets pour un sourire éclatant.</p><div class="flex flex-wrap gap-1.5 mb-4"><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Détartrage</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Soins caries</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Orthodontie</span></div><a href="{{ route('service.soins-dentaires') }}" class="w-full bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold py-2 rounded-lg transition-all duration-300 text-center text-sm flex items-center justify-center gap-2 group/btn"><span>En savoir plus</span><i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i></a></div></div>
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 flex flex-col h-full" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300"><div class="relative h-36 overflow-hidden"><img src="{{ asset('images/services/soins-infirmiers.jpg') }}" alt="Soins infirmiers" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/400x200/1a6fff/white?text=Soins+Infirmiers'"><div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div><div class="absolute bottom-3 left-3"><div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center"><i class="fas fa-syringe text-white text-base"></i></div></div></div><div class="p-4 flex-1 flex flex-col"><h3 class="text-lg font-bold text-gray-800 mb-1">Soins infirmiers</h3><p class="text-gray-500 text-xs mb-3 flex-1 leading-relaxed">Des soins infirmiers à domicile ou en centre par des professionnels dévoués.</p><div class="flex flex-wrap gap-1.5 mb-4"><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Pansements</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Injections</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Soins à domicile</span></div><a href="{{ route('service.soins-infirmiers') }}" class="w-full bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold py-2 rounded-lg transition-all duration-300 text-center text-sm flex items-center justify-center gap-2 group/btn"><span>En savoir plus</span><i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i></a></div></div>
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 flex flex-col h-full" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400"><div class="relative h-36 overflow-hidden"><img src="{{ asset('images/services/vaccinations.jpg') }}" alt="Vaccinations" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/400x200/1a6fff/white?text=Vaccinations'"><div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div><div class="absolute bottom-3 left-3"><div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center"><i class="fas fa-vaccine text-white text-base"></i></div></div></div><div class="p-4 flex-1 flex flex-col"><h3 class="text-lg font-bold text-gray-800 mb-1">Vaccinations</h3><p class="text-gray-500 text-xs mb-3 flex-1 leading-relaxed">Calendrier vaccinal complet avec rappels automatiques par SMS.</p><div class="flex flex-wrap gap-1.5 mb-4"><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Enfants</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Adultes</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Voyage</span></div><a href="{{ route('service.vaccinations') }}" class="w-full bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold py-2 rounded-lg transition-all duration-300 text-center text-sm flex items-center justify-center gap-2 group/btn"><span>En savoir plus</span><i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i></a></div></div>
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 flex flex-col h-full" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500"><div class="relative h-36 overflow-hidden"><img src="{{ asset('images/services/suivi-grossesse.jpg') }}" alt="Suivi de grossesse" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/400x200/1a6fff/white?text=Suivi+Grossesse'"><div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div><div class="absolute bottom-3 left-3"><div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center"><i class="fas fa-baby-carriage text-white text-base"></i></div></div></div><div class="p-4 flex-1 flex flex-col"><h3 class="text-lg font-bold text-gray-800 mb-1">Suivi de grossesse</h3><p class="text-gray-500 text-xs mb-3 flex-1 leading-relaxed">Un accompagnement personnalisé pour les futures mamans.</p><div class="flex flex-wrap gap-1.5 mb-4"><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Consultations prénatales</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Échographies</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Préparation accouchement</span></div><a href="{{ route('service.suivi-grossesse') }}" class="w-full bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold py-2 rounded-lg transition-all duration-300 text-center text-sm flex items-center justify-center gap-2 group/btn"><span>En savoir plus</span><i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i></a></div></div>
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 flex flex-col h-full" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600"><div class="relative h-36 overflow-hidden"><img src="{{ asset('images/services/kinesitherapie.jpg') }}" alt="Kinésithérapie" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/400x200/1a6fff/white?text=Kinésithérapie'"><div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div><div class="absolute bottom-3 left-3"><div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center"><i class="fas fa-hand-holding-heart text-white text-base"></i></div></div></div><div class="p-4 flex-1 flex flex-col"><h3 class="text-lg font-bold text-gray-800 mb-1">Kinésithérapie</h3><p class="text-gray-500 text-xs mb-3 flex-1 leading-relaxed">Des séances de rééducation pour retrouver votre mobilité.</p><div class="flex flex-wrap gap-1.5 mb-4"><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Rééducation</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Massages thérapeutiques</span><span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-full">Sport</span></div><a href="{{ route('service.kinesitherapie') }}" class="w-full bg-[#1a6fff] hover:bg-[#0d5ae0] text-white font-semibold py-2 rounded-lg transition-all duration-300 text-center text-sm flex items-center justify-center gap-2 group/btn"><span>En savoir plus</span><i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i></a></div></div>
            </div>
        </div>
    </section>

<!-- ==================== SECTION CONSEILS SANTÉ ==================== -->
<section id="conseils" class="py-20 bg-gradient-to-br from-white to-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up" data-aos-duration="800">
            <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider bg-[#1a6fff]/10 px-4 py-1.5 rounded-full inline-block mb-4">Bien-être et prévention</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-2 mb-4 leading-tight">Conseils <span class="text-[#1a6fff]">santé</span></h2>
            <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-5"></div>
            <p class="text-gray-600 text-lg max-w-lg mx-auto">Des astuces et recommandations pour prendre soin de votre santé au quotidien</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $conseils = [
                    [
                        'id' => 1,
                        'titre' => '5 aliments à privilégier pour booster votre immunité',
                        'categorie' => 'Nutrition',
                        'couleur_categorie' => '#1a6fff',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=500&h=300&fit=crop',
                        'resume' => 'Découvrez les aliments riches en vitamines qui renforcent vos défenses naturelles.',
                        'contenu' => 'Les agrumes comme l\'orange et le citron sont riches en vitamine C...'
                    ],
                    [
                        'id' => 2,
                        'titre' => 'Les bienfaits d\'une activité physique régulière',
                        'categorie' => 'Sport',
                        'couleur_categorie' => '#43A047',
                        'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=300&fit=crop',
                        'resume' => 'Comment 30 minutes d\'exercice par jour peuvent transformer votre santé.',
                        'contenu' => 'L\'activité physique régulière réduit les risques de maladies cardiovasculaires...'
                    ],
                    [
                        'id' => 3,
                        'titre' => 'Les clés d\'un sommeil réparateur',
                        'categorie' => 'Bien-être',
                        'couleur_categorie' => '#E53935',
                        'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=500&h=300&fit=crop',
                        'resume' => 'Adoptez les bonnes habitudes pour mieux dormir et récupérer.',
                        'contenu' => 'Un adulte a besoin de 7 à 9 heures de sommeil par nuit...'
                    ]
                ];
            @endphp
            
            @foreach(array_slice($conseils, 0, 3) as $conseil)
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
        <div class="text-center mt-12">
            <a href="{{ route('conseils.index') }}" class="inline-flex items-center gap-2 bg-[#1a6fff] hover:bg-[#0d5ae0] text-white px-8 py-3 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-eye"></i>
                <span>Voir tous les conseils</span>
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>

    <!-- ==================== SECTION CONTACT ==================== -->
    <section id="contact" class="py-20 bg-gradient-to-b from-[#F8FAFC] to-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up" data-aos-duration="800">
                <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider bg-[#1a6fff]/10 px-4 py-1.5 rounded-full inline-block mb-4">Nous contacter</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-2 mb-4 leading-tight">Une question ? <span class="text-[#1a6fff]">Écrivez-nous</span></h2>
                <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-5"></div>
                <p class="text-gray-600 text-lg max-w-lg mx-auto">Notre équipe est à votre écoute pour répondre à toutes vos questions</p>
            </div>
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="space-y-8" data-aos="fade-right" data-aos-duration="800">
                        <div class="bg-white rounded-2xl p-8 shadow-lg">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-envelope text-[#1a6fff]"></i> Formulaire de contact</h3>
                            <form id="contactForm" class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom complet <span class="text-red-500">*</span></label>
                                    <input type="text" id="contactName" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent outline-none transition" placeholder="Jean Dupont">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" id="contactEmail" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent outline-none transition" placeholder="jean@exemple.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                                    <input type="tel" id="contactPhone" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent outline-none transition" placeholder="+229 XX XX XX XX">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sujet <span class="text-red-500">*</span></label>
                                    <select id="contactSubject" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent outline-none transition">
                                        <option value="">Sélectionnez un sujet</option>
                                        <option value="Prise de rendez-vous">Prise de rendez-vous</option>
                                        <option value="Information sur les services">Information sur les services</option>
                                        <option value="Réclamation">Réclamation</option>
                                        <option value="Partenariat">Partenariat</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Message <span class="text-red-500">*</span></label>
                                    <textarea id="contactMessage" rows="5" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent outline-none transition resize-none" placeholder="Votre message..."></textarea>
                                </div>
                                <button type="button" id="sendContactBtn" class="w-full bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white font-bold py-3.5 rounded-xl hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 group">
                                    <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                                    <span>Envoyer le message</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="space-y-8" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                        <div class="bg-gradient-to-br from-[#1a6fff]/5 to-transparent rounded-2xl p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-phone-alt text-[#1a6fff]"></i> Nos coordonnées</h3>
                            <div class="space-y-5">
                                <div class="flex items-start gap-4 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                                    <div class="w-12 h-12 bg-[#1a6fff]/10 rounded-xl flex items-center justify-center"><i class="fas fa-map-marker-alt text-[#1a6fff] text-xl"></i></div>
                                    <div><p class="font-semibold text-gray-800">Adresse</p><p class="text-gray-500 text-sm">Porto-Novo, Bénin</p></div>
                                </div>
                                <div class="flex items-start gap-4 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                                    <div class="w-12 h-12 bg-[#1a6fff]/10 rounded-xl flex items-center justify-center"><i class="fas fa-phone text-[#1a6fff] text-xl"></i></div>
                                    <div><p class="font-semibold text-gray-800">Téléphone</p><p class="text-gray-500 text-sm">+229 21 30 00 00</p></div>
                                </div>
                                <div class="flex items-start gap-4 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                                    <div class="w-12 h-12 bg-[#1a6fff]/10 rounded-xl flex items-center justify-center"><i class="fas fa-envelope text-[#1a6fff] text-xl"></i></div>
                                    <div><p class="font-semibold text-gray-800">Email</p><p class="text-gray-500 text-sm">contact@santerdv.bj</p></div>
                                </div>
                                <div class="flex items-start gap-4 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                                    <div class="w-12 h-12 bg-[#1a6fff]/10 rounded-xl flex items-center justify-center"><i class="fas fa-clock text-[#1a6fff] text-xl"></i></div>
                                    <div><p class="font-semibold text-gray-800">Horaires</p><p class="text-gray-500 text-sm">Lundi - Vendredi : 8h00 - 18h00<br>Samedi : 8h00 - 13h00</p></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl p-8 shadow-lg">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fab fa-facebook-messenger text-[#1a6fff]"></i> Réponse rapide</h3>
                            <p class="text-gray-500 text-sm mb-4">Notre équipe s'engage à vous répondre dans les meilleurs délais (sous 24h ouvrées).</p>
                            <div class="flex gap-4">
                                <a href="#" class="w-12 h-12 bg-[#1877F2]/10 rounded-full flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition text-[#1877F2]"><i class="fab fa-facebook-f text-xl"></i></a>
                                <a href="#" class="w-12 h-12 bg-[#1DA1F2]/10 rounded-full flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition text-[#1DA1F2]"><i class="fab fa-twitter text-xl"></i></a>
                                <a href="#" class="w-12 h-12 bg-[#25D366]/10 rounded-full flex items-center justify-center hover:bg-[#25D366] hover:text-white transition text-[#25D366]"><i class="fab fa-whatsapp text-xl"></i></a>
                                <a href="#" class="w-12 h-12 bg-[#E4405F]/10 rounded-full flex items-center justify-center hover:bg-[#E4405F] hover:text-white transition text-[#E4405F]"><i class="fab fa-instagram text-xl"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION POURQUOI CHOISIR SanteRDV ==================== -->
    <section class="py-20" style="background-color: #f4f8ff;">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-duration="800">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Pourquoi choisir <span class="text-[#1a6fff]">SanteRDV</span> ?</h2>
                <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-4"></div>
                <p class="text-gray-600 text-base">Une plateforme innovante pour une santé accessible et de qualité</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="text-center" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"><div class="w-20 h-20 bg-[#1a6fff]/10 rounded-full flex items-center justify-center mx-auto mb-5"><i class="fas fa-microchip text-3xl text-[#1a6fff]"></i></div><h3 class="text-xl font-bold text-gray-800 mb-3">Technologie avancée</h3><p class="text-gray-500 leading-relaxed max-w-sm mx-auto">Une plateforme moderne et intuitive qui simplifie la gestion de vos rendez-vous médicaux et de votre dossier de santé.</p></div>
                <div class="text-center" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"><div class="w-20 h-20 bg-[#1a6fff]/10 rounded-full flex items-center justify-center mx-auto mb-5"><i class="fas fa-clock text-3xl text-[#1a6fff]"></i></div><h3 class="text-xl font-bold text-gray-800 mb-3">Disponibilité 24/7</h3><p class="text-gray-500 leading-relaxed max-w-sm mx-auto">Accédez à vos rendez-vous et à votre espace patient à tout moment, où que vous soyez, 24 heures sur 24 et 7 jours sur 7.</p></div>
                <div class="text-center" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300"><div class="w-20 h-20 bg-[#1a6fff]/10 rounded-full flex items-center justify-center mx-auto mb-5"><i class="fas fa-user-md text-3xl text-[#1a6fff]"></i></div><h3 class="text-xl font-bold text-gray-800 mb-3">Équipe d'experts</h3><p class="text-gray-500 leading-relaxed max-w-sm mx-auto">Des médecins qualifiés et expérimentés à votre service, avec des spécialités variées pour répondre à tous vos besoins.</p></div>
            </div>
            <div class="mt-16" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                <div class="bg-gradient-to-r from-[#E9F0FD] to-[#E9F0FD] rounded-2xl overflow-hidden shadow-xl">
                    <div class="flex flex-col md:flex-row items-center justify-between p-8 md:p-10">
                        <div class="text-center md:text-left mb-6 md:mb-0">
                            <h3 class="text-xl md:text-2xl font-semibold text-[#2A4A73] mb-3">Besoin d'une assistance médicale immédiate ?</h3>
                            <p class="text-[#6B7C93] text-sm md:text-base max-w-lg leading-relaxed">Notre équipe d'urgence est disponible 24h/24 et 7j/7 pour vous fournir un soutien médical immédiat quand vous en avez le plus besoin.</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="tel:+22921300000" class="inline-flex items-center justify-center gap-3 bg-[#1a6fff] text-white hover:bg-[#0d5ae0] font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl"><i class="fas fa-phone-alt text-lg"></i><span class="text-lg">+229 21 30 00 00</span></a>
                            <a href="#centre" class="inline-flex items-center justify-center gap-3 bg-[#1a6fff] text-white hover:bg-[#0d5ae0] font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl"><i class="fas fa-map-marker-alt text-lg"></i><span class="text-lg">Trouver un centre</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ==================== SECTION PARTENAIRES ==================== -->
    <section class="py-16 bg-gradient-to-b from-white to-gray-50 border-t border-gray-100">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-duration="800">
                <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider bg-[#1a6fff]/10 px-4 py-1.5 rounded-full inline-block mb-4">Ils nous font confiance</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-3">Nos <span class="text-[#1a6fff]">partenaires</span></h2>
                <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-4"></div>
                <p class="text-gray-600 text-base max-w-2xl mx-auto">Des institutions de confiance qui collaborrent avec SanteRDV pour améliorer l'accès aux soins</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 items-center" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                <!-- Partenaire 1 - Ministère de la Santé -->
                <div class="group bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-hospital-user text-5xl text-[#1a6fff] group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="text-xs font-semibold text-gray-700">Ministère de la Santé</p>
                        <p class="text-[10px] text-gray-400">Bénin</p>
                    </div>
                </div>
                
                <!-- Partenaire 2 - CHU -->
                <div class="group bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-building text-5xl text-[#E53935] group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="text-xs font-semibold text-gray-700">CHU Mère-Enfant</p>
                        <p class="text-[10px] text-gray-400">Lagune</p>
                    </div>
                </div>
                
                <!-- Partenaire 3 - OMS -->
                <div class="group bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-globe-africa text-5xl text-[#43A047] group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="text-xs font-semibold text-gray-700">OMS Bénin</p>
                        <p class="text-[10px] text-gray-400">Organisation Mondiale de la Santé</p>
                    </div>
                </div>
                
                <!-- Partenaire 4 - Croix Rouge -->
                <div class="group bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-hand-holding-heart text-5xl text-[#E53935] group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="text-xs font-semibold text-gray-700">Croix-Rouge</p>
                        <p class="text-[10px] text-gray-400">Béninoise</p>
                    </div>
                </div>
                
                <!-- Partenaire 5 - Assurance Maladie -->
                <div class="group bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-shield-alt text-5xl text-[#1a6fff] group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="text-xs font-semibold text-gray-700">CNAM</p>
                        <p class="text-[10px] text-gray-400">Caisse Nationale d'Assurance Maladie</p>
                    </div>
                </div>
            </div>
            
           
                
                
               
                
                
            </div>
            
            
            
        </div>
    </section>

    
    <!-- ==================== SECTION CENTRE DE SANTÉ ==================== -->
    <section id="centre" class="py-10 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-6" data-aos="fade-up" data-aos-duration="800">
                <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider">Notre établissement</span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1 mb-2">Notre centre</h2>
                <div class="w-16 h-0.5 bg-[#1a6fff] mx-auto rounded-full"></div>
                <p class="text-gray-500 text-sm mt-2">Un cadre moderne et des équipes dévouées</p>
            </div>
            <div class="max-w-5xl mx-auto">
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="grid md:grid-cols-2 gap-0">
                        <!-- PHOTO DU CENTRE -->
                        <div class="relative h-56 md:h-auto overflow-hidden image-container">
                            <img src="{{ asset('images/centre-ouando.jpg') }}" alt="Centre de santé de Ouando" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent md:bg-gradient-to-r"></div>
                        </div>
                        <div class="p-5 flex flex-col justify-center">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Centre de santé de Ouando</h3>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[#1a6fff]/10 flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-[#1a6fff] text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">Adresse</p>
                                        <p class="text-gray-500 text-xs">Ouando, Porto-Novo, Bénin</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[#1a6fff]/10 flex items-center justify-center">
                                        <i class="fas fa-user-md text-[#1a6fff] text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">Équipe médicale</p>
                                        <p class="text-gray-500 text-xs">{{ isset($medecins) ? $medecins->count() : 0 }} médecins spécialistes</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[#1a6fff]/10 flex items-center justify-center">
                                        <i class="fas fa-clock text-[#1a6fff] text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">Horaires</p>
                                        <p class="text-gray-500 text-xs">Tous les jours, 8h - 18h</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[#1a6fff]/10 flex items-center justify-center">
                                        <i class="fas fa-phone-alt text-[#1a6fff] text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">Contact</p>
                                        <p class="text-gray-500 text-xs">+229 21 30 00 00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <a target="_blank" href="https://www.google.com/maps/dir/?api=1&destination=Ouando+Porto-Novo+Bénin" class="inline-flex items-center gap-1 bg-[#1a6fff] text-white px-4 py-1.5 rounded-lg font-medium text-xs hover:bg-[#2E7D32] transition-all duration-300 shadow-sm">
                                    <i class="fas fa-directions text-xs"></i>
                                    <span>Obtenir l'itinéraire</span>
                                    <i class="fas fa-external-link-alt text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION AVIS PATIENTS ==================== -->
    <section class="py-16" style="background-color: #f4f8ff;">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="800">
                    <span class="text-[#1a6fff] font-semibold text-sm uppercase tracking-wider bg-[#1a6fff]/10 px-4 py-1.5 rounded-full inline-block mb-4">Témoignages</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-3">Ce que nos patients disent</h2>
                    <div class="w-20 h-1 bg-[#1a6fff] mx-auto rounded-full mb-3"></div>
                    <p class="text-gray-600">Ils nous font confiance avec SanteRDV</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-full overflow-hidden bg-gradient-to-br from-[#1a6fff] to-[#0d5ae0] flex items-center justify-center shadow-md">
                                <img src="{{ asset('images/avatars/marie-k.jpg') }}" alt="Marie K." class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Marie+K&background=1a6fff&color=fff&size=56&bold=true&fontsize=28'">
                            </div>
                            <div><h4 class="font-bold text-gray-800">Marie K.</h4><div class="flex text-yellow-400 text-xs gap-0.5 mt-1"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div></div>
                        </div>
                        <div class="relative"><i class="fas fa-quote-left text-[#1a6fff]/20 text-3xl absolute -top-2 -left-1"></i><p class="text-gray-600 text-sm leading-relaxed pl-4">"Grâce à SanteRDV, j'ai pu prendre rendez-vous rapidement avec un cardiologue. L'interface est très intuitive et les rappels sont très utiles. Je recommande vivement !"</p></div>
                        <div class="mt-4 pt-3 border-t border-gray-100"><p class="text-xs text-gray-400 flex items-center gap-1"><i class="fas fa-calendar-alt text-[#1a6fff] text-[10px]"></i><span>Publié le 15 mars 2025</span></p></div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-full overflow-hidden bg-gradient-to-br from-[#E53935] to-[#C62828] flex items-center justify-center shadow-md">
                                <img src="{{ asset('images/avatars/jean-d.jpg') }}" alt="Jean D." class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Jean+D&background=E53935&color=fff&size=56&bold=true&fontsize=28'">
                            </div>
                            <div><h4 class="font-bold text-gray-800">Jean D.</h4><div class="flex text-yellow-400 text-xs gap-0.5 mt-1"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div></div>
                        </div>
                        <div class="relative"><i class="fas fa-quote-left text-[#1a6fff]/20 text-3xl absolute -top-2 -left-1"></i><p class="text-gray-600 text-sm leading-relaxed pl-4">"Plateforme très pratique pour gérer mes rendez-vous médicaux. Les rappels par SMS sont très utiles et m'évitent d'oublier mes consultations. Un service de qualité !"</p></div>
                        <div class="mt-4 pt-3 border-t border-gray-100"><p class="text-xs text-gray-400 flex items-center gap-1"><i class="fas fa-calendar-alt text-[#1a6fff] text-[10px]"></i><span>Publié le 22 février 2025</span></p></div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-full overflow-hidden bg-gradient-to-br from-[#43A047] to-[#2E7D32] flex items-center justify-center shadow-md">
                                <img src="{{ asset('images/avatars/amelie-l.jpg') }}" alt="Amélie L." class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Amelie+L&background=43A047&color=fff&size=56&bold=true&fontsize=28'">
                            </div>
                            <div><h4 class="font-bold text-gray-800">Amélie L.</h4><div class="flex text-yellow-400 text-xs gap-0.5 mt-1"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div></div>
                        </div>
                        <div class="relative"><i class="fas fa-quote-left text-[#1a6fff]/20 text-3xl absolute -top-2 -left-1"></i><p class="text-gray-600 text-sm leading-relaxed pl-4">"Service exceptionnel ! Mon médecin traitant a pu consulter mon historique médical directement. Je recommande vivement SanteRDV à toutes les familles. Bravo à toute l'équipe !"</p></div>
                        <div class="mt-4 pt-3 border-t border-gray-100"><p class="text-xs text-gray-400 flex items-center gap-1"><i class="fas fa-calendar-alt text-[#1a6fff] text-[10px]"></i><span>Publié le 5 janvier 2025</span></p></div>
                    </div>
                </div>
                <div class="text-center mt-6 pb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <button id="laisserAvisBtn" class="inline-flex items-center gap-2 bg-[#1a6fff] hover:bg-[#0d5ae0] text-white px-8 py-3.5 rounded-xl font-semibold text-sm transition-all duration-300 shadow-md hover:shadow-lg"><i class="fas fa-pen-alt text-sm"></i><span>Donner mon avis</span></button>
                </div>
            </div>
        </div>
    </section>

    <div id="avisModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-[9999] p-4 hidden" style="display: none;">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative mx-auto my-auto">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-200 z-10"><i class="fas fa-times text-xl"></i></button>
            <div class="mb-5 pr-8"><h3 class="text-2xl font-bold text-gray-800">Donnez votre avis</h3></div>
            <form id="avisForm">
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Votre nom</label><input type="text" id="avisNomInput" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a6fff] focus:border-[#1a6fff] transition outline-none" placeholder="Ex: Jean Dupont"></div>
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Votre photo (optionnel)</label><input type="file" id="avisPhotoInput" accept="image/*" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a6fff] focus:border-[#1a6fff] transition outline-none"><p class="text-xs text-gray-400 mt-1">Format JPG, PNG (max 2 Mo)</p></div>
                <div class="mb-5"><label class="block text-sm font-medium text-gray-700 mb-1">Votre avis</label><textarea id="avisMessageInput" rows="3" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1a6fff] focus:border-[#1a6fff] transition outline-none resize-none" placeholder="Partagez votre expérience..."></textarea></div>
                <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Note</label><div class="flex gap-1"><i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition rating-star" data-rating="1"></i><i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition rating-star" data-rating="2"></i><i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition rating-star" data-rating="3"></i><i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition rating-star" data-rating="4"></i><i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition rating-star" data-rating="5"></i></div><input type="hidden" id="avisRating" value="5"></div>
                <button type="submit" class="w-full bg-[#43A047] hover:bg-[#2E7D32] text-white font-semibold py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2"><i class="fas fa-paper-plane"></i><span>Envoyer mon avis</span></button>
                <p class="text-xs text-gray-500 mt-3 text-center">Votre avis sera publié après modération.</p>
            </form>
        </div>
    </div>

    <style>.line-clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}@keyframes modalFadeIn{from{opacity:0;transform:scale(0.95)}to{opacity:1;transform:scale(1)}}#avisModal .bg-white{animation:modalFadeIn 0.3s ease-out;}</style>

    <script>
        const stars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('avisRating');
        if (stars.length > 0) {
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    stars.forEach((s, index) => {
                        if (index < rating) { s.classList.remove('text-gray-300'); s.classList.add('text-yellow-400'); }
                        else { s.classList.remove('text-yellow-400'); s.classList.add('text-gray-300'); }
                    });
                });
            });
        }
        let avisData = [ { nom: "Marie K.", photo: "{{ asset('images/avatars/marie-k.jpg') }}", initial: "M", message: "Grâce à SanteRDV, j'ai pu prendre rendez-vous rapidement avec un cardiologue. L'interface est très intuitive et les rappels sont très utiles. Je recommande vivement !", date: "15 mars 2025", rating: 5, couleur: "#1a6fff" }, { nom: "Jean D.", photo: "{{ asset('images/avatars/jean-d.jpg') }}", initial: "J", message: "Plateforme très pratique pour gérer mes rendez-vous médicaux. Les rappels par SMS sont très utiles et m'évitent d'oublier mes consultations. Un service de qualité !", date: "22 février 2025", rating: 5, couleur: "#E53935" }, { nom: "Amélie L.", photo: "{{ asset('images/avatars/amelie-l.jpg') }}", initial: "A", message: "Service exceptionnel ! Mon médecin traitant a pu consulter mon historique médical directement. Je recommande vivement SanteRDV à toutes les familles. Bravo à toute l'équipe !", date: "5 janvier 2025", rating: 5, couleur: "#43A047" } ];
        const modal = document.getElementById('avisModal');
        const laisserAvisBtn = document.getElementById('laisserAvisBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const avisForm = document.getElementById('avisForm');
        const avisNomInput = document.getElementById('avisNomInput');
        const avisMessageInput = document.getElementById('avisMessageInput');
        function ajouterAvis(nom, message, rating) {
            const date = new Date().toLocaleDateString('fr-FR');
            const initial = nom.charAt(0).toUpperCase();
            const nouvelAvis = { nom: nom, photo: null, initial: initial, message: message, date: date, rating: rating, couleur: "#F77F00" };
            avisData.push(nouvelAvis);
            afficherAvis();
        }
        function afficherAvis() {
            const container = document.querySelector('#specialistes ~ .grid.md\\:grid-cols-3');
            if (!container) return;
            container.innerHTML = '';
            avisData.forEach((avis, index) => {
                let starsHtml = '';
                for (let i = 0; i < 5; i++) starsHtml += i < avis.rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                container.innerHTML += `<div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"><div class="flex items-center gap-4 mb-4"><div class="w-14 h-14 rounded-full overflow-hidden bg-gradient-to-br from-[${avis.couleur}] to-[${avis.couleur}] flex items-center justify-center shadow-md"><img src="${avis.photo || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(avis.nom) + '&background=' + avis.couleur.replace('#', '') + '&color=fff&size=56&bold=true&fontsize=28'}" alt="${avis.nom}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(avis.nom)}&background=${avis.couleur.replace('#', '')}&color=fff&size=56&bold=true&fontsize=28'"></div><div><h4 class="font-bold text-gray-800">${avis.nom}</h4><div class="flex text-yellow-400 text-xs gap-0.5 mt-1">${starsHtml}</div></div></div><div class="relative"><i class="fas fa-quote-left text-[#1a6fff]/20 text-3xl absolute -top-2 -left-1"></i><p class="text-gray-600 text-sm leading-relaxed pl-4">"${avis.message}"</p></div><div class="mt-4 pt-3 border-t border-gray-100"><p class="text-xs text-gray-400 flex items-center gap-1"><i class="fas fa-calendar-alt text-[#1a6fff] text-[10px]"></i><span>Publié le ${avis.date}</span></p></div></div>`;
            });
        }
        if (laisserAvisBtn) laisserAvisBtn.addEventListener('click', () => { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; });
        if (closeModalBtn) closeModalBtn.addEventListener('click', () => { modal.style.display = 'none'; document.body.style.overflow = ''; });
        if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) { modal.style.display = 'none'; document.body.style.overflow = ''; } });
        if (avisForm) avisForm.addEventListener('submit', (e) => { e.preventDefault(); const nom = avisNomInput ? avisNomInput.value.trim() : ''; const message = avisMessageInput ? avisMessageInput.value.trim() : ''; const rating = ratingInput ? parseInt(ratingInput.value) || 5 : 5; if (nom && message) { ajouterAvis(nom, message, rating); modal.style.display = 'none'; document.body.style.overflow = ''; if (avisNomInput) avisNomInput.value = ''; if (avisMessageInput) avisMessageInput.value = ''; if (ratingInput) ratingInput.value = 5; if (stars.length > 0) { stars.forEach(star => { star.classList.remove('text-yellow-400'); star.classList.add('text-gray-300'); }); for (let i = 0; i < 5; i++) { if (i < 5 && stars[i]) { stars[i].classList.remove('text-gray-300'); stars[i].classList.add('text-yellow-400'); } } } alert('Merci pour votre avis !'); } else { alert('Veuillez remplir tous les champs.'); } });
        afficherAvis();
    </script>

    <script>
        function voirDetails(id, nom, specialite, experience) {
            Swal.fire({
                title: 'Dr. ' + nom,
                html: `<div class="text-left space-y-3"><div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl"><i class="fas fa-stethoscope text-[#1a6fff] text-xl"></i><div><p class="text-xs text-gray-500">Spécialité</p><p class="font-semibold text-gray-800">${specialite}</p></div></div><div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl"><i class="fas fa-calendar-alt text-[#1a6fff] text-xl"></i><div><p class="text-xs text-gray-500">Expérience</p><p class="font-semibold text-gray-800">${experience} ans d'expérience</p></div></div><div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl"><i class="fas fa-clock text-[#1a6fff] text-xl"></i><div><p class="text-xs text-gray-500">Disponibilités</p><p class="font-semibold text-gray-800">Lundi au Vendredi, 9h - 17h</p></div></div><div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl"><i class="fas fa-map-marker-alt text-[#1a6fff] text-xl"></i><div><p class="text-xs text-gray-500">Cabinet</p><p class="font-semibold text-gray-800">Centre de santé de Ouando, Porto-Novo</p></div></div><div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl"><i class="fas fa-graduation-cap text-[#1a6fff] text-xl"></i><div><p class="text-xs text-gray-500">Diplômes</p><p class="font-semibold text-gray-800">Diplômé(e) de l'Université d'Abomey-Calavi</p></div></div><div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl"><i class="fas fa-language text-[#1a6fff] text-xl"></i><div><p class="text-xs text-gray-500">Langues parlées</p><p class="font-semibold text-gray-800">Français, Anglais</p></div></div></div>`,
                icon: 'info', confirmButtonColor: '#1a6fff', confirmButtonText: 'Fermer', showCloseButton: true,
                customClass: { popup: 'rounded-2xl', title: 'text-2xl font-bold text-gray-800', confirmButton: 'rounded-xl px-6 py-2.5' }
            });
        }
    </script>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="container mx-auto px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div data-aos="fade-up" data-aos-duration="800"><div class="flex items-center space-x-2 mb-2"><span class="text-sm font-bold text-[#1a6fff]">SanteRDV</span></div><p class="text-gray-400 text-[11px] leading-relaxed">Rendez-vous médical simplifié, suivi intelligent.</p><div class="mt-2 space-y-0.5"><p class="text-gray-400 text-[11px] flex items-center gap-1"><i class="fas fa-map-marker-alt text-[#1a6fff] text-[9px]"></i> Porto-Novo, Bénin</p><p class="text-gray-400 text-[11px] flex items-center gap-1"><i class="fas fa-phone-alt text-[#1a6fff] text-[9px]"></i> +229 21 30 00 00</p><p class="text-gray-400 text-[11px] flex items-center gap-1"><i class="fas fa-envelope text-[#1a6fff] text-[9px]"></i> contact@santerdv.bj</p></div></div>
                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"><h4 class="text-white font-semibold text-xs mb-2">Liens rapides</h4><ul class="space-y-1"><li><a href="#accueil" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Accueil</a></li><li><a href="#services" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Services</a></li><li><a href="#specialistes" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Spécialistes</a></li><li><a href="#centre" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Notre centre</a></li><li><a href="#conseils" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Conseils santé</a></li><li><a href="#contact" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Contact</a></li></ul></div>
                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"><h4 class="text-white font-semibold text-xs mb-2">Informations légales</h4><ul class="space-y-1"><li><a href="{{ route('legal.confidentialite') }}" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Confidentialité</a></li><li><a href="{{ route('legal.conditions') }}" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Conditions d'utilisation</a></li><li><a href="{{ route('legal.mentions') }}" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Mentions légales</a></li><li><a href="{{ route('legal.cookies') }}" class="text-gray-400 text-[11px] hover:text-[#1a6fff] transition">Cookies</a></li></ul></div>
                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="300"><h4 class="text-white font-semibold text-xs mb-2">Sécurité</h4><div class="space-y-1"><div class="flex items-center gap-1"><i class="fas fa-lock text-[#43A047] text-[10px]"></i><span class="text-gray-400 text-[11px]">Données sécurisées</span></div><div class="flex items-center gap-1"><i class="fas fa-certificate text-[#43A047] text-[10px]"></i><span class="text-gray-400 text-[11px]">Conforme HDS</span></div></div><div class="mt-3"><h4 class="text-white font-semibold text-xs mb-1.5">Suivez-nous</h4><div class="flex gap-2"><a href="#" class="w-6 h-6 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[#1a6fff] transition"><i class="fab fa-facebook-f text-gray-400 text-[9px] hover:text-white"></i></a><a href="#" class="w-6 h-6 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[#1a6fff] transition"><i class="fab fa-twitter text-gray-400 text-[9px] hover:text-white"></i></a><a href="#" class="w-6 h-6 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[#1a6fff] transition"><i class="fab fa-linkedin-in text-gray-400 text-[9px] hover:text-white"></i></a><a href="#" class="w-6 h-6 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[#1a6fff] transition"><i class="fab fa-instagram text-gray-400 text-[9px] hover:text-white"></i></a></div></div></div>
            </div>
        </div>
        <div class="border-t border-gray-800"><div class="container mx-auto px-6 py-2"><p class="text-gray-500 text-[10px] text-center">&copy; {{ date('Y') }} SanteRDV. Tous droits réservés.</p></div></div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ once: true, duration: 800, easing: 'ease-in-out', offset: 100 });</script>

    @livewire('chatbot')
    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const specialiteSelect = document.getElementById('specialite');
            const medecinSelect = document.getElementById('medecin');
            const btnRechercher = document.getElementById('btnRechercher');
            const modal = document.getElementById('modalCreneaux');
            const closeModal = document.getElementById('closeModal');
            const creneauxList = document.getElementById('creneauxList');
            if (!btnRechercher) { console.error('Bouton rechercher non trouvé'); return; }
            function filtrerMedecins() {
    if (!specialiteSelect || !medecinSelect) return;
    const specialiteChoisie = specialiteSelect.value;
    let hasVisibleOption = false;
    
    for (let i = 0; i < medecinSelect.options.length; i++) {
        const option = medecinSelect.options[i];
        const specialiteOption = option.getAttribute('data-specialite');
        
        if (option.value === '') continue; // Ne pas cacher l'option par défaut
        
        if (!specialiteChoisie || specialiteOption === specialiteChoisie) {
            option.style.display = '';
            hasVisibleOption = true;
        } else {
            option.style.display = 'none';
        }
    }
    
    // Si aucune option visible, on réinitialise la sélection
    if (!hasVisibleOption && medecinSelect.selectedOptions[0] && medecinSelect.selectedOptions[0].style.display === 'none') {
        medecinSelect.value = '';
    }
}
            if (closeModal) closeModal.addEventListener('click', () => modal.classList.remove('active'));
            if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('active'); });
            document.querySelectorAll('#emergency-nav, #emergency-fab').forEach(el => {
                el.addEventListener('click', (e) => { e.preventDefault(); const urgentSection = document.querySelector('.bg-red-50'); if (urgentSection) urgentSection.scrollIntoView({ behavior: 'smooth' }); else window.scrollTo({ top: 0, behavior: 'smooth' }); });
            });
            
            const sendUrgentBtn = document.getElementById('sendUrgentBtn');
            if (sendUrgentBtn) {
                sendUrgentBtn.addEventListener('click', async function(e) {
                    e.preventDefault();
                    
                    const name = document.getElementById('urgentName').value.trim();
                    const phone = document.getElementById('urgentPhone').value.trim();
                    const description = document.getElementById('urgentDesc').value.trim();
                    
                    if (!name || !phone || !description) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Champs manquants',
                            text: 'Veuillez remplir tous les champs du formulaire.',
                            confirmButtonColor: '#1a6fff'
                        });
                        return;
                    }
                    
                    const originalText = sendUrgentBtn.innerHTML;
                    sendUrgentBtn.disabled = true;
                    sendUrgentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
                    
                    try {
                        const response = await fetch('{{ route("urgence.store") }}', { 
                            method: 'POST', 
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                            }, 
                            body: JSON.stringify({ 
                                nom: name, 
                                telephone: phone, 
                                description: description 
                            }) 
                        });
                        const data = await response.json();
                        if (response.ok && data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '✅ Alerte envoyée !',
                                text: 'Votre alerte a été envoyée. Notre équipe vous recontactera dans les plus brefs délais.',
                                confirmButtonColor: '#1a6fff',
                                timer: 4000,
                                timerProgressBar: true
                            }).then(() => {
                                document.getElementById('urgentName').value = '';
                                document.getElementById('urgentPhone').value = '';
                                document.getElementById('urgentDesc').value = '';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: data.message || 'Une erreur est survenue. Veuillez réessayer.',
                                confirmButtonColor: '#1a6fff'
                            });
                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur réseau',
                            text: 'Impossible de connecter au serveur. Vérifiez votre connexion.',
                            confirmButtonColor: '#1a6fff'
                        });
                    } finally {
                        sendUrgentBtn.disabled = false;
                        sendUrgentBtn.innerHTML = originalText;
                    }
                });
            }

            const sendContactBtn = document.getElementById('sendContactBtn');
            if (sendContactBtn) {
                sendContactBtn.addEventListener('click', async function(e) {
                    e.preventDefault();
                    
                    const name = document.getElementById('contactName').value.trim();
                    const email = document.getElementById('contactEmail').value.trim();
                    const phone = document.getElementById('contactPhone').value.trim();
                    const subject = document.getElementById('contactSubject').value;
                    const message = document.getElementById('contactMessage').value.trim();

                    if (!name || !email || !subject || !message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Champs manquants',
                            text: 'Veuillez remplir tous les champs obligatoires.',
                            confirmButtonColor: '#1a6fff'
                        });
                        return;
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Email invalide',
                            text: 'Veuillez entrer une adresse email valide.',
                            confirmButtonColor: '#1a6fff'
                        });
                        return;
                    }

                    const originalText = sendContactBtn.innerHTML;
                    sendContactBtn.disabled = true;
                    sendContactBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';

                    try {
                        const response = await fetch('{{ route("contact.store") }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ nom: name, email: email, telephone: phone, sujet: subject, message: message })
                        });
                        const data = await response.json();
                        if (response.ok && data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '✅ Message envoyé !',
                                text: 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.',
                                confirmButtonColor: '#1a6fff',
                                timer: 4000,
                                timerProgressBar: true
                            }).then(() => {
                                document.getElementById('contactName').value = '';
                                document.getElementById('contactEmail').value = '';
                                document.getElementById('contactPhone').value = '';
                                document.getElementById('contactSubject').value = '';
                                document.getElementById('contactMessage').value = '';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: data.message || 'Une erreur est survenue. Veuillez réessayer.',
                                confirmButtonColor: '#1a6fff'
                            });
                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur réseau',
                            text: 'Impossible de connecter au serveur. Vérifiez votre connexion.',
                            confirmButtonColor: '#1a6fff'
                        });
                    } finally {
                        sendContactBtn.disabled = false;
                        sendContactBtn.innerHTML = originalText;
                    }
                });
            }
        });
        
        function openModal() { 
            const modalOverlay = document.getElementById('modalOverlay'); 
            if (modalOverlay) { 
                modalOverlay.classList.add('open'); 
                document.body.style.overflow = 'hidden'; 
            } 
        }
        
        function closeModal() { 
            const modalOverlay = document.getElementById('modalOverlay'); 
            if (modalOverlay) { 
                modalOverlay.classList.remove('open'); 
                document.body.style.overflow = ''; 
            } 
        }
    </script>

</body>
</html>
