<?php

namespace App\Http\Controllers; // Définit l'espace de noms du contrôleur

use App\Models\Commande; // Importe le modèle de la commande
use App\Models\Commande_historique; // Importe le modèle de l'historique de commande
use App\Models\Fournisseur; // Importe le modèle du fournisseur
use Illuminate\Http\Request; // Importe la classe Request pour gérer les requêtes HTTP
use Illuminate\Support\Facades\Auth; // Importe la classe Auth pour gérer l'authentification

class DashboardController extends Controller // Définit la classe du contrôleur
{
    public function dashboardUsers()
    {
        // Définit la méthode pour afficher le tableau de bord des utilisateurs
        if (Auth::check()) {
            // Vérifie si l'utilisateur est connecté
            // Tableau des différents statuts de commande
            $statuses = ['En attente', 'Incomplet', 'Complet'];
            $results = []; // Initialise le tableau pour stocker les résultats
            $color = ['#FF0000', '#FFA500', '#00FF00']; // Couleurs pour les graphiques
            $counteur = 0; // Compteur pour l'index des couleurs

            // Boucle à travers chaque statut et récupère le nombre de commandes correspondantes
            foreach ($statuses as $status) {
                $count = Commande::where('statut', $status)->count(); // Nombre de commandes pour chaque statut
                $colore = $color[$counteur % count($color)]; // Sélectionne une couleur
                $results[] = [
                    // Ajoute les données au tableau de résultats
                    'name' => strtoupper($status), // Convertit le nom du statut en majuscules
                    'y' => $count, // Nombre de commandes pour ce statut
                    'color' => $colore, // Couleur associée à ce statut
                ];
                $counteur++; // Incrémente le compteur
            }

            // Tableau pour stocker les noms des fournisseurs et le nombre de produits associés
            $categories = [];
            $barChartData = [];
            $colors = ['#FF0000', '#0000FF', '#ADD8E6', '#800080', '#00FF00', '#FF00FF', '#FFA500', '#800000'];
            $counter = 0;

            // Récupère tous les fournisseurs avec le nombre de produits associés
            $suppliers = Fournisseur::withCount('produits')->get();

            // Boucle à travers chaque fournisseur et récupère le nombre de produits associés
            foreach ($suppliers as $supplier) {
                $categories[] = $supplier->nom_fournisseur; // Ajoute le nom du fournisseur au tableau des catégories

                // Utilise le compteur pour boucler sur les couleurs
                $color = $colors[$counter % count($colors)];

                $barChartData[] = [
                    // Ajoute les données au tableau pour le graphique à barres
                    'y' => $supplier->produits_count, // Nombre de produits associés à ce fournisseur
                    'color' => $color, // Couleur associée à ce fournisseur
                ];

                $counter++; // Incrémente le compteur
            }

            // Récupère l'historique des commandes de produits et les trie par date
            $orderProductHistories = Commande_historique::orderBy('created_at', 'asc')->get();

            // Traite les données pour le graphique en ligne
            $lineData = [];
            foreach ($orderProductHistories as $history) {
                $key = $history->created_at->format('Y-m-d');
                if (!isset($lineData[$key])) {
                    $lineData[$key] = 0;
                }
                $lineData[$key] += (int) $history->quantite; // Incrémente la quantité pour chaque date
            }

            $lineCategories = array_keys($lineData); // Récupère les clés comme catégories
            $lineData = array_values($lineData); // Récupère les valeurs comme données

            $pageTitle = 'Tableau de bord'; // Titre de la page

            // Retourne les données à une vue pour affichage
            return view('pages.dashboard', compact('results', 'barChartData', 'categories', 'lineCategories', 'lineData', 'pageTitle'));
        } else {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            return redirect('/connexion')->with('email', 'Vous devez être connecté pour accéder au tableau de bord');
        }
    }
}
