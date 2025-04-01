<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Stagiaire - MASAM</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <link href="https://unpkg.com/lucide@latest/dist/lucide.min.css" rel="stylesheet">
    <!-- AlpineJS pour l'interactivité -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .animated-link {
            position: relative;
            display: inline-block;
        }
        
        .animated-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        
        .animated-link:hover::after {
            width: 100%;
        }
        
        .tab-button {
            transition: all 0.3s ease;
        }
        
        .tab-button.active {
            background-color: #eff6ff;
            color: #3b82f6;
            font-weight: 500;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen" x-data="{ activeTab: 'login' }">
    @include('partials.header')
    
    <main class="flex-1 pt-32 pb-16 px-4">
        <div class="container mx-auto max-w-5xl">
            <!-- Bouton Retour -->
            <div class="mb-8" style="animation: fadeIn 0.5s ease-out forwards;">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Retour à l'accueil
                </a>
            </div>
            
            <!-- Titre et description -->
            <div class="text-center mb-12" style="animation: fadeIn 0.5s ease-out forwards;">
                <h1 class="text-3xl md:text-4xl font-bold">Espace Stagiaire</h1>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto">
                    Connectez-vous ou créez un compte pour accéder à votre espace personnel de stage.
                </p>
            </div>
            
            <!-- Onglets -->
            <div style="animation: fadeIn 0.5s ease-out 0.2s forwards;">
                <div class="flex justify-center mb-8">
                    <div class="inline-flex bg-gray-100 p-1 rounded-lg">
                        <button 
                            @click="activeTab = 'login'" 
                            :class="{ 'active': activeTab === 'login' }"
                            class="tab-button px-6 py-2 rounded-md text-sm font-medium"
                        >
                            Connexion
                        </button>
                        <button 
                            @click="activeTab = 'register'" 
                            :class="{ 'active': activeTab === 'register' }"
                            class="tab-button px-6 py-2 rounded-md text-sm font-medium"
                        >
                            Inscription
                        </button>
                    </div>
                </div>
                
                <!-- Contenu des onglets -->
                <div x-show="activeTab === 'login'" class="animate-fade-in">
                    @include('auth.login-form')
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">
                            Vous n'avez pas encore de compte?{" "}
                            <button 
                                @click="activeTab = 'register'"
                                class="text-blue-600 animated-link"
                            >
                                Créer un compte
                            </button>
                        </p>
                    </div>
                </div>
                
                <div x-show="activeTab === 'register'" class="animate-fade-in">
                    @include('auth.register-form')
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">
                            Vous avez déjà un compte?{" "}
                            <button 
                                @click="activeTab = 'login'"
                                class="text-blue-600 animated-link"
                            >
                                Se connecter
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        // Initialiser les icônes Lucide
        lucide.createIcons();
    </script>
</body>
</html>