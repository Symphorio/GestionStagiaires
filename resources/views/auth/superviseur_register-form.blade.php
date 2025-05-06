<form method="POST" action="{{ route('superviseur.register.submit') }}" class="space-y-4">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-2">
            <label for="nom" class="block text-gray-700 font-medium">Nom</label>
            <input
                id="nom"
                name="nom"
                type="text"
                value="{{ old('nom') }}"
                required
                class="block w-full rounded-md border border-gray-300 bg-white/90 px-3 py-2 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
            />
            @error('nom')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-2">
            <label for="prenom" class="block text-gray-700 font-medium">Prénom</label>
            <input
                id="prenom"
                name="prenom"
                type="text"
                value="{{ old('prenom') }}"
                required
                class="block w-full rounded-md border border-gray-300 bg-white/90 px-3 py-2 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
            />
            @error('prenom')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
    <div class="space-y-2">
        <label for="email" class="block text-gray-700 font-medium">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            placeholder="votre@email.com"
            value="{{ old('email') }}"
            required
            class="block w-full rounded-md border border-gray-300 bg-white/90 px-3 py-2 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
        />
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="password" class="block text-gray-700 font-medium">Mot de passe</label>
        <input
            id="password"
            name="password"
            type="password"
            required
            class="block w-full rounded-md border border-gray-300 bg-white/90 px-3 py-2 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
        />
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="password_confirmation" class="block text-gray-700 font-medium">Confirmer le mot de passe</label>
        <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            required
            class="block w-full rounded-md border border-gray-300 bg-white/90 px-3 py-2 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
        />
    </div>

    <div class="space-y-2">
        <label for="poste" class="block text-gray-700 font-medium">Poste</label>
        <select
            id="poste"
            name="poste"
            required
            class="block w-full rounded-md border border-gray-300 bg-white/90 px-3 py-2 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
        >
            <option value="">Sélectionner un poste</option>
            <option value="chef" {{ old('poste') == 'chef' ? 'selected' : '' }}>Chef de service</option>
            <option value="directeur" {{ old('poste') == 'directeur' ? 'selected' : '' }}>Directeur</option>
        </select>
        @error('poste')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="departement" class="block text-gray-700 font-medium">Département</label>
        <select
            id="departement"
            name="departement"
            required
            class="block w-full rounded-md border border-gray-300 bg-white/90 px-3 py-2 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
        >
            <option value="">Sélectionner un département</option>
            <option value="informatique" {{ old('departement') == 'informatique' ? 'selected' : '' }}>Informatique</option>
            <option value="rh" {{ old('departement') == 'rh' ? 'selected' : '' }}>Ressources Humaines</option>
            <option value="finance" {{ old('departement') == 'finance' ? 'selected' : '' }}>Finance</option>
            <option value="marketing" {{ old('departement') == 'marketing' ? 'selected' : '' }}>Marketing</option>
            <option value="production" {{ old('departement') == 'production' ? 'selected' : '' }}>Production</option>
        </select>
        @error('departement')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-4">
        <button type="submit" class="btn-inscription w-full flex items-center justify-center py-3 px-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            S'inscrire
        </button>
    </div>
</form>