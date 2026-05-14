<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - SantéRDV</title>
    
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
        
        .btn-login {
            background: linear-gradient(135deg, #1152c2 0%, #103e8d  100%);
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
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
                        
                        <h2 class="text-2xl font-bold mb-3">Bienvenue !</h2>
                        <p class="text-white/70 text-sm mb-8 leading-relaxed">Connectez-vous pour accéder à votre espace personnel et gérer vos rendez-vous médicaux.</p>
                        
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-white/70 text-sm">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                                <span>Prise de rendez-vous en ligne 24h/24</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/70 text-sm">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                                <span>Suivi de votre dossier médical sécurisé</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/70 text-sm">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                                <span>Consultations avec des médecins qualifiés</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/70 text-sm">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                                <span>Rappels automatiques par SMS et email</span>
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
                            <p class="text-white/60 text-xs">Plus de <strong class="text-white">10 000 patients</strong> nous font confiance</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right side - Login Form (fond blanc) -->
            <div class="lg:w-1/2 bg-white p-8 lg:p-10 animate-slideInRight">
                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-full bg-[#1761e0]/10 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-[#1761e0] text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Connexion</h3>
                    <p class="text-gray-500 text-sm mt-1">Accédez à votre espace patient</p>
                </div>
                
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#1761e0] input-focus transition bg-gray-50 text-sm"
                                   placeholder="exemple@email.com">
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password" id="password" required
                                   class="w-full pl-9 pr-10 py-2.5 border border-gray-200 rounded-lg focus:border-[#173b7a] input-focus transition bg-gray-50 text-sm"
                                   placeholder="••••••••">
                            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#1761e0] transition">
                                <i class="fas fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#1761e0] focus:ring-[#1761e0] w-3.5 h-3.5">
                            <span class="text-xs text-gray-600">Se souvenir de moi</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-[#173b7a] hover:underline">Mot de passe oublié ?</a>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn-login w-full py-2.5 text-white rounded-lg font-semibold text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-right-to-bracket text-xs"></i> Se connecter
                    </button>
                    
                    <div class="text-center pt-3">
                        <p class="text-xs text-gray-500">
                            Pas encore de compte ?
                            <a href="{{ route('register') }}" class="text-[#173b7a] font-semibold hover:underline">Créer un compte</a>
                        </p>
                    </div>
                </form>
                
                
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
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
        
        // Fill demo account
        function fillDemo(email, password) {
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="password"]').value = password;
        }
    </script>
</body>
</html>