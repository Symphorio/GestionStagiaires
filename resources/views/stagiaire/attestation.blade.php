@extends('layouts.stagiaire')

@section('contenu')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Mes Attestations</h1>
    </div>

    @if($attestations->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Aucune attestation disponible</h3>
            <p class="mt-1 text-sm text-gray-500">Vos attestations apparaîtront ici une fois générées par votre superviseur.</p>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul class="divide-y divide-gray-200">
                @foreach($attestations as $attestation)
                <li>
                    <div class="px-4 py-5 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Attestation de stage - {{ $attestation->date_generation->format('d/m/Y') }}
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Entreprise: {{ $attestation->company_name }}
                                </p>
                            </div>
                            <div class="flex space-x-3">
                            @if($attestation->file_path && Storage::exists($attestation->file_path))
<a href="{{ route('stagiaire.attestations.download', $attestation) }}" 
   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
    <svg class="-ml-1 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
    </svg>
    Télécharger
</a>
@else
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
    Fichier non disponible
</span>
@endif
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Superviseur</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $attestation->superviseur_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Statut</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($attestation->statut === 'complété') bg-green-100 text-green-800
                                    @elseif($attestation->statut === 'en cours') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($attestation->statut) }}
                                </span>
                            </div>
                        </div>
                        @if($attestation->date_signature)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-500">Signée le</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $attestation->date_signature->format('d/m/Y') }}</p>
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection