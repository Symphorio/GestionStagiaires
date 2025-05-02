@php
use App\Models\DemandeStage; // Ajoutez cette ligne en haut du fichier
@endphp

@extends('layouts.dpaf')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord DPAF</h1>
        <p class="mt-2 text-lg text-gray-600">Gérez et suivez les demandes entrantes</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        @include('components.stats-card', [
            'title' => 'À Traiter',
            'value' => DemandeStage::where('status', 'transferee_dpaf')->count(),
            'description' => 'Demandes en attente',
            'icon' => 'inbox',
            'color' => 'bg-indigo-100 text-indigo-600'
        ])
        
        @include('components.stats-card', [
            'title' => 'Départements',
            'value' => DemandeStage::where('status', 'department_assigned')->count(),
            'description' => 'Avec département assigné',
            'icon' => 'sitemap',
            'color' => 'bg-emerald-100 text-emerald-600'
        ])
        
        @include('components.stats-card', [
            'title' => 'Traitées',
            'value' => DemandeStage::whereNotIn('status', ['transferee_dpaf', 'pending_sg'])->count(),
            'description' => 'Demandes finalisées',
            'icon' => 'check-double',
            'color' => 'bg-purple-100 text-purple-600'
        ])
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Requests -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 lg:col-span-2">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Demandes récentes</h2>
                    @if(DemandeStage::where('status', 'transferee_dpaf')->count() > 3)
                        <a href="{{ route('dpaf.requests.pending') }}" 
                           class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                            Voir toutes →
                        </a>
                    @endif
                </div>
            </div>
            
            @php
                $latestPendingDemandes = DemandeStage::where('status', 'transferee_dpaf')
                                          ->latest()
                                          ->take(3)
                                          ->get();
            @endphp
            
            <div class="divide-y divide-gray-200">
                @forelse($latestPendingDemandes as $demande)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $demande->prenom }} {{ $demande->nom }}</h3>
                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                    <i class="fas fa-graduation-cap mr-1.5"></i>
                                    {{ $demande->formation }}
                                </div>
                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                    <i class="far fa-clock mr-1.5"></i>
                                    {{ $demande->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ str_replace('_', ' ', $demande->status) }}
                            </span>
                        </div>
                        
                        <div class="mt-4 flex space-x-3">
                            <a href="{{ route('stage.downloadLettre', $demande->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <i class="far fa-file-pdf mr-1.5"></i>
                                Voir PDF
                            </a>
                            
                            @if($demande->status === 'transferee_dpaf')
                                <form method="POST" action="{{ route('dpaf.forward', $demande->id) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                        <i class="fas fa-share mr-1.5"></i>
                                        Transférer
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">Aucune demande en attente</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Authorizations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Autorisations</h2>
            </div>
            
            @php
                $departmentAssignedCount = DemandeStage::where('status', 'department_assigned')->count();
            @endphp
            
            <div class="p-6">
                <div class="text-center py-4">
                    <p class="text-5xl font-bold text-gray-900">{{ $departmentAssignedCount }}</p>
                    <p class="text-sm text-gray-500 mt-2">Demandes à autoriser</p>
                </div>
                
                @if($departmentAssignedCount > 0)
                    <a href="{{ route('dpaf.requests.authorize') }}" 
                       class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 transition-all">
                        <i class="fas fa-tasks mr-2"></i>
                        Gérer les autorisations
                    </a>
                @else
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-check-circle text-gray-300 text-3xl mb-2"></i>
                        <p>Toutes les demandes sont traitées</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection