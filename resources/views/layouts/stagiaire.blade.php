<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASM - Tableau de bord stagiaire</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Icônes Lucide -->
    <link href="https://unpkg.com/lucide@latest/dist/lucide.css" rel="stylesheet">
    <!-- Alpine.js pour les interactions -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- En-tête mobile -->
    <header class="md:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center space-x-2">
                <span class="font-medium">MASM</span>
                <span class="text-xs text-gray-500">Stagiaire</span>
            </a>
            
            <div class="flex items-center space-x-2">
                <!-- Menu déroulant notifications -->
                <div x-data="{ ouvert: false }" class="relative">
                    <button @click="ouvert = !ouvert" class="p-2 rounded-full hover:bg-gray-100">
                        <i data-lucide="bell" class="h-5 w-5"></i>
                    </button>
                    <div x-show="ouvert" @click.away="ouvert = false" 
                         class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg z-50">
                        <div class="py-1">
                            <div class="px-4 py-2 text-sm font-medium text-gray-700">Notifications</div>
                            <div class="border-t border-gray-100"></div>
                            <div class="px-4 py-2 text-sm text-gray-500">Aucune notification</div>
                        </div>
                    </div>
                </div>
                
                <!-- Bouton menu mobile -->
                <button @click="menuMobileOuvert = true" class="p-2 rounded-full hover:bg-gray-100">
                    <i data-lucide="menu" class="h-5 w-5"></i>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Menu mobile -->
    <div x-data="{ menuMobileOuvert: false }" class="md:hidden">
        <div x-show="menuMobileOuvert" class="fixed inset-0 z-50 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     @click="menuMobileOuvert = false"></div>
                <div class="fixed inset-y-0 left-0 max-w-full flex">
                    <div class="relative w-screen max-w-xs">
                        <div class="h-full flex flex-col bg-white shadow-xl">
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center space-x-2">
                                        <span class="font-medium">MASM</span>
                                        <span class="text-xs text-gray-500">Stagiaire</span>
                                    </a>
                                    <button @click="menuMobileOuvert = false" class="p-2 rounded-full hover:bg-gray-100">
                                        <i data-lucide="x" class="h-5 w-5"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <nav class="flex-1 overflow-y-auto p-4">
                                <ul class="space-y-2">
                                    <li>
                                        <a href="{{ route('stagiaire.dashboard') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.tableau-de-bord') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                                            <i data-lucide="home" class="h-5 w-5"></i>
                                            <span>Tableau de bord</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('stagiaire.taches') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.taches') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                                            <i data-lucide="chevron-down" class="h-5 w-5"></i>
                                            <span>Tâches</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('stagiaire.rapports') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.rapports') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                                            <i data-lucide="file-text" class="h-5 w-5"></i>
                                            <span>Rapports</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('stagiaire.memoire') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.memoire') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                                            <i data-lucide="book-open" class="h-5 w-5"></i>
                                            <span>Mémoire</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('stagiaire.calendrier') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.calendrier') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                                            <i data-lucide="calendar" class="h-5 w-5"></i>
                                            <span>Calendrier</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('stagiaire.profil') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.profil') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                                            <i data-lucide="user" class="h-5 w-5"></i>
                                            <span>Profil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('stagiaire.parametres') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.parametres') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                                            <i data-lucide="settings" class="h-5 w-5"></i>
                                            <span>Paramètres</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            
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
    </div>
    
    <!-- Layout bureau -->
    <div class="flex h-screen">
        <!-- Barre latérale bureau -->
        <div class="hidden md:block">
            @include('layouts.sidebar-stagiaire')
        </div>
        
        <!-- Contenu principal -->
        <main class="flex-1 overflow-y-auto">
            <!-- En-tête bureau -->
            <header class="hidden md:flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white/80 backdrop-blur-sm z-10">
                <h1 class="text-lg font-medium">
                    @yield('titre', 'Tableau de bord')
                </h1>
                
                <div class="flex items-center space-x-4">
                    <!-- Menu notifications -->
                    <div x-data="{ ouvert: false }" class="relative">
                        <button @click="ouvert = !ouvert" class="p-2 rounded-full hover:bg-gray-100">
                            <i data-lucide="bell" class="h-5 w-5"></i>
                        </button>
                        <div x-show="ouvert" @click.away="ouvert = false" 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg z-50">
                            <div class="py-1">
                                <div class="px-4 py-2 text-sm font-medium text-gray-700">Notifications</div>
                                <div class="border-t border-gray-100"></div>
                                <div class="px-4 py-2 text-sm text-gray-500">Aucune notification</div>
                            </div>
                        </div>
                    </div>
                    
                   <!-- Menu utilisateur -->
<div x-data="{ ouvert: false }" class="relative">
    <button @click="ouvert = !ouvert" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
            <span class="text-sm font-medium">#{{ Auth::id() }}</span>
        </div>
        <span>Stagiaire #{{ Auth::id() }}</span>
        <i data-lucide="chevron-down" class="h-4 w-4"></i>
    </button>
    <div x-show="ouvert" @click.away="ouvert = false" 
         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
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
            
            <!-- Zone de contenu -->
            <div class="p-6 md:p-8 mt-16 md:mt-0">
                <div x-data="{ afficher: true }" x-show="afficher" x-transition>
                    @yield('contenu')
                </div>
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