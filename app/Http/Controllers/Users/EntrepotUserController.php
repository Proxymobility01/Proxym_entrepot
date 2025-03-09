<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\UsersEntrepot; // Modèle pour les utilisateur de l'agence
use App\Models\Agence; // Modèle Agence
use App\Models\RoleEntite; // Modèle RoleEntite
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  // Gardez cet import ici
use Illuminate\Support\Str;        // Déplacez cet import ici

class EntrepotUserController extends Controller
{
     /**
     * Affiche la vue des utilisateurs swap avec la liste des agents et le formulaire d'ajout.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Vérifiez si l'agence est présente dans la session
        $entrepot = session('entrepot');  // Récupère l'objet agence stocké dans la session

        // Vérifiez si l'agence existe dans la session avant de l'utiliser
        if (!$entrepot) {
            return redirect()->route('login')->withErrors('L\'entrepot n\'est pas authentifiée');
        }

        // Récupérer les agents swap associés à l'agence authentifiée
           // Récupérer les agents avec leurs rôles et email
        $agents = UsersEntrepot::with('role')->where('id_entrepot', $entrepot->id)->get();

        // Récupérer les rôles de la table role_entites
         $roles = RoleEntite::all();

        // Retourner la vue avec les agents et les informations de l'agence
        return view('users.entrepot_users', compact('agents', 'entrepot','roles')); 
    }

    /**
     * Enregistrer un nouvel agent swap.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email', // Validation de l'email
            'ville' => 'required|string|max:255',
            'quartier' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8048',
            'password' => 'required|string|min:6|confirmed',
            'id_role_entite' => 'required|exists:role_entites,id', // Validation du rôle
        ]);
    
        // Gérer l'upload de la photo (si présente)
        if ($request->hasFile('photo')) {
            // Upload de la photo et stockage
            $validatedData['photo'] = $request->file('photo')->store('agents_swap_photos');
        }
    
        // Générer le user_agence_unique_id avec le format souhaité
        $anneemois = now()->format('Ym'); // Année et mois actuel, format "202501"
        $validatedData['users_entrepot_unique_id'] = 'ENU-' . $anneemois . '-' . Str::random(4); // Génération de l'ID
    
        // Ajouter un nouvel agent swap avec l'agence associée
        $entrepot = session('entrepot');
        $validatedData['id_entrepot'] = $entrepot->id; // Associer l'agent swap à l'agence de la session

          // Hasher le mot de passe
          $validatedData['password'] = Hash::make($validatedData['password']);
    
        // Créer l'agent swap dans la base de données
        UsersEntrepot::create($validatedData);
    
        // Rediriger avec un message de succès
        return redirect()->route('entrepot.users')->with('success', 'Agent swap ajouté avec succès.');
    }
    

    /**
     * Supprime un agent swap.
     *
     * @param \App\Models\SwapUser $swapUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Users_entrepots $entrepotUser)
    {
        // Supprimer l'agent swap
        $entrepotUser->delete();

        return redirect()->route('agence.users.index')->with('success', 'Agent swap supprimé avec succès.');
    }
}
