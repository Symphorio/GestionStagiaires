@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Validation des mémoires</h1>
        <p class="text-gray-500">
            Examinez et validez les mémoires soumis par vos stagiaires.
        </p>
    </div>

    @if($memoires->isEmpty())
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <p class="text-gray-500">Aucun mémoire à valider pour le moment.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($memoires as $memoire)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $memoire->title }}</h3>
                            <p class="text-gray-500 mt-1">
                                Par {{ $memoire->stagiaire->prenom }} {{ $memoire->stagiaire->nom }} • 
                                Domaine: {{ $memoire->field }}
                            </p>
                        </div>
                        <span @class([
                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                            'bg-yellow-100 text-yellow-800' => $memoire->status === 'pending',
                            'bg-green-100 text-green-800' => $memoire->status === 'approved',
                            'bg-red-100 text-red-800' => $memoire->status === 'rejected',
                            'bg-orange-100 text-orange-800' => $memoire->status === 'revision',
                        ])>
                            @switch($memoire->status)
                                @case('pending') En attente @break
                                @case('approved') Approuvé @break
                                @case('rejected') Rejeté @break
                                @case('revision') Révision demandée @break
                            @endswitch
                        </span>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="text-sm">
                        <strong>Soumis le:</strong> {{ $memoire->submit_date->format('d/m/Y') }}
                    </div>
                    <div class="mt-2">
                        <strong>Résumé:</strong>
                        <p class="mt-1 text-sm text-gray-600">{{ $memoire->summary }}</p>
                    </div>
                    @if($memoire->feedback)
                    <div class="mt-2">
                        <strong>Feedback:</strong>
                        <p class="mt-1 text-sm text-gray-600">{{ $memoire->feedback }}</p>
                    </div>
                    @endif
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                    <a href="{{ route('superviseur.memoires.download', $memoire) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Télécharger le mémoire
                    </a>
                    
                    @if($memoire->status === 'pending')
                    <div class="flex space-x-2" x-data="{ 
                        openApproval: false,
                        openRevision: false, 
                        openRejection: false,
                        feedback: ''
                    }">
                        <!-- Approbation -->
                        <button @click="openApproval = true" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Approuver
                        </button>
                        
                        <!-- Demande de révision -->
                        <button @click="openRevision = true" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Demander une révision
                        </button>
                        
                        <!-- Rejet -->
                        <button @click="openRejection = true" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Rejeter
                        </button>
                        
                        <!-- Modals -->
                        <!-- Modal Approbation -->
                        <div x-show="openApproval" x-transition class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="openApproval = false"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                    <div>
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Confirmer l'approbation
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Êtes-vous sûr de vouloir approuver ce mémoire ? Cette action est irréversible.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                        <form method="POST" action="{{ route('superviseur.memoires.action', $memoire) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="approved">
                                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:col-start-2 sm:text-sm">
                                                Confirmer
                                            </button>
                                        </form>
                                        <button @click="openApproval = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Révision -->
                        <div x-show="openRevision" x-transition class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="openRevision = false"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                    <div>
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Demander une révision
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Veuillez fournir des commentaires détaillés pour aider le stagiaire à améliorer son mémoire.
                                            </p>
                                            <form method="POST" action="{{ route('superviseur.memoires.action', $memoire) }}" class="mt-4">
                                                @csrf
                                                <input type="hidden" name="action" value="revision">
                                                <div>
                                                    <label for="feedback" class="block text-sm font-medium text-gray-700">Commentaires</label>
                                                    <textarea id="feedback" name="feedback" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required x-model="feedback"></textarea>
                                                </div>
                                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm">
                                                        Envoyer
                                                    </button>
                                                    <button @click="openRevision = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                                        Annuler
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Rejet -->
                        <div x-show="openRejection" x-transition class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="openRejection = false"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                    <div>
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Rejeter le mémoire
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Veuillez expliquer pourquoi vous rejetez ce mémoire afin que le stagiaire puisse comprendre et améliorer son travail.
                                            </p>
                                            <form method="POST" action="{{ route('superviseur.memoires.action', $memoire) }}" class="mt-4">
                                                @csrf
                                                <input type="hidden" name="action" value="rejected">
                                                <div>
                                                    <label for="feedback" class="block text-sm font-medium text-gray-700">Raison du rejet</label>
                                                    <textarea id="feedback" name="feedback" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required x-model="feedback"></textarea>
                                                </div>
                                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                                                        Confirmer
                                                    </button>
                                                    <button @click="openRejection = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                                        Annuler
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('success') }}');
    });
</script>
@endif
@endsection