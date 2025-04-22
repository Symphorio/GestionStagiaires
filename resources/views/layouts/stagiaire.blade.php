<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASM - Tableau de Bord Stagiaire</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Icônes Lucide -->
    <link href="https://unpkg.com/lucide@latest/dist/lucide.css" rel="stylesheet">
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .dashboard-header {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            letter-spacing: 0.025em;
            text-transform: uppercase;
        }
        .notification-badge {
            top: -0.25rem;
            right: -0.25rem;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- ==================== -->
    <!-- EN-TÊTE MOBILE -->
    <!-- ==================== -->
    <header class="md:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center space-x-2">
                <span class="font-medium">MASM</span>
                <span class="text-xs text-gray-500">Stagiaire</span>
            </a>
            
            <div class="flex items-center space-x-3">
                <!-- Bouton Notifications Mobile -->
                <div x-data="{ notificationsOpen: false }" class="relative">
                    <button @click="notificationsOpen = !notificationsOpen" 
                            class="p-2 rounded-full hover:bg-gray-100 relative">
                        <i data-lucide="bell" class="h-5 w-5"></i>
                        <span class="absolute notification-badge h-2.5 w-2.5 rounded-full bg-red-500"></span>
                    </button>
                    
                    <!-- Dropdown Notifications Mobile -->
                    <div x-show="notificationsOpen" @click.away="notificationsOpen = false" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                        <div class="py-1">
                            <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                                <button @click="notificationsOpen = false" class="text-gray-400 hover:text-gray-500">
                                    <i data-lucide="x" class="h-4 w-4"></i>
                                </button>
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                <div class="px-4 py-3 text-center text-sm text-gray-500">
                                    Aucune nouvelle notification
                                </div>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-2 text-center">
                                <a href="#" class="text-xs text-blue-600 hover:text-blue-800">
                                    Voir toutes les notifications
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bouton Menu Mobile -->
                <button @click="mobileMenuOpen = true" class="p-2 rounded-full hover:bg-gray-100">
                    <i data-lucide="menu" class="h-5 w-5"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- ==================== -->
    <!-- MENU MOBILE -->
    <!-- ==================== -->
    <div x-show="mobileMenuOpen" class="md:hidden fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="mobileMenuOpen = false"></div>
            <div class="fixed inset-y-0 left-0 max-w-full flex">
                <div class="relative w-screen max-w-xs">
                    <div class="h-full flex flex-col bg-white shadow-xl">
                        <!-- En-tête Menu Mobile -->
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center space-x-2">
                                <span class="font-medium">MASM</span>
                                <span class="text-xs text-gray-500">Stagiaire</span>
                            </a>
                            <button @click="mobileMenuOpen = false" class="p-2 rounded-full hover:bg-gray-100">
                                <i data-lucide="x" class="h-5 w-5"></i>
                            </button>
                        </div>
                        
                        <!-- Navigation Mobile -->
                        <nav class="flex-1 overflow-y-auto p-4">
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('stagiaire.dashboard') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.dashboard') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                                        <i data-lucide="home" class="h-5 w-5"></i>
                                        <span>Tableau de bord</span>
                                    </a>
                                </li>
                                <!-- ... autres éléments du menu ... -->
                            </ul>
                        </nav>
                        
                        <!-- Pied de page Mobile -->
                        <div class="p-4 border-t border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-start px-4 py-2 text-sm text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg">
                                    <i data-lucide="log-out" class="h-4 w-4 mr-2"></i>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ==================== -->
    <!-- LAYOUT PRINCIPAL -->
    <!-- ==================== -->
    <div class="flex h-screen">
        <!-- Barre latérale Bureau -->
        <div class="hidden md:flex md:flex-shrink-0">
            @include('layouts.sidebar-stagiaire')
        </div>
        
        <!-- Contenu Principal -->
        <main class="flex-1 overflow-y-auto">
            <!-- En-tête Bureau -->
            <header class="hidden md:flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white/80 backdrop-blur-sm z-10">
                <h1 class="dashboard-header">
                    @yield('titre', 'TABLEAU DE BORD')
                </h1>
                
                <div class="flex items-center space-x-6">
                    <!-- Bouton Notifications Bureau -->
                    <div x-data="{ notificationsOpen: false }" class="relative">
                        <button @click="notificationsOpen = !notificationsOpen" 
                                class="p-2 rounded-full hover:bg-gray-100 relative">
                            <i data-lucide="bell" class="h-5 w-5"></i>
                            <span class="absolute notification-badge h-2.5 w-2.5 rounded-full bg-red-500"></span>
                        </button>
                        
                        <!-- Dropdown Notifications Bureau -->
                        <div x-show="notificationsOpen" @click.away="notificationsOpen = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                            <div class="py-1">
                                <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                                    <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                                    <button @click="notificationsOpen = false" class="text-gray-400 hover:text-gray-500">
                                        <i data-lucide="x" class="h-4 w-4"></i>
                                    </button>
                                </div>
                                <div class="max-h-60 overflow-y-auto">
                                    <div class="px-4 py-3 text-center text-sm text-gray-500">
                                        Aucune nouvelle notification
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 px-4 py-2 text-center">
                                    <a href="#" class="text-xs text-blue-600 hover:text-blue-800">
                                        Voir toutes les notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menu Utilisateur -->
                    <div x-data="{ userMenuOpen: false }" class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-sm font-medium">#{{ Auth::id() }}</span>
                            </div>
                            <span>Stagiaire #{{ Auth::id() }}</span>
                            <i data-lucide="chevron-down" class="h-4 w-4"></i>
                        </button>
                        
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                            <div class="py-1">
                                <a href="{{ route('stagiaire.profil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon Profil</a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Contenu Dynamique -->
            <div class="p-6 md:p-8 mt-16 md:mt-0">
                @yield('contenu')
            </div>
        </main>
    </div>

    <!-- Initialisation des icônes Lucide -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>