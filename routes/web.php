<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StageController;
use App\Http\Controllers\CompteStagiaireController;
use App\Http\Controllers\TableauDeBordStagiaireController;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DpafLoginController;
use App\Http\Controllers\Auth\DpafRegisterController;
use App\Http\Controllers\Auth\SgLoginController;
use App\Http\Controllers\Auth\SgRegisterController;
use App\Http\Controllers\Auth\SrhdsLoginController;
use App\Http\Controllers\Auth\SrhdsRegisterController;
use App\Http\Controllers\Auth\SuperviseurAuthController;

// Dashboard Controllers
use App\Http\Controllers\SgDashboardController;
use App\Http\Controllers\DpafDashboardController;
use App\Http\Controllers\SrhdsDashboardController;

/*
|--------------------------------------------------------------------------
| Page d’accueil
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| Routes publiques : Stages
|--------------------------------------------------------------------------
*/
Route::prefix('stages')->group(function () {
    Route::get('/formulaire', [StageController::class, 'afficherFormulaire'])->name('stage.formulaire');
    Route::post('/demande-de-stage', [StageController::class, 'soumettreFormulaire'])->name('stage.soumettre');
    Route::get('/download-lettre/{id}', [StageController::class, 'downloadLettre'])->name('stage.downloadLettre');
});

/*
|--------------------------------------------------------------------------
| Authentification (guest uniquement)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // --- Stagiaire ---
    Route::get('/espace-stagiaire', [LoginController::class, 'showLoginForm'])->name('stagiaire.login');
    Route::post('/espace-stagiaire', [LoginController::class, 'login'])->name('stagiaire.login.submit');
    Route::get('/register-stagiaire', [CompteStagiaireController::class, 'showRegistrationForm'])->name('stagiaire.register.form');
    Route::post('/register-stagiaire', [CompteStagiaireController::class, 'register'])->name('stagiaire.register.submit');

    // --- SG ---
    Route::prefix('sg')->group(function () {
        Route::get('/login', [SgLoginController::class, 'showLoginForm'])->name('sg.login');
        Route::post('/login', [SgLoginController::class, 'login'])->name('sg.login.submit');
        Route::get('/register', [SgRegisterController::class, 'showRegistrationForm'])->name('sg.register');
        Route::post('/register', [SgRegisterController::class, 'register'])->name('sg.register.submit');
    });

    // --- DPAF ---
    Route::prefix('dpaf')->group(function () {
        Route::get('/login', [DpafLoginController::class, 'showLoginForm'])->name('dpaf.login');
        Route::post('/login', [DpafLoginController::class, 'login'])->name('dpaf.login.submit');
        Route::get('/register', [DpafRegisterController::class, 'showRegistrationForm'])->name('dpaf.register');
        Route::post('/register', [DpafRegisterController::class, 'register'])->name('dpaf.register.submit');
    });

    // --- SRHDS ---
    Route::prefix('srhds')->group(function () {
        Route::get('/login', [SrhdsLoginController::class, 'showLoginForm'])->name('srhds.login');
        Route::post('/login', [SrhdsLoginController::class, 'login'])->name('srhds.login.submit');
        Route::get('/register', [SrhdsRegisterController::class, 'showRegistrationForm'])->name('srhds.register');
        Route::post('/register', [SrhdsRegisterController::class, 'register'])->name('srhds.register.submit');
    });

    // Supervisur
    Route::prefix('superviseur')->group(function () {
        Route::get('/auth', [SuperviseurAuthController::class, 'index'])->name('superviseur.auth');
        Route::post('/login', [SuperviseurAuthController::class, 'login'])->name('superviseur.login.submit');
        Route::post('/register', [SuperviseurAuthController::class, 'register'])->name('superviseur.register.submit');
    });   
});

/*
|--------------------------------------------------------------------------
| Déconnexion (auth requis)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware(['auth:stagiaire,sg,dpaf,srhds,suprviseur'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Espace Stagiaire (auth:stagiaire)
|--------------------------------------------------------------------------
*/
Route::prefix('stagiaire')->name('stagiaire.')->middleware('auth:stagiaire')->group(function () {
    Route::get('/dashboard', [TableauDeBordStagiaireController::class, 'dashboard'])->name('dashboard');
    Route::get('/taches', [TableauDeBordStagiaireController::class, 'taches'])->name('taches');
    Route::patch('/taches/{task}/status', [TableauDeBordStagiaireController::class, 'updateTaskStatus'])->name('taches.update-status');
    Route::get('/rapports', [TableauDeBordStagiaireController::class, 'rapports'])->name('rapports');
    Route::post('/rapports/upload', [TableauDeBordStagiaireController::class, 'uploadRapport'])->name('rapports.upload');
    Route::get('/soumission-memoire', [TableauDeBordStagiaireController::class, 'afficherSoumissionMemoire'])->name('soumission-memoire');
    Route::post('/soumettre-memoire', [TableauDeBordStagiaireController::class, 'soumettreMemoire'])->name('soumettre-memoire');
    Route::get('/telecharger-memoire/{id}', [TableauDeBordStagiaireController::class, 'telechargerMemoire'])->name('telecharger-memoire');

    // Profil & Paramètres
    Route::get('/profil', [TableauDeBordStagiaireController::class, 'profil'])->name('profil');
    Route::post('/profil', [TableauDeBordStagiaireController::class, 'updateProfil'])->name('profil.update');
    Route::put('/profil/avatar', [TableauDeBordStagiaireController::class, 'updateProfil'])->name('profil.update.avatar');
    Route::get('/parametres', [TableauDeBordStagiaireController::class, 'parametres'])->name('parametres');
    Route::put('/parametres/update', [TableauDeBordStagiaireController::class, 'update'])->name('parametres.update');
    Route::delete('/parametres', [TableauDeBordStagiaireController::class, 'destroy'])->name('parametres.destroy');
});

/*
|--------------------------------------------------------------------------
| Espace SG (auth:sg)
|--------------------------------------------------------------------------
*/
Route::prefix('sg')->name('sg.')->middleware('auth:sg')->group(function () {
    Route::get('/dashboard', [SgDashboardController::class, 'index'])->name('dashboard');
    Route::get('/requests', [SgDashboardController::class, 'listRequests'])->name('requests.index');
    Route::patch('/requests/{id}/forward', [SgDashboardController::class, 'forward'])->name('requests.forward');
    Route::post('/logout', [SgLoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Espace DPAF (auth:dpaf)
|--------------------------------------------------------------------------
*/
Route::prefix('dpaf')->name('dpaf.')->middleware('auth:dpaf')->group(function () {
    Route::get('/dashboard', [DpafDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending-requests', [DpafDashboardController::class, 'pendingRequests'])->name('requests.pending');
    Route::get('/request/{id}', [DpafDashboardController::class, 'showRequest'])->name('request.show');
    Route::post('/forward/{id}', [DpafDashboardController::class, 'forward'])->name('forward');
    Route::get('/authorize', [DpafDashboardController::class, 'authorizeRequests'])->name('authorize');
    Route::get('/demandes/{demande}/signature', [DpafDashboardController::class, 'showSignaturePad'])->name('demandes.signature');
    Route::post('/demandes/{demande}/authorize', [DpafDashboardController::class, 'processAuthorization'])->name('demandes.authorize');
    Route::delete('/demandes/{demande}', [DpafDashboardController::class, 'destroy'])
    ->name('demandes.destroy');
    Route::post('/logout', [DpafLoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Espace SRHDS (auth:srhds)
|--------------------------------------------------------------------------
*/
Route::prefix('srhds')->name('srhds.')->middleware('auth:srhds')->group(function () {
    Route::get('/dashboard', [SrhdsDashboardController::class, 'index'])->name('dashboard');
    Route::get('/assign', [SrhdsDashboardController::class, 'assign'])->name('assign');
    Route::post('/assign/{id}', [SrhdsDashboardController::class, 'assignDepartment'])->name('assign.department');
    Route::get('/request/{id}', [SrhdsDashboardController::class, 'showRequest'])->name('request.show');
    Route::delete('/assign/{id}', [SrhdsDashboardController::class, 'deleteRequest'])->name('assign.delete');
    Route::post('/logout', [SrhdsLoginController::class, 'logout'])->name('logout');
});





/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => redirect('/'));
