@extends('layouts.stagiaire')

@section('contenu')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Soumission de Mémoire</h1>
    
    <!-- Section État du mémoire -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">État de votre Mémoire</h2>
        
        <div class="p-4 text-center">
            @if($memoireSoumis)
                <p class="text-gray-600 mb-2">
                    <span class="font-medium">Mémoire soumis:</span> 
                    <span class="text-blue-600">{{ $fichierMemoire }}</span>
                </p>
                <p class="text-sm text-gray-500 mb-4">
                    Soumis le: {{ $dateSoumission ? $dateSoumission->format('d/m/Y à H:i') : 'Date non disponible' }}
                </p>
                <a href="{{ route('stagiaire.telecharger-memoire', $dernierMemoire->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    Télécharger
                </a>
            @else
                <p class="text-gray-500 py-4">
                    Aucun mémoire soumis pour le moment.
                </p>
            @endif
        </div>
    </div>

    <!-- Section Feedback -->
    @if($dernierMemoire && $dernierMemoire->feedback)
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border @if($dernierMemoire->status === 'revision') border-orange-100 @else border-red-100 @endif">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">
            @if($dernierMemoire->status === 'revision')
                <span class="text-orange-600">Demande de révision</span>
            @else
                <span class="text-red-600">Retour sur votre mémoire</span>
            @endif
        </h2>
        
        <div class="p-4 @if($dernierMemoire->status === 'revision') bg-orange-50 @else bg-red-50 @endif rounded-lg">
            <p class="text-sm text-gray-700 mb-2">
                <strong>Date:</strong> 
                {{ $dernierMemoire->review_requested_at ? $dernierMemoire->review_requested_at->format('d/m/Y à H:i') : 'Date non disponible' }}
            </p>
            <div class="bg-white p-4 rounded border border-gray-200">
                <p class="text-gray-800">{!! nl2br(e($dernierMemoire->feedback)) !!}</p>
            </div>
            
            @if($dernierMemoire->status === 'revision')
            <div class="mt-4 text-center">
                <a href="{{ route('stagiaire.soumission-memoire') }}" 
                   class="inline-flex items-center px-4 py-2 @if($dernierMemoire->status === 'revision') bg-orange-600 hover:bg-orange-700 @else bg-red-600 hover:bg-red-700 @endif text-white rounded-lg transition-colors">
                    <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                    Modifier et resoumettre
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
    
    <!-- Section Formulaire de soumission -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-xl font-semibold mb-6 text-gray-700">
            @if($enRevision)
                Resoumettre votre mémoire
            @else
                Déposer un nouveau Mémoire
            @endif
        </h2>
        
        <form action="{{ route('stagiaire.soumettre-memoire') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Champ Titre -->
            <div class="mb-6">
                <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">Titre du mémoire</label>
                <input type="text" id="titre" name="titre" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                       placeholder="Titre de votre mémoire"
                       value="{{ old('titre', $dernierMemoire->title ?? '') }}">
            </div>
            
            <!-- Champ Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (optionnel)</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                          placeholder="Décrivez brièvement le contenu de votre mémoire...">{{ old('description', $dernierMemoire->summary ?? '') }}</textarea>
            </div>
            
            <!-- Champ Fichier -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fichier du mémoire</label>
                <div class="flex items-center justify-center w-full">
                    <label for="memoire" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i data-lucide="upload" class="w-8 h-8 mb-2 text-gray-500"></i>
                            <p class="mb-2 text-sm text-gray-500">
                                <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                            </p>
                            <p class="text-xs text-gray-500">PDF, DOC, DOCX (MAX: 20MB)</p>
                        </div>
                        <input id="memoire" name="memoire" type="file" accept=".pdf,.doc,.docx" required class="hidden" />
                    </label>
                </div>
                @error('memoire')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div id="file-name" class="text-sm text-gray-500 mt-2"></div>
            </div>
            
            <!-- Bouton de soumission -->
            <button type="submit" 
                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                @if($enRevision)
                    Resoumettre le mémoire
                @else
                    Soumettre le mémoire
                @endif
            </button>
        </form>
    </div>
</div>

<script>
    // Afficher le nom du fichier sélectionné
    document.getElementById('memoire').addEventListener('change', function(e) {
        const fileName = document.getElementById('file-name');
        if (this.files.length > 0) {
            fileName.textContent = 'Fichier sélectionné: ' + this.files[0].name;
        } else {
            fileName.textContent = '';
        }
    });

    // Initialiser les icônes Lucide
    document.addEventListener('DOMContentLoaded', function() {
        const icons = {
            download: window.lucide.icons.download,
            upload: window.lucide.icons.upload,
            edit: window.lucide.icons.edit
        };
        
        // Remplacer les balises <i> par les SVG
        document.querySelectorAll('i[data-lucide]').forEach(icon => {
            const name = icon.getAttribute('data-lucide');
            if (icons[name]) {
                icon.innerHTML = icons[name].outerHTML;
            }
        });
    });
</script>
@endsection