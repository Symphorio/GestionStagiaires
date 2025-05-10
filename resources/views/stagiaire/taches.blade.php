@extends('layouts.stagiaire')

@section('contenu')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Mes Tâches</h1>
    </div>
    
    <div class="space-y-4">
        @foreach($taches as $tache)
        <div class="bg-white shadow rounded-lg overflow-hidden border-l-4 
            @if($tache->status === 'completed') border-green-500
            @elseif($tache->deadline < now()) border-red-500
            @else border-amber-500 @endif">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $tache->title }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $tache->description }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($tache->status === 'completed') bg-green-100 text-green-800
                        @elseif($tache->deadline < now()) bg-red-100 text-red-800
                        @else bg-amber-100 text-amber-800 @endif">
                        @if($tache->status === 'completed') Terminée
                        @elseif($tache->deadline < now()) En échec
                        @else En cours @endif
                    </span>
                </div>
                
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Échéance: {{ $tache->deadline->format('d/m/Y') }}
                        </div>
                        <div class="mt-1 flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Assignée par: {{ $tache->assignedBy->nom ?? 'Superviseur' }}
                        </div>
                    </div>
                    
                    <form action="{{ route('stagiaire.taches.update-status', $tache) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                            class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-supervisor focus:border-supervisor sm:text-sm rounded-md">
                            <option value="in_progress" {{ $tache->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                            <option value="completed" {{ $tache->status === 'completed' ? 'selected' : '' }}>Terminée</option>
                        </select>
                    </form>
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