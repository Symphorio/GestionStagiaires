@extends('layouts.sg')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Nouvelles demandes</h1>
    
    @if($requests->count() > 0)
        <div class="space-y-4">
            @foreach($requests as $request)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-lg font-semibold">{{ $request->prenom }} {{ $request->nom }}</h2>
                            <p class="text-gray-600 text-sm mt-1">
                                {{ $request->created_at->format('d/m/Y H:i') }} | {{ $request->formation }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            En attente SG
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 mb-4">
                        <div>
                            <span class="font-medium">Période:</span> 
                            {{ $request->date_debut->format('d/m/Y') }} - {{ $request->date_fin->format('d/m/Y') }}
                        </div>
                        <div>
                            <span class="font-medium">Email:</span> {{ $request->email }}
                        </div>
                        @if($request->telephone)
                            <div>
                                <span class="font-medium">Téléphone:</span> {{ $request->telephone }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-end">
                        <form action="{{ route('sg.requests.forward', $request->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors flex items-center">
                                Transférer à DPAF
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-700">Aucune nouvelle demande</h2>
            <p class="text-gray-500 mt-2">Toutes les demandes ont été traitées.</p>
        </div>
    @endif
</div>
@endsection