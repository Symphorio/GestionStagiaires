@extends('layouts.stagiaire')

@section('contenu')
<div class="space-y-8">
    <h1 class="text-2xl font-semibold">Mon Profil</h1>
    
    <div class="glass-card p-6">
        <!-- En-tête du profil avec avatar et bouton d'édition -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8 mb-8">
            <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                @if($profil['avatarUrl'])
                    <img src="{{ $profil['avatarUrl'] }}" alt="Avatar" class="h-full w-full object-cover">
                @else
                    <span class="text-2xl">
                        {{ implode('', array_map(fn($n) => $n[0] ?? '', explode(' ', $profil['fullName']))) }}
                    </span>
                @endif
            </div>
            
            <div class="text-center md:text-left">
                <h2 class="text-xl font-medium">{{ $profil['fullName'] }}</h2>
                <p class="text-gray-500">Stagiaire en {{ $profil['specialisation'] ?? 'Non spécifié' }}</p>
                
                <div class="mt-4">
                    <button
                        onclick="document.getElementById('edit-profil-modal').classList.remove('hidden')"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Modifier le profil
                    </button>
                </div>
            </div>
        </div>
        
        <hr class="my-6 border-gray-200">
        
        <!-- Contenu principal du profil -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Section Informations Personnelles -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium mb-4 pb-2 border-b border-gray-200">Informations Personnelles</h3>
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">Nom complet</span>
                        <span class="font-medium mt-1">{{ $profil['fullName'] }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">Email</span>
                        <span class="font-medium mt-1">{{ $profil['email'] }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">Téléphone</span>
                        <span class="font-medium mt-1">{{ $profil['phone'] ?? 'Non renseigné' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Section Informations du Stage -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium mb-4 pb-2 border-b border-gray-200">Informations du Stage</h3>
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">ID Stagiaire</span>
                        <span class="font-medium mt-1">{{ $profil['internId'] }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">Département</span>
                        <span class="font-medium mt-1">{{ $profil['department'] ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">Encadreur</span>
                        <span class="font-medium mt-1">{{ $profil['supervisor'] ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">Période</span>
                        <span class="font-medium mt-1">
                            @if($profil['date_debut'] && $profil['date_fin'])
                                Du {{ \Carbon\Carbon::parse($profil['date_debut'])->format('d/m/Y') }} 
                                au {{ \Carbon\Carbon::parse($profil['date_fin'])->format('d/m/Y') }}
                            @else
                                Non renseigné
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de modification du profil -->
<div id="edit-profil-modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('stagiaire.profil.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Modifier mon profil</h3>
                            
                            <div class="mt-5 space-y-5">
                                <div class="space-y-4">
                                    <!-- Section informations modifiables -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input
                                            type="text"
                                            name="phone"
                                            id="phone"
                                            value="{{ old('phone', $profil['phone'] ?? '') }}"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            placeholder="Entrez votre numéro de téléphone"
                                        >
                                        @error('phone')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="department" class="block text-sm font-medium text-gray-700">Département</label>
                                        <select
                                            name="department"
                                            id="department"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                            <option value="">Sélectionnez un département</option>
                                            <option value="Direction Juridique" {{ old('department', $profil['department'] ?? '') == 'Direction Juridique' ? 'selected' : '' }}>Direction Juridique</option>
                                            <option value="Direction Financière" {{ old('department', $profil['department'] ?? '') == 'Direction Financière' ? 'selected' : '' }}>Direction Financière</option>
                                            <option value="Ressources Humaines" {{ old('department', $profil['department'] ?? '') == 'Ressources Humaines' ? 'selected' : '' }}>Ressources Humaines</option>
                                            <option value="Informatique" {{ old('department', $profil['department'] ?? '') == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                        </select>
                                        @error('department')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="supervisor" class="block text-sm font-medium text-gray-700">Encadreur</label>
                                        <input
                                            type="text"
                                            name="supervisor"
                                            id="supervisor"
                                            value="{{ old('supervisor', $profil['supervisor'] ?? '') }}"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            placeholder="Entrez le nom de votre encadreur"
                                        >
                                        @error('supervisor')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="avatar" class="block text-sm font-medium text-gray-700">Photo de profil</label>
                                        <input
                                            type="file"
                                            name="avatar"
                                            id="avatar"
                                            class="mt-1 block w-full text-sm text-gray-500
                                                   file:mr-4 file:py-2 file:px-4
                                                   file:rounded-md file:border-0
                                                   file:text-sm file:font-semibold
                                                   file:bg-indigo-50 file:text-indigo-700
                                                   hover:file:bg-indigo-100"
                                            accept="image/*"
                                        >
                                        @error('avatar')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        
                                        @if($profil['avatarUrl'])
                                            <div class="mt-2 flex items-center gap-4">
                                                <img src="{{ $profil['avatarUrl'] }}" alt="Photo actuelle" class="h-20 w-20 rounded-full object-cover">
                                                <span class="text-sm text-gray-500">Photo actuelle</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Section Informations non modifiables -->
                                <div class="border p-4 rounded-md bg-gray-50">
                                    <h4 class="font-medium mb-4 text-gray-800">Informations non modifiables</h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Nom complet</p>
                                            <p class="font-medium mt-1">{{ $profil['fullName'] }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Email</p>
                                            <p class="font-medium mt-1">{{ $profil['email'] }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">ID Stagiaire</p>
                                            <p class="font-medium mt-1">{{ $profil['internId'] }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Spécialisation</p>
                                            <p class="font-medium mt-1">{{ $profil['specialisation'] ?? 'Non spécifié' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Période de stage</p>
                                            <p class="font-medium mt-1">
                                                @if($profil['date_debut'] && $profil['date_fin'])
                                                    Du {{ \Carbon\Carbon::parse($profil['date_debut'])->format('d/m/Y') }} 
                                                    au {{ \Carbon\Carbon::parse($profil['date_fin'])->format('d/m/Y') }}
                                                @else
                                                    Non renseigné
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button
                        type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Enregistrer les modifications
                    </button>
                    <button
                        type="button"
                        onclick="document.getElementById('edit-profil-modal').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Gestion améliorée de la prévisualisation de l'image
    document.getElementById('avatar').addEventListener('change', function(e) {
        const previewContainer = document.querySelector('#avatar-preview');
        const file = e.target.files[0];
        
        if (file) {
            if (!previewContainer) {
                const newPreview = document.createElement('div');
                newPreview.id = 'avatar-preview';
                newPreview.className = 'mt-2 flex items-center gap-4';
                
                const img = document.createElement('img');
                img.className = 'h-20 w-20 rounded-full object-cover';
                img.id = 'avatar-preview-img';
                
                const label = document.createElement('span');
                label.className = 'text-sm text-gray-500';
                label.textContent = 'Nouvelle photo';
                
                newPreview.appendChild(img);
                newPreview.appendChild(label);
                
                const existingPreview = document.querySelector('#avatar + div');
                if (existingPreview) {
                    existingPreview.replaceWith(newPreview);
                } else {
                    e.target.after(newPreview);
                }
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('avatar-preview-img').src = event.target.result;
            }
            reader.readAsDataURL(file);
        } else if (previewContainer) {
            previewContainer.remove();
        }
    });
</script>
@endsection