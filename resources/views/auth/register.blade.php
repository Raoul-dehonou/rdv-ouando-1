<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - SantéRDV</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-slideInLeft { animation: slideInLeft 0.6s ease-out forwards; }
        .animate-slideInRight { animation: slideInRight 0.6s ease-out forwards; }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        
        /* Fond bleu UNIQUEMENT pour la partie gauche */
        .bg-blue-side {
            background: linear-gradient(135deg, #1152c2 0%, #103e8d 100%);
        }
        
        .btn-register {
            background: linear-gradient(135deg, #1152c2 0%, #103e8d 100%);
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            background: linear-gradient(135deg, #1152c2 0%, #103e8d 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(23, 97, 224, 0.4);
        }
        
        .input-focus:focus {
            border-color: #1761e0;
            box-shadow: 0 0 0 3px rgba(23, 97, 224, 0.1);
            outline: none;
        }
        
        /* Style pour l'icône oeil */
        .toggle-password {
            cursor: pointer;
            transition: color 0.2s;
        }
        .toggle-password:hover {
            color: #1761e0;
        }
    </style>
</head>
<body class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.pexels.com/photos/263402/pexels-photo-263402.jpeg');">
    
    <!-- Overlay sombre pour l'image de fond -->
    <div class="fixed inset-0 bg-black/50"></div>
    
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Floating back button -->
        <a href="{{ url('/') }}" class="absolute top-8 left-8 flex items-center gap-2 text-white/80 hover:text-white transition group z-10">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i>
            Retour à l'accueil
        </a>
        
        <div class="max-w-5xl w-full flex flex-col lg:flex-row rounded-2xl overflow-hidden shadow-2xl animate-fadeInUp">
            
            <!-- Left side - Branding (UNIQUEMENT ICI LE FOND BLEU) -->
            <div class="lg:w-1/2 bg-blue-side p-8 lg:p-10 text-white">
                <div class="h-full flex flex-col justify-between">
                    <div class="animate-slideInLeft">
                        <div class="flex items-center gap-3 mb-10">
                            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                                <i class="fas fa-heartbeat text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-white">Santé<span class="text-white">RDV</span></h1>
                                <p class="text-white/60 text-xs">Centre Médical</p>
                            </div>
                        </div>
                        
                        <h2 class="text-2xl font-bold mb-3">Inscription</h2>
                        <p class="text-white/70 text-sm mb-8 leading-relaxed">Créez votre compte pour accéder à nos services et prendre rendez-vous en ligne facilement.</p>
                        
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-white/70 text-sm">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                                <span>Prise de rendez-vous en ligne 24h/24</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/70 text-sm">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                                <span>Dossier médical sécurisé</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/70 text-sm">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                                <span>Rappels automatiques par SMS/Email</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/70 text-sm">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                                <span>Consultations avec des médecins qualifiés</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-10 pt-6 border-t border-white/20 animate-slideInLeft delay-100">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-xs font-medium">JD</div>
                                <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-xs font-medium">MZ</div>
                                <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-xs font-medium">AB</div>
                            </div>
                            <p class="text-white/60 text-xs">Rejoignez <strong class="text-white">+10 000 patients</strong> satisfaits</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right side - Register Form (fond blanc) -->
            <div class="lg:w-1/2 bg-white p-8 lg:p-10 animate-slideInRight">
                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-full bg-[#1761e0]/10 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-[#1761e0] text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Créer un compte</h3>
                    <p class="text-gray-500 text-sm mt-1">Remplissez le formulaire ci-dessous</p>
                </div>
                
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf
                    
                    <!-- Nom complet -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#1761e0] input-focus transition bg-gray-50 text-sm"
                                   placeholder="Jean Kouassi">
                        </div>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#1761e0] input-focus transition bg-gray-50 text-sm"
                                   placeholder="exemple@email.com">
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Mot de passe -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password" id="password" required
                                   class="w-full pl-9 pr-10 py-2.5 border border-gray-200 rounded-lg focus:border-[#1761e0] input-focus transition bg-gray-50 text-sm"
                                   placeholder="••••••••">
                            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#1761e0] transition">
                                <i class="fas fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Confirmation mot de passe -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#1761e0] input-focus transition bg-gray-50 text-sm"
                                   placeholder="••••••••">
                        </div>
                    </div>
                    
                    <!-- Submit button -->
                    <button type="submit" class="btn-register w-full py-2.5 text-white rounded-lg font-semibold text-sm flex items-center justify-center gap-2 mt-4">
                        <i class="fas fa-user-plus text-xs"></i> S'inscrire
                    </button>
                    
                    <!-- Login link -->
                    <div class="text-center pt-3">
                        <p class="text-xs text-gray-500">
                            Déjà un compte ?
                            <a href="{{ route('login') }}" class="text-[#1761e0] font-semibold hover:underline">
                                Se connecter
                            </a>
                        </p>
                    </div>
                </form>
                
                <div class="mt-5 pt-4 border-t border-gray-100">
                    <p class="text-center text-xs text-gray-400">En créant un compte, vous acceptez nos</p>
                    <p class="text-center text-xs text-gray-400">
                        <a href="{{ route('legal.conditions') }}" class="text-[#1761e0] hover:underline">Conditions générales</a> et notre 
                        <a href="{{ route('legal.confidentialite') }}" class="text-[#1761e0] hover:underline">Politique de confidentialité</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility for password field
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>