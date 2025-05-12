<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre de Commande des Superviseurs</title>
    <meta name="description" content="Plateforme de gestion des stagiaires pour superviseurs">
    <meta name="author" content="Lovable">

    <meta property="og:title" content="Centre de Commande des Superviseurs">
    <meta property="og:description" content="Plateforme de gestion des stagiaires pour superviseurs">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://lovable.dev/opengraph-image-p98pqg.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@lovable_dev">
    <meta name="twitter:image" content="https://lovable.dev/opengraph-image-p98pqg.png">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js" defer></script>
    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Signature Pad -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-blue-800 text-white">
                <div class="flex items-center h-16 px-4 border-b border-blue-700">
                    <span class="text-xl font-semibold">Superviseur</span>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <nav class="px-2 py-4">
                        <!-- Premier élément avec marge supplémentaire en bas -->
                        <div class="mb-6">
                            <a href="{{ route('superviseur.dashboard') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium text-white rounded-md group transition-all duration-200
                                      {{ request()->routeIs('superviseur.dashboard') ? 'bg-blue-900 shadow-md scale-[1.02]' : 'bg-blue-800 hover:bg-blue-700 hover:scale-[1.02]' }}">
                                <span class="mr-3">📊</span>
                                Tableau de bord
                            </a>
                        </div>
                        
                        <!-- Groupe des autres liens avec espacement régulier -->
                        <div class="space-y-3">
                            <a href="{{ route('superviseur.stagiaires') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium rounded-md group transition-all duration-200
                                      {{ request()->routeIs('superviseur.stagiaires') ? 'bg-blue-900 text-white shadow-md scale-[1.02]' : 'text-blue-200 hover:text-white hover:bg-blue-700 hover:scale-[1.02]' }}">
                                <span class="mr-3">👥</span>
                                Stagiaires
                            </a>
                            <a href="{{ route('superviseur.tasks') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium rounded-md group transition-all duration-200
                                      {{ request()->routeIs('superviseur.tasks') ? 'bg-blue-900 text-white shadow-md scale-[1.02]' : 'text-blue-200 hover:text-white hover:bg-blue-700 hover:scale-[1.02]' }}">
                                <span class="mr-3">📋</span>
                                Tâches
                            </a>
                            <a href="{{ route('superviseur.rapports.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium rounded-md group transition-all duration-200
                                      {{ request()->routeIs('superviseur.rapports.*') ? 'bg-blue-900 text-white shadow-md scale-[1.02]' : 'text-blue-200 hover:text-white hover:bg-blue-700 hover:scale-[1.02]' }}">
                                <span class="mr-3">📝</span>
                                Rapports
                            </a>
                            <a href="{{ route('superviseur.memoires') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium rounded-md group transition-all duration-200
                                      {{ request()->routeIs('superviseur.memoires') ? 'bg-blue-900 text-white shadow-md scale-[1.02]' : 'text-blue-200 hover:text-white hover:bg-blue-700 hover:scale-[1.02]' }}">
                                <span class="mr-3">📚</span>
                                Mémoires
                            </a>
                        </div>
                    </nav>
                </div>
                
                <!-- Section de déconnexion épurée -->
                <div class="p-4 border-t border-blue-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-700 hover:bg-blue-600 rounded-md transition-all duration-200
                                       hover:shadow-md hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1 overflow-auto">
            <div class="p-6">
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>