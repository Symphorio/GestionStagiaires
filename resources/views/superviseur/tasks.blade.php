@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Gestion des tâches</h1>
        <p class="text-gray-500">
            Assignez et suivez les tâches des stagiaires.
        </p>
    </div>

    <!-- Formulaire d'ajout de tâche -->
    <x-card>
        <x-card-header>
            <x-card-title>Assigner une nouvelle tâche</x-card-title>
            <x-card-description>
                Créez une nouvelle tâche à assigner à un ou plusieurs stagiaires
            </x-card-description>
        </x-card-header>
        <x-card-content class="space-y-4">
            <form action="{{ route('superviseur.tasks.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="space-y-2">
                        <x-label for="title">Titre de la tâche</x-label>
                        <x-input 
                            id="title" 
                            name="title"
                            placeholder="Entrez le titre de la tâche" 
                        />
                    </div>
                    <div class="space-y-2">
                        <x-label for="description">Description</x-label>
                        <textarea
                            id="description" 
                            name="description"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-supervisor focus:ring focus:ring-supervisor focus:ring-opacity-50"
                            placeholder="Décrivez la tâche en détail" 
                            rows="3"
                        ></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-label for="stagiaires-select">Stagiaire(s) assigné(s)</x-label>
                            <div class="relative">
                                <!-- Bouton déclencheur -->
                                <button
                                    type="button"
                                    id="stagiaires-trigger"
                                    class="w-full flex justify-between items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-left shadow-sm focus:border-supervisor focus:outline-none focus:ring-1 focus:ring-supervisor sm:text-sm"
                                    onclick="toggleStagiairesList()"
                                >
                                    <span id="selected-stagiaires-text">
                                        @if(old('all_stagiaires', false))
                                            Tous les stagiaires
                                        @elseif(count(old('stagiaires', [])) > 0)
                                            {{ count(old('stagiaires', [])) }} stagiaire(s) sélectionné(s)
                                        @else
                                            Sélectionner un ou plusieurs stagiaires
                                        @endif
                                    </span>
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <!-- Liste déroulante -->
                                <div 
                                    id="stagiaires-list"
                                    class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm hidden"
                                    style="max-height: 16rem;"
                                >
                                    <!-- Option "Tous les stagiaires" -->
                                    <div class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            id="select-all-stagiaires"
                                            name="all_stagiaires"
                                            value="1"
                                            class="h-4 w-4 rounded border-gray-300 text-supervisor focus:ring-supervisor"
                                            @if(old('all_stagiaires', false)) checked @endif
                                            onclick="toggleAllStagiaires(this)"
                                        >
                                        <label for="select-all-stagiaires" class="ml-2 text-gray-700">
                                            Tous les stagiaires
                                        </label>
                                    </div>
                                    
                                    <div class="border-t border-gray-200 my-1"></div>
                                    
                                    <!-- Liste des stagiaires individuels -->
                                    <div id="stagiaires-options" class="overflow-y-auto" style="max-height: 12rem;">
                                        @foreach($stagiaires as $stagiaire)
                                            <div class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                                <input 
                                                    type="checkbox" 
                                                    id="stagiaire-{{ $stagiaire->id }}"
                                                    name="stagiaires[]"
                                                    value="{{ $stagiaire->id }}"
                                                    class="h-4 w-4 rounded border-gray-300 text-supervisor focus:ring-supervisor individual-checkbox"
                                                    @if(in_array($stagiaire->id, old('stagiaires', []))) checked @endif
                                                    onclick="updateSelection()"
                                                >
                                                <label for="stagiaire-{{ $stagiaire->id }}" class="ml-2 text-gray-700">
                                                    {{ $stagiaire->prenom }} {{ $stagiaire->nom }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <x-label for="deadline">Date d'échéance</x-label>
                            <x-input 
                                id="deadline" 
                                name="deadline"
                                type="date" 
                            />
                        </div>
                    </div>
                </div>
                <x-card-footer class="mt-4">
                    <x-button type="submit" class="bg-supervisor hover:bg-supervisor-light">
                        Assigner la tâche
                    </x-button>
                </x-card-footer>
            </form>
        </x-card-content>
    </x-card>

    <!-- Liste des tâches -->
    <div>
        <h2 class="text-xl font-semibold mb-4">Tâches en cours</h2>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($tasks as $task)
                <x-card class="overflow-hidden">
                    <x-card-header class="pb-3">
                        <div class="flex justify-between items-start">
                            <x-card-title class="text-lg">{{ $task->title }}</x-card-title>
                            <span class="px-2 py-1 rounded-full text-xs {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $task->status_text }}
                            </span>
                        </div>
                        <x-card-description class="text-sm text-gray-500">
                            Assignée à: {{ $task->stagiaire->prenom }} {{ $task->stagiaire->nom }}
                        </x-card-description>
                    </x-card-header>
                    <x-card-content class="pb-4">
                        <p class="text-sm mb-2">{{ $task->description }}</p>
                        <p class="text-xs text-gray-500">Échéance: {{ $task->deadline->format('d/m/Y') }}</p>
                    </x-card-content>
                    <x-card-footer class="border-t pt-3 flex justify-between">
                        <a href="{{ route('superviseur.tasks.edit', $task) }}" 
                           class="text-blue-500 hover:text-blue-700 hover:bg-blue-50 px-2 py-1 rounded text-sm">
                           Modifier
                        </a>
                        <form action="{{ route('superviseur.tasks.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit"
                                class="text-red-500 hover:text-red-700 hover:bg-red-50 px-2 py-1 rounded text-sm"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')"
                            >
                                Supprimer
                            </button>
                        </form>
                    </x-card-footer>
                </x-card>
            @endforeach
        </div>
    </div>
</div>

<script>
    // Basculer l'affichage de la liste des stagiaires
    function toggleStagiairesList() {
        const list = document.getElementById('stagiaires-list');
        list.classList.toggle('hidden');
    }

    // Fermer la liste quand on clique ailleurs
    document.addEventListener('click', function(event) {
        const trigger = document.getElementById('stagiaires-trigger');
        const list = document.getElementById('stagiaires-list');
        
        if (!trigger.contains(event.target) && !list.contains(event.target)) {
            list.classList.add('hidden');
        }
    });

    // Sélectionner/désélectionner tous les stagiaires
    function toggleAllStagiaires(checkbox) {
        const allChecked = checkbox.checked;
        const individualCheckboxes = document.querySelectorAll('.individual-checkbox');
        
        individualCheckboxes.forEach(cb => {
            cb.checked = false;
            cb.disabled = allChecked;
        });
        
        updateSelectionText();
    }

    // Mettre à jour la sélection quand on clique sur une case individuelle
    function updateSelection() {
        const selectAllCheckbox = document.getElementById('select-all-stagiaires');
        selectAllCheckbox.checked = false;
        updateSelectionText();
    }

    // Mettre à jour le texte affiché dans le bouton
    function updateSelectionText() {
        const selectAllCheckbox = document.getElementById('select-all-stagiaires');
        const individualCheckboxes = document.querySelectorAll('.individual-checkbox');
        const selectedText = document.getElementById('selected-stagiaires-text');
        
        if (selectAllCheckbox.checked) {
            selectedText.textContent = 'Tous les stagiaires';
            return;
        }
        
        const checkedCount = Array.from(individualCheckboxes).filter(cb => cb.checked).length;
        
        if (checkedCount === 0) {
            selectedText.textContent = 'Sélectionner un ou plusieurs stagiaires';
        } else if (checkedCount === 1) {
            const checked = Array.from(individualCheckboxes).find(cb => cb.checked);
            const label = document.querySelector(`label[for="${checked.id}"]`).textContent;
            selectedText.textContent = label;
        } else {
            selectedText.textContent = `${checkedCount} stagiaire(s) sélectionné(s)`;
        }
    }

    // Initialiser le texte au chargement
    document.addEventListener('DOMContentLoaded', function() {
        updateSelectionText();
    });
</script>
@endsection