@extends('layouts.superviseur')

@section('content')
<div class="space-y-6" x-data="signaturePad()" x-init="init()">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Signature</h1>
        <p class="text-gray-500">
            Signez dans la zone ci-dessous en utilisant votre souris ou votre doigt
        </p>
    </div>
    
    <form id="signatureForm" action="{{ route('superviseur.rapports.sign-attestation', $attestation) }}" method="POST">
        @csrf
        <input type="hidden" name="signature" id="signatureData">
        
        <div class="border border-gray-300 rounded-md p-2 bg-white">
            <canvas
                id="signatureCanvas"
                class="border border-gray-200 rounded w-full"
                style="touch-action: none; height: 200px; width: 100%; background-color: white;"
                x-ref="canvas"
            ></canvas>
        </div>
        
        <div class="mt-4 flex gap-2">
            <button 
                type="button" 
                class="btn-secondary"
                @click="clearSignature()"
            >
                Effacer
            </button>
            <button 
                type="button" 
                class="btn-primary"
                @click="submitSignature()"
                :disabled="isLoading"
            >
                <span x-show="!isLoading">Appliquer la signature</span>
                <span x-show="isLoading" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enregistrement...
                </span>
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('signaturePad', () => ({
        signaturePad: null,
        isLoading: false,
        
        init() {
            // Initialiser SignaturePad
            this.signaturePad = new SignaturePad(this.$refs.canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 1,
                maxWidth: 2.5
            });
            this.resizeCanvas();
        },
        
        resizeCanvas() {
            const canvas = this.$refs.canvas;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
            this.signaturePad.clear(); // Effacer après redimensionnement
        },
        
        clearSignature() {
            this.signaturePad.clear();
        },
        
        async submitSignature() {
            if (this.signaturePad.isEmpty()) {
                alert('Veuillez signer avant de soumettre');
                return;
            }
            
            this.isLoading = true;
            const signatureData = this.signaturePad.toDataURL('image/png');
            document.getElementById('signatureData').value = signatureData;
            
            try {
                const response = await fetch(this.$el.querySelector('form').action, {
                    method: 'POST',
                    body: new FormData(this.$el.querySelector('form')),
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (!response.ok) {
                    const error = await response.json();
                    throw new Error(error.message || 'Erreur serveur');
                }
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    throw new Error(data.message || 'Erreur inconnue');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Échec de l\'enregistrement: ' + error.message);
            } finally {
                this.isLoading = false;
            }
        }
    }));
});
</script>
@endsection