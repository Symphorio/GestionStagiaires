@php
    $navigationLinks = [
        ['name' => 'Tableau de bord', 'path' => route('dpaf.dashboard'), 'icon' => 'grid'],
        ['name' => 'Demandes à traiter', 'path' => route('dpaf.requests.pending'), 'icon' => 'inbox'],
        ['name' => 'Autoriser des demandes', 'path' => route('dpaf.authorize'), 'icon' => 'check-circle']
    ];
    $currentPath = url()->current();
@endphp

<div class="fixed h-screen w-64 bg-white shadow-lg flex flex-col" style="top: 0; left: 0;">
    <!-- Logo/Title -->
    <div class="p-4 border-b">
        <h2 class="text-xl font-bold text-gray-800">DPAF</h2>
    </div>
    
    <!-- Navigation - Contenu scrollable -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            @foreach($navigationLinks as $link)
                <li>
                    <a href="{{ $link['path'] }}"
                       class="flex items-center p-3 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors {{ $currentPath === $link['path'] ? 'bg-gray-100 font-medium text-blue-600' : '' }}">
                        <i class="fas fa-{{ $link['icon'] }} mr-3 w-5 text-center"></i>
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
    
    <!-- Logout - Toujours fixé en bas -->
    <div class="p-4 border-t mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center p-3 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
                Déconnexion
            </button>
        </form>
    </div>
</div>