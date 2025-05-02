@php
    $cheminActuel = request()->path();
@endphp

<div class="w-64 bg-gray-800 text-white flex flex-col h-screen fixed">
    <!-- Logo/Titre -->
    <div class="p-4 border-b border-gray-700">
        <h2 class="text-xl font-bold">SRHDS</h2>
    </div>

    <!-- Navigation simplifiée -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('srhds.dashboard') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors {{ $cheminActuel === 'srhds/dashboard' ? 'bg-gray-700 font-medium' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                    Tableau de bord
                </a>
            </li>
            <li>
                <a href="{{ route('srhds.assign') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors {{ $cheminActuel === 'srhds/assign' ? 'bg-gray-700 font-medium' : '' }}">
                    <i class="fas fa-share-alt mr-3 w-5 text-center"></i>
                    Assigner départements
                </a>
            </li>
        </ul>
    </nav>

    <!-- Déconnexion (toujours en bas) -->
    <div class="p-4 border-t border-gray-700 mt-auto">
        <form action="{{ route('srhds.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
                Déconnexion
            </button>
        </form>
    </div>
</div>