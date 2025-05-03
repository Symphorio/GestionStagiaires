{{-- resources/views/dpaf/signature.blade.php --}}
@extends('layouts.dpaf')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Signature électronique</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <h3 class="font-medium">Demande de stage de {{ $demande->prenom }} {{ $demande->nom }}</h3>
            <p class="text-sm text-gray-600">Département: {{ $demande->department->name ?? 'Non spécifié' }}</p>
        </div>
        
        <form method="POST" action="{{ route('dpaf.demandes.authorize', $demande->id) }}" id="signatureForm">
    @csrf
    <input type="hidden" name="action" value="approve">
    <input type="hidden" name="signature" id="signatureInput">
    
    <div class="border-2 border-gray-300 rounded-md mb-4">
        <canvas id="signaturePad" class="w-full h-64 bg-gray-50"></canvas>
    </div>
    
    <div class="flex justify-between">
        <button type="button" id="clearBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">
            Effacer
        </button>
        <div class="space-x-2">
            <button type="button" id="rejectBtn" class="px-4 py-2 bg-red-500 text-white rounded-md">
                Refuser
            </button>
            <button type="submit" id="approveBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                Signer et Autoriser
            </button>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('signaturePad');
    const signaturePad = new SignaturePad(canvas);
    const form = document.getElementById('signatureForm');
    const signatureInput = document.getElementById('signatureInput');
    const clearBtn = document.getElementById('clearBtn');
    const rejectBtn = document.getElementById('rejectBtn');

    // Redimensionnement du canvas
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        signaturePad.clear();
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    // Effacer la signature
    clearBtn.addEventListener('click', () => signaturePad.clear());

    // Gestion de la soumission
    form.addEventListener('submit', function(e) {
        if (signaturePad.isEmpty()) {
            e.preventDefault();
            alert('Veuillez fournir votre signature');
            return;
        }
        signatureInput.value = signaturePad.toDataURL();
    });

    // Gestion du rejet
    rejectBtn.addEventListener('click', function() {
        if (confirm('Confirmez-vous le rejet de cette demande ?')) {
            const hiddenAction = document.createElement('input');
            hiddenAction.type = 'hidden';
            hiddenAction.name = 'action';
            hiddenAction.value = 'reject';
            form.appendChild(hiddenAction);
            form.submit();
        }
    });
});
</script>
@endsection