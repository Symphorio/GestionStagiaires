<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme de Gestion des Stagiaires - Ministère des Affaires Sociales et de la Microfinance</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <link href="https://unpkg.com/lucide@latest/dist/lucide.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .glass-button {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .hover-scale:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    @include('partials.header')
    
    <!-- Hero Section -->
    <section class="pt-32 pb-16 md:pt-40 md:pb-24 px-4">
        <div class="container mx-auto max-w-5xl">
            <div class="text-center space-y-6">
                <div class="opacity-0 animate-fade-in-up animation-delay-100">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Plateforme de Gestion des Stagiaires
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 max-w-3xl mx-auto">
                        Ministère des Affaires Sociales et de la Microfinance
                    </p>
                </div>
                
                <div class="opacity-0 animate-fade-in animation-delay-300 flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
                <x-glass-button scrollTo="apply">
                 Demander un Stage
                </x-glass-button>
                    
                    <a 
                        href="{{ route('login') }}"
                        class="hover-scale px-6 py-3 rounded-lg font-medium border border-gray-300 hover:bg-gray-100 transition-all"
                    >
                        Espace Stagiaire
                    </a>
                </div>
            </div>
            
            <div class="opacity-0 animate-fade-in animation-delay-600 mt-16 text-center">
                <button
                    id="scrollDownButton"
                    class="animate-float cursor-pointer p-2 rounded-full hover:bg-gray-200 transition-all"
                >
                    <i data-lucide="arrow-down" class="h-8 w-8"></i>
                </button>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-16 md:py-24 bg-gray-100 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="opacity-0 animate-fade-in-up text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold">Un Processus Simple et Efficace</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                    Notre plateforme vous accompagne à chaque étape de votre stage, de la demande jusqu'à l'obtention de votre attestation.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $features = [
                        [
                            'icon' => 'check-circle',
                            'title' => "Procédure Simplifiée",
                            'description' => "Soumettez votre demande en quelques clics et suivez son statut directement depuis notre plateforme."
                        ],
                        [
                            'icon' => 'clock',
                            'title' => "Suivi en Temps Réel",
                            'description' => "Accédez à votre espace personnel pour suivre l'avancement de vos tâches et respecter vos délais."
                        ],
                        [
                            'icon' => 'file-check',
                            'title' => "Gestion des Rapports",
                            'description' => "Soumettez vos rapports de stage et recevez les commentaires de vos encadreurs directement sur la plateforme."
                        ],
                        [
                            'icon' => 'user-check',
                            'title' => "Attestation Automatisée",
                            'description' => "Recevez automatiquement votre attestation de stage une fois validée par votre encadreur."
                        ]
                    ];
                @endphp

                @foreach($features as $index => $feature)
                    <div class="opacity-0 animate-fade-in-up animation-delay-{{ ($index + 1) * 100 }} glass-card p-6 flex flex-col items-center text-center hover-scale">
                        <div class="mb-4">
                            <i data-lucide="{{ $feature['icon'] }}" class="h-10 w-10 text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-medium mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Process Steps -->
    <section class="py-16 md:py-24 px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="opacity-0 animate-fade-in-up text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold">Comment ça marche</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                    Suivez ces étapes simples pour commencer votre stage
                </p>
            </div>
            
            <div class="space-y-12">
                <div class="opacity-0 animate-fade-in-up flex flex-col md:flex-row items-center gap-8">
                    <div class="glass-card p-6 flex items-center justify-center w-20 h-20 rounded-full shrink-0">
                        <span class="text-2xl font-bold">1</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-medium mb-2">Remplissez le formulaire de demande</h3>
                        <p class="text-gray-600">
                            Remplissez le formulaire de demande de stage avec vos informations personnelles et académiques.
                        </p>
                    </div>
                </div>
                
                <div class="opacity-0 animate-fade-in-up animation-delay-100 flex flex-col md:flex-row items-center gap-8">
                    <div class="glass-card p-6 flex items-center justify-center w-20 h-20 rounded-full shrink-0">
                        <span class="text-2xl font-bold">2</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-medium mb-2">Recevez une confirmation par email</h3>
                        <p class="text-gray-600">
                            Après validation de votre demande, vous recevrez un email contenant un ID unique et un lien pour créer votre compte.
                        </p>
                    </div>
                </div>
                
                <div class="opacity-0 animate-fade-in-up animation-delay-200 flex flex-col md:flex-row items-center gap-8">
                    <div class="glass-card p-6 flex items-center justify-center w-20 h-20 rounded-full shrink-0">
                        <span class="text-2xl font-bold">3</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-medium mb-2">Créez votre compte stagiaire</h3>
                        <p class="text-gray-600">
                            Utilisez le lien et l'ID reçus pour créer votre compte sur la plateforme et accéder à votre espace personnel.
                        </p>
                    </div>
                </div>
                
                <div class="opacity-0 animate-fade-in-up animation-delay-300 flex flex-col md:flex-row items-center gap-8">
                    <div class="glass-card p-6 flex items-center justify-center w-20 h-20 rounded-full shrink-0">
                        <span class="text-2xl font-bold">4</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-medium mb-2">Gérez votre stage en ligne</h3>
                        <p class="text-gray-600">
                            Suivez vos tâches, soumettez vos rapports et recevez votre attestation directement sur la plateforme.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Application Form Section -->
    <section id="apply" class="py-16 md:py-24 bg-gray-100 px-4">
        <div class="container mx-auto max-w-5xl">
            <div class="opacity-0 animate-fade-in-up text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold">Demande de Stage</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                    Remplissez le formulaire ci-dessous pour soumettre votre demande de stage au Ministère des Affaires Sociales et de la Microfinance.
                </p>
                </div>
                   @include('application-form')
              </div>
    </section>
    
    <!-- Contact CTA -->
    <section class="py-16 md:py-24 px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="opacity-0 animate-fade-in-up glass-card p-8 md:p-12 text-center">
                <i data-lucide="lightbulb" class="h-12 w-12 mx-auto mb-6 text-blue-600"></i>
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Besoin d'aide?</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                    Notre équipe est disponible pour répondre à toutes vos questions concernant les stages au sein du Ministère.
                </p>
                <a 
                    href="mailto:contact@masam.gouv.bj"
                    class="glass-button hover-scale px-6 py-3 rounded-lg text-white font-medium inline-flex items-center"
                >
                    <i data-lucide="mail" class="mr-2 h-4 w-4"></i>
                    Contactez-nous
                </a>
            </div>
        </div>
    </section>
    
    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        // Initialiser les icônes Lucide
        lucide.createIcons();
        
        // Animation au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            // Activer les animations
            const animateElements = document.querySelectorAll('[class*="animate-"]');
            animateElements.forEach(el => {
                el.classList.remove('opacity-0');
            });
            
            // Scroll vers le formulaire
            document.getElementById('applyButton').addEventListener('click', function() {
                document.getElementById('apply').scrollIntoView({
                    behavior: 'smooth'
                });
            });
            
            document.getElementById('scrollDownButton').addEventListener('click', function() {
                document.getElementById('apply').scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>