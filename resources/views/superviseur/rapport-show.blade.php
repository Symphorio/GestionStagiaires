@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">{{ $rapport->titre }}</h1>
        <p class="text-gray-500">
            Par {{ $rapport->stagiaire->prenom }} {{ $rapport->stagiaire->nom }} • 
            Soumis le {{ $rapport->created_at->format('d/m/Y') }}
        </p>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <div class="prose max-w-none">
                {!! nl2br(e($rapport->contenu)) !!}
            </div>
        </div>
        <div class="px-4 py-4 bg-gray-50 sm:px-6 flex justify-between">
            @if($rapport->statut === 'en attente')
            <div class="flex space-x-2">
                <form action="{{ route('superviseur.rapports.approve', $rapport) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Approuver
                    </button>
                </form>
                
                <button x-data="{ open: false }" @click="open = true" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Rejeter
                </button>
                
                <!-- Modal de rejet -->
                <div x-show="open" class="fixed inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        
                        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Rejeter le rapport
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Veuillez fournir un feedback pour expliquer le rejet du rapport.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <form action="{{ route('superviseur.rapports.reject', $rapport) }}" method="POST">
                                    @csrf
                                    <textarea name="feedback" rows="4" class="shadow-sm focus:ring-supervisor focus:border-supervisor block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Votre feedback..."></textarea>
                                    
                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                    <button type="button" 
                                            @click="open = false" 
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor sm:mt-0 sm:col-start-1 sm:text-sm">
                                        Annuler
                                    </button>
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                                            Confirmer le rejet
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($rapport->statut === 'approuvé' && $rapport->attestation)
            <a href="{{ route('superviseur.rapports.show-attestation', $rapport->attestation) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Voir l'attestation
            </a>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('rapport', {
            openRejectModal: false,
            
            init() {
                // Fermer le modal avec la touche ESC
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.openRejectModal = false;
                    }
                });
            }
        });
    });
</script>
@endsection