<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">MASAM Stages</h3>
                <p class="text-gray-400">
                    Plateforme de gestion des stagiaires du Ministère des Affaires Sociales et de la Microfinance.
                </p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Liens utiles</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-400 hover:text-white">Accueil</a></li>
                    <li><a href="#apply" class="text-gray-400 hover:text-white">Demande de stage</a></li>
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white">Espace stagiaire</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Contact</h3>
                <address class="text-gray-400 not-italic">
                    <p>Ministère des Affaires Sociales et de la Microfinance</p>
                    <p class="mt-2"><a href="mailto:contact@masam.gouv.bj" class="hover:text-white">contact@masam.gouv.bj</a></p>
                </address>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Ministère des Affaires Sociales et de la Microfinance. Tous droits réservés.</p>
        </div>
    </div>
</footer>