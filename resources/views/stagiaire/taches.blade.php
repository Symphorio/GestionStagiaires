@extends('layouts.stagiaire')

@section('contenu')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Mes Tâches</h1>
        <div class="text-sm text-gray-500">
            {{ $taches->count() }} tâche(s) au total
        </div>
    </div>
    
    <div class="space-y-4">
        @foreach($taches as $tache)
        <div class="bg-white shadow rounded-lg overflow-hidden border-l-4 
            @if($tache->isCompleted()) border-green-500
            @elseif($tache->isFailed()) border-red-500
            @elseif($tache->status === 'in_progress') border-blue-500
            @else border-gray-500 @endif">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 truncate">{{ $tache->title }}</h3>
                        <p class="mt-1 text-sm text-gray-500 whitespace-pre-line">{{ $tache->description }}</p>
                    </div>
                    <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tache->status_class }}">
                        {{ $tache->status_text }}
                    </span>
                </div>
                
                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-500 space-y-2 sm:space-y-0 sm:space-x-4">
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Échéance: {{ $tache->deadline->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Assignée par: {{ $tache->assignedBy->nom ?? 'Superviseur' }}
                        </div>
                    </div>
                    
                   @if(!$tache->isCompleted() && !$tache->isFailed())
    <form action="{{ route('stagiaire.taches.update-status', $tache) }}" method="POST" class="mt-3 sm:mt-0">
        @csrf
        @method('PATCH')
        <select name="status" onchange="this.form.submit()" 
            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-supervisor focus:border-supervisor sm:text-sm rounded-md">
            @if($tache->status === 'pending')
                <option value="" selected disabled>Changer l'état</option>
                <option value="in_progress">Commencer la tâche</option>
            @else
                <option value="" selected disabled>Changer l'état</option>
                <option value="in_progress" {{ $tache->status === 'in_progress' ? 'selected disabled' : '' }}>En cours</option>
                <option value="completed">Terminer la tâche</option>
            @endif
        </select>
    </form>
@elseif($tache->isFailed())
    <div class="mt-3 sm:mt-0 text-sm text-red-600 flex items-center">
        <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        Échouée (échéance dépassée)
    </div>
@else
    <div class="mt-3 sm:mt-0 text-sm text-green-600 flex items-center">
        <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        Terminée le {{ $tache->updated_at->format('d/m/Y') }}
    </div>
@endif
                </div>
            </div>
        </div>
        @endforeach

        @if($taches->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune tâche assignée</h3>
            <p class="mt-1 text-sm text-gray-500">Votre superviseur ne vous a encore assigné aucune tâche.</p>
        </div>
        @endif
    </div>
</div>
@endsection