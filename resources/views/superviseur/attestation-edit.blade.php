@extends('layouts.superviseur')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight">Modifier l'attestation de Stage</h1>
        <p class="text-gray-500">
            Modifiez les informations de l'attestation avant de l'envoyer.
        </p>
    </div>

    <form action="{{ route('superviseur.rapports.update-attestation', $attestation) }}" method="POST">
        @csrf
        @method('PUT')
                  
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Il y a {{ $errors->count() }} erreur(s) dans votre formulaire
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6 space-y-4">
                <div>
                    <label for="superviseur_name" class="block text-sm font-medium text-gray-700">Nom du superviseur</label>
                    <input type="text" name="superviseur_name" id="superviseur_name" value="{{ old('superviseur_name', $attestation->superviseur_name) }}" class="mt-1 focus:ring-supervisor focus:border-supervisor block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $attestation->company_name) }}" class="mt-1 focus:ring-supervisor focus:border-supervisor block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="company_address" class="block text-sm font-medium text-gray-700">Adresse de l'entreprise</label>
                    <textarea name="company_address" id="company_address" rows="3" class="mt-1 focus:ring-supervisor focus:border-supervisor block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('company_address', $attestation->company_address) }}</textarea>
                </div>
                
                <div>
                    <label for="activities" class="block text-sm font-medium text-gray-700">Activités du stagiaire</label>
                    <textarea name="activities" id="activities" rows="5" class="mt-1 focus:ring-supervisor focus:border-supervisor block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('activities', implode("\n", json_decode($attestation->activities))) }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">Entrez une activité par ligne</p>
                </div>
                
                @if($attestation->signature_path)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Signature actuelle</label>
                    <div class="mt-1 p-2 border border-gray-300 rounded-md">
                        <img src="{{ asset('storage/'.$attestation->signature_path) }}" alt="Signature" class="h-20">
                    </div>
                </div>
                @endif
                
                <div class="flex justify-between">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-supervisor hover:bg-supervisor-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor">
                        Enregistrer les modifications
                    </button>
                    
                    <button 
                        type="button" 
                        onclick="openSignatureModal('{{ route('superviseur.rapports.sign-attestation', $attestation) }}')"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor"
                    >
                        Signer l'attestation
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal pour la signature -->
<div id="signatureModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Signature</h3>
            <div class="mt-2 px-7 py-3">
                <div class="border border-gray-300 rounded-md p-2">
                    <canvas
                        id="signatureCanvas"
                        width="550"
                        height="200"
                        class="border border-gray-200 rounded touch-none w-full bg-white"
                    ></canvas>
                </div>
                <div class="mt-4 flex gap-2 justify-center">
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
                    <button 
                        type="button" 
                        onclick="closeSignatureModal()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supervisor"
                    >
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    let signaturePad;

    function openSignatureModal(url) {
        document.getElementById('signatureModal').classList.remove('hidden');
        initSignaturePad(url);
    }

    function closeSignatureModal() {
        document.getElementById('signatureModal').classList.add('hidden');
    }

    function initSignaturePad(url) {
        const canvas = document.getElementById("signatureCanvas");
        signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });
        
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }
        
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        document.getElementById('clearSignature').addEventListener('click', () => {
            signaturePad.clear();
        });

        document.getElementById('saveSignature').addEventListener('click', async () => {
            if (signaturePad.isEmpty()) {
                alert("Veuillez fournir une signature");
                return;
            }

            const signatureData = signaturePad.toDataURL();
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ signature: signatureData })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Erreur serveur');
                }

                if (data.success) {
                    closeSignatureModal();
                    window.location.href = data.redirect_url;
                } else {
                    alert(data.message || 'Erreur lors de l\'enregistrement');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Erreur: ' + error.message);
            }
        });
    }
</script>
@endpush

@endsection