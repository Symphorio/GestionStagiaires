@php
use App\Models\DemandeStage;
@endphp

@extends('layouts.dpaf')

@section('content')
<header class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Tableau de bord DPAF</h1>
    <p class="text-slate-500 mt-1">Gérez et suivez les demandes entrantes</p>
</header>

<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Demandes à traiter (status transferee_dpaf) -->
        @include('components.stats-card', [
            'title' => 'Demandes à traiter',
            'value' => DemandeStage::where('status', 'transferee_dpaf')->count(),
            'description' => 'Demandes en attente de traitement',
            'icon' => 'inbox',
            'color' => 'bg-blue-100 text-blue-600'
        ])
        
        <!-- Demandes avec département assigné -->
        @include('components.stats-card', [
            'title' => 'Demandes avec département',
            'value' => DemandeStage::where('status', 'department_assigned')->count(),
            'description' => 'Demandes avec départements assignés',
            'icon' => 'building',
            'color' => 'bg-green-100 text-green-600'
        ])
        
        <!-- Demandes traitées -->
        @include('components.stats-card', [
            'title' => 'Demandes traitées',
            'value' => DemandeStage::whereNotIn('status', ['transferee_dpaf', 'pending_sg'])->count(),
            'description' => 'Nombre total de demandes traitées',
            'icon' => 'check-circle',
            'color' => 'bg-purple-100 text-purple-600'
        ])
    </div>
    
    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Requests -->
        <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold">Demandes récentes</h2>
                @if(DemandeStage::where('status', 'transferee_dpaf')->count() > 3)
                    <a href="{{ route('dpaf.requests.pending') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800">
                        Voir toutes →
                    </a>
                @endif
            </div>
            
            @php
                $latestPendingDemandes = DemandeStage::where('status', 'transferee_dpaf')
                                          ->latest()
                                          ->take(3)
                                          ->get();
            @endphp
            
            @if($latestPendingDemandes->count() > 0)
                <div class="space-y-4">
                    @foreach($latestPendingDemandes as $demande)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium">{{ $demande->prenom }} {{ $demande->nom }}</h3>
                                    <p class="text-sm text-gray-500">{{ $demande->formation }}</p>
                                    <p class="text-sm text-gray-500">{{ $demande->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                    {{ str_replace('_', ' ', $demande->status) }}
                                </span>
                            </div>
                            
                            <div class="mt-4 flex space-x-2">
                                <a href="{{ route('stage.downloadLettre', $demande->id) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Voir PDF
                                </a>
                                
                                @if($demande->status === 'transferee_dpaf')
                                    <form method="POST" action="{{ route('dpaf.forward', $demande->id) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                            Transférer à SRHDS
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-gray-300 text-4xl mb-2"></i>
                    <p class="text-gray-500">Aucune demande en attente</p>
                </div>
            @endif
        </div>
        
        <!-- Authorizations -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-6">Autorisations</h2>
            <div class="space-y-6">
                @php
                    $departmentAssignedCount = DemandeStage::where('status', 'department_assigned')->count();
                @endphp
                
                <div class="text-center">
                    <p class="text-5xl font-bold text-gray-800">{{ $departmentAssignedCount }}</p>
                    <p class="text-sm text-gray-500 mt-2">Demandes à autoriser</p>
                </div>
                
                @if($departmentAssignedCount > 0)
                    <a href="{{ route('dpaf.authorize') }}" 
                       class="block w-full text-center py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                        Gérer les autorisations
                    </a>
                @else
                    <div class="text-center py-4 text-gray-500">
                        Aucune demande à autoriser
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection