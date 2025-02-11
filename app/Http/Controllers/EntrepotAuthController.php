<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\Entrepot;


class EntrepotAuthController extends Controller
{
    
    /**
     * Authentifier l'entrepôt avec son `entrepot_unique_id` et mot de passe.
     */
    public function authenticate(Request $request)
    {
        // Validation des entrées
        $validated = $request->validate([
            'entrepot_unique_id' => 'required|string|exists:entrepots,entrepot_unique_id', // L'ID unique de l'entrepôt
            'password' => 'required|string',  // Le mot de passe de l'entrepôt
        ]);

        // Recherche de l'entrepôt par son `entrepot_unique_id`
        $entrepot = Entrepot::where('entrepot_unique_id', $request->entrepot_unique_id)->first();

        // Vérification du mot de passe
        if ($entrepot && Hash::check($request->password, $entrepot->password)) {
            // Authentification réussie, stocker l'entrepôt dans la session
            session(['entrepot' => $entrepot]);  // Sauvegarder l'entrepôt dans la session

            // Générer un jeton d'authentification (si nécessaire)
            $token = \Str::random(60);  // Exemple de jeton unique
            session(['auth_token' => $token]);  // Sauvegarder le jeton dans la session

            // Rediriger vers la page d'accueil
            return redirect()->route('dashboard');  // Vous pouvez changer la redirection selon vos besoins
        }

        // Si les identifiants sont incorrects
        return response()->json(['message' => 'Identifiants incorrects'], 401);
    }

    /**
     * Déconnexion de l'entrepôt.
     */
    public function logout()
    {
        // Supprimer les informations de session de l'entrepôt
        session()->forget('entrepot');  // Effacer l'entrepôt de la session
        session()->forget('auth_token');  // Effacer le token d'authentification

        // Rediriger vers la page de connexion
        return redirect()->route('login');
    }

}
