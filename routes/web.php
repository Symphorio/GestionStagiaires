<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StageController;
use App\Http\Controllers\CompteStagiaireController;
use App\Http\Controllers\TableauDeBordStagiaireController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DpafLoginController;
use App\Http\Controllers\Auth\DpafRegisterController;
use App\Http\Controllers\Auth\SgLoginController;
use App\Http\Controllers\Auth\SgRegisterController;
use App\Http\Controllers\SgDashboardController;
use App\Http\Controllers\Auth\SrhdsLoginController;
use App\Http\Controllers\Auth\SrhdsRegisterController;
use App\Http\Controllers\DpafDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Routes publiques pour les stages
Route::prefix('stages')->group(function () {
    Route::get('/formulaire', [StageController::class, 'afficherFormulaire'])->name('stage.formulaire');
    Route::post('/demande-de-stage', [StageController::class, 'soumettreFormulaire'])->name('stage.soumettre');
    Route::get('/download-lettre/{id}', [StageController::class, 'downloadLettre'])->name('stage.downloadLettre');
});

// Routes d'authentification (accessibles sans être connecté)
Route::middleware('guest')->group(function () {
    // Authentification Stagiaire
    Route::get('/espace-stagiaire', [LoginController::class, 'showLoginForm'])->name('stagiaire.login');
    Route::post('/espace-stagiaire', [LoginController::class, 'login'])->name('stagiaire.login.submit');
    
    // Inscription Stagiaire
    Route::get('/register-stagiaire', [CompteStagiaireController::class, 'showRegistrationForm'])->name('stagiaire.register.form');
    Route::post('/register-stagiaire', [CompteStagiaireController::class, 'register'])->name('stagiaire.register.submit');
    
    // Authentification SG
    Route::prefix('sg')->group(function () {
        Route::get('/login', [SgLoginController::class, 'showLoginForm'])->name('sg.login');
        Route::post('/login', [SgLoginController::class, 'login'])->name('sg.login.submit');
        Route::get('/register', [SgRegisterController::class, 'showRegistrationForm'])->name('sg.register');
        Route::post('/register', [SgRegisterController::class, 'register'])->name('sg.register.submit');
    });
    
    // Authentification DPAF
    Route::prefix('dpaf')->group(function () {
        Route::get('/login', [DpafLoginController::class, 'showLoginForm'])->name('dpaf.login');
        Route::post('/login', [DpafLoginController::class, 'login'])->name('dpaf.login.submit');
        Route::get('/register', [DpafRegisterController::class, 'showRegistrationForm'])->name('dpaf.register');
        Route::post('/register', [DpafRegisterController::class, 'register'])->name('dpaf.register.submit');
    });
    
    // Authentification SRHDS (nouvelle section ajoutée)
    Route::prefix('srhds')->group(function () {
        Route::get('/login', [SrhdsLoginController::class, 'showLoginForm'])->name('srhds.login');
        Route::post('/login', [SrhdsLoginController::class, 'login'])->name('srhds.login.submit');
        Route::get('/register', [SrhdsRegisterController::class, 'showRegistrationForm'])->name('srhds.register');
        Route::post('/register', [SrhdsRegisterController::class, 'register'])->name('srhds.register.submit');
    });
});

// Déconnexion globale
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:stagiaire');

// Espace Stagiaire (protégé)
Route::prefix('stagiaire')->name('stagiaire.')->middleware('auth:stagiaire')->group(function() {
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
    Route::put('/parametres/update', [TableauDeBordStagiaireController::class, 'update'])->name('parametres.update');
    Route::delete('/parametres', [TableauDeBordStagiaireController::class, 'destroy'])->name('parametres.destroy');
});

// Espace SG (protégé)
Route::prefix('sg')->middleware('auth:sg')->group(function() {
    Route::get('/dashboard', [SgDashboardController::class, 'index'])->name('sg.dashboard');
    Route::get('/requests', [SgDashboardController::class, 'listRequests'])->name('sg.requests.index');
    Route::patch('/requests/{id}/forward', [SgDashboardController::class, 'forward'])->name('sg.requests.forward');
    Route::post('/logout', [SgLoginController::class, 'logout'])->name('sg.logout');
});

// Espace DPAF (protégé)
Route::prefix('dpaf')->middleware('auth:dpaf')->group(function() {
    Route::get('/dashboard', [DpafDashboardController::class, 'dashboard'])->name('dpaf.dashboard');
    Route::get('/pending-requests', [DpafDashboardController::class, 'pendingRequests'])->name('dpaf.requests.pending');
   // Route::get('/authorize', [DpafDashboardController::class, 'authorize'])->name('dpaf.requests.authorize');
    Route::get('/request/{id}', [DpafDashboardController::class, 'showRequest'])->name('dpaf.request.show');
    Route::post('/forward/{id}', [DpafDashboardController::class, 'forward'])->name('dpaf.forward');
    Route::get('/authorize', [DpafDashboardController::class, 'authorizeRequests'])->name('dpaf.requests.authorize');
    Route::post('/authorize/{id}', [DpafDashboardController::class, 'processAuthorization'])->name('dpaf.authorize.process');
    Route::post('/logout', [DpafLoginController::class, 'logout'])->name('dpaf.logout');
    
    // Mot de passe oublié
    Route::get('password/reset', [Auth\DpafForgotPasswordController::class, 'showLinkRequestForm'])->name('dpaf.password.request');
    Route::post('password/email', [Auth\DpafForgotPasswordController::class, 'sendResetLinkEmail'])->name('dpaf.password.email');
    Route::get('password/reset/{token}', [Auth\DpafResetPasswordController::class, 'showResetForm'])->name('dpaf.password.reset');
    Route::post('password/reset', [Auth\DpafResetPasswordController::class, 'reset'])->name('dpaf.password.update');
});

// Espace SRHDS (protégé) - Nouvelle section ajoutée
Route::prefix('srhds')->middleware('auth:srhds')->group(function () {
    Route::get('/', [SrhdsDashboardController::class, 'index'])->name('srhds.dashboard');
    Route::get('/assign', [SrhdsDashboardController::class, 'assign'])->name('srhds.assign');
    Route::get('/finalize', [SrhdsDashboardController::class, 'finalize'])->name('srhds.finalize');
    Route::post('/logout', [SrhdsLoginController::class, 'logout'])->name('srhds.logout');
});

Route::fallback(function () {
    return redirect('/');
});