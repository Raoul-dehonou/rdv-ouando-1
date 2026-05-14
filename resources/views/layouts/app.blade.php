<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'OuandoSanté') }} - @yield('title')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Livewire Styles pour le chatbot -->
    @livewireStyles
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Couleurs personnalisables */
        :root {
            --primary: #1761e0;
            --primary-dark: #134db3;
            --primary-light: #4e8aff;
            --secondary: #F59E0B;
            --danger: #DC2626;
            --success: #10B981;
            --info: #3B82F6;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(10px); }
        }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        .animate-fade-out {
            animation: fadeOut 0.3s ease-in;
        }
        
        /* Loader global */
        .global-loader {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .global-loader.active {
            display: flex;
        }
        
        .loader-content {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            animation: fadeIn 0.3s ease-out;
        }
        
        .loader-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid #e5e7eb;
            border-bottom-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
            transition: background 0.2s;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background: linear-gradient(135deg, #2456ad 0%, #103e8d 100%);
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar.collapsed {
            transform: translateX(-280px);
        }
        
        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-icon i {
            font-size: 1.5rem;
            color: white;
        }
        
        .logo-text h1 {
            font-size: 1.3rem;
            font-weight: bold;
            color: white;
        }
        
        .logo-text p {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .logo-text span {
            color: #fcf7f6;
        }
        
        /* Navigation */
        .nav-menu {
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.2s;
            text-decoration: none;
            position: relative;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .nav-item.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-right: 3px solid #F59E0B;
        }
        
        .nav-item i {
            width: 24px;
            font-size: 1.1rem;
        }
        
        /* Badge notification dans le menu - positionné en haut à droite */
        .nav-item .notification-badge {
            position: absolute;
            top: 0px;
            right: 10px;
            background: #ef4444;
            color: white;
            font-size: 0.6rem;
            font-weight: bold;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
        }
        
        .nav-item .message-badge {
            position: absolute;
            top: 0px;
            right: 10px;
            background: #ef4444;
            color: white;
            font-size: 0.6rem;
            font-weight: bold;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
        }
        
        /* Sidebar footer */
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }
        
        .logout-button {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 10px 16px;
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.3);
            border-radius: 12px;
            color: #f87171;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .logout-button:hover {
            background: rgba(220, 38, 38, 0.25);
            transform: translateX(5px);
        }
        
        /* Topbar */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 280px;
            background: #ffffff;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 999;
            transition: left 0.3s ease;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        body.sidebar-collapsed .topbar {
            left: 0;
        }
        
        .toggle-sidebar-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #1761e0;
            font-size: 1.3rem;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .toggle-sidebar-btn:hover {
            background: #f0f0f0;
        }
        
        /* User menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #1761e0 0%, #134db3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: #1f2937;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: #1761e0;
            text-transform: capitalize;
        }
        
        /* Dropdown */
        .dropdown-menu {
            position: absolute;
            top: 60px;
            right: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 220px;
            display: none;
            z-index: 1000;
        }
        
        .dropdown-menu.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background: #f9fafb;
            color: #1761e0;
        }
        
        .dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 4px 0;
        }
        
        /* Main content */
        .main-content {
            margin-top: 70px;
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }
        
        body.sidebar-collapsed .main-content {
            margin-left: 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-280px);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .topbar {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="logo-text">
                <h1>Santé<span>RDV</span></h1>
                <p>Centre Médical</p>
            </div>
        </div>
        
        <nav class="nav-menu">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.patients.index') }}" class="nav-item {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Patients</span>
                </a>
                <a href="{{ route('admin.medecins.index') }}" class="nav-item {{ request()->routeIs('admin.medecins.*') ? 'active' : '' }}">
                    <i class="fas fa-user-md"></i> <span>Médecins</span>
                </a>
                <a href="{{ route('admin.rendez-vous.index') }}" class="nav-item {{ request()->routeIs('admin.rendez-vous.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> <span>Rendez-vous</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fas fa-stethoscope"></i> <span>Services</span>
                </a>
               
                <a href="{{ route('admin.statistiques') }}" class="nav-item {{ request()->routeIs('admin.statistiques*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> <span>Statistiques</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> <span>Messages contact</span>
                </a>
                <a href="{{ route('admin.urgences.index') }}" class="nav-item {{ request()->routeIs('admin.urgences.*') ? 'active' : '' }}">
                    <i class="fas fa-ambulance"></i> <span>Alertes urgence</span>
                </a>
            @elseif(Auth::user()->role === 'medecin')
                <a href="{{ route('medecin.dashboard') }}" class="nav-item {{ request()->routeIs('medecin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('medecin.rendez-vous.index') }}" class="nav-item {{ request()->routeIs('medecin.rendez-vous.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> <span>Mes rendez-vous</span>
                </a>
                <a href="{{ route('medecin.agenda') }}" class="nav-item {{ request()->routeIs('medecin.agenda') ? 'active' : '' }}">
                    <i class="fas fa-calendar-week"></i> <span>Mon agenda</span>
                </a>
                <a href="{{ route('medecin.patients.index') }}" class="nav-item {{ request()->routeIs('medecin.patients.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Mes patients</span>
                </a>
                <a href="{{ route('medecin.disponibilites.index') }}" class="nav-item {{ request()->routeIs('medecin.disponibilites.*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> <span>Mes disponibilités</span>
                </a>
                <a href="{{ route('medecin.consultations.index') }}" class="nav-item {{ request()->routeIs('medecin.consultations.*') ? 'active' : '' }}">
                    <i class="fas fa-notes-medical"></i> <span>Mes consultations</span>
                </a>
                <a href="{{ url('/medecin/messagerie') }}" class="nav-item {{ request()->routeIs('medecin.messagerie.*') ? 'active' : '' }}">
                    <i class="fas fa-comment-dots"></i> <span>Messagerie</span>
                    @php
                        $unreadMessagesCount = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                    @endphp
                    @if($unreadMessagesCount > 0)
                        <span class="message-badge">{{ $unreadMessagesCount }}</span>
                    @endif
                </a>
                <a href="{{ route('medecin.notifications') }}" class="nav-item {{ request()->routeIs('medecin.notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> <span>Notifications</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            @elseif(Auth::user()->role === 'patient')
                <a href="{{ route('patient.dashboard') }}" class="nav-item {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('patient.rendez-vous.index') }}" class="nav-item {{ request()->routeIs('patient.rendez-vous.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> <span>Mes RDV</span>
                </a>
                <a href="{{ route('patient.dossier.index') }}" class="nav-item {{ request()->routeIs('patient.dossier.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i> <span>Mon dossier médical</span>
                </a>
                
                <a href="{{ url('/patient/messagerie') }}" class="nav-item {{ request()->routeIs('patient.messagerie.*') ? 'active' : '' }}">
                    <i class="fas fa-comment-dots"></i> <span>Messagerie</span>
                    @php
                        $unreadMessagesCount = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                    @endphp
                    @if($unreadMessagesCount > 0)
                        <span class="message-badge">{{ $unreadMessagesCount }}</span>
                    @endif
                </a>
                <a href="{{ route('patient.notifications') }}" class="nav-item {{ request()->routeIs('patient.notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> <span>Notifications</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            @endif
        </nav>
        
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>
    
    <!-- TOPBAR -->
    <header class="topbar">
        <div class="flex items-center gap-4">
            <button id="toggleSidebar" class="toggle-sidebar-btn">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="flex items-center gap-3">
                <!-- Icône dynamique -->
                <div class="w-12 h-12 bg-gradient-to-br from-[#1a6fff] to-[#0d5ae0] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas @yield('header_icon', 'fa-chart-line') text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">@yield('header_title', 'Tableau de bord')</h1>
                    <p class="text-xs text-gray-500">@yield('header_subtitle', 'Bienvenue, ' . Auth::user()->name)</p>
                </div>
                <div class="hidden md:block h-8 w-px bg-gray-200"></div>
               
            </div>
        </div>
        
        <div class="user-menu">
            <button id="notificationsBtn" class="relative text-gray-600 hover:text-primary transition">
                <i class="fas fa-bell text-xl"></i>
                <span class="absolute -top-1 -right-2 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            
            <div class="relative">
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ Auth::user()->role }}</div>
                </div>
                <button id="userMenuBtn" class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </button>
                
                <div id="userDropdown" class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user-circle"></i> <span>Mon profil</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item w-full text-left">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
    <!-- MAIN CONTENT -->
    <main class="main-content">
        @yield('content')
    </main>
    
    <!-- Chatbot IA (uniquement pour patient) -->
    @if(Auth::user()->role === 'patient')
        @livewire('chatbot')
    @endif
    
    <script>
        // Toggle sidebar
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            body.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
        
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            sidebar.classList.add('collapsed');
            body.classList.add('sidebar-collapsed');
        }
        
        // User dropdown
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        
        document.addEventListener('click', () => {
            userDropdown.classList.remove('show');
        });
        
        // Notifications
        const notifBtn = document.getElementById('notificationsBtn');
        notifBtn.addEventListener('click', () => {
            Swal.fire({ title: 'Notifications', text: 'Aucune nouvelle notification', icon: 'info', confirmButtonColor: '#1761e0' });
        });
    </script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>