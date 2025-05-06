<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isLogin ? 'Connexion' : 'Inscription' }} - Centre de Commande Superviseurs</title>
    <meta name="description" content="Plateforme de gestion des stagiaires pour superviseurs">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <style>
        .bg-blue-nuit {
            background-color: #0f172a; /* Bleu nuit profond */
            background-image: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.92); /* Blanc légèrement transparent */
            backdrop-filter: blur(5px);
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .btn-inscription {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3), 0 2px 4px -1px rgba(99, 102, 241, 0.2);
        }
        .btn-inscription:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4), 0 4px 6px -2px rgba(99, 102, 241, 0.3);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen bg-blue-nuit flex flex-col">
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md mx-auto form-container"> <!-- Ajout de la classe form-container -->
            <div class="p-1"> <!-- Réduit le padding pour la bordure glass -->
                <div class="text-center border-b border-gray-200 pb-4 pt-6 px-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $isLogin ? 'Connexion' : 'Inscription' }} - Centre de Commande Superviseurs
                    </h3>
                </div>
                <div class="p-6">
                    @if($isLogin)
                        @include('auth.superviseur_login-form')
                    @else
                        @include('auth.superviseur_register-form')
                    @endif
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('superviseur.auth', ['isLogin' => !$isLogin]) }}"
                           class="text-indigo-600 hover:text-indigo-800 underline text-sm">
                            {{ $isLogin ? 'Pas encore de compte ? Inscrivez-vous' : 'Déjà un compte ? Connectez-vous' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.onload = function() {
            window.history.forward();
        };
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.history.forward();
            }
        };
    </script>
</body>
</html>