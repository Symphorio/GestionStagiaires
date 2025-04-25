<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASM - Tableau de Bord Stagiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .dashboard-header {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            letter-spacing: 0.025em;
            text-transform: uppercase;
        }
        .bell-icon {
            width: 24px;
            height: 24px;
            transition: all 0.2s ease;
        }
        .bell-icon:hover {
            transform: scale(1.1);
            color: #3b82f6;
        }
        .bell-ring {
            animation: ring 0.5s ease-in-out infinite;
            transform-origin: 50% 0;
        }
        @keyframes ring {
            0% { transform: rotate(0); }
            25% { transform: rotate(15deg); }
            50% { transform: rotate(-15deg); }
            75% { transform: rotate(10deg); }
            100% { transform: rotate(0); }
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }

        /* Solution pour le flou sous la navbar */
        .main-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .content-wrapper {
            flex: 1;
            overflow-y: auto;
            position: relative;
        }
        .nav-header {
            position: sticky;
            top: 0;
            z-index: 30;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: 80px; /* Ajustez selon votre header */
        }
        .blur-overlay {
            position: sticky;
            top: 80px; /* Doit correspondre à la hauteur du header */
            height: 20px;
            background: linear-gradient(to bottom, 
                                      rgba(255,255,255,0.9) 0%, 
                                      rgba(255,255,255,0.7) 100%);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 20;
            pointer-events: none;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50" 
      x-data="{ 
          mobileMenuOpen: false, 
          notificationsOpen: false, 
          userMenuOpen: false, 
          hasNotifications: false, 
          notificationCount: 0,
          newNotifications: false,
          lastChecked: null
      }"
      x-init="
          checkNotifications();
          setInterval(() => checkNotifications(), 60000);
      ">

    <!-- En-tête mobile -->
    <header class="md:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center space-x-2">
                <span class="font-medium">MASM</span>
                <span class="text-xs text-gray-500">Stagiaire</span>
            </a>
            <button @click="mobileMenuOpen = true" class="p-2 rounded-full hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </header>

    <!-- Menu mobile -->
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" 
         class="md:hidden fixed inset-0 z-50 bg-white overflow-y-auto">
        <div class="p-4 flex justify-end">
            <button @click="mobileMenuOpen = false" class="p-2 rounded-full hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm hover:bg-gray-100">
                        <i data-lucide="home" class="h-5 w-5"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <!-- Autres éléments du menu mobile -->
            </ul>
        </nav>
    </div>
    
    <!-- Layout principal -->
    <div class="main-container">
        <!-- Barre latérale Bureau -->
        <div class="hidden md:flex md:flex-shrink-0">
            @include('layouts.sidebar-stagiaire')
        </div>
        
        <!-- Contenu Principal -->
        <div class="content-wrapper">
            <!-- En-tête Bureau - Fixe en haut -->
            <header class="nav-header hidden md:flex items-center justify-between p-6 border-b border-gray-200">
                <h1 class="dashboard-header">
                    @yield('titre', 'TABLEAU DE BORD')
                </h1>
                
                <div class="flex items-center space-x-6">
                    <!-- Bouton Notifications -->
                    <div class="relative">
                        <button @click="notificationsOpen = !notificationsOpen; newNotifications = false; markNotificationsAsRead();" 
                                class="p-2 text-gray-600 hover:text-blue-500 relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                 class="bell-icon" :class="{ 'bell-ring': hasNotifications && newNotifications }">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <template x-if="notificationCount > 0">
                                <span class="notification-badge" x-text="notificationCount"></span>
                            </template>
                        </button>
                        
                        <!-- Dropdown Notifications -->
                        <div x-show="notificationsOpen" @click.away="notificationsOpen = false"
                             class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                            <!-- Contenu des notifications -->
                        </div>
                    </div>
                    
                    <!-- Menu Utilisateur - MODIFIÉ POUR AFFICHER LE NOM COMPLET -->
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                @if(auth('stagiaire')->user()->profile && auth('stagiaire')->user()->profile->avatar_path)
                                    <img src="{{ Storage::url(auth('stagiaire')->user()->profile->avatar_path) }}" 
                                         alt="Avatar" class="h-full w-full object-cover">
                                @else
                                    <span class="text-xs font-medium">
                                        {{ strtoupper(substr(auth('stagiaire')->user()->prenom, 0, 1) . substr(auth('stagiaire')->user()->nom, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-sm font-medium">
                                {{ auth('stagiaire')->user()->prenom }} {{ auth('stagiaire')->user()->nom }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                            <div class="py-1">
                                <a href="{{ route('stagiaire.profil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Mon Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Zone de flou sous la navbar -->
            <div class="blur-overlay"></div>
            
            <!-- Contenu Dynamique -->
            <div class="p-6 md:p-8">
                @yield('contenu')
            </div>
        </div>
    </div>

    <!-- Audio pour l'effet de sonnerie -->
    <audio id="bellSound" preload="auto">
        <source src="https://assets.mixkit.co/sfx/preview/mixkit-alarm-digital-clock-beep-989.mp3" type="audio/mpeg">
    </audio>

    <script>
        // Fonction pour jouer le son de cloche
        function playBellSound() {
            const bellSound = document.getElementById('bellSound');
            bellSound.currentTime = 0;
            bellSound.play().catch(e => console.log("La lecture automatique a été bloquée:", e));
        }

        // Fonction pour vérifier les nouvelles notifications
        function checkNotifications() {
            fetch('/api/check-notifications')
                .then(response => response.json())
                .then(data => {
                    // Gestion des notifications
                });
        }

        // Fonction pour marquer les notifications comme lues
        function markNotificationsAsRead() {
            fetch('/api/mark-notifications-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        }

        // Initialisation Alpine.js
        document.addEventListener('alpine:init', () => {
            Alpine.store('data', {
                hasNotifications: false,
                notificationCount: 0,
                newNotifications: false,
                lastChecked: null,
                notifications: []
            });
        });
    </script>
</body>
</html>