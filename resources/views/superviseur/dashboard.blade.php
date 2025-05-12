@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold">Tableau de bord</h1>
        <p class="text-gray-500">Bienvenue dans votre espace de gestion des stagiaires.</p>
    </div>

    <!-- Cartes statistiques -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-medium text-gray-500">Stagiaires</h3>
            <p class="text-3xl font-bold">{{ $stats['stagiaires_count'] }}</p>
            <p class="text-sm text-gray-500">Stagiaires sous votre supervision</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-medium text-gray-500">Tâches</h3>
            <p class="text-3xl font-bold">{{ $stats['taches_count'] }}</p>
            <p class="text-sm text-gray-500">Tâches en cours</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-medium text-gray-500">Rapports en attente</h3>
            <p class="text-3xl font-bold">{{ $stats['rapports_pending_count'] }}</p>
            <p class="text-sm text-gray-500">Nécessite votre validation</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-medium text-gray-500">Mémoires à valider</h3>
            <p class="text-3xl font-bold">{{ $stats['memoires_pending_count'] }}</p>
            <p class="text-sm text-gray-500">Mémoires soumis pour validation</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <!-- Section Progression des stagiaires -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-2">Progression des stagiaires</h2>
            <p class="text-gray-500 mb-4">Suivi de l'avancement global des stagiaires sous votre supervision</p>
            
            <div class="space-y-4">
                @foreach($stagiaires as $stagiaire)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="font-medium">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</span>
                        <span class="text-gray-500">{{ number_format($stagiaire->progress, 2) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stagiaire->progress }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $stagiaire->email }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Section Tâches récentes -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-2">Tâches récentes</h2>
    <p class="text-gray-500 mb-4">Les dernières tâches assignées aux stagiaires</p>
    
    <div class="space-y-3">
        @forelse($taches as $tache)
        <div class="border-b pb-3 last:border-b-0 last:pb-0">
            @if(!empty($tache->title))
                <p class="font-medium">{{ $tache->title }}</p>
                <p class="text-sm text-gray-500">Assignée à {{ $tache->stagiaire->prenom }} {{ $tache->stagiaire->nom }}</p>
            @else
                <p class="text-sm text-yellow-600">Tâche sans titre</p>
                <p class="text-sm text-gray-500">Assignée à {{ $tache->stagiaire->prenom }} {{ $tache->stagiaire->nom }}</p>
            @endif
        </div>
        @empty
        <p class="text-gray-500">Aucune tâche récente</p>
        @endforelse
    </div>
</div>
    </div>
</div>
@endsection