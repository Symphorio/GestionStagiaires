@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
<div class="flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">{{ $rapport->titre }}</h1>
        <p class="text-gray-500">
            Par {{ $rapport->stagiaire->prenom }} {{ $rapport->stagiaire->nom }} • 
            Soumis le {{ $rapport->created_at->format('d/m/Y') }}
        </p>
    </div>
    
    @if($rapport->download_url)
        <a href="{{ $rapport->download_url }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Télécharger le rapport
        </a>
    @else
        <div class="bg-yellow-50 p-3 rounded-md">
            <p class="text-yellow-700 text-sm">
                <span class="font-medium">Fichier indisponible</span><br>
                @if(empty($rapport->file_path))
                    (Aucun fichier enregistré)
                @else
                    (Fichier introuvable: {{ basename($rapport->file_path) }})
                @endif
            </p>
        </div>
    @endif
</div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Description du rapport</h3>
            <div class="prose max-w-none">
                {!! nl2br(e($rapport->contenu)) !!}
            </div>
        </div>
        
        @if($rapport->statut === 'en attente')
<div class="px-4 py-4 bg-gray-50 sm:px-6">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-600">Veuillez approuver ou rejeter ce rapport</p>
        
        <div class="flex space-x-3">
            <!-- Bouton Approuver avec modal de confirmation -->
            <div x-data="{ openApproveModal: false }">
                <button @click="openApproveModal = true" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Approuver
                </button>

                <!-- Modal de confirmation d'approbation -->
                <div x-show="openApproveModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     x-cloak
                     class="fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                             @click="openApproveModal = false"
                             aria-hidden="true"></div>
                        
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        
                        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Confirmer l'approbation
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Vous êtes sur le point d'approuver ce rapport. Cette action va créer une attestation de stage que vous devrez compléter.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                <button type="button" 
                                        @click="openApproveModal = false" 
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                    Annuler
                                </button>
                                <form action="{{ route('superviseur.rapports.approve', $rapport) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:col-start-2 sm:text-sm">
                                        Confirmer l'approbation
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    
                    <div x-data="{ open: false }">
                        <button @click="open = true" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Rejeter
                        </button>

                        <!-- Modal de rejet -->
                        <div x-show="open" 
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             x-cloak
                             class="fixed z-10 inset-0 overflow-y-auto">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                     @click="open = false"
                                     aria-hidden="true"></div>
                                
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                
                                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                    <form action="{{ route('superviseur.rapports.reject', $rapport) }}" method="POST">
                                        @csrf
                                        <div>
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                Rejeter le rapport
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    Veuillez fournir un feedback pour expliquer le rejet du rapport.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <textarea name="feedback" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Expliquez pourquoi vous rejetez ce rapport..." required></textarea>
                                        </div>
                                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                            <button type="button" 
                                                    @click="open = false" 
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                                Annuler
                                            </button>
                                            <button type="submit" 
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                                                Confirmer le rejet
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('rapport', () => ({
            openRejectModal: false,
            
            init() {
                // Fermer le modal avec la touche ESC
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.openRejectModal = false;
                    }
                });
            }
        }));
    });
</script>
@endsection