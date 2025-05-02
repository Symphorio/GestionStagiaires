@extends('layouts.srhds')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Détails de la demande</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">Informations du stagiaire</h2>
                <p><span class="font-medium">Nom:</span> {{ $demande->prenom }} {{ $demande->nom }}</p>
                <p><span class="font-medium">Email:</span> {{ $demande->email }}</p>
                <p><span class="font-medium">Téléphone:</span> {{ $demande->telephone }}</p>
                <p><span class="font-medium">Formation:</span> {{ $demande->formation }}</p>
                @if($demande->specialisation)
                    <p><span class="font-medium">Spécialisation:</span> {{ $demande->specialisation }}</p>
                @endif
            </div>
            
            <div>
                <h2 class="text-lg font-semibold mb-2">Détails du stage</h2>
                <p><span class="font-medium">Période:</span> 
                    {{ $demande->date_debut->format('d/m/Y') }} - {{ $demande->date_fin->format('d/m/Y') }}
                </p>
                <p><span class="font-medium">Statut:</span> 
                    <span class="px-2 py-1 rounded-full text-xs 
                        {{ $demande->status === 'pending_srhds' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $demande->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $demande->status)) }}
                    </span>
                </p>
                @if($demande->department)
                    <p><span class="font-medium">Département:</span> {{ $demande->department->name }}</p>
                @endif
            </div>
        </div>
        
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Lettre de motivation</h2>
            <a href="{{ route('stage.downloadLettre', $demande->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Télécharger la lettre
            </a>
        </div>
        
        @if($demande->status === 'pending_srhds')
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Assigner un département</h2>
            <form action="{{ route('srhds.assign.department', $demande->id) }}" method="POST">
                @csrf
                <div class="flex items-center space-x-2">
                    <select name="department_id" class="rounded border-gray-300">
                        <option value="">Choisir un département</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ $demande->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Assigner
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection