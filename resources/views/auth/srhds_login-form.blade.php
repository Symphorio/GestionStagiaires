<!-- resources/views/auth/login.blade.php -->
<div class="glass-card w-full max-w-md mx-auto p-8 animate-scale-in">
    <h2 class="text-2xl font-medium mb-6 text-center">Connexion</h2>
    
    <form method="POST" action="{{ route('srhds.login.submit') }}" class="space-y-6">
        @csrf
        
        <div class="space-y-2">
        <label for="name" class="text-sm font-medium">Nom complet</label>
        <input 
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            class="focus-ring w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Votre nom complet"
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
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="space-y-2">
            <label for="password" class="text-sm font-medium">Mot de passe</label>
            <input 
                type="password"
                id="password"
                name="password"
                class="focus-ring w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Votre mot de passe"
                required
            />
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        
        <button 
            type="submit" 
            class="w-full glass-button hover-scale flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
            x-data="{ isSubmitting: false }"
            @click="isSubmitting = true; $event.target.form.submit()"
        >
            <template x-if="isSubmitting">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </template>
            <template x-if="!isSubmitting">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </template>
            <span x-text="isSubmitting ? 'Connexion en cours...' : 'Se connecter'"></span>
        </button>
    </form>
</div>

<!-- Ajoutez ce style dans votre fichier CSS -->
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.5rem;
    }
    
    .hover-scale:hover {
        transform: scale(1.02);
        transition: transform 0.3s ease;
    }
    
    .focus-ring:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }
    
    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    
    .animate-scale-in {
        animation: scaleIn 0.3s ease-out forwards;
    }
</style>