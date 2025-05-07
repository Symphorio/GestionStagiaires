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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <nav class="px-2 py-4 space-y-1">
                        <a href="{{ route('superviseur.dashboard') }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-900 rounded-md group">
                            <span class="mr-3">📊</span>
                            Tableau de bord
                        </a>
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-sm font-medium text-blue-200 hover:text-white hover:bg-blue-700 rounded-md group">
                            <span class="mr-3">👥</span>
                            Stagiaires
                        </a>
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-sm font-medium text-blue-200 hover:text-white hover:bg-blue-700 rounded-md group">
                            <span class="mr-3">📋</span>
                            Tâches
                        </a>
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-sm font-medium text-blue-200 hover:text-white hover:bg-blue-700 rounded-md group">
                            <span class="mr-3">📝</span>
                            Rapports
                        </a>
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-sm font-medium text-blue-200 hover:text-white hover:bg-blue-700 rounded-md group">
                            <span class="mr-3">📚</span>
                            Mémoires
                        </a>
                    </nav>
                </div>
                <div class="p-4 border-t border-blue-700">
                    <div class="flex items-center">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ Auth::guard('superviseur')->user()->name }}</p>
                            <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-xs font-medium text-blue-200 hover:text-white">
        Déconnexion
    </button>
</form>
                        </div>
                    </div>
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