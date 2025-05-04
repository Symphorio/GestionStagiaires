@extends('layouts.dpaf')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Autoriser des demandes</h1>

    {{-- Notifications --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">Succès !</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            
            @if(session('intern_code'))
                <div class="mt-2 p-2 bg-green-50 rounded">
                    <p class="font-semibold">Informations pour le stagiaire :</p>
                    <p>Email : {{ session('email') }}</p>
                    <p>Code d'inscription : <span class="font-bold text-lg">{{ session('intern_code') }}</span></p>
                </div>
            @endif
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">Erreur !</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if($demandes->count() > 0)
        <div class="space-y-4">
            @foreach($demandes as $demande)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 border-b flex justify-between items-center">
                        <h3 class="text-lg font-medium">{{ $demande->prenom }} {{ $demande->nom }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            En attente d'autorisation
                        </span>
                    </div>
                    
                    <div class="p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-semibold">Email:</span> {{ $demande->email }}
                            </div>
                            <div>
                                <span class="font-semibold">Téléphone:</span> {{ $demande->telephone }}
                            </div>
                            <div>
                                <span class="font-semibold">Formation:</span> {{ $demande->formation }}
                            </div>
                            <div>
                                <span class="font-semibold">Spécialisation:</span> {{ $demande->specialisation ?? 'N/A' }}
                            </div>
                            <div class="col-span-2">
                                <span class="font-semibold">Département:</span> 
                                {{ $demande->department->name ?? 'Non spécifié' }}
                            </div>
                        </div>
                        
                        @if($demande->lettre_motivation_path)
                        <div>
                            <a href="{{ route('stage.downloadLettre', $demande->id) }}" 
                               class="text-blue-500 hover:text-blue-700 text-sm">
                                Télécharger la lettre de motivation
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <div class="px-4 py-3 bg-gray-50 border-t flex justify-end space-x-2">
                        <a href="{{ route('dpaf.demandes.signature', $demande->id) }}" 
                           class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Signer et Autoriser
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-700">Aucune demande à autoriser</h2>
            <p class="text-gray-500 mt-2">
                @if($hasPendingWithoutDepartment)
                    Il y a des demandes en attente mais aucun département n'a été assigné.
                @else
                    Il n'y a aucune demande en attente d'autorisation.
                @endif
            </p>
        </div>
    @endif
</div>
@endsection