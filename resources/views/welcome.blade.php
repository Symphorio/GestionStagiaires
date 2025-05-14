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
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        /* Nouvelles animations */
        [class*="animate-"] {
            animation-fill-mode: both;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes pulse {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.1); }
        }
        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Transitions pour les cartes */
        .glass-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        /* Animation pour le formulaire */
        #apply {
            animation: slideInUp 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    @include('partials.header')
    
<!-- Hero Section -->
<section class="relative pt-32 pb-16 md:pt-40 md:pb-24 px-4 bg-cover bg-center" style="background-image: url('{{ asset('images/demande.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative container mx-auto max-w-5xl text-white">
        <div class="text-center space-y-6">
            <div class="opacity-0 animate-fade-in-up animation-delay-100">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight drop-shadow-lg">
                    Plateforme de Gestion des Stagiaires
                </h1>
                <p class="mt-6 text-xl max-w-3xl mx-auto drop-shadow">
                    Ministère des Affaires Sociales et de la Microfinance
                </p>
            </div>
            
            <div class="opacity-0 animate-fade-in animation-delay-300 flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
                <x-glass-button scrollTo="apply" 
                   class="glass-button hover-scale px-6 py-3 rounded-lg font-medium transition-all">
                   Demander un Stage
                </x-glass-button>
                
                <a href="{{ route('stagiaire.login') }}" 
                   class="hover-scale px-6 py-3 rounded-lg font-medium border border-white hover:bg-white hover:text-black transition-all">
                   Espace Stagiaire
                </a>
            </div>
            
            <div class="opacity-0 animate-fade-in animation-delay-600 mt-16 text-center">
                <button id="scrollDownButton"
                        class="animate-float cursor-pointer p-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white transition-all">
                    <i data-lucide="arrow-down" class="h-8 w-8"></i>
                </button>
            </div>
        </div>
    </div>
</section>



    
    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Un Processus Simple et Efficace</h2>
            <p class="mt-4 text-gray-600">
                Notre plateforme vous accompagne à chaque étape de votre stage, de la demande jusqu'à l'obtention de votre attestation.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Bloc 1 --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                <img src="{{ asset('images/procedure.jpeg') }}" alt="Procédure Simplifiée" class="mx-auto mb-4 w-24 h-24 object-cover rounded-full border">
                <div class="flex justify-center mb-3 text-blue-500">
                    <i data-lucide="file-check" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Procédure Simplifiée</h3>
                <p class="text-gray-600 text-sm">
                    Soumettez votre demande en quelques clics et suivez son statut directement depuis notre plateforme.
                </p>
            </div>

            {{-- Bloc 2 --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                <img src="{{ asset('images/suivis1.jpeg') }}" alt="Suivi en Temps Réel" class="mx-auto mb-4 w-24 h-24 object-cover rounded-full border">
                <div class="flex justify-center mb-3 text-green-500">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Suivi en Temps Réel</h3>
                <p class="text-gray-600 text-sm">
                    Accédez à votre espace personnel pour suivre l'avancement de vos tâches et respecter vos délais.
                </p>
            </div>

            {{-- Bloc 3 --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                <img src="{{ asset('images/gestion.jpeg') }}" alt="Gestion des Rapports" class="mx-auto mb-4 w-24 h-24 object-cover rounded-full border">
                <div class="flex justify-center mb-3 text-purple-500">
                    <i data-lucide="file-text" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Gestion des Rapports</h3>
                <p class="text-gray-600 text-sm">
                    Soumettez vos rapports de stage et recevez les commentaires de vos encadreurs directement sur la plateforme.
                </p>
            </div>

            {{-- Bloc 4 --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                <img src="{{ asset('images/attestation.jpeg') }}" alt="Attestation Automatisée" class="mx-auto mb-4 w-24 h-24 object-cover rounded-full border">
                <div class="flex justify-center mb-3 text-yellow-500">
                    <i data-lucide="trophy" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Attestation Automatisée</h3>
                <p class="text-gray-600 text-sm">
                    Recevez automatiquement votre attestation de stage une fois validée par votre encadreur.
                </p>
            </div>
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
            {{-- Étape 1 --}}
            <div class="opacity-0 animate-fade-in-up flex flex-col md:flex-row items-center gap-8">
                <span class="text-2xl font-bold">1</span>
                <img src="{{ asset('images/formulaire.jpeg') }}" alt="Formulaire" class="w-24 h-24 rounded-lg object-cover border shadow-md">
                <div>
                    <h3 class="text-xl font-medium mb-2">Remplissez le formulaire de demande</h3>
                    <p class="text-gray-600">
                        Remplissez le formulaire de demande de stage avec vos informations personnelles et académiques.
                    </p>
                </div>
            </div>

            {{-- Étape 2 --}}
            <div class="opacity-0 animate-fade-in-up animation-delay-100 flex flex-col md:flex-row items-center gap-8">
                <span class="text-2xl font-bold">2</span>
                <img src="{{ asset('images/mail.jpeg') }}" alt="Mail" class="w-24 h-24 rounded-lg object-cover border shadow-md">
                <div>
                    <h3 class="text-xl font-medium mb-2">Recevez une confirmation par email</h3>
                    <p class="text-gray-600">
                        Après validation de votre demande, vous recevrez un email contenant un ID unique et un lien pour créer votre compte.
                    </p>
                </div>
            </div>

            {{-- Étape 3 --}}
            <div class="opacity-0 animate-fade-in-up animation-delay-200 flex flex-col md:flex-row items-center gap-8">
                <span class="text-2xl font-bold">3</span>
                <img src="{{ asset('images/compte.jpeg') }}" alt="Compte Stagiaire" class="w-24 h-24 rounded-lg object-cover border shadow-md">
                <div>
                    <h3 class="text-xl font-medium mb-2">Créez votre compte stagiaire</h3>
                    <p class="text-gray-600">
                        Utilisez le lien et l'ID reçus pour créer votre compte sur la plateforme et accéder à votre espace personnel.
                    </p>
                </div>
            </div>

            {{-- Étape 4 --}}
            <div class="opacity-0 animate-fade-in-up animation-delay-300 flex flex-col md:flex-row items-center gap-8">
                <span class="text-2xl font-bold">4</span>
                <img src="{{ asset('images/stage_online.jpeg') }}" alt="Stage en ligne" class="w-24 h-24 rounded-lg object-cover border shadow-md">
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
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les icônes Lucide
            lucide.createIcons();
            
            // 1. Smooth scrolling pour tous les liens
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // 2. Animation au scroll
            function animateOnScroll() {
                const elements = document.querySelectorAll('[class*="animate-"]');
                const windowHeight = window.innerHeight;
                
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementPosition < windowHeight - elementVisible) {
                        element.classList.remove('opacity-0');
                        
                        if (element.classList.contains('animate-fade-in-up')) {
                            element.style.animation = 'fadeInUp 0.6s ease-out forwards';
                        } else if (element.classList.contains('animate-fade-in')) {
                            element.style.animation = 'fadeIn 0.6s ease-out forwards';
                        }
                    }
                });
            }
            
            // 3. Animation du bouton flottant
            const floatButton = document.getElementById('scrollDownButton');
            if (floatButton) {
                floatButton.addEventListener('mouseenter', () => {
                    floatButton.style.animation = 'float 1.5s ease-in-out infinite, pulse 1.5s ease-in-out infinite';
                });
                
                floatButton.addEventListener('mouseleave', () => {
                    floatButton.style.animation = 'float 3s ease-in-out infinite';
                });
                
                floatButton.addEventListener('click', function() {
                    document.getElementById('apply').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            }
            
            // 4. Animation des cartes au survol
            document.querySelectorAll('.glass-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px)';
                    card.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.1)';
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = '';
                    card.style.boxShadow = '';
                });
            });
            
            // 5. Animation au chargement initial
            const title = document.querySelector('h1');
            if (title) {
                setTimeout(() => {
                    title.style.animation = 'fadeInUp 0.8s ease-out forwards';
                    title.classList.remove('opacity-0');
                }, 300);
            }
            
            const buttons = document.querySelectorAll('.animate-fade-in');
            if (buttons) {
                setTimeout(() => {
                    buttons.forEach(btn => {
                        btn.style.animation = 'fadeIn 0.8s ease-out forwards';
                        btn.classList.remove('opacity-0');
                    });
                }, 600);
            }
            
            if (floatButton) {
                setTimeout(() => {
                    floatButton.style.animation = 'fadeIn 0.8s ease-out forwards, float 3s ease-in-out infinite';
                    floatButton.classList.remove('opacity-0');
                }, 900);
            }
            
            // Activer les animations au scroll et au chargement
            window.addEventListener('scroll', animateOnScroll);
            window.addEventListener('load', animateOnScroll);
            
            // Activer les animations initiales
            animateOnScroll();
        });
    </script>
</body>
</html>