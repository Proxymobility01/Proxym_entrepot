<?php

namespace App\Http\Controllers\Historiques;

use App\Models\HistoriqueEntrepot;
use App\Models\Distributeur;
use App\Models\UsersEntrepot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HistoriqueController extends Controller 
{
    /**
     * Affiche la liste des transactions avec filtres
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request) 
    {
        try {
            // Vérifier si l'entrepôt est présent dans la session
            $entrepot = session('entrepot');
            
            // Récupérer l'ID de l'entrepôt à partir de la session
            $entrepotId = $entrepot ? $entrepot->id : null;
            
            // Vérifier si l'entrepôt existe avant de récupérer l'historique
            if (!$entrepotId) {
                if ($request->ajax() || $request->has('ajax')) {
                    return response()->json(['error' => 'Non authentifié'], 401);
                }
                return redirect()->route('login')->withErrors('L\'entrepôt n\'est pas authentifié');
            }
            
            // Paramètres de filtrage et pagination
            $perPage = $request->input('per_page', 100);
            $search = $request->input('search');
            $dateDebut = $request->input('date_debut');
            $dateFin = $request->input('date_fin');
            $typeSwap = $request->input('type_swap');
            
            // Construction de la requête de base avec optimisation (eager loading)
            $query = HistoriqueEntrepot::with(['distributeur', 'userEntrepot'])
                                      ->where('id_entrepot', $entrepotId);
            
            // Appliquer les filtres si présents
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('bat_sortante', 'LIKE', "%$search%")
                      ->orWhere('bat_entrante', 'LIKE', "%$search%");
                });
            }
            
            if ($dateDebut) {
                $query->where('created_at', '>=', Carbon::parse($dateDebut)->startOfDay());
            }
            
            if ($dateFin) {
                $query->where('created_at', '<=', Carbon::parse($dateFin)->endOfDay());
            }
            
            if ($typeSwap) {
                $query->where('type_swap', $typeSwap);
            }
            
            // Récupérer l'historique des transactions, trié par date décroissante
            $historique = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            // Traiter chaque transaction pour formater les données
            foreach ($historique as $transaction) {
                // Vérifier si un distributeur est associé à cette transaction
                if ($transaction->id_distributeur) {
                    $transaction->user_name = $transaction->distributeur ? $transaction->distributeur->nom . ' ' . $transaction->distributeur->prenom : 'Distributeur inconnu';
                } else {
                    // Si aucun distributeur, récupérer l'utilisateur de l'entrepôt
                    $user = $transaction->userEntrepot;
                    $transaction->user_name = $user ? $user->nom . ' ' . $user->prenom : 'Utilisateur inconnu';
                }
                
                // Traitement des batteries sortantes et entrantes
                $transaction->bat_sortante = $this->decodeBatteries($transaction->bat_sortante);
                $transaction->bat_entrante = $this->decodeBatteries($transaction->bat_entrante);
                
                // Formatage de la date
                $transaction->formatted_date = Carbon::parse($transaction->date_time)->format('d/m/Y H:i');
            }
            
            // Préparer les données pour la vue
            $data = [
                'historique' => $historique,
                'entrepot' => $entrepot,
                'filters' => [
                    'search' => $search,
                    'date_debut' => $dateDebut,
                    'date_fin' => $dateFin,
                    'type_swap' => $typeSwap
                ]
            ];
            
            // Si la requête est AJAX, retourner uniquement le tableau
            if ($request->ajax() || $request->has('ajax')) {
                return view('historiques.partials.table', $data);
            }
            
            // Retourner la vue complète pour les requêtes normales
            return view('historiques.index', $data);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement de l\'historique: ' . $e->getMessage());
            
            if ($request->ajax() || $request->has('ajax')) {
                return response()->json(['error' => 'Une erreur est survenue'], 500);
            }
            
            return redirect()->back()->withErrors('Une erreur est survenue lors du chargement des données.');
        }
    }
    
    /**
     * Décode les données des batteries depuis JSON
     *
     * @param mixed $batteries
     * @return array
     */
    private function decodeBatteries($batteries)
    {
        if (empty($batteries)) {
            return [];
        }
        
        // Si c'est déjà un tableau, le retourner tel quel
        if (is_array($batteries)) {
            return $batteries;
        }
        
        // Si c'est une chaîne JSON, la décoder
        if (is_string($batteries)) {
            try {
                $decoded = json_decode($batteries, true);
                return is_array($decoded) ? $decoded : [];
            } catch (\Exception $e) {
                Log::warning('Erreur lors du décodage des batteries: ' . $e->getMessage());
                // En cas d'erreur de décodage, retourner un tableau vide
                return [];
            }
        }
        
        // Par défaut, retourner un tableau vide
        return [];
    }
    
    /**
     * Récupère les détails d'une transaction spécifique
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $entrepot = session('entrepot');
            
            if (!$entrepot) {
                return response()->json(['error' => 'Non autorisé'], 401);
            }
            
            $transaction = HistoriqueEntrepot::with(['distributeur', 'userEntrepot'])
                                          ->where('id_entrepot', $entrepot->id)
                                          ->where('id', $id)
                                          ->first();
            
            if (!$transaction) {
                return response()->json(['error' => 'Transaction non trouvée'], 404);
            }
            
            // Récupérer les informations du distributeur ou de l'utilisateur
            if ($transaction->id_distributeur && $transaction->distributeur) {
                $transaction->user_name = $transaction->distributeur->nom . ' ' . $transaction->distributeur->prenom;
            } else {
                $user = $transaction->userEntrepot;
                $transaction->user_name = $user ? $user->nom . ' ' . $user->prenom : 'Utilisateur inconnu';
            }
            
            // Décoder les batteries
            $transaction->bat_sortante = $this->decodeBatteries($transaction->bat_sortante);
            $transaction->bat_entrante = $this->decodeBatteries($transaction->bat_entrante);
            
            // Formatage de la date pour l'affichage
            $transaction->formatted_date = Carbon::parse($transaction->date_time)->format('d/m/Y H:i');
            
            return response()->json($transaction);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des détails de transaction: ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des détails'], 500);
        }
    }
    
    /**
     * Exporte l'historique en CSV
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function export(Request $request)
    {
        try {
            $entrepot = session('entrepot');
            
            if (!$entrepot) {
                return redirect()->route('login')->withErrors('L\'entrepot n\'est pas authentifié');
            }
            
            // Récupérer les mêmes paramètres de filtrage que la méthode index
            $search = $request->input('search');
            $dateDebut = $request->input('date_debut');
            $dateFin = $request->input('date_fin');
            $typeSwap = $request->input('type_swap');
            
            // Construction de la requête de base avec optimisation
            $query = HistoriqueEntrepot::with(['distributeur', 'userEntrepot'])
                                      ->where('id_entrepot', $entrepot->id);
            
            // Appliquer les filtres si présents
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('bat_sortante', 'LIKE', "%$search%")
                      ->orWhere('bat_entrante', 'LIKE', "%$search%");
                });
            }
            
            if ($dateDebut) {
                $query->where('created_at', '>=', Carbon::parse($dateDebut)->startOfDay());
            }
            
            if ($dateFin) {
                $query->where('created_at', '<=', Carbon::parse($dateFin)->endOfDay());
            }
            
            if ($typeSwap) {
                $query->where('type_swap', $typeSwap);
            }
            
            // Récupérer toutes les transactions filtrées pour l'export
            $transactions = $query->orderBy('date_time', 'desc')->get();
            
            // Nom du fichier avec date et heure
            $filename = 'historique_transactions_' . date('Y-m-d_H-i') . '.csv';
            
            // Headers pour le téléchargement
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            // Créer le CSV
            $callback = function() use ($transactions) {
                $file = fopen('php://output', 'w');
                
                // UTF-8 BOM pour Excel
                fputs($file, "\xEF\xBB\xBF");
                
                // En-têtes CSV
                fputcsv($file, [
                    'ID',
                    'Type de Swap',
                    'Batteries Sortantes',
                    'Batteries Entrantes',
                    'Distributeur/Utilisateur',
                    'Date et Heure'
                ]);
                
                // Données
                foreach ($transactions as $transaction) {
                    $batteriesSortantes = implode(', ', $this->decodeBatteries($transaction->bat_sortante));
                    $batteriesEntrantes = implode(', ', $this->decodeBatteries($transaction->bat_entrante));
                    
                    // Récupérer le nom du distributeur ou de l'utilisateur
                    $userName = '';
                    if ($transaction->id_distributeur && $transaction->distributeur) {
                        $userName = $transaction->distributeur->nom . ' ' . $transaction->distributeur->prenom;
                    } else {
                        $user = $transaction->userEntrepot;
                        $userName = $user ? $user->nom . ' ' . $user->prenom : 'Utilisateur inconnu';
                    }
                    
                    fputcsv($file, [
                        $transaction->id,
                        ucfirst($transaction->type_swap),
                        $batteriesSortantes,
                        $batteriesEntrantes,
                        $userName,
                        Carbon::parse($transaction->date_time)->format('d/m/Y H:i')
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'export: ' . $e->getMessage());
            return redirect()->back()->withErrors('Une erreur est survenue lors de l\'export des données.');
        }
    }
}