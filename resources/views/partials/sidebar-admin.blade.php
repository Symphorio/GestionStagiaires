@php
    // Définition des liens de navigation
    $navigationLinks = [
        'sg' => [
            ['name' => 'Tableau de bord', 'path' => route('sg.dashboard')],
            ['name' => 'Nouvelles demandes', 'path' => route('sg.requests.index')]
        ]
    ];
    
    // Couleurs par rôle
    $roleColors = [
        'sg' => 'bg-blue-600',
        'dpaf' => 'bg-green-600',
        'srhds' => 'bg-purple-600'
    ];

    // Récupération du rôle actuel
    $currentRole = auth()->user()->role ?? 'sg'; // Valeur par défaut 'sg' si non défini
    $currentPath = url()->current();
@endphp

<div class="w-64 h-screen bg-white shadow-lg flex flex-col">
    <!-- En-tête avec couleur dynamique -->
    <div class="{{ $roleColors[$currentRole] }} p-4 text-white">
        <h2 class="text-xl font-bold">Admin {{ strtoupper($currentRole) }}</h2>
    </div>
    
    <!-- Navigation -->
    <nav class="mt-6 flex-1">
        <ul class="space-y-2 px-4">
            @foreach(($navigationLinks[$currentRole] ?? []) as $link)
                <li>
                    <a 
                        href="{{ $link['path'] }}"
                        class="block py-3 px-4 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors {{ $currentPath === $link['path'] ? 'bg-gray-100 font-medium' : '' }}"
                    >
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
    
    <!-- Bouton de déconnexion -->
    <div class="p-4 border-t">
        <form action="{{ route('sg.logout') }}" method="POST">
            @csrf
            <button 
                type="submit"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                <i class="fas fa-sign-out-alt mr-2"></i>
                Déconnexion
            </button>
        </form>
    </div>
</div>