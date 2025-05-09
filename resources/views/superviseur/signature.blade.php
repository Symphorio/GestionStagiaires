@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Signature</h1>
        <p class="text-gray-500">
            Signez dans la zone ci-dessous en utilisant votre souris ou votre doigt
        </p>
    </div>
    
    <form id="signatureForm" action="{{ route('superviseur.rapports.sign-attestation', $attestation) }}" method="POST">
        @csrf
        <input type="hidden" name="signature" id="signatureData">
        
        <div class="border border-gray-300 rounded-md p-2">
            <canvas
                id="signatureCanvas"
                width="550"
                height="200"
                class="border border-gray-200 rounded touch-none w-full"
            ></canvas>
        </div>
        
        <div class="mt-4 flex gap-2">
            <button 
                type="button" 
                id="clearSignature"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor"
            >
                Effacer
            </button>
            <button 
                type="button" 
                id="saveSignature"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-supervisor hover:bg-supervisor-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor"
            >
                Appliquer la signature
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/signature.js') }}"></script>
@endsection