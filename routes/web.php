<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Users\EntrepotUserController;
use App\Http\Controllers\EntrepotAuthController;
use App\Http\Controllers\Batteries\BatteryEntrepotController;
use App\Http\Controllers\Historiques\HistoriqueController;


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
    
    // Afficher les utilisateurs de l'entrepot
   Route::get('/entrepot_users', [EntrepotUserController::class, 'index'])->name('entrepot.users');

    //afficher les batteries de l'entrepot
    Route::get('/batteries', [BatteryEntrepotController::class, 'index'])->name('batteries.index');

   
  
    // Enregistrer un nouvel agent swap
    Route::post('/entrepot_users', [EntrepotUserController::class, 'store'])->name('entrepot.users.store');

    // Supprimer un agent swap
    Route::delete('/entrepot_users/{entrepotUser}', [EntrepotUserController::class, 'destroy'])->name('entrepot.users.destroy');




    // route pour les batteries des entrepôts
    Route::get('/batteries_entrepot', [BatteryEntrepotController::class, 'index'])->name('batteries.entrepots.index');






    // Route pour afficher l'historique des transactions de l'entrepôt
   // Route::get('/historiques', [HistoriqueController::class, 'index'])->name('historiques.index');


   
// Routes pour la gestion de l'historique des transactions
// Affichage de l'historique
Route::get('/historiques', [HistoriqueController::class, 'index'])->name('historiques.index');

// Affichage des détails d'une transaction
Route::get('/historiques/show/{id}', [HistoriqueController::class, 'show'])->name('historiques.show');

// Export des données
Route::get('/historiques/export', [HistoriqueController::class, 'export'])->name('historiques.export');


    
  
//});



