@extends('layouts.stagiaire')

@section('contenu')
<div class="space-y-8">
    <h1 class="text-2xl font-semibold">Paramètres</h1>
    
    <div class="glass-card p-6">
        <h2 class="text-xl font-medium mb-6">Préférences du Compte</h2>
        
        <form action="{{ route('stagiaire.parametres.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Notifications -->
            <div class="flex flex-row items-center justify-between rounded-lg border p-4">
                <div class="space-y-0.5">
                    <label class="text-base font-medium block">Notifications</label>
                    <p class="text-sm text-gray-500">
                        Activer les notifications dans l'application
                    </p>
                </div>
                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                    <input type="checkbox" name="notifications" id="notifications" 
                           class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                           {{ $userParametres->notifications ? 'checked' : '' }}>
                    <label for="notifications" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </div>
            
            <!-- Alertes Email -->
            <div class="flex flex-row items-center justify-between rounded-lg border p-4">
                <div class="space-y-0.5">
                    <label class="text-base font-medium block">Alertes par Email</label>
                    <p class="text-sm text-gray-500">
                        Recevoir des alertes par email pour les nouvelles tâches et rappels
                    </p>
                </div>
                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                    <input type="checkbox" name="emailAlerts" id="emailAlerts" 
                           class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                           {{ $userParametres->email_alerts ? 'checked' : '' }}>
                    <label for="emailAlerts" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </div>
            
            <!-- Mode Sombre -->
            <div class="flex flex-row items-center justify-between rounded-lg border p-4">
                <div class="space-y-0.5">
                    <label class="text-base font-medium block">Mode Sombre</label>
                    <p class="text-sm text-gray-500">
                        Activer le mode sombre pour l'interface
                    </p>
                </div>
                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                    <input type="checkbox" name="darkMode" id="darkMode" 
                           class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                           {{ $userParametres->dark_mode ? 'checked' : '' }}>
                    <label for="darkMode" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </div>
            
            <!-- Langue -->
            <div class="space-y-2">
                <label for="language" class="block text-sm font-medium">Langue</label>
                <select name="language" id="language" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="fr" {{ $userParametres->language === 'fr' ? 'selected' : '' }}>Français</option>
                    <option value="en" {{ $userParametres->language === 'en' ? 'selected' : '' }}>English</option>
                </select>
                <p class="text-sm text-gray-500">
                    Langue préférée pour l'interface (fr, en)
                </p>
            </div>
            
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Enregistrer les modifications
            </button>
        </form>
    </div>
    
    <div class="glass-card p-6">
        <h2 class="text-xl font-medium mb-6 text-red-600">Zone Dangereuse</h2>
        
        <div class="space-y-4">
            <p class="text-gray-500">
                La suppression de votre compte est une action permanente et ne peut pas être annulée.
                Toutes vos données seront perdues.
            </p>
            
            <button type="button" onclick="confirmDelete()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Supprimer mon compte
            </button>
        </div>
    </div>
</div>

<style>
    /* Style pour les switches */
    .toggle-checkbox:checked {
        right: 0;
        border-color: #6366F1;
    }
    .toggle-checkbox:checked + .toggle-label {
        background-color: #6366F1;
    }
    .toggle-checkbox {
        transition: all 0.2s ease;
        right: 20px;
    }
    .toggle-label {
        transition: background-color 0.2s ease;
    }
</style>

<script>
    // Confirmation avant suppression
    function confirmDelete() {
        if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
            // Soumettre le formulaire de suppression
            document.getElementById('delete-form').submit();
        }
    }

    // Toast pour la confirmation des paramètres
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Envoyer le formulaire en AJAX
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Afficher un message de succès
            alert('Paramètres mis à jour avec succès');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

<!-- Formulaire caché pour la suppression -->
<form id="delete-form" action="{{ route('stagiaire.parametres.destroy') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection