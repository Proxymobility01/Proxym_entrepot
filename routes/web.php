<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Users\EntrepotUserController;
use App\Http\Controllers\EntrepotAuthController;
use App\Http\Controllers\Batteries\BatteryEntrepotController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('auth.login');  // Vue de la page de connexion
})->name('login');

Route::post('login', [EntrepotAuthController::class, 'authenticate']);

//Route::middleware(['auth.agence'])->group(function () {
    // Route pour la déconnexion
    Route::post('logout', [EntrepotAuthController::class, 'logout'])->name('logout');
    
    // Routes protégées par authentification
    Route::get('/create-agent-swap', [AgentSwapController::class, 'create'])->name('create.agent.swap');
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Afficher les utilisateurs de l'agence
   Route::get('/entrepot_users', [EntrepotUserController::class, 'index'])->name('entrepot.users');
    
  
//});



// Enregistrer un nouvel agent swap
Route::post('/entrepot_users', [EntrepotUserController::class, 'store'])->name('entrepot.users.store');

// Supprimer un agent swap
Route::delete('/entrepot_users/{entrepotUser}', [EntrepotUserController::class, 'destroy'])->name('entrepot.users.destroy');




// route pour les batteries des entrepôts
Route::get('/batteries_entrepot', [BatteryEntrepotController::class, 'index'])->name('batteries.entrepots.index');
