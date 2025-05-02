@extends('layouts.dpaf')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $demande->titre }}</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold mb-2">Détails de la demande</h2>
                    <p class="text-gray-700">{{ $demande->description }}</p>
                    
                    <div class="mt-4">
                        <p><span class="font-semibold">Statut:</span> {{ ucfirst(str_replace('_', ' ', $demande->status)) }}</p>
                        <p><span class="font-semibold">Date de création:</span> {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-semibold mb-2">Actions</h2>
                    <div class="flex flex-col space-y-2">
                        <form action="{{ route('dpaf.forward', $demande->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                                Transférer à SRHDS
                            </button>
                        </form>
                        <a href="{{ route('dpaf.requests.pending') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition text-center">
                            Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection