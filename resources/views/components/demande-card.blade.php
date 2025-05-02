@props(['demande'])

<div class="border border-gray-200 rounded-lg p-6 mb-6 shadow-sm bg-white hover:shadow-md transition-shadow duration-200">
    <!-- En-tête avec nom et informations -->
    <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-100">
        <div>
            <h3 class="text-xl font-bold text-gray-800">
                {{ $demande->prenom }} {{ $demande->nom }}
                <span class="ml-2 text-sm font-normal text-gray-500">
                    {{ $demande->created_at->format('d/m/Y') }}
                </span>
            </h3>
            <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                {{ $demande->formation }}
            </span>
        </div>
    </div>

    <!-- Détails du stage -->
    <div class="mb-4">
        <div>
            <p class="text-sm font-medium text-gray-500">Période de stage</p>
            <p class="font-semibold">
                {{ $demande->date_debut->format('d/m/Y') }} - {{ $demande->date_fin->format('d/m/Y') }}
            </p>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-gray-700">{{ $demande->document_name ?? 'Document.pdf' }}</span>
        </div>
        <div class="flex space-x-2">
            <button onclick="window.open('{{ route('stage.downloadLettre', $demande->id) }}', '_blank')"
                class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir PDF
            </button>
            @if($demande->status === 'pending_dpaf')
                <form method="POST" action="{{ route('dpaf.forward', $demande->id) }}">
                    @csrf
                    <button type="submit" 
                        class="flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                        Transférer
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>