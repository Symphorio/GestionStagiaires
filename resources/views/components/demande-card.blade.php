@props(['demande'])

<div class="border rounded-lg p-4 mb-4 last:mb-0">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="font-medium">{{ $demande->stagiaire->nom ?? 'Nom stagiaire' }}</h3>
            <p class="text-sm text-gray-500">{{ $demande->departement ?? 'Département' }}</p>
            <p class="text-sm text-gray-500">{{ $demande->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <span class="px-2 py-1 text-xs rounded-full
            {{ $demande->status === 'pending_dpaf' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
            {{ str_replace('_', ' ', $demande->status) }}
        </span>
    </div>

    <div class="mt-4 flex space-x-2">
        <button onclick="window.open('{{ route('demandes.pdf', $demande->id) }}', '_blank')"
            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Voir PDF
        </button>

        @if($demande->status === 'pending_dpaf')
            <form method="POST" action="{{ route('dpaf.forward', $demande->id) }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Transférer à SRHDS
                </button>
            </form>
        @endif
    </div>
</div>