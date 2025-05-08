@extends('layouts.stagiaire')

@section('contenu')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Mes Tâches</h1>
    </div>
    
    <div class="space-y-6">
        @foreach($taches as $tache)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $tache->title }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $tache->description }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($tache->status === 'completed') bg-green-100 text-green-800
                        @elseif($tache->status === 'late') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $tache->status_text }}
                    </span>
                </div>
                
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">Assignée par:</span> {{ $tache->assignedBy->name ?? 'Superviseur' }}
                        <span class="mx-2">•</span>
                        <span class="font-medium">Échéance:</span> {{ $tache->deadline->format('d/m/Y') }}
                    </div>
                    
                    <form action="{{ route('stagiaire.taches.update-status', $tache) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                            class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-supervisor focus:border-supervisor sm:text-sm rounded-md">
                            @foreach(App\Models\Tache::STATUSES as $value => $label)
                                <option value="{{ $value }}" {{ $tache->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
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