@extends('layouts.superviseur')

@section('content')
<div class="space-y-8" x-data="{
    archiveModalOpen: false,
    archiveData: null,
    isLoading: false,
    errorMessage: '',
    
    async openArchiveModal(stagiaireId) {
        try {
            this.isLoading = true;
            this.errorMessage = '';
            this.archiveData = null;
            
            const response = await fetch(`/superviseur/stagiaires/${stagiaireId}/archives`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Erreur serveur: ' + response.status);
            }

            const data = await response.json();
            
            if (!data.prenom) {
                throw new Error('Données du stagiaire manquantes');
            }

            this.archiveData = data;
            this.archiveModalOpen = true;
            
        } catch (error) {
            console.error('Erreur:', error);
            this.errorMessage = error.message || 'Erreur lors du chargement des archives';
            this.archiveModalOpen = true;
        } finally {
            this.isLoading = false;
        }
    }
}">
    <!-- En-tête -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des stagiaires</h1>
        <p class="text-gray-600 mt-2">Ajoutez et gérez les stagiaires sous votre supervision.</p>
    </div>

    <!-- Formulaire d'association -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Associer un stagiaire</h2>
        <p class="text-gray-600 mb-6">Recherchez et sélectionnez un stagiaire à ajouter à votre supervision</p>
        
        <form action="{{ route('superviseur.stagiaires.store') }}" method="POST" id="associate-form" class="space-y-4">
            @csrf
            <div class="relative">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher un stagiaire</label>
                <input type="text" id="search" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" 
                       placeholder="Tapez le nom ou l'email du stagiaire..."
                       autocomplete="off">
                <div id="search-results" class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
            </div>

            <div id="selected-stagiaire-container" class="hidden p-3 bg-gray-50 rounded-md border border-gray-200">
                <input type="hidden" id="stagiaire_id" name="stagiaire_id" required>
                <div class="flex justify-between items-center">
                    <div>
                        <span id="selected-name" class="font-medium text-gray-800"></span>
                        <span id="selected-email" class="text-sm text-gray-500 ml-2"></span>
                    </div>
                    <button type="button" id="clear-selection" class="text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" id="submit-button" disabled
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                Associer le stagiaire
            </button>
        </form>
    </div>

    <!-- Onglets -->
    <div x-data="{ activeTab: 'active' }">
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-8">
                <button @click="activeTab = 'active'" 
                        :class="activeTab === 'active' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Stagiaires actifs ({{ $activeStagiaires->count() }})
                </button>
                <button @click="activeTab = 'completed'" 
                        :class="activeTab === 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Stages terminés ({{ $completedStagiaires->count() }})
                </button>
            </nav>
        </div>

        <!-- Stagiaires actifs -->
        <div x-show="activeTab === 'active'" x-transition class="space-y-4">
            @forelse($activeStagiaires as $stagiaire)
            <div class="bg-white p-6 rounded-lg shadow flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center space-x-4 flex-1 min-w-0">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-12 h-12 flex-shrink-0 flex items-center justify-center font-bold">
                        {{ substr($stagiaire->prenom, 0, 1) }}{{ substr($stagiaire->nom, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-medium text-gray-800 truncate">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h3>
                        <p class="text-sm text-gray-500 truncate">{{ $stagiaire->email }}</p>
                        <div class="mt-2 flex items-center">
                            <span class="text-sm font-medium mr-2">Progression:</span>
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stagiaire->progress }}%"></div>
                            </div>
                            <span class="text-sm font-medium ml-2">{{ $stagiaire->progress }}%</span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto">
                    <form action="{{ route('superviseur.stagiaires.dissociate', $stagiaire) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Dissocier
                        </button>
                    </form>
                    <a href="{{ route('superviseur.stagiaires.details', $stagiaire) }}" 
                       class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-center">
                        Détails
                    </a>
                </div>
            </div>
            @empty
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                Aucun stagiaire actif pour le moment.
            </div>
            @endforelse
        </div>

        <!-- Stages terminés -->
        <div x-show="activeTab === 'completed'" x-transition class="space-y-4">
            @forelse($completedStagiaires as $stagiaire)
            <div class="bg-white p-6 rounded-lg shadow flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center space-x-4 flex-1 min-w-0">
                    <div class="bg-gray-100 text-gray-800 rounded-full w-12 h-12 flex-shrink-0 flex items-center justify-center font-bold">
                        {{ substr($stagiaire->prenom, 0, 1) }}{{ substr($stagiaire->nom, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-medium text-gray-800 truncate">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h3>
                        <p class="text-sm text-gray-500 truncate">{{ $stagiaire->email }}</p>
                        <div class="mt-2 flex items-center flex-wrap gap-2">
                            <span class="text-sm font-medium">Progression finale: {{ $stagiaire->progress }}%</span>
                            <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full">Terminé</span>
                        </div>
                    </div>
                </div>
                <button @click="openArchiveModal({{ $stagiaire->id }})" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Archives
                </button>
            </div>
            @empty
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                Aucun stage terminé pour le moment.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Archives -->
    <div x-show="archiveModalOpen" x-transition.opacity 
         class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
         x-cloak
         style="display: none;">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.away="archiveModalOpen = false">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold text-gray-800">
                        <span x-text="errorMessage ? 'Erreur' : 'Archives du stagiaire'"></span>
                        <span x-show="!errorMessage && archiveData" x-text="' ' + archiveData.prenom + ' ' + archiveData.nom"></span>
                    </h3>
                    <button @click="archiveModalOpen = false" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <template x-if="errorMessage">
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700" x-text="errorMessage"></p>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="!errorMessage && archiveData">
                    <div>
                        <template x-if="isLoading">
                            <div class="flex justify-center py-8">
                                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
                            </div>
                        </template>

                        <template x-if="!isLoading">
                            <div class="space-y-6">
                                <div>
                                    <h4 class="font-semibold text-lg mb-3 border-b pb-2 text-gray-800">Informations générales</h4>
                                    <div class="space-y-2 text-gray-700">
                                        <p><span class="font-medium">Stage:</span> <span x-text="archiveData.date_debut + ' au ' + archiveData.date_fin"></span></p>
                                        <p><span class="font-medium">Durée:</span> <span x-text="archiveData.duree"></span></p>
                                        <p><span class="font-medium">Département:</span> <span x-text="archiveData.departement"></span></p>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="font-semibold text-lg mb-3 border-b pb-2 text-gray-800">Performance</h4>
                                    <div class="space-y-2 text-gray-700">
                                        <p><span class="font-medium">Tâches réussies:</span> <span x-text="archiveData.taches_reussies + ' (' + archiveData.taux_reussite + ')'"></span></p>
                                        <p><span class="font-medium">Tâches échouées:</span> <span x-text="archiveData.taches_echouees + ' (' + archiveData.taux_echec + ')'"></span></p>
                                        <p><span class="font-medium">Progression finale:</span> <span x-text="archiveData.progression + '% (complété)'"></span></p>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="font-semibold text-lg mb-3 border-b pb-2 text-gray-800">Documents soumis</h4>
                                    <div class="space-y-3">
                                        <template x-for="document in archiveData.documents">
                                            <div class="flex items-center">
                                                <input type="checkbox" class="mr-3 h-5 w-5 text-blue-600" :checked="document.soumis" disabled>
                                                <span x-text="document.nom" class="flex-1 text-gray-700"></span>
                                                <template x-if="document.soumis">
                                                    <a :href="document.lien" class="ml-2 text-blue-600 hover:text-blue-800 hover:underline" target="_blank">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                        </svg>
                                                    </a>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
                
                <div class="mt-6 flex justify-end">
                    <button @click="archiveModalOpen = false" 
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour la recherche -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchResults = document.getElementById('search-results');
    const stagiaireIdInput = document.getElementById('stagiaire_id');
    const selectedContainer = document.getElementById('selected-stagiaire-container');
    const selectedName = document.getElementById('selected-name');
    const selectedEmail = document.getElementById('selected-email');
    const clearSelection = document.getElementById('clear-selection');
    const submitButton = document.getElementById('submit-button');
    const associateForm = document.getElementById('associate-form');

    // Empêcher la soumission du formulaire avec Enter
    associateForm.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });

    // Gestion de la recherche
    searchInput.addEventListener('input', debounce(function(e) {
        const query = e.target.value.trim();
        
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        fetch(`{{ route('superviseur.stagiaires.search') }}?q=${encodeURIComponent(query)}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'include'
        })
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau');
                return response.json();
            })
            .then(data => {
                searchResults.innerHTML = '';
                
                if (data.length === 0) {
                    const noResults = document.createElement('div');
                    noResults.className = 'p-3 text-gray-500 text-center';
                    noResults.textContent = 'Aucun stagiaire trouvé';
                    searchResults.appendChild(noResults);
                } else {
                    data.forEach(stagiaire => {
                        const resultItem = document.createElement('div');
                        resultItem.className = 'p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0';
                        resultItem.innerHTML = `
                            <div class="font-medium text-gray-800">${stagiaire.prenom} ${stagiaire.nom}</div>
                            <div class="text-sm text-gray-500">${stagiaire.email}</div>
                        `;
                        
                        resultItem.addEventListener('click', function() {
                            stagiaireIdInput.value = stagiaire.id;
                            selectedName.textContent = `${stagiaire.prenom} ${stagiaire.nom}`;
                            selectedEmail.textContent = stagiaire.email;
                            selectedContainer.classList.remove('hidden');
                            searchResults.classList.add('hidden');
                            submitButton.disabled = false;
                            searchInput.value = '';
                        });
                        
                        searchResults.appendChild(resultItem);
                    });
                }
                
                searchResults.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Erreur:', error);
                searchResults.innerHTML = '<div class="p-3 text-red-500 text-center">Erreur lors de la recherche</div>';
                searchResults.classList.remove('hidden');
            });
    }, 300));

    // Gestion de la touche Entrée
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.dispatchEvent(new Event('input'));
        }
    });

    clearSelection.addEventListener('click', function() {
        stagiaireIdInput.value = '';
        selectedContainer.classList.add('hidden');
        submitButton.disabled = true;
        searchInput.value = '';
        searchInput.focus();
    });

    // Fermer les résultats quand on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!searchResults.contains(e.target) && e.target !== searchInput) {
            searchResults.classList.add('hidden');
        }
    });

    // Fonction debounce pour limiter les requêtes
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
});
</script>
@endsection