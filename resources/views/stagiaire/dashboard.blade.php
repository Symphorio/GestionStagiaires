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
        
        <div class="space-y-4">
            @foreach($recentTasks as $task)
                @include('partials.task-item', ['task' => $task])
            @endforeach
        </div>
    </div>
    
    <!-- Actions rapides -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Soumettre un Rapport</h3>
            <p class="text-gray-500 mb-4">
                Soumettez votre rapport de stage pour évaluation par votre encadreur.
            </p>
            <a href="{{ route('stagiaire.rapports') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                <i data-lucide="file-text" class="h-4 w-4 mr-2"></i>
                Soumettre un Rapport
            </a>
        </div>
    </div>
</div>
@endsection