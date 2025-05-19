<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>MASM - Tableau de Bord Stagiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Appliquer le mode sombre au chargement
        if (localStorage.getItem('dark-mode') === 'true') {
            document.documentElement.classList.add('dark');
        } else if (!localStorage.getItem('dark-mode') && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
    </script>
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
            animation: ring 1.5s ease infinite;
            transform-origin: 50% 4px;
        }
        @keyframes ring {
            0% { transform: rotate(0); }
            10% { transform: rotate(-15deg); }
            20% { transform: rotate(15deg); }
            30% { transform: rotate(-10deg); }
            40% { transform: rotate(10deg); }
            50% { transform: rotate(0); }
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
            height: 80px;
        }
        .blur-overlay {
            position: sticky;
            top: 80px;
            height: 20px;
            background: linear-gradient(to bottom, 
                                      rgba(255,255,255,0.9) 0%, 
                                      rgba(255,255,255,0.7) 100%);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 20;
            pointer-events: none;
        }
        .notification-item {
            transition: all 0.2s ease;
        }
        .notification-item:hover {
            background-color: #f9fafb;
        }
        .notification-unread {
            background-color: #f0f9ff;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50" 
      x-data="{ 
          mobileMenuOpen: false, 
          notificationsOpen: false, 
          userMenuOpen: false
      }"
      x-init="
          Alpine.store('data').refreshNotifications();
          setInterval(() => Alpine.store('data').refreshNotifications(), 60000);
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
            <!-- En-tête Bureau -->
            <header class="nav-header hidden md:flex items-center justify-between p-6 border-b border-gray-200">
                <h1 class="dashboard-header">
                    @yield('titre', 'TABLEAU DE BORD')
                </h1>
                
                <div class="flex items-center space-x-6">
                    <!-- Bouton Notifications -->
                    <div class="relative">
                        <button @click="notificationsOpen = !notificationsOpen; Alpine.store('data').markAsRead();" 
                                class="p-2 text-gray-600 hover:text-blue-500 relative">
                            <img src="/images/icons/bell.png" class="h-6 w-6" :class="{ 'bell-ring': Alpine.store('data').newNotifications }">
                            <template x-if="Alpine.store('data').notificationCount > 0">
                                <span class="notification-badge" x-text="Alpine.store('data').notificationCount"></span>
                            </template>
                        </button>
                        
                        <!-- Dropdown Notifications -->
                        <div x-show="notificationsOpen" @click.away="notificationsOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-sm font-medium">Notifications</h3>
                            </div>
                            <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                                <template x-for="notification in Alpine.store('data').notifications" :key="notification.id">
                                    <div class="p-3 hover:bg-gray-50 notification-item" :class="{ 'notification-unread': !notification.is_read }">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 pt-0.5">
                                                <template x-if="notification.type === 'task'">
                                                    <i data-lucide="list-checks" class="h-5 w-5 text-blue-500"></i>
                                                </template>
                                                <template x-if="notification.type === 'memory'">
                                                    <i data-lucide="book-open" class="h-5 w-5 text-purple-500"></i>
                                                </template>
                                                <template x-if="notification.type === 'attestation'">
                                                    <i data-lucide="book-marked" class="h-5 w-5 text-green-500"></i>
                                                </template>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p x-text="notification.message" class="text-sm text-gray-700"></p>
                                                <p class="text-xs text-gray-500 mt-1" x-text="new Date(notification.created_at).toLocaleString()"></p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="Alpine.store('data').notifications.length === 0">
                                    <div class="p-4 text-center text-sm text-gray-500">
                                        Aucune nouvelle notification
                                    </div>
                                </template>
                            </div>
                            <div class="p-2 border-t border-gray-200 text-center">
                                <a href="#" class="text-xs text-blue-500 hover:text-blue-700">
                                    Voir toutes les notifications
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menu Utilisateur -->
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

        // Initialisation Alpine.js
        document.addEventListener('alpine:init', () => {
            Alpine.store('data', {
                hasNotifications: false,
                notificationCount: 0,
                newNotifications: false,
                lastChecked: null,
                notifications: [],
                
               // Dans la fonction refreshNotifications() du store Alpine:
refreshNotifications() {
    console.log("Checking for new notifications...");
    fetch('/api/check-notifications')
        .then(response => {
            console.log("API Response status:", response.status);
            return response.json();
        })
        .then(data => {
            console.log("Notifications data:", data);
            this.notificationCount = data.count;
            this.notifications = data.notifications;
            this.hasNotifications = data.count > 0;
            this.newNotifications = data.hasNew;
            this.lastChecked = data.lastChecked;
            
            if (data.hasNew && !document.hidden) {
                console.log("New notification detected!");
                playBellSound();
            }
        })
        .catch(error => console.error("Notification error:", error));
},
                
                markAsRead() {
                    if (this.notificationCount > 0) {
                        fetch('/api/mark-notifications-read', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(() => {
                            this.newNotifications = false;
                            this.notificationCount = 0;
                            this.notifications.forEach(n => n.is_read = true);
                        });
                    }
                }
            });
        });

        // Initialiser les icônes Lucide
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>