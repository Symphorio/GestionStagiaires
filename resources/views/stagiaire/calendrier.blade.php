{{-- resources/views/stagiaire/calendrier.blade.php --}}
@extends('layouts.stagiaire')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Mon Calendrier de Stage</h1>
        
        <div class="flex items-center space-x-2">
            <form method="GET" action="{{ route('stagiaire.calendrier') }}" class="flex items-center space-x-2">
                <select name="filtre_type" onchange="this.form.submit()" class="w-[180px] rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="tous" {{ $filtreType === 'tous' ? 'selected' : '' }}>Tous les événements</option>
                    <option value="echeance" {{ $filtreType === 'echeance' ? 'selected' : '' }}>Échéances</option>
                    <option value="reunion" {{ $filtreType === 'reunion' ? 'selected' : '' }}>Réunions</option>
                    <option value="formation" {{ $filtreType === 'formation' ? 'selected' : '' }}>Formations</option>
                    <option value="ferie" {{ $filtreType === 'ferie' ? 'selected' : '' }}>Jours fériés</option>
                </select>
                
                <input type="hidden" name="vue" value="{{ $vue }}">
                <input type="hidden" name="date" value="{{ $dateSelectionnee->format('Y-m-d') }}">
                
                <button type="submit" name="vue" value="mois" class="px-4 py-2 rounded-md {{ $vue === 'mois' ? 'bg-blue-500 text-white' : 'bg-white border border-gray-300' }}">
                    Vue Mois
                </button>
                <button type="submit" name="vue" value="liste" class="px-4 py-2 rounded-md {{ $vue === 'liste' ? 'bg-blue-500 text-white' : 'bg-white border border-gray-300' }}">
                    Vue Liste
                </button>
            </form>
        </div>
    </div>
    
    @if($vue === 'mois')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-lg font-semibold">Calendrier des Activités</h2>
                    <p class="text-gray-500 mb-4">Cliquez sur une date pour voir les événements</p>
                    
                    <div id="calendrier"
                         data-evenements='{!! $evenementsJSON !!}'
                         data-route="{{ route('stagiaire.calendrier') }}"
                         data-filtre-type="{{ $filtreType }}">
                    </div>
                </div>
                <div class="px-6 py-4 border-t flex items-center justify-between text-sm text-gray-500">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-1 rounded-full bg-blue-500"></span>
                            <span>Événement programmé</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-1 rounded-full bg-gray-500"></span>
                            <span>Aujourd'hui</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-lg font-semibold">{{ $dateSelectionnee->isoFormat('LL') }}</h2>
                    <p class="text-gray-500">{{ $dateSelectionnee->isoFormat('dddd') }}</p>
                    
                    @if($evenementsPourDate->count() > 0)
                        <div class="space-y-4 mt-4">
                            @foreach($evenementsPourDate as $evenement)
                                <div class="p-3 border rounded-lg hover:bg-gray-50 transition-colors cursor-pointer" 
                                     onclick="afficherDetailsEvenement({{ $evenement->id }})">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-medium">{{ $evenement->titre }}</h3>
                                        <span class="px-2 py-1 text-xs rounded-full" style="background-color: {{ $evenement->couleur }}; color: white;">
                                            {{ $this->formatEventType($evenement->type) }}
                                        </span>
                                    </div>
                                    @if($evenement->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $evenement->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center">
                            <svg class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500">
                                Aucun événement prévu pour cette date
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h2 class="text-lg font-semibold">Liste des Événements</h2>
                <p class="text-gray-500 mb-4">Tous vos événements à venir</p>
                
                @if($evenements->count() > 0)
                    <div class="space-y-4">
                        @foreach($evenements->sortBy('date_debut') as $evenement)
                            <div class="p-4 border rounded-lg hover:bg-gray-50 transition-colors cursor-pointer" 
                                 onclick="afficherDetailsEvenement({{ $evenement->id }})">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-medium">{{ $evenement->titre }}</h3>
                                    <span class="px-2 py-1 text-xs rounded-full" style="background-color: {{ $evenement->couleur }}; color: white;">
                                        {{ $this->formatEventType($evenement->type) }}
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center justify-between">
                                    <p class="text-sm text-gray-500">{{ Carbon::parse($evenement->date_debut)->isoFormat('LL') }}</p>
                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                @if($evenement->description)
                                    <div class="mt-2">
                                        <p class="text-sm">{{ $evenement->description }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center">
                        <svg class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500">
                            Aucun événement ne correspond à vos critères
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Modal pour les détails -->
<div id="modalEvenement" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-80 shadow-lg rounded-md bg-white">
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <h3 id="modalTitre" class="text-lg font-medium"></h3>
                <span id="modalBadge" class="px-2 py-1 text-xs rounded-full"></span>
            </div>
            <p id="modalDate" class="text-sm font-medium"></p>
            <p id="modalDescription" class="text-sm text-gray-500 pt-2 border-t"></p>
            <div class="flex justify-end mt-4">
                <button onclick="document.getElementById('modalEvenement').classList.add('hidden')" 
                        class="px-4 py-2 text-sm border rounded-md hover:bg-gray-50">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialisation du calendrier
    document.addEventListener('DOMContentLoaded', function() {
        const calendrierEl = document.getElementById('calendrier');
        if (calendrierEl) {
            const calendrier = new FullCalendar.Calendar(calendrierEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                events: JSON.parse(calendrierEl.dataset.evenements),
                dateClick: function(info) {
                    window.location.href = calendrierEl.dataset.route + 
                        "?date=" + info.dateStr + 
                        "&vue=mois&filtre_type=" + calendrierEl.dataset.filtreType;
                },
                eventClick: function(info) {
                    afficherDetailsEvenement(info.event.id);
                }
            });
            calendrier.render();
        }
    });

    function afficherDetailsEvenement(evenementId) {
        fetch(`{{ route('stagiaire.calendrier.details', '') }}/${evenementId}`)
            .then(response => response.json())
            .then(evenement => {
                document.getElementById('modalTitre').textContent = evenement.titre;
                document.getElementById('modalDate').textContent = 
                    new Date(evenement.date).toLocaleDateString('fr-FR', { 
                        day: 'numeric', 
                        month: 'long', 
                        year: 'numeric' 
                    });
                document.getElementById('modalDescription').textContent = 
                    evenement.description || '';
                
                const badge = document.getElementById('modalBadge');
                badge.textContent = evenement.type_formatted;
                badge.className = 'px-2 py-1 text-xs rounded-full';
                badge.style.backgroundColor = evenement.couleur;
                badge.style.color = 'white';
                
                document.getElementById('modalEvenement').classList.remove('hidden');
            });
    }
</script>
@endpush
@endsection