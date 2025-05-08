@props(['stagiaire', 'active'])

<x-card>
    <x-card-content class="p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <x-avatar>
                    <x-avatar-fallback class="{{ $active ? 'bg-supervisor' : 'bg-gray-400' }} text-white">
                        {{ $stagiaire->initials ?? '' }}
                    </x-avatar-fallback>
                </x-avatar>
                <div>
                    <h3 class="font-medium">{{ $stagiaire->name ?? 'Non spécifié' }}</h3>
                    <p class="text-sm text-gray-500">{{ $stagiaire->email ?? '' }}</p>
                    <div class="flex items-center mt-1 text-xs text-gray-500">
                        <span class="mr-2">{{ $stagiaire->department ?? '' }}</span>
                        <span>•</span>
                        <span class="mx-2">
                            @isset($stagiaire->start_date)
                                {{ $stagiaire->start_date->format('d/m/Y') }}
                            @else
                                Date inconnue
                            @endisset
                             - 
                            @isset($stagiaire->end_date)
                                {{ $stagiaire->end_date->format('d/m/Y') }}
                            @else
                                Date inconnue
                            @endisset
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                @if($active)
                    <div class="mr-4 text-right">
                        <div class="text-sm font-medium">Progression</div>
                        <div class="text-xl font-bold text-supervisor">
                            {{ $stagiaire->progress ?? 0 }}%
                        </div>
                    </div>
                    
                    <!-- Dialogue Détails -->
                    <div x-data="{ detailsOpen: false }" class="mr-2">
                        <button @click="detailsOpen = true" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor">
                            Détails
                        </button>

                        <!-- Modal Détails -->
                        <div x-show="detailsOpen" x-transition class="fixed inset-0 z-50 overflow-y-auto" @click.away="detailsOpen = false">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
                                    <div class="border-b pb-4">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Détails du stagiaire</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Informations complètes sur {{ $stagiaire->name }}
                                        </p>
                                    </div>
                                    
                                    <div class="space-y-4 py-4">
                                        <div class="flex justify-center mb-4">
                                            <x-avatar class="h-20 w-20">
                                                <x-avatar-fallback class="bg-supervisor text-white text-xl">
                                                    {{ $stagiaire->initials }}
                                                </x-avatar-fallback>
                                            </x-avatar>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="text-sm font-medium">Nom:</div>
                                            <div class="text-sm">{{ $stagiaire->name }}</div>
                                            
                                            <div class="text-sm font-medium">Email:</div>
                                            <div class="text-sm">{{ $stagiaire->email }}</div>
                                            
                                            <div class="text-sm font-medium">Département:</div>
                                            <div class="text-sm">{{ $stagiaire->department }}</div>
                                            
                                            <div class="text-sm font-medium">Date de début:</div>
                                            <div class="text-sm">{{ $stagiaire->start_date->format('d/m/Y') }}</div>
                                            
                                            <div class="text-sm font-medium">Date de fin:</div>
                                            <div class="text-sm">{{ $stagiaire->end_date->format('d/m/Y') }}</div>
                                            
                                            <div class="text-sm font-medium">Progression:</div>
                                            <div class="text-sm">{{ $stagiaire->progress }}%</div>

                                            <div class="text-sm font-medium">Tâches réussies:</div>
                                            <div class="text-sm">{{ $stagiaire->tasks_completed }}</div>

                                            <div class="text-sm font-medium">Tâches échouées:</div>
                                            <div class="text-sm">{{ $stagiaire->tasks_failed }}</div>

                                            <div class="text-sm font-medium">Taux de réussite:</div>
                                            <div class="text-sm">{{ $stagiaire->task_success_rate }}%</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-end">
                                        <button @click="detailsOpen = false" type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor sm:text-sm">
                                            Fermer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Dialogue Archives -->
                    <div x-data="{ archivesOpen: false }">
                        <button @click="archivesOpen = true" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            Archives
                        </button>

                        <!-- Modal Archives -->
                        <div x-show="archivesOpen" x-transition class="fixed inset-0 z-50 overflow-y-auto" @click.away="archivesOpen = false">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
                                    <div class="border-b pb-4">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Archives du stagiaire {{ $stagiaire->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Accédez aux documents, rapports et statistiques de performance
                                        </p>
                                    </div>
                                    
                                    <div class="py-4 space-y-6">
                                        <div>
                                            <h3 class="font-medium mb-3">Informations générales</h3>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div class="text-sm font-medium">Stage:</div>
                                                <div class="text-sm">
                                                    {{ $stagiaire->start_date->format('d/m/Y') }} au {{ $stagiaire->end_date->format('d/m/Y') }}
                                                </div>
                                                
                                                <div class="text-sm font-medium">Durée:</div>
                                                <div class="text-sm">
                                                    {{ $stagiaire->start_date->diffInMonths($stagiaire->end_date) }} mois
                                                </div>
                                                
                                                <div class="text-sm font-medium">Département:</div>
                                                <div class="text-sm">{{ $stagiaire->department }}</div>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <h3 class="font-medium mb-3">Performance</h3>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div class="text-sm font-medium">Tâches réussies:</div>
                                                <div class="text-sm">{{ $stagiaire->tasks_completed }} ({{ $stagiaire->task_success_rate }}%)</div>
                                                
                                                <div class="text-sm font-medium">Tâches échouées:</div>
                                                <div class="text-sm">{{ $stagiaire->tasks_failed }} ({{ $stagiaire->task_failure_rate }}%)</div>
                                                
                                                <div class="text-sm font-medium">Progression finale:</div>
                                                <div class="text-sm">{{ $stagiaire->progress }}% (complété)</div>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <h3 class="font-medium mb-3">Documents soumis</h3>
                                            <div class="space-y-2">
                                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-md">
                                                    <div class="flex items-center">
                                                        <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        <span>Rapport final.pdf</span>
                                                    </div>
                                                    <button type="button" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor">
                                                        Voir
                                                    </button>
                                                </div>
                                                
                                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-md">
                                                    <div class="flex items-center">
                                                        <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        <span>Mémoire.pdf</span>
                                                    </div>
                                                    <button type="button" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor">
                                                        Voir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-end">
                                        <button @click="archivesOpen = false" type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor sm:text-sm">
                                            Fermer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Bouton de suppression -->
                <form action="{{ route('stagiaires.destroy', $stagiaire) }}" method="POST" class="ml-2">
                    @csrf
                    @method('DELETE')
                    <div x-data="{ deleteOpen: false }">
                        <button @click="deleteOpen = true" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-red-600 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>

                        <!-- Modal Suppression -->
                        <div x-show="deleteOpen" x-transition class="fixed inset-0 z-50 overflow-y-auto" @click.away="deleteOpen = false">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmer la suppression</h3>
                                    <p class="mb-4">Êtes-vous sûr de vouloir supprimer ce stagiaire ? Cette action est irréversible.</p>
                                    <div class="mt-5 sm:mt-6 flex justify-between">
                                        <button @click="deleteOpen = false" type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor sm:text-sm">
                                            Annuler
                                        </button>
                                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-card-content>
</x-card>