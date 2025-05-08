@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Modifier la tâche</h1>
    </div>

    <x-card>
        <x-card-header>
            <x-card-title>Modifier la tâche</x-card-title>
        </x-card-header>
        
        <x-card-content class="space-y-4">
            <form action="{{ route('superviseur.tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <x-label for="title">Titre</x-label>
                        <x-input 
                            id="title" 
                            name="title"
                            value="{{ old('title', $task->title) }}" 
                            placeholder="Titre de la tâche" 
                        />
                    </div>
                    
                    <div class="space-y-2">
                        <x-label for="description">Description</x-label>
                        <textarea
                            id="description" 
                            name="description"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-supervisor focus:ring focus:ring-supervisor focus:ring-opacity-50"
                            rows="3"
                        >{{ old('description', $task->description) }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-label for="stagiaire_id">Stagiaire</x-label>
                            <select
                                id="stagiaire_id"
                                name="stagiaire_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-supervisor focus:ring focus:ring-supervisor focus:ring-opacity-50"
                            >
                                @foreach($stagiaires as $stagiaire)
                                    <option value="{{ $stagiaire->id }}" 
                                        {{ $task->stagiaire_id == $stagiaire->id ? 'selected' : '' }}>
                                        {{ $stagiaire->prenom }} {{ $stagiaire->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <x-label for="deadline">Date d'échéance</x-label>
                            <x-input 
                                id="deadline" 
                                name="deadline"
                                type="date" 
                                value="{{ old('deadline', $task->deadline->format('Y-m-d')) }}"
                            />
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <x-label for="status">Statut</x-label>
                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-supervisor focus:ring focus:ring-supervisor focus:ring-opacity-50"
                        >
                            @foreach(App\Models\Tache::STATUSES as $value => $label)
                                <option value="{{ $value }}" 
                                    {{ $task->status == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <x-card-footer class="mt-4 flex justify-between">
                    <x-button type="button" onclick="window.history.back()" class="bg-gray-500 hover:bg-gray-600">
                        Annuler
                    </x-button>
                    <x-button type="submit" class="bg-supervisor hover:bg-supervisor-light">
                        Enregistrer
                    </x-button>
                </x-card-footer>
            </form>
        </x-card-content>
    </x-card>
</div>
@endsection