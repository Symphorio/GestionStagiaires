@php
use App\Models\DemandeStage;
@endphp

@extends('layouts.dpaf')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Autoriser des demandes</h1>
    
    @if($demandes->count() > 0)
        <div class="space-y-4">
            @foreach($demandes as $demande)
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold">{{ $demande->prenom }} {{ $demande->nom }}</h3>
                            <p class="text-gray-600">{{ $demande->department->name ?? 'Département non spécifié' }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $demande->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            En attente d'autorisation
                        </span>
                    </div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Période de stage</p>
                            <p>{{ $demande->date_debut->format('d/m/Y') }} - {{ $demande->date_fin->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Formation</p>
                            <p>{{ $demande->formation }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <button onclick="window.open('{{ route('stage.downloadLettre', $demande->id) }}', '_blank')"
                            class="px-4 py-2 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100 transition">
                            Voir PDF
                        </button>
                        
                        <button onclick="openAuthorizationModal('{{ $demande->id }}', true)"
                            class="px-4 py-2 bg-green-50 text-green-600 rounded-md hover:bg-green-100 transition">
                            Autoriser
                        </button>
                        
                        <button onclick="openAuthorizationModal('{{ $demande->id }}', false)"
                            class="px-4 py-2 bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition">
                            Refuser
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-700">Aucune demande à autoriser</h2>
            <p class="text-gray-500 mt-2">Il n'y a pas de demandes avec des départements assignés en attente d'autorisation.</p>
        </div>
    @endif
</div>

<!-- Modal d'autorisation -->
<div id="authorizationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Confirmer l'autorisation</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                &times;
            </button>
        </div>
        
        <p class="mb-4">En autorisant cette demande, vous y apposerez votre signature électronique.</p>
        
        <div class="flex justify-center py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
        </div>
        
        <div id="signaturePad" class="border border-gray-300 rounded-md h-32 mb-4"></div>
        
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal()" 
                class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                Annuler
            </button>
            <button onclick="submitAuthorization(false)" 
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Refuser
            </button>
            <button onclick="submitAuthorization(true)" 
                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Autoriser et signer
            </button>
        </div>
    </div>
</div>

<script>
    let currentRequestId = null;
    let isAuthorizing = false;
    let signaturePad = null;
    
    function openAuthorizationModal(requestId, authorize) {
        currentRequestId = requestId;
        isAuthorizing = authorize;
        document.getElementById('authorizationModal').classList.remove('hidden');
        
        if (authorize && !signaturePad) {
            initSignaturePad();
        }
    }
    
    function closeModal() {
        document.getElementById('authorizationModal').classList.add('hidden');
    }
    
    function submitAuthorization(authorized) {
        const formData = new FormData();
        formData.append('authorized', authorized);
        formData.append('_token', '{{ csrf_token() }}');
        
        if (authorized && signaturePad) {
            if (signaturePad.isEmpty()) {
                alert('Veuillez ajouter votre signature');
                return;
            }
            const signatureData = signaturePad.toDataURL();
            formData.append('signature', signatureData);
        }
        
        fetch(`/dpaf/authorize/${currentRequestId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Erreur: ' + (data.message || 'Action non effectuée'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue: ' + error.message);
        });
    }
    
    function initSignaturePad() {
        const canvas = document.createElement('canvas');
        canvas.width = document.getElementById('signaturePad').offsetWidth;
        canvas.height = document.getElementById('signaturePad').offsetHeight;
        document.getElementById('signaturePad').innerHTML = '';
        document.getElementById('signaturePad').appendChild(canvas);
        
        signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });
    }
</script>

<!-- Inclure la librairie signature_pad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session('success') }}');
        });
    </script>
@endif
@endsection