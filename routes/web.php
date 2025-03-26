<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StageController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Routes pour la gestion des stages
Route::prefix('stages')->group(function () {
    // Route pour afficher le formulaire
    Route::get('/formulaire', [StageController::class, 'afficherFormulaire'])
         ->name('stage.formulaire');
    
    // Route pour traiter la soumission du formulaire
Route::post('/demande-de-stage', [StageController::class, 'soumettreFormulaire'])->name('stage.soumettre');
    
    // Espace stagiaire
    Route::get('/espace', [StageController::class, 'espace'])->name('stage.espace')
         ->middleware('auth'); // Protection si besoin
});

// Route de fallback pour les pages non trouvées
Route::fallback(function () {
    return redirect()->route('home');
});