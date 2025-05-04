<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::middleware('auth:api')->group(function() {
  //  Route::get('/check-notifications', [NotificationController::class, 'check']);
    //Route::post('/mark-notifications-read', [NotificationController::class, 'markAsRead']);
//});
Route::post('/verify-stagiaire-code', function(Request $request) {
  $valid = DemandeStage::where('email', $request->email)
            ->where('intern_code', $request->code)
            ->where('account_created', false)
            ->exists();

  return response()->json([
      'valid' => $valid,
      'message' => $valid ? 'Valide' : 'Combinaison invalide ou compte déjà créé'
  ]);
});