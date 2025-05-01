@extends('layouts.sg')

@section('content')
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Tableau de bord SG</h1>
        <p class="text-slate-500 mt-1">Gérez et suivez les demandes entrantes</p>
    </header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- New Requests Card -->
        <div class="border-l-4 border-blue-500 shadow-md hover:shadow-lg transition-shadow bg-white rounded-lg">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Nouvelles demandes</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="h-12 w-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-500 h-6 w-6"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4">Demandes en attente de traitement</p>
            </div>
        </div>

        <!-- Forwarded Requests Card -->
        <div class="shadow-md hover:shadow-lg transition-shadow bg-white rounded-lg">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Demandes transférées</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['forwarded'] }}</p>
                    </div>
                    <div class="h-12 w-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-arrow-right text-blue-500 h-6 w-6"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4">Demandes envoyées à DPAF</p>
            </div>
        </div>

        <!-- Transfer Rate Card -->
        <div class="shadow-md hover:shadow-lg transition-shadow bg-white rounded-lg">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Taux de transfert</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['transfer_rate'] }}%</p>
                    </div>
                    <div class="h-12 w-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-arrow-up text-blue-500 h-6 w-6"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4">Pourcentage de demandes traitées</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Latest Requests -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="pb-3 p-6">
                    <h3 class="text-xl text-slate-800 flex items-center font-semibold">
                        <i class="fas fa-file-alt h-5 w-5 mr-2 text-blue-500"></i>
                        Dernières demandes
                    </h3>
                </div>
                <div class="pt-0 p-6">
                    @forelse($latestRequests as $demande)
                        <div class="rounded-lg border border-slate-200 p-5 hover:shadow-md transition-shadow mb-6 last:mb-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-lg text-slate-800 flex items-center">
                                        <i class="fas fa-user h-4 w-4 mr-2 text-slate-400"></i>
                                        {{ $demande->prenom }} {{ $demande->nom }}
                                    </h3>
                                    <div class="text-slate-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-calendar h-3 w-3 mr-1"></i>
                                        <span>{{ $demande->created_at->format('d/m/Y') }}</span>
                                        <span class="mx-2">|</span>
                                        <span class="font-medium">{{ $demande->formation }}</span>
                                    </div>
                                </div>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-amber-50 text-amber-700 border-amber-200">
                                    En attente SG
                                </span>
                            </div>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-slate-700">
                                <div>
                                    <span class="font-medium">Période:</span> 
                                    {{ $demande->date_debut->format('d/m/Y') }} - {{ $demande->date_fin->format('d/m/Y') }}
                                </div>
                                <div>
                                    <span class="font-medium">Email:</span> {{ $demande->email }}
                                </div>
                                @if($demande->telephone)
                                    <div>
                                        <span class="font-medium">Téléphone:</span> {{ $demande->telephone }}
                                    </div>
                                @endif
                                <div class="mt-2 text-sm flex items-center">
                                <span class="font-medium flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                    Lettre :
                                </span> 
                                <span class="text-gray-600 ml-1">
                                    Document.pdf
                                </span>
                                </div>
                            </div>
                            
                            @if($demande->status === 'en_attente_sg')
                                <hr class="my-4 border-t border-slate-200">
                                <div class="flex justify-end">
                                    <form action="{{ route('sg.requests.forward', $demande->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="flex items-center justify-center gap-2 rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 transition-all hover:translate-x-1 px-4 py-2">
                                            Transférer à la DPAF
                                            <i class="fas fa-arrow-right ml-1 h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-500">
                            <p>Aucune demande en attente</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Stats and Logout -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="pb-3 p-6">
                    <h3 class="text-xl font-semibold">Statistiques</h3>
                </div>
                <div class="pt-0 p-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Demandes ce mois</p>
                            <p class="text-2xl font-bold">{{ $totalRequests }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Temps moyen de traitement</p>
                            <p class="text-2xl font-bold">2 jours</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="p-6">
                    <form action="{{ route('sg.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-red-500 hover:text-red-600 hover:bg-red-50 border border-red-200 flex items-center justify-center gap-2 rounded-md text-sm font-medium h-10 px-4 py-2">
                            <i class="fas fa-sign-out-alt h-4 w-4 mr-2"></i>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection