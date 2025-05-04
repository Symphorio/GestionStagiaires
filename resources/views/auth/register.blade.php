<!-- resources/views/auth/register.blade.php -->
<div class="glass-card w-full max-w-md mx-auto p-8 animate-scale-in">
    <h2 class="text-2xl font-medium mb-6 text-center">Création de Compte Stagiaire</h2>
    
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('stagiaire.register.submit') }}" class="space-y-6">
        @csrf
        
        <div class="space-y-2">
            <label for="nom" class="text-sm font-medium">Nom</label>
            <input 
                type="text"
                id="nom"
                name="nom"
                value="{{ old('nom') }}"
                class="focus-ring w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Votre nom"
                required
            />
        </div>

        <div class="space-y-2">
            <label for="prenom" class="text-sm font-medium">Prénom</label>
            <input 
                type="text"
                id="prenom"
                name="prenom"
                value="{{ old('prenom') }}"
                class="focus-ring w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Votre prénom"
                required
            />
        </div>
        
        <div class="space-y-2">
            <label for="email" class="text-sm font-medium">Email</label>
            <input 
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                class="focus-ring w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="votre.email@exemple.com"
                required
            />
            <p class="text-xs text-gray-500 mt-1">Utilisez le même email que dans votre demande de stage</p>
        </div>
        
        <div class="space-y-2">
            <label for="intern_id" class="text-sm font-medium">Code de validation</label>
            <input 
                type="text"
                id="intern_id"
                name="intern_id"
                value="{{ old('intern_id') }}"
                class="focus-ring w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Code reçu par email"
                required
            />
            <p class="text-xs text-gray-500 mt-1">Le code unique fourni dans l'email d'acceptation</p>
        </div>
        
        <div class="space-y-2">
            <label for="password" class="text-sm font-medium">Mot de passe</label>
            <input 
                type="password"
                id="password"
                name="password"
                class="focus-ring w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Créez un mot de passe"
                required
            />
        </div>
        
        <div class="space-y-2">
            <label for="password_confirmation" class="text-sm font-medium">Confirmer le mot de passe</label>
            <input 
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="focus-ring w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Confirmez votre mot de passe"
                required
            />
        </div>
        
        <button 
            type="submit" 
            id="submitButton"
            class="w-full glass-button hover-scale flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            <span id="submitText">Créer mon compte</span>
        </button>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const spinner = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;

    form.addEventListener('submit', function(e) {
        // Empêcher la soumission multiple
        if (submitButton.disabled) {
            e.preventDefault();
            return;
        }

        // Afficher le spinner et désactiver le bouton
        submitButton.disabled = true;
        submitButton.innerHTML = spinner + 'Création en cours...';
    });
});
</script>