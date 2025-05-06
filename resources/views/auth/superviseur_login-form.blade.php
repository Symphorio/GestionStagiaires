<form method="POST" action="{{ route('superviseur.login.submit') }}" class="space-y-4">
    @csrf
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
        <div class="flex items-center justify-between">
            <label for="password" class="block text-gray-700 font-medium">Mot de passe</label>
            <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800 hover:underline">
                Mot de passe oublié?
            </a>
        </div>
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

    <div class="pt-2">
        <button type="submit" class="btn-inscription w-full flex items-center justify-center py-3 px-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
            Se connecter
        </button>
    </div>
</form>