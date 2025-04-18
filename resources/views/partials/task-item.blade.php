<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="font-medium">{{ $task['title'] }}</h3>
            <p class="text-gray-500 text-sm mt-1">{{ $task['description'] }}</p>
            
            <div class="mt-3 flex items-center text-sm text-gray-500">
                <span>Assigné par: {{ $task['assignedBy'] }}</span>
                <span class="mx-2">•</span>
                <span>Échéance: {{ $task['deadline'] }}</span>
            </div>
        </div>
        
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1 rounded-full text-xs font-medium 
                {{ $task['status'] === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                {{ $task['status'] === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                {{ $task['status'] === 'late' ? 'bg-red-100 text-red-800' : '' }}">
                {{ $task['status'] === 'completed' ? 'Complétée' : '' }}
                {{ $task['status'] === 'pending' ? 'En cours' : '' }}
                {{ $task['status'] === 'late' ? 'En retard' : '' }}
            </span>
            
            <form method="POST" action="{{ route('stagiaire.taches.update-status', $task['id']) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $task['status'] === 'completed' ? 'pending' : 'completed' }}">
                <button type="submit" class="p-2 rounded-full hover:bg-gray-100">
                    <i data-lucide="{{ $task['status'] === 'completed' ? 'rotate-ccw' : 'check' }}" class="h-4 w-4"></i>
                </button>
            </form>
        </div>
    </div>
</div>