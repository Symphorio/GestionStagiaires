@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Validation des rapports</h1>
        <p class="text-gray-500">
            Examinez et validez les rapports soumis par les stagiaires.
        </p>
    </div>

    @if($rapports->isEmpty())
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <p class="text-gray-500">Aucun rapport à valider pour le moment.</p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($rapports as $rapport)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-medium text-gray-900">{{ $rapport->titre }}</h3>
                        {!! $rapport->status_badge !!}
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Par {{ $rapport->stagiaire->prenom }} {{ $rapport->stagiaire->nom }} • 
                        Soumis le {{ $rapport->created_at->format('d/m/Y') }}
                    </p>
                    <p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ Str::limit($rapport->contenu, 150) }}</p>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6 flex justify-between items-center">
                    <a href="{{ route('superviseur.rapports.show', $rapport) }}" 
                       class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Voir le rapport
                    </a>
                    <span class="text-sm text-gray-500">
                        {{ $rapport->statut === 'en attente' ? 'En attente' : ($rapport->statut === 'approuvé' ? 'Validé' : 'Rejeté') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection