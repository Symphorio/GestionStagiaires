@extends('layouts.stagiaire')

@section('contenu')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Mes Tâches</h1>
        <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Filtrer
            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </button>
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
                        <span class="font-medium">Assignée par:</span> {{ $tache->assigned_by }}
                        <span class="mx-2">•</span>
                        <span class="font-medium">Échéance:</span> {{ $tache->deadline }}
                    </div>
                    
                    <form action="{{ route('taches.update-status', $tache) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                            class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            @foreach(App\Models\Tache::STATUSES as $value => $label)
                                <option value="{{ $value }}" {{ $tache->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection