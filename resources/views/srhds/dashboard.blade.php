@extends('layouts.srhds')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Tableau de bord SRHDS</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <!-- Carte: Demandes à traiter -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <h3 class="text-sm font-medium text-gray-500">Demandes à traiter</h3>
            <p class="text-2xl font-bold">{{ $pendingSRHDSRequests->count() }}</p>
            <p class="text-sm text-gray-500">Demandes en attente d'assignation</p>
        </div>
        
        <!-- Carte: Demandes autorisées -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Demandes autorisées</h3>
            <p class="text-2xl font-bold">{{ $authorizedRequests->count() }}</p>
            <p class="text-sm text-gray-500">Demandes avec autorisation DPAF</p>
        </div>
        
        <!-- Carte: Demandes finalisées -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <h3 class="text-sm font-medium text-gray-500">Demandes finalisées</h3>
            <p class="text-2xl font-bold">{{ $approvedRequests->count() }}</p>
            <p class="text-sm text-gray-500">Demandes approuvées et finalisées</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-4 lg:col-span-2">
            <h2 class="text-lg font-semibold mb-4">Dernières demandes</h2>
            
            @if($latestPendingRequests->count() > 0)
                @foreach($latestPendingRequests as $request)
                    <div class="mb-4 border-b pb-4 last:border-b-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium">{{ $request->student_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $request->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <a href="{{ route('srhds.request.show', $request->id) }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                Voir
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500">Aucune demande en attente</p>
            @endif
            
            @if($pendingSRHDSRequests->count() > 3)
                <div class="mt-4 text-center">
                    <a href="{{ route('srhds.assign') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Voir toutes les demandes
                    </a>
                </div>
            @endif
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold mb-4">Actions nécessaires</h2>
            <div class="space-y-4">
                @if($requestsNeedingDepartment->count() > 0)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">À assigner un département</h3>
                        <p class="text-2xl font-bold">{{ $requestsNeedingDepartment->count() }}</p>
                        <a href="{{ route('srhds.assign') }}" class="mt-2 block">
                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200">
                                Assigner départements
                            </button>
                        </a>
                    </div>
                @endif
                
                @if($authorizedRequests->count() > 0)
                    <div class="mt-4">
                        <h3 class="text-sm font-medium text-gray-500">À finaliser</h3>
                        <p class="text-2xl font-bold">{{ $authorizedRequests->count() }}</p>
                        <a href="{{ route('srhds.finalize') }}" class="mt-2 block">
                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Finaliser demandes
                            </button>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection