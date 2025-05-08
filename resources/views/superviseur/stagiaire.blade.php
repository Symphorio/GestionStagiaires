@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Gestion des stagiaires</h1>
        <p class="text-gray-500">
            Ajoutez et gérez les stagiaires sous votre supervision.
        </p>
    </div>

    <!-- Formulaire d'ajout -->
    <x-card>
        <x-card-header>
            <x-card-title>Associer un stagiaire existant</x-card-title>
            <x-card-description>
                Sélectionnez un stagiaire à ajouter à votre supervision
            </x-card-description>
        </x-card-header>
        <x-card-content class="space-y-4">
            <form action="{{ route('superviseur.stagiaires.store') }}" method="POST">
                @csrf
                <div class="space-y-2">
                    <x-label for="stagiaire_id">Stagiaire disponible</x-label>
                    <select id="stagiaire_id" name="stagiaire_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-supervisor focus:ring focus:ring-supervisor focus:ring-opacity-50" required>
                        <option value="">Sélectionnez un stagiaire...</option>
                        @foreach($availableStagiaires as $stagiaire)
                            <option value="{{ $stagiaire->id }}">
                                {{ $stagiaire->prenom }} {{ $stagiaire->nom }} ({{ $stagiaire->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-card-footer class="mt-4">
                    <x-button type="submit" class="bg-supervisor hover:bg-supervisor-light">
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
                            
                            <form action="{{ route('superviseur.stagiaires.destroy', $stagiaire) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-button variant="destructive" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </x-button>
                            </form>
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
                            <form action="{{ route('superviseur.stagiaires.destroy', $stagiaire) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-button variant="destructive" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </x-button>
                            </form>
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

<!-- Modal de confirmation de suppression -->
<div x-data="{ showDeleteModal: false, stagiaireToDelete: null }">
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmer la suppression</h3>
                <p class="mb-4">Êtes-vous sûr de vouloir supprimer définitivement ce stagiaire ?</p>
                <div class="mt-5 sm:mt-6 flex justify-between">
                    <button @click="showDeleteModal = false" type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor sm:text-sm">
                        Annuler
                    </button>
                    <form :action="'{{ url('superviseur/stagiaires') }}/' + stagiaireToDelete" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(stagiaireId) {
        window.dispatchEvent(new CustomEvent('delete-modal', { 
            detail: { 
                show: true,
                stagiaireId: stagiaireId
            }
        }));
    }
</script>
@endsection