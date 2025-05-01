@extends('layouts.dpaf')

@section('content')

<header class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Tableau de bord DPAF</h1>
        <p class="text-slate-500 mt-1">Gérez et suivez les demandes entrantes</p>
    </header>

<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @include('components.stats-card', [
            'title' => 'Demandes à traiter',
            'value' => $pendingDPAFDemandes->count(),
            'description' => 'Demandes en attente de traitement',
            'icon' => 'inbox',
            'color' => 'bg-blue-100 text-blue-600'
        ])
        
        @include('components.stats-card', [
            'title' => 'Demandes avec département',
            'value' => $departmentAssignedDemandes->count(),
            'description' => 'Demandes avec départements assignés',
            'icon' => 'building',
            'color' => 'bg-green-100 text-green-600'
        ])
        
        @include('components.stats-card', [
            'title' => 'Demandes traitées',
            'value' => $totalProcessedByDPAF,
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
                @if($pendingDPAFDemandes->count() > 3)
                    <a href="{{ route('dpaf.pending-requests') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800">
                        Voir toutes →
                    </a>
                @endif
            </div>
            
            @if($latestPendingDemandes->count() > 0)
                <div class="space-y-4">
                    @foreach($latestPendingDemandes as $demande)
                        @include('components.demande-card', ['demande' => $demande])
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
                <div class="text-center">
                    <p class="text-5xl font-bold text-gray-800">{{ $departmentAssignedDemandes->count() }}</p>
                    <p class="text-sm text-gray-500 mt-2">Demandes à autoriser</p>
                </div>
                
                @if($departmentAssignedDemandes->count() > 0)
                    <a href="{{ route('dpaf.authorize') }}" 
                       class="block w-full text-center py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
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