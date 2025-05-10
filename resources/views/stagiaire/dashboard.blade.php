@extends('layouts.stagiaire')

@section('titre', 'Tableau de Bord')

@section('contenu')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Tableau de Bord</h1>
        <p class="text-gray-500">
            Bienvenue à votre espace stagiaire
        </p>
    </div>
    
    <!-- Cartes de synthèse -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-2">Tâches Complétées</h3>
            <p class="text-3xl font-bold text-green-500">{{ $completedTasks }}</p>
            <p class="text-gray-500 text-sm mt-2">sur {{ $totalTasks }} tâches</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-2">Tâches En Cours</h3>
            <p class="text-3xl font-bold text-amber-500">{{ $pendingTasks }}</p>
            <p class="text-gray-500 text-sm mt-2">à compléter</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-2">Tâches En Retard</h3>
            <p class="text-3xl font-bold text-red-500">{{ $lateTasks }}</p>
            <p class="text-gray-500 text-sm mt-2">nécessitent votre attention</p>
        </div>
    </div>
    
    <!-- Tâches récentes -->
<div>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-medium">Tâches Récentes</h2>
        <a href="{{ route('stagiaire.taches') }}" class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
            Voir toutes les tâches
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($recentTasks as $task)
            <div class="bg-white p-4 rounded-lg shadow border-l-4 
                @if($task->status === 'completed') border-green-500
                @elseif($task->deadline < now() && $task->status !== 'completed') border-red-500
                @else border-amber-500 @endif">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-medium text-gray-900 truncate">{{ $task->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $task->description }}</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                        @if($task->status === 'completed') bg-green-100 text-green-800
                        @elseif($task->deadline < now() && $task->status !== 'completed') bg-red-100 text-red-800
                        @else bg-amber-100 text-amber-800 @endif">
                        @if($task->status === 'completed') Terminée
                        @elseif($task->deadline < now() && $task->status !== 'completed') En échec
                        @else En cours @endif
                    </span>
                </div>
                
                <div class="mt-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Échéance: {{ $task->deadline->format('d/m/Y') }}
                    </div>
                    <div class="mt-1 flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Assignée par: {{ $task->assignedBy->nom ?? 'Superviseur' }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-4">
                <p class="text-gray-500">Aucune tâche récente</p>
            </div>
        @endforelse
    </div>
</div>
    
    <!-- Actions rapides - Version corrigée -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Carte Rapport -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col">
            <h3 class="text-lg font-medium mb-4">Soumettre un Rapport</h3>
            <p class="text-gray-500 mb-4 flex-grow">
                Soumettez votre rapport de stage pour évaluation par votre encadreur.
            </p>
            <div class="mt-auto">
                <a href="{{ route('stagiaire.rapports') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    Soumettre un Rapport
                </a>
            </div>
        </div>
        
        <!-- Carte Mémoire -->
        <div class="bg-white p-6 rounded-lg shadow flex flex-col">
            <h3 class="text-lg font-medium mb-4">Soumettre un Mémoire</h3>
            <p class="text-gray-500 mb-4 flex-grow">
                Soumettez votre mémoire de fin de stage pour évaluation finale.
            </p>
            <div class="mt-auto">
                <a href="{{ route('stagiaire.soumission-memoire') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    Soumettre un Mémoire
                </a>
            </div>
        </div>
    </div>
</div>
@endsection