@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Tableau de bord</h1>
        <p class="text-gray-500">
            Bienvenue dans votre espace de gestion des stagiaires.
        </p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <x-stat-card 
            title="Stagiaires" 
            value="{{ $stats['stagiaires_count'] }}" 
            description="Stagiaires sous votre supervision" 
            icon="👥"
        />
        <x-stat-card 
            title="Tâches" 
            value="{{ $stats['taches_count'] }}" 
            description="Tâches en cours" 
            icon="📋"
        />
        <x-stat-card 
            title="Rapports en attente" 
            value="{{ $stats['rapports_pending_count'] }}" 
            description="Nécessite votre validation" 
            icon="📝"
        />
        <x-stat-card 
            title="Mémoires à valider" 
            value="{{ $stats['memoires_pending_count'] }}" 
            description="Mémoires soumis pour validation" 
            icon="📚"
        />
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <x-card>
            <x-card-header>
                <x-card-title>Progression des stagiaires</x-card-title>
                <x-card-description>
                    Suivi de l'avancement global des stagiaires sous votre supervision
                </x-card-description>
            </x-card-header>
            <x-card-content class="space-y-6">
                @foreach($stagiaires as $stagiaire)
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="font-medium">{{ $stagiaire->full_name }}</div>
                            <div class="text-sm text-gray-500">{{ $stagiaire->progress }}%</div>
                        </div>
                        <x-progress value="{{ $stagiaire->progress }}" class="h-2" />
                    </div>
                @endforeach
            </x-card-content>
        </x-card>

        <x-card>
            <x-card-header>
                <x-card-title>Tâches récentes</x-card-title>
                <x-card-description>
                    Les dernières tâches assignées aux stagiaires
                </x-card-description>
            </x-card-header>
            <x-card-content>
                <ul class="space-y-2">
                    @foreach($taches as $tache)
                    <li class="border-b pb-2">
                        <div class="font-medium">{{ $tache->titre }}</div>
                        <div class="text-sm text-gray-500">Assignée à {{ $tache->stagiaire->full_name }}</div>
                    </li>
                    @endforeach
                </ul>
            </x-card-content>
        </x-card>
    </div>
</div>
@endsection