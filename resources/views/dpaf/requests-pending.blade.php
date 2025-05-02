@extends('layouts.dpaf')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Demandes à traiter</h1>
        
        @if($demandes->count() > 0)
            <div class="space-y-4">
                @foreach($demandes as $demande)
                    @include('components.demande-card', [
                        'demande' => $demande,
                        'forwardLabel' => 'Transférer à SRHDS'
                    ])
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <h2 class="text-xl font-semibold text-gray-700">Aucune demande en attente</h2>
                <p class="text-gray-500 mt-2">Toutes les demandes ont été traitées.</p>
            </div>
        @endif
    </div>
@endsection