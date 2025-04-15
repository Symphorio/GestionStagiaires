<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StageController;
use App\Http\Controllers\CompteStagiaireController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification Jetstream (le fichier existe par défaut)
//

// Routes protégées
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
//require __DIR__.'/auth.php';

// Routes pour la gestion des stages
Route::prefix('stages')->group(function () {
    // Formulaire de demande
    Route::get('/formulaire', [StageController::class, 'afficherFormulaire'])
         ->name('stage.formulaire');
    
    // Soumission de demande
    Route::post('/demande-de-stage', [StageController::class, 'soumettreFormulaire'])
         ->name('stage.soumettre');
    
    // Espace stagiaire
    Route::get('/espace', [StageController::class, 'espace'])
         ->name('stage.espace');
});

// Routes pour la finalisation des comptes stagiaires
Route::prefix('compte')->group(function () {
    // Version temporaire sans ID
    Route::get('/inscription', [CompteStagiaireController::class, 'showRegistrationForm'])
         ->name('stagiaire.inscription');
    
    Route::post('/inscription', [CompteStagiaireController::class, 'register'])
         ->name('stagiaire.finaliser');

    // Conservez les routes originales (commentées pour l'instant)
    // Route::get('/finaliser/{intern_id}', [CompteStagiaireController::class, 'showRegistrationFormWithId'])
    //      ->name('stagiaire.finalisation');
    // Route::post('/finaliser/{intern_id}', [CompteStagiaireController::class, 'registerWithId'])
    //      ->name('stagiaire.finaliser');
});


// Route de fallback
Route::fallback(function () {
    return redirect('/');
});