@extends('layouts.superviseur')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-start mb-6">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="h-16 w-16 rounded-full bg-supervisor text-white flex items-center justify-center text-2xl font-bold">
                    {{ substr($stagiaire->prenom, 0, 1) }}{{ substr($stagiaire->nom, 0, 1) }}
                </div>
            </div>
            <div>
                <h1 class="text-2xl font-bold">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h1>
                <p class="text-gray-600">{{ $stagiaire->email }}</p>
            </div>
        </div>
        <a href="{{ route('superviseur.stagiaires') }}" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Informations personnelles</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Nom:</span> {{ $stagiaire->nom }}</p>
                    <p><span class="font-medium">Prénom:</span> {{ $stagiaire->prenom }}</p>
                    <p><span class="font-medium">Email:</span> {{ $stagiaire->email }}</p>
                    <p><span class="font-medium">Département:</span> {{ $stagiaire->demandeStage->specialisation ?? 'Non spécifié' }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Détails du stage</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Date de début:</span> {{ $stagiaire->demandeStage->date_debut->format('d/m/Y') }}</p>
                    <p><span class="font-medium">Date de fin:</span> {{ $stagiaire->demandeStage->date_fin->format('d/m/Y') }}</p>
                    <p><span class="font-medium">Durée restante:</span> 
                        {{ now()->diffInDays(Carbon\Carbon::parse($stagiaire->demandeStage->date_fin)) }} jours
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Progression du stage</h2>
    <div class="w-full bg-gray-200 rounded-full h-4">
        <div class="bg-supervisor h-4 rounded-full"
             style="width: {{ $progress }}%"></div>
    </div>
    <p class="mt-2 text-right">{{ number_format($progress, 2) }}% complété</p>
</div>
</div>
@endsection