@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Gestion des stagiaires</h1>
        <p class="text-gray-500">
            Ajoutez et gérez les stagiaires sous votre supervision.
        </p>
    </div>

    <!-- Formulaire d'ajout avec recherche -->
    <x-card>
    <x-card-header>
        <x-card-title>Associer un stagiaire</x-card-title>
        <x-card-description>
            Recherchez et sélectionnez un stagiaire à ajouter à votre supervision
        </x-card-description>
    </x-card-header>
    <x-card-content class="space-y-4">
        <form action="{{ route('superviseur.stagiaires.store') }}" method="POST" id="associate-form">
            @csrf
            <div class="space-y-4">
                <div class="relative">
                    <x-label for="search">Rechercher un stagiaire</x-label>
                    <input type="text" id="search" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-supervisor focus:ring focus:ring-supervisor focus:ring-opacity-50" 
                           placeholder="Tapez le nom ou l'email du stagiaire..."
                           autocomplete="off">
                    <div id="search-results" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
                </div>

                <div id="selected-stagiaire-container" class="hidden">
                    <input type="hidden" id="stagiaire_id" name="stagiaire_id" required>
                    <div id="selected-stagiaire" class="mt-2 p-3 bg-gray-50 rounded-md border border-gray-200 flex justify-between items-center">
                        <div>
                            <span id="selected-name" class="font-medium"></span>
                            <span id="selected-email" class="text-sm text-gray-500 ml-2"></span>
                        </div>
                        <button type="button" id="clear-selection" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <x-card-footer class="mt-4">
                <x-button type="submit" class="bg-supervisor hover:bg-supervisor-light" id="submit-button" disabled>
                    Associer le stagiaire
                </x-button>
            </x-card-footer>
        </form>
    </x-card-content>
</x-card>

    <!-- Onglets -->
    <div x-data="{ activeTab: 'active' }">
        <!-- Barre d'onglets -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'active'" 
                        :class="activeTab === 'active' ? 'border-supervisor text-supervisor' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Stagiaires actifs ({{ $activeStagiaires->count() }})
                </button>
                
                <button @click="activeTab = 'completed'" 
                        :class="activeTab === 'completed' ? 'border-supervisor text-supervisor' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Stages terminés ({{ $completedStagiaires->count() }})
                </button>
            </nav>
        </div>

        <!-- Contenu des onglets -->
        <div x-show="activeTab === 'active'" x-transition class="space-y-4">
            @foreach($activeStagiaires as $stagiaire)
                <x-card>
                    <x-card-content class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <x-avatar>
                                    <x-avatar-fallback class="bg-supervisor text-white">
                                        {{ substr($stagiaire->prenom, 0, 1) }}{{ substr($stagiaire->nom, 0, 1) }}
                                    </x-avatar-fallback>
                                </x-avatar>
                                <div>
                                    <h3 class="font-medium">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h3>
                                    <p class="text-sm text-gray-500">{{ $stagiaire->email }}</p>
                                    <div class="mt-2">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium mr-2">Progression:</span>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-supervisor h-2.5 rounded-full" 
                                                     style="width: {{ $stagiaire->progress }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium ml-2">{{ number_format($stagiaire->progress, 2) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex space-x-2">
                                <form action="{{ route('superviseur.stagiaires.dissociate', $stagiaire) }}" method="POST">
                                    @csrf
                                    <x-button type="submit" variant="secondary">
                                        Dissocier
                                    </x-button>
                                </form>
                                <a href="{{ route('superviseur.stagiaires.details', $stagiaire) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Détails
                                </a>
                                <form action="{{ route('superviseur.stagiaires.destroy', $stagiaire) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="destructive" type="submit">
                                        Supprimer
                                    </x-button>
                                </form>
                            </div>
                        </div>
                    </x-card-content>
                </x-card>
            @endforeach
            
            @if($activeStagiaires->isEmpty())
                <p class="text-gray-500">Aucun stagiaire actif pour le moment.</p>
            @endif
        </div>

        <div x-show="activeTab === 'completed'" x-transition class="space-y-4">
            @foreach($completedStagiaires as $stagiaire)
                <x-card>
                    <x-card-content class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <x-avatar>
                                    <x-avatar-fallback class="bg-gray-400 text-white">
                                        {{ substr($stagiaire->prenom, 0, 1) }}{{ substr($stagiaire->nom, 0, 1) }}
                                    </x-avatar-fallback>
                                </x-avatar>
                                <div>
                                    <h3 class="font-medium">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h3>
                                    <p class="text-sm text-gray-500">{{ $stagiaire->email }}</p>
                                    <div class="mt-2">
                                        <span class="text-sm font-medium">Progression finale: {{ number_format($stagiaire->progress, 2) }}%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('superviseur.stagiaires.details', $stagiaire) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Détails
                                </a>
                                <form action="{{ route('superviseur.stagiaires.destroy', $stagiaire) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="destructive" type="submit">
                                        Supprimer
                                    </x-button>
                                </form>
                            </div>
                        </div>
                    </x-card-content>
                </x-card>
            @endforeach
            
            @if($completedStagiaires->isEmpty())
                <p class="text-gray-500">Aucun stage terminé pour le moment.</p>
            @endif
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
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        fetch(`{{ route('superviseur.stagiaires.search') }}?q=${encodeURIComponent(query)}`)
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
                            <div class="font-medium">${stagiaire.prenom} ${stagiaire.nom}</div>
                            <div class="text-sm text-gray-500">${stagiaire.email}</div>
                        `;
                        
                        resultItem.addEventListener('click', function() {
                            stagiaireIdInput.value = stagiaire.id;
                            selectedName.textContent = `${stagiaire.prenom} ${stagiaire.nom}`;
                            selectedEmail.textContent = stagiaire.email;
                            selectedContainer.classList.remove('hidden');
                            searchResults.classList.add('hidden');
                            submitButton.disabled = false;
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
    });

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
});
</script>
@endsection