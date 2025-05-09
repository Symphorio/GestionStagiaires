@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Modifier l'attestation de Stage</h1>
        <p class="text-gray-500">
            Modifiez les informations de l'attestation avant de l'envoyer.
        </p>
    </div>

    <form action="{{ route('superviseur.rapports.update-attestation', $attestation) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6 space-y-4">
                <div>
                    <label for="superviseur_name" class="block text-sm font-medium text-gray-700">Nom du superviseur</label>
                    <input type="text" name="superviseur_name" id="superviseur_name" value="{{ old('superviseur_name', $attestation->superviseur_name) }}" class="mt-1 focus:ring-supervisor focus:border-supervisor block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $attestation->company_name) }}" class="mt-1 focus:ring-supervisor focus:border-supervisor block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="company_address" class="block text-sm font-medium text-gray-700">Adresse de l'entreprise</label>
                    <textarea name="company_address" id="company_address" rows="3" class="mt-1 focus:ring-supervisor focus:border-supervisor block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('company_address', $attestation->company_address) }}</textarea>
                </div>
                
                <div>
                    <label for="activities" class="block text-sm font-medium text-gray-700">Activités du stagiaire</label>
                    <textarea name="activities" id="activities" rows="5" class="mt-1 focus:ring-supervisor focus:border-supervisor block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('activities', implode("\n", json_decode($attestation->activities))) }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">Entrez une activité par ligne</p>
                </div>
                
                <div class="flex justify-between">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-supervisor hover:bg-supervisor-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor">
                        Enregistrer les modifications
                    </button>
                    
                    <button type="button" onclick="window.location.href='{{ route('superviseur.rapports.sign-attestation', $attestation) }}'" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor">
                        Signer l'attestation
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection