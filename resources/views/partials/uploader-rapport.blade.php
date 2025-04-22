<div class="mt-8">
    <h2 class="text-xl font-medium mb-4">Déposer un nouveau rapport</h2>
    
    <form action="{{ route('stagiaire.rapports.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        
        <div>
            <label for="report_file" class="block text-sm font-medium text-gray-700">Fichier du rapport</label>
            <input type="file" id="report_file" name="report_file" required
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        
        <div>
            <label for="comments" class="block text-sm font-medium text-gray-700">Commentaires (optionnel)</label>
            <textarea id="comments" name="comments" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
        </div>
        
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Soumettre le rapport
        </button>
    </form>
</div>