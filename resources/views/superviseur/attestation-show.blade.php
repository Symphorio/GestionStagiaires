@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Attestation de Stage</h1>
        <p class="text-gray-500">
            L'attestation a été générée pour {{ $attestation->rapport->stagiaire->prenom }} {{ $attestation->rapport->stagiaire->nom }}.
        </p>
    </div>

    <div class="bg-white p-8 border rounded-lg my-4">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold uppercase">Attestation de Stage</h1>
        </div>
        
        <div class="text-right mb-6">
            <p>Paris, le {{ now()->format('d/m/Y') }}</p>
        </div>
        
        <div class="mb-8">
            <p class="font-semibold">Organisme d'accueil :</p>
            <p>{{ $attestation->company_name }}</p>
            {!! nl2br(e($attestation->company_address)) !!}
        </div>
        
        <div class="mb-8 text-justify">
            <p class="mb-4">
                Je soussigné(e), {{ $attestation->superviseur_name }}, agissant en qualité de Superviseur de stage, certifie que :
            </p>
            
            <p class="font-semibold text-center my-6">{{ $attestation->rapport->stagiaire->prenom }} {{ $attestation->rapport->stagiaire->nom }}</p>
            
            <p class="mb-4">
                a effectué un stage au sein de notre organisation dans le cadre de sa formation.
            </p>
            
            <p class="mb-4">Ce stage s'est déroulé du {{ $attestation->rapport->created_at->subMonths(3)->format('d/m/Y') }} au {{ $attestation->rapport->created_at->format('d/m/Y') }}.</p>
            
            <p class="mb-4">
                Au cours de ce stage, {{ $attestation->rapport->stagiaire->prenom }} a participé avec succès aux activités suivantes :
            </p>
            
            <ul class="list-disc pl-6 mb-4">
                @foreach(json_decode($attestation->activities) as $activity)
                <li>{{ $activity }}</li>
                @endforeach
            </ul>
            
            <p class="mb-4">
                {{ $attestation->rapport->stagiaire->prenom }} a fait preuve de sérieux, d'initiative et d'un excellent esprit d'équipe tout au long de son stage.
            </p>
        </div>
        
        <div class="mb-8">
            <p>Cette attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.</p>
        </div>
        
        <div class="flex justify-between items-end mt-16">
            <div>
                <p class="font-semibold">Signature et cachet :</p>
                <div class="h-20 mt-2">
                    @if($attestation->signature_path)
                    <img src="{{ Storage::url($attestation->signature_path) }}" alt="Signature" class="h-20">
                    @endif
                </div>
            </div>
            
            <div>
                <p class="font-semibold">Le superviseur</p>
                <div class="mt-2">{{ $attestation->superviseur_name }}</div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-between">
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor">
            Imprimer l'attestation
        </button>
        
        @if(!$attestation->date_envoi)
        <form action="{{ route('superviseur.rapports.send-attestation', $attestation) }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Envoyer au stagiaire
            </button>
        </form>
        @endif
    </div>
</div>
@endsection