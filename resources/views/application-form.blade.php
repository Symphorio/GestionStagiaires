@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-md p-8 border border-gray-200">
        <h2 class="text-2xl font-medium mb-6 text-center text-gray-800">Demande de Stage</h2>
        
        <!-- Conteneur pour les messages AJAX -->
        <div id="ajax-messages" class="hidden mb-6"></div>
        
        <!-- Messages de succès/erreur (pour soumission non-AJAX) -->
        @if(session('succes'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('succes') }}
            </div>
        @endif
        
        @if($errors->any() && !request()->ajax())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('stage.soumettre') }}" id="demandeStageForm" class="space-y-6" enctype="multipart/form-data">
            @csrf
            
            <!-- En haut du formulaire -->
<div id="form-messages" class="hidden mb-6"></div>
            <!-- Ligne 1 - Prénom et Nom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input 
                        type="text"
                        id="prenom"
                        name="prenom"
                        value="{{ old('prenom') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Votre prénom"
                        required
                    />
                </div>
                
                <div class="space-y-2">
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input 
                        type="text"
                        id="nom"
                        name="nom"
                        value="{{ old('nom') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Votre nom"
                        required
                    />
                </div>
            </div>
            
            <!-- Ligne 2 - Email et Téléphone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="votre.email@exemple.com"
                        required
                    />
                </div>
                
                <div class="space-y-2">
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input 
                        type="tel"
                        id="telephone"
                        name="telephone"
                        value="{{ old('telephone') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Votre numéro de téléphone"
                        required
                    />
                </div>
            </div>
            
            <!-- Ligne 3 - Formation et Spécialisation -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="formation" class="block text-sm font-medium text-gray-700">Formation</label>
                    <input 
                        type="text"
                        id="formation"
                        name="formation"
                        value="{{ old('formation') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Votre niveau d'études"
                        required
                    />
                </div>
                
                <div class="space-y-2">
                    <label for="specialisation" class="block text-sm font-medium text-gray-700">Spécialisation</label>
                    <input 
                        type="text"
                        id="specialisation"
                        name="specialisation"
                        value="{{ old('specialisation') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Votre domaine de spécialisation"
                    />
                </div>
            </div>
            
            <!-- Ligne 4 - Dates de début et fin -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début souhaitée</label>
                    <input 
                        type="date"
                        id="date_debut"
                        name="date_debut"
                        value="{{ old('date_debut') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    />
                </div>
                
                <div class="space-y-2">
                    <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin souhaitée</label>
                    <input 
                        type="date"
                        id="date_fin"
                        name="date_fin"
                        value="{{ old('date_fin') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    />
                </div>
            </div>
            
            <!-- Lettre de motivation -->
            <div class="space-y-2">
    <label for="lettre_motivation" class="block text-sm font-medium text-gray-700">
        Lettre de Motivation (PDF)
    </label>
    <input 
        type="file"
        id="lettre_motivation"
        name="lettre_motivation"
        class="block w-full text-sm text-gray-500
               file:mr-4 file:py-2 file:px-4
               file:rounded-md file:border-0
               file:text-sm file:font-semibold
               file:bg-blue-50 file:text-blue-700
               hover:file:bg-blue-100"
        accept=".pdf"
        required
    />
    <p class="mt-1 text-xs text-gray-500">Format PDF uniquement (max 2MB)</p>
</div>
            
            <!-- Bouton de soumission -->
            <button 
                type="submit" 
                id="submitBtn"
                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-150 ease-in-out hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Soumettre ma demande
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('demandeStageForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitBtn = document.getElementById('submitBtn');
    const originalBtnText = submitBtn.innerHTML;
    
    // Afficher l'indicateur de chargement
    submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Soumission en cours...
    `;
    submitBtn.disabled = true;

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (response.ok) {
            // 1. Notification navigateur
            showBrowserNotification('Demande soumise avec succès!');

            // 2. Toast notification
            showToast('success', 'Votre demande a été enregistrée!');

            // 3. Message dans la page
            showPageMessage('success', data.message || 'Demande soumise avec succès!');

            // Réinitialiser le formulaire
            form.reset();

        } else {
            // Gestion des erreurs
            const errorMsg = data.errors 
                ? Object.values(data.errors).join('\n')
                : data.message || 'Erreur lors de la soumission';
            
            showToast('error', errorMsg);
            showPageMessage('error', errorMsg);
        }

    } catch (error) {
        showToast('error', 'Erreur réseau');
        showPageMessage('error', 'Erreur de connexion');
    } finally {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
    }
});

// Fonctions d'affichage
function showBrowserNotification(message) {
    if ('Notification' in window && Notification.permission === 'granted') {
        new Notification('MASAM Stages', { body: message });
    }
}

function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-md shadow-lg text-white ${
        type === 'success' ? 'bg-green-600' : 'bg-red-600'
    } z-50 transform transition-all duration-300 translate-y-4 opacity-0`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('translate-y-4', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    }, 10);

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

function showPageMessage(type, message) {
    const container = document.getElementById('form-messages');
    container.innerHTML = `
        <div class="p-4 rounded-md ${
            type === 'success' 
                ? 'bg-green-100 text-green-800 border border-green-200' 
                : 'bg-red-100 text-red-800 border border-red-200'
        }">
            ${message}
        </div>
    `;
    container.classList.remove('hidden');
}

// Demander la permission au chargement
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}
</script>

<style>
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endsection