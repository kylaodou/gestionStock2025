<?php

namespace App\Http\Controllers; // Espace de noms du contrôleur

use Illuminate\Support\Facades\DB; // Facade pour accéder à la base de données

use App\Models\Fournisseur; // Importation du modèle Fournisseur
use Illuminate\Http\Request; // Importation de la classe Request
use App\Models\Produit; // Importation du modèle Produit
use Illuminate\Support\Facades\Auth; // Facade pour gérer l'authentification
use Illuminate\Database\QueryException; // Exception pour les erreurs de requête SQL

class ProduitController extends Controller // Déclaration de la classe du contrôleur
{
    public function formulaire()
    {
        // Méthode pour afficher le formulaire d'ajout de produit
        $fournisseurs = Fournisseur::all(); // Récupère tous les fournisseurs
        $pageTitle = 'Ajouter un produit'; // Titre de la page
        return view('pages.ajoutproduit', compact('fournisseurs', 'pageTitle')); // Renvoie la vue du formulaire avec les fournisseurs et le titre
    }

    public function traitement(Request $request)
    {
        // Méthode pour traiter les données du formulaire d'ajout de produit
        if (Auth::check()) {
            // Vérifie si l'utilisateur est connecté
            $request->validate([
                // Validation des données du formulaire
                'nom_produit' => ['required', 'unique:produits'], // Champ nom_produit requis et unique dans la table produits
                'description' => ['required'], // Champ description requis
                'image' => ['required'], // Champ image requis
                'fournisseur_id' => ['required', 'array'], // Champ fournisseur_id requis et doit être un tableau
                'fournisseur_id.*' => ['exists:fournisseurs,id'], // Chaque élément de fournisseur_id doit exister dans la table fournisseurs
            ]);

            DB::transaction(function () {
                // Débute une transaction
                $produit = new Produit(); // Instanciation d'un nouveau produit
                $produit->nom_produit = request()->nom_produit; // Affecte le nom du produit depuis la requête
                $produit->description = request()->description; // Affecte la description du produit depuis la requête
                $imagePath = request()->file('image')->store('public/img'); // Stocke l'image dans le répertoire 'public/img' et récupère son chemin
                $produit->image = basename($imagePath); // Affecte le nom de l'image (sans le chemin) au produit
                $produit->stock = 0; // Initialise le stock à zéro
                $produit->created_by = auth()->id(); // Affecte l'ID de l'utilisateur connecté comme créateur du produit
                $produit->save(); // Enregistre le produit dans la base de données
                $produit->fournisseurs()->sync(request()->fournisseur_id); // Associe les fournisseurs sélectionnés au produit
            });

            return redirect('/ajout_produit')->with('status', 'reussi'); // Redirige avec un message de succès
        } else {
            return redirect('/connexion')->with('error', 'Vous devez être connecté pour ajouter un produit'); // Redirige vers la page de connexion
        }
    }

    public function read()
    {
        // Méthode pour afficher la liste des produits
        $produits = Produit::with('fournisseurs')->orderBy('created_at', 'desc')->get(); // Récupère tous les produits avec leurs fournisseurs associés
        $fournisseurs = Fournisseur::all(); // Récupère tous les fournisseurs
        $pageTitle = 'Liste des produits'; // Titre de la page
        return view('pages.listeproduit', compact('produits', 'fournisseurs', 'pageTitle')); // Renvoie la vue avec les produits, les fournisseurs et le titre
    }

    public function delete($id)
    {
        // Méthode pour supprimer un produit
        try {
            $produit = Produit::findOrFail($id); // Trouve le produit par son ID
            $produit->delete(); // Supprime le produit de la base de données
            return redirect('/liste_produit')->with('status', 'supprimer'); // Redirige avec un message de succès
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                // Vérifie le code d'erreur
                return redirect('/liste_produit')->with('error', 'Ce produit ne peut pas être supprimé car il a des fournisseurs associés.'); // Redirige avec un message d'erreur
            }
        }
    }

    public function modifier()
    {
        // Méthode pour modifier les informations d'un produit
        if (Auth::check()) {
            // Vérifie si l'utilisateur est connecté
            request()->validate([
                // Validation des données du formulaire de modification
                'nom_produit' => ['required', 'unique:produits,nom_produit,' . request()->id . ',id'], // Champ nom_produit requis et unique dans la table produits (sauf pour l'ID actuel)
                'description' => ['required'], // Champ description requis
                'fournisseur_id' => ['required', 'array'], // Champ fournisseur_id requis et doit être un tableau
                'fournisseur_id.*' => ['exists:fournisseurs,id'], // Chaque élément de fournisseur_id doit exister dans la table fournisseurs
            ]);

            DB::transaction(function () {
                // Débute une transaction
                $produit = Produit::find(request()->id); // Trouve le produit par son ID
                $produit->nom_produit = request()->nom_produit; // Met à jour le nom du produit
                $produit->description = request()->description; // Met à jour la description du produit
                if (request()->hasFile('image')) {
                    // Vérifie si un fichier image est envoyé
                    $imagePath = request()->file('image')->store('public/img'); // Stocke la nouvelle image dans le répertoire 'public/img' et récupère son chemin
                    $produit->image = basename($imagePath); // Met à jour le nom de l'image
                }
                $produit->update(); // Met à jour le produit dans la base de données
                $produit->fournisseurs()->sync(request()->fournisseur_id); // Met à jour les fournisseurs associés au produit
            });

            return redirect('/liste_produit')->with('status', 'modifier'); // Redirige avec un message de succès
        } else {
            return redirect('/connexion')->with('error', 'Vous devez être connecté pour ajouter un produit'); // Redirige vers la page de connexion
        }
    }
}
