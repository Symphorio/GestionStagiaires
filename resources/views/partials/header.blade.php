<header class="fixed w-full bg-white shadow-sm z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <a href="/" class="text-xl font-bold text-gray-800">MASAM Stages</a>
        </div>
        <nav class="hidden md:flex space-x-8">
            <a href="/" class="text-gray-600 hover:text-gray-900">Accueil</a>
            <a href="{{ route('stage.formulaire') }}" class="text-gray-600 hover:text-gray-900">Demande</a>
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Connexion</a>
        </nav>
        <button class="md:hidden focus:outline-none" id="mobileMenuButton">
            <i data-lucide="menu" class="h-6 w-6 text-gray-600"></i>
        </button>
    </div>

    <!-- Mobile Menu (hidden by default) -->
    <div class="md:hidden hidden bg-white" id="mobileMenu">
        <div class="container mx-auto px-4 py-2 flex flex-col space-y-3">
            <a href="/" class="py-2 text-gray-600 hover:text-gray-900">Accueil</a>
            <a href="{{ route('stage.formulaire') }}" class="text-gray-600 hover:text-gray-900">Demande</a>
            <a href="{{ route('login') }}" class="py-2 text-gray-600 hover:text-gray-900">Connexion</a>
        </div>
    </div>
</header>

<script>
    // Gestion du menu mobile
    document.getElementById('mobileMenuButton')?.addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    });
</script>