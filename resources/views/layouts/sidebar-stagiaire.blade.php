<div class="h-full w-64 border-r border-gray-200 bg-white">
    <div class="p-4 border-b border-gray-200">
        <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center space-x-2">
            <span class="font-medium">MASM</span>
            <span class="text-xs text-gray-500">Stagiaire</span>
        </a>
    </div>
    
    <nav class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('stagiaire.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.dashboard') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                    <i data-lucide="home" class="h-5 w-5"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li>
                <a href="{{ route('stagiaire.taches') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.taches') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                    <i data-lucide="list-checks" class="h-5 w-5"></i>
                    <span>Tâches</span>
                </a>
            </li>
            <li>
                <a href="{{ route('stagiaire.rapports') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.rapports') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                    <i data-lucide="file-text" class="h-5 w-5"></i>
                    <span>Rapports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('stagiaire.memoire') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.memoire') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                    <i data-lucide="book-open" class="h-5 w-5"></i>
                    <span>Mémoire</span>
                </a>
            </li>
            <li>
                <a href="{{ route('stagiaire.calendrier') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.calendrier') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                    <i data-lucide="calendar" class="h-5 w-5"></i>
                    <span>Calendrier</span>
                </a>
            </li>
            <li>
                <a href="{{ route('stagiaire.profil') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.profil') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                    <i data-lucide="user" class="h-5 w-5"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('stagiaire.parametres') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('stagiaire.parametres') ? 'bg-blue-500 text-white' : 'hover:bg-gray-100 hover:text-gray-900' }}">
                    <i data-lucide="settings" class="h-5 w-5"></i>
                    <span>Paramètres</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-start px-4 py-2 text-sm text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg">
                <i data-lucide="log-out" class="h-4 w-4 mr-2"></i>
                Déconnexion
            </button>
        </form>
    </div>
</div>