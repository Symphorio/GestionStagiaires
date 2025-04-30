<footer class="bg-gray-200 text-gray-800 py-12 border-t border-gray-300">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4 text-gray-700">MASM Stages</h3>
                <p class="text-gray-600">
                    Plateforme de gestion des stagiaires du Ministère des Affaires Sociales et de la Microfinance.
                </p>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-4 text-gray-700">Liens utiles</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="/" class="animated-link group">
                            <span class="flex items-center text-gray-600 hover:text-blue-600 transition-all duration-300 transform hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="border-b border-transparent group-hover:border-blue-600 transition-all duration-300">Accueil</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#apply" class="animated-link group">
                            <span class="flex items-center text-gray-600 hover:text-blue-600 transition-all duration-300 transform hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span class="border-b border-transparent group-hover:border-blue-600 transition-all duration-300">Demande de stage</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stagiaire.login.submit') }}" class="animated-link group">
                            <span class="flex items-center text-gray-600 hover:text-blue-600 transition-all duration-300 transform hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="border-b border-transparent group-hover:border-blue-600 transition-all duration-300">Espace stagiaire</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-4 text-gray-700">Contact</h3>
                <address class="text-gray-600 not-italic space-y-3">
                    <div class="flex items-start group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Ministère des Affaires Sociales et de la Microfinance</span>
                    </div>
                    <div class="flex items-start group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:contact@masam.gouv.bj" class="hover:text-blue-600 transition-colors duration-300">contact@masam.gouv.bj</a>
                    </div>
                    <div class="flex items-start group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>+229 00 00 00 00</span>
                    </div>
                </address>
            </div>
        </div>
        
        <div class="border-t border-gray-400 mt-8 pt-8 text-center text-gray-600">
            <p>&copy; {{ date('Y') }} Ministère des Affaires Sociales et de la Microfinance. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<style>
    .animated-link:hover span:last-child {
        animation: underlineGrow 0.3s ease-out forwards;
    }
    
    @keyframes underlineGrow {
        0% {
            transform: scaleX(0);
            transform-origin: left;
        }
        100% {
            transform: scaleX(1);
            transform-origin: left;
        }
    }
</style>