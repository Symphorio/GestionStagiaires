@extends('layouts.stagiaire')

@section('contenu')
<div class="max-w-4xl mx-auto px-4 py-8 space-y-8">
    <h1 class="text-3xl font-bold text-gray-800">Rapports</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Historique des Rapports</h2>
        
        @if($hasReports)
            <!-- Afficher la liste des rapports ici -->
        @else
            <div class="bg-gray-50 rounded-lg p-8 text-center border-2 border-dashed border-gray-200">
                <p class="text-gray-500">
                    Aucun rapport soumis pour le moment.
                </p>
            </div>
        @endif
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Soumettre un Rapport</h3>
        
        <form action="{{ route('stagiaire.rapports.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rapport (PDF)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="report_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                <span>Cliquez pour télécharger</span>
                                <input id="report_file" name="report_file" type="file" class="sr-only" accept=".pdf" required>
                            </label>
                            <p class="pl-1">ou glissez-déposez</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF (MAX. 10MB)</p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <label for="comments" class="block text-sm font-medium text-gray-700">Description</label>
                <p class="mt-1 text-sm text-gray-500">Décrivez brièvement le contenu de ce rapport...</p>
                <textarea id="comments" name="comments" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Soumettre le rapport
                </button>
            </div>
        </form>
    </div>
</div>
@endsection