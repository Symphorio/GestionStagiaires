<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StageController;
use App\Http\Controllers\CompteStagiaireController;
use App\Http\Controllers\TableauDeBordStagiaireController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Routes publiques
Route::prefix('stages')->group(function () {
    Route::get('/formulaire', [StageController::class, 'afficherFormulaire'])->name('stage.formulaire');
    Route::post('/demande-de-stage', [StageController::class, 'soumettreFormulaire'])->name('stage.soumettre');
});

// Routes d'authentification unifiées
Route::middleware('guest')->group(function () {
    // Inscription
    Route::get('/register', [CompteStagiaireController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [CompteStagiaireController::class, 'register'])->name('register.submit');
    
   // Authentification unique
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Espace stagiaire
Route::prefix('stagiaire')->name('stagiaire.')->middleware(['auth:stagiaire'])->group(function() {
    Route::get('/dashboard', [TableauDeBordStagiaireController::class, 'dashboard'])->name('dashboard');
    Route::get('/taches', [TableauDeBordStagiaireController::class, 'taches'])->name('taches');
    Route::patch('/taches/{task}/status', [TableauDeBordStagiaireController::class, 'updateTaskStatus'])->name('taches.update-status');
    Route::get('/rapports', [TableauDeBordStagiaireController::class, 'rapports'])->name('rapports');
    Route::post('/rapports/upload', [TableauDeBordStagiaireController::class, 'uploadRapport'])->name('rapports.upload');
    Route::get('/soumission-memoire', [TableauDeBordStagiaireController::class, 'afficherSoumissionMemoire'])->name('soumission-memoire');
    Route::post('/soumettre-memoire', [TableauDeBordStagiaireController::class, 'soumettreMemoire'])->name('soumettre-memoire');
    Route::get('/telecharger-memoire/{id}', [TableauDeBordStagiaireController::class, 'telechargerMemoire'])->name('telecharger-memoire');
    Route::get('/profil', [TableauDeBordStagiaireController::class, 'profil'])->name('profil');
    Route::post('/profil', [TableauDeBordStagiaireController::class, 'updateProfil'])->name('profil.update');
    Route::put('/profil/avatar', [TableauDeBordStagiaireController::class, 'updateProfil'])
     ->name('profil.update.avatar');
    Route::get('/parametres', [TableauDeBordStagiaireController::class, 'parametres'])->name('parametres');
    Route::put('/', [TableauDeBordStagiaireController::class, 'update'])->name('parametres.update');
    Route::delete('/', [TableauDeBordStagiaireController::class, 'destroy'])->name('parametres.destroy');
});

// Autres espaces (DPAF, Tuteur)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->hasRole('stagiaire') 
            ? redirect()->route('stagiaire.dashboard')
            : view('dashboard');
    })->name('dashboard');
});

Route::fallback(function () {
    return redirect('/');
});