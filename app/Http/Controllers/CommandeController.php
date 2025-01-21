<?php

namespace App\Http\Controllers;

// Importation des modèles nécessaires pour ce contrôleur
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\Commande_historique;

// Importation de la classe Request du namespace Illuminate\Http, utilisée pour gérer les requêtes HTTP
use Illuminate\Http\Request;

// Importation de la classe Auth du namespace Illuminate\Support\Facades, utilisée pour l'authentification
use Illuminate\Support\Facades\Auth;

// Importation de la classe DB du namespace Illuminate\Support\Facades, utilisée pour interagir avec la base de données
use Illuminate\Support\Facades\DB;

// Définition du contrôleur CommandeController
class CommandeController extends Controller
{
    // Méthode formulaire() pour afficher le formulaire d'ajout de commande
    public function formulaire()
    {
        // Récupération des produits avec leurs fournisseurs
        $produits = Produit::with('fournisseurs')->get();

        // Récupération de tous les fournisseurs
        $fournisseurs = Fournisseur::all();

        // Titre de la page
        $pageTitle = 'Ajouter une commande';

        // Retourne la vue avec les données nécessaires
        return view('pages.ajoutcommande', compact('produits', 'fournisseurs', 'pageTitle'));
    }

    // Méthode getProductInfo() pour récupérer les informations sur un produit via une requête AJAX
    public function getProductInfo($id)
    {
        // Recherche du produit avec ses fournisseurs
        $produit = Produit::with('fournisseurs')->find($id);

        // Si le produit est trouvé, retourne ses informations au format JSON
        // Sinon, retourne une réponse JSON avec un message d'erreur
        if ($produit) {
            return response()->json($produit);
        } else {
            return response()->json(['error' => 'Produit non trouvé'], 404);
        }
    }

    // Méthode traitement() pour traiter la soumission du formulaire d'ajout de commande
    public function traitement(Request $request)
    {
        // Vérification de l'authentification de l'utilisateur
        if (Auth::check()) {
            // Validation des données du formulaire
            $request->validate([
                'quantite' => ['required'],
                'checkbox' => ['required', 'array'],
                'checkbox.*' => ['exists:produits,id'],
            ]);

            // Génération d'un numéro de lot basé sur le timestamp actuel
            $batch = time();

            // Début de la transaction de base de données
            DB::beginTransaction();

            // Parcours de chaque produit sélectionné dans le formulaire
            foreach ($request->input('checkbox') as $pid) {
                $supplier_qty = $request->input("quantite.{$pid}", []);
                foreach ($supplier_qty as $sid => $qty) {
                    // Vérification que la quantité commandée est supérieure à zéro
                    if ($qty > 0) {
                        // Création d'une nouvelle commande dans la base de données
                        Commande::create([
                            'fournisseur' => $sid,
                            'produit' => $pid,
                            'quantite_commander' => $qty,
                            'quantite_recu' => 0,
                            'quantite_restante' => $qty,
                            'statut' => 'En attente',
                            'batch' => $batch,
                            'created_by' => Auth::id(),
                        ]);
                    }
                }
            }

            // Validation de la transaction de base de données
            DB::commit();

            // Redirection avec un message de succès
            return redirect('/commande')->with('status', 'reussi');
        } else {
            // Redirection vers la page de connexion avec un message d'erreur
            return redirect('/connexion')->with('email', 'Vous devez être connecté pour ajouter un produit');
        }
    }

    // Méthode read() pour afficher la liste des commandes
    public function read()
    {
        // Récupération de toutes les commandes avec leur historique
        $commandes = Commande::with('historiqueCommandes')->orderBy('created_at', 'desc')->get();

        // Titre de la page
        $pageTitle = 'Liste des commandes';

        // Retourne la vue avec les données nécessaires
        return view('pages.listecommande', compact('commandes', 'pageTitle'));
    }

    // Méthode delete() pour supprimer une commande
    public function delete($id)
    {
        // Recherche de la commande à supprimer
        $commande = Commande::find($id);

        // Suppression de la commande
        $commande->delete();

        // Redirection avec un message de succès
        return redirect('/liste_commande')->with('status', 'supprimer');
    }

    // Méthode modifier() pour modifier les commandes
    public function modifier()
    {
        // Vérification de l'authentification de l'utilisateur
        if (Auth::check()) {
            // Validation des données du formulaire
            request()->validate([
                'commande.*.quantite_livre' => 'required|numeric|min:0',
                'commande.*.statut' => 'required|in:En attente,Complet,Incomplet',
            ]);

            // Récupération des données du formulaire
            $data = request()->input('commande');

            // Parcours des données de chaque commande
            foreach ($data as $id => $commandeData) {
                // Recherche de la commande
                $commande = Commande::findOrFail($id);

                // Mise à jour des quantités reçues et du statut de la commande
                $commande->quantite_recu = $commandeData['quantite_livre'] + $commande->quantite_recu;
                $commande->quantite_restante = $commande->quantite_commander - $commande->quantite_recu;
                $commande->statut = $commandeData['statut'];
                $commande->save();

                // Mise à jour du stock du produit associé à la commande
                $produit = $commande->produits;
                if ($produit) {
                    $nouveauStock = $produit->commande->sum('quantite_recu');
                    $produit->stock = $nouveauStock;
                    $produit->save();
                }

                // Enregistrement de l'historique de la commande si une quantité a été livrée
                if ($commandeData['quantite_livre'] > 0) {
                    $historique = new Commande_historique();
                    $historique->commande_id = $id;
                    $historique->quantite = $commandeData['quantite_livre'];
                    $historique->save();
                }
            }

            // Redirection avec un message de succès
            return redirect('/liste_commande')->with('status', 'modifier');
        } else {
            // Redirection vers la page de connexion avec un message d'erreur
            return redirect('/connexion')->with('email', 'Vous devez être connecté pour ajouter un produit');
        }
    }
}
