@extends('layouts.srhds')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Assigner des départements</h1>
    
    @if($demandes->count() > 0)
        <div class="space-y-4">
            @foreach($demandes as $demande)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-medium text-lg">{{ $demande->prenom }} {{ $demande->nom }}</h3>
                        <p class="text-gray-600">{{ $demande->formation }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $demande->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('srhds.request.show', $demande->id) }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Voir
                        </a>
                        <form action="{{ route('srhds.assign.department', $demande->id) }}" method="POST">
                            @csrf
                            <select name="department_id" class="rounded border-gray-300 mr-2" required>
                                <option value="">Choisir un département</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Assigner et transférer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <p class="text-gray-500">Aucune demande à assigner</p>
        </div>
    @endif
</div>
@endsection