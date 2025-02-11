<?php

namespace App\Http\Controllers\Batteries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrepot;
use App\Models\BatteryEntrepot;
use App\Models\BatteriesValide;


class BatteryEntrepotController extends Controller
{
    // Méthode pour afficher le tableau des batteries pour l'entrepôt connecté
    public function index()
    {
        // Récupérer l'entrepôt de l'utilisateur actuellement connecté
        $entrepot = session('entrepot');; // Assurez-vous que l'utilisateur est bien lié à un entrepôt

        // Récupérer toutes les batteries associées à cet entrepôt
        $batteries = BatteryEntrepot::with('batteryValide')
            ->where('id_entrepot', $entrepot->id)
            ->get();

        // Passer les données à la vue
        return view('batteries.batterie_entrepot', compact('batteries' , 'entrepot'));
    }
}
