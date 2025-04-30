<header class="fixed w-full bg-white shadow-sm z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <a href="/" class="text-xl font-bold text-gray-800 hover:text-blue-600 transition-colors duration-300">MASM Stages</a>
        </div>
        <nav class="hidden md:flex space-x-6 items-center"> <!-- Réduit l'espacement entre les liens -->
            <a href="/" class="nav-link group relative">
                <span class="text-gray-600 hover:text-blue-600 transition-colors duration-300">Accueil</span>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
            </a>

            <a href="{{ route('stagiaire.login') }}?force=true" class="nav-link group relative">
                <span class="text-gray-600 hover:text-blue-600 transition-colors duration-300">Espace stagiaires</span>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
            </a>

            <!-- Bouton "Demande" réduit -->
            <x-glass-button scrollTo="apply" class="nav-link group relative px-3 py-1 text-sm"> <!-- Taille réduite -->
                <span class="text-gray-600 hover:text-blue-600 transition-colors duration-300">Demande</span>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
            </x-glass-button>
        </nav>
        <button class="md:hidden focus:outline-none" id="mobileMenuButton">
            <i data-lucide="menu" class="h-6 w-6 text-gray-600 hover:text-blue-600 transition-colors duration-300"></i>
        </button>
    </div>

    <!-- Mobile Menu (identique) -->
    <div class="md:hidden hidden bg-white shadow-lg" id="mobileMenu">
        <div class="container mx-auto px-4 py-2 flex flex-col space-y-3">
            <a href="/" class="mobile-nav-link py-2 pl-2 border-l-4 border-transparent hover:border-blue-600 hover:text-blue-600 transition-all duration-300">
                <span class="text-gray-600 hover:text-blue-600 transition-colors duration-300">Accueil</span>
            </a>
            <a href="{{ route('stage.formulaire') }}" class="mobile-nav-link py-2 pl-2 border-l-4 border-transparent hover:border-blue-600 hover:text-blue-600 transition-all duration-300">
                <span class="text-gray-600 hover:text-blue-600 transition-colors duration-300">Demande</span>
            </a>
            <a href="{{ route('stagiaire.login') }}" class="mobile-nav-link py-2 pl-2 border-l-4 border-transparent hover:border-blue-600 hover:text-blue-600 transition-all duration-300">
                <span class="text-gray-600 hover:text-blue-600 transition-colors duration-300">Espace stagiaires</span>
            </a>
        </div>
    </div>
</header>

<script>
    // Gestion du menu mobile (identique)
    document.getElementById('mobileMenuButton')?.addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
        
        const icon = this.querySelector('i');
        if (menu.classList.contains('hidden')) {
            lucide.createIcons();
        } else {
            icon.setAttribute('data-lucide', 'x');
            lucide.createIcons();
        }
    });

    // Animation au survol pour desktop (identique)
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('mouseenter', () => {
            link.querySelector('span:last-child').style.width = '100%';
        });
        link.addEventListener('mouseleave', () => {
            link.querySelector('span:last-child').style.width = '0';
        });
    });
</script>

<style>
    .nav-link {
        padding: 0.3rem 0; /* Padding réduit */
        display: inline-block;
        position: relative;
    }
    
    .mobile-nav-link:hover {
        transform: translateX(5px);
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .nav-link:hover span:first-child {
        animation: pulse 0.5s ease;
    }
</style>