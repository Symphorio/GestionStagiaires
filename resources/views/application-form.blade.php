@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Carte avec effet "verre" -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-lg shadow-lg p-8 border border-white/20 dark:border-gray-700">
        <h2 class="text-2xl font-medium mb-6 text-center text-gray-800 dark:text-white">Demande de Stage</h2>
        
        <!-- Messages de succès/erreur -->
        @if(session('succes'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('succes') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('stage.soumettre') }}" class="space-y-6"> <!-- Correction ici -->
            @csrf
            
            <!-- Ligne 1 - Prénom et Nom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prénom *</label>
                    <input 
                        type="text"
                        id="prenom"
                        name="prenom"
                        value="{{ old('prenom') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        placeholder="Votre prénom"
                        required
                    />
                </div>
                
                <div class="space-y-2">
                    <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom *</label>
                    <input 
                        type="text"
                        id="nom"
                        name="nom"
                        value="{{ old('nom') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        placeholder="Votre nom"
                        required
                    />
                </div>
            </div>
            
            <!-- Ligne 2 - Email et Téléphone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email *</label>
                    <input 
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        placeholder="votre.email@exemple.com"
                        required
                    />
                </div>
                
                <div class="space-y-2">
                    <label for="telephone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Téléphone *</label>
                    <input 
                        type="tel"
                        id="telephone"
                        name="telephone"
                        value="{{ old('telephone') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        placeholder="Votre numéro de téléphone"
                        required
                    />
                </div>
            </div>
            
            <!-- Ligne 3 - Formation et Spécialisation -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="formation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Formation *</label>
                    <input 
                        type="text"
                        id="formation"
                        name="formation"
                        value="{{ old('formation') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        placeholder="Votre niveau d'études"
                        required
                    />
                </div>
                
                <div class="space-y-2">
                    <label for="specialisation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spécialisation</label>
                    <input 
                        type="text"
                        id="specialisation"
                        name="specialisation"
                        value="{{ old('specialisation') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        placeholder="Votre domaine de spécialisation"
                    />
                </div>
            </div>
            
            <!-- Ligne 4 - Dates de début et fin -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de début souhaitée *</label>
                    <input 
                        type="date"
                        id="date_debut"
                        name="date_debut"
                        value="{{ old('date_debut') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        required
                    />
                </div>
                
                <div class="space-y-2">
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de fin souhaitée *</label>
                    <input 
                        type="date"
                        id="date_fin"
                        name="date_fin"
                        value="{{ old('date_fin') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        required
                    />
                </div>
            </div>
            
            <!-- Lettre de motivation -->
            <div class="space-y-2">
                <label for="lettre_motivation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lettre de Motivation *</label>
                <textarea 
                    id="lettre_motivation"
                    name="lettre_motivation"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white min-h-[120px]"
                    placeholder="Décrivez votre motivation pour ce stage..."
                    required
                >{{ old('lettre_motivation') }}</textarea>
            </div>
            
            <!-- Bouton de soumission -->
            <button 
                type="submit" 
                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-150 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Soumettre ma demande
            </button>
        </form>
    </div>
</div>
@endsection