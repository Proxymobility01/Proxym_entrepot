<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $entrepot = session('entrepot');  // Récupère l'objet agence stocké dans la session

        // Vérifiez si l'agence existe dans la session avant de l'utiliser
        if (!$entrepot) {
            return redirect()->route('login')->withErrors('L\'entrepot n\'est pas authentifiée');
        }


        // Passer la variable à la vue
        return view('layouts.app', compact('entrepot'));
    }
}
