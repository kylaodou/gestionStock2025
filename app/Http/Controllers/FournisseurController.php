<?php

namespace App\Http\Controllers; // Espace de noms du contrôleur

use App\Models\Fournisseur; // Importation du modèle Fournisseur
use Illuminate\Support\Facades\Auth; // Facade pour gérer l'authentification
use Illuminate\Support\Facades\DB; // Facade pour accéder à la base de données
use Illuminate\Database\QueryException; // Exception pour les erreurs de requête SQL

class FournisseurController extends Controller // Déclaration de la classe du contrôleur
{
    public function formulaire()
    {
        // Méthode pour afficher le formulaire d'ajout de fournisseur
        $pageTitle = 'Ajouter un fournisseur'; // Titre de la page
        return view('pages.ajoutfournisseur', compact('pageTitle')); // Renvoie la vue du formulaire avec le titre
    }

    public function traitement()
    {
        // Méthode pour traiter les données du formulaire d'ajout de fournisseur
        if (Auth::check()) {
            // Vérifie si l'utilisateur est connecté
            request()->validate([
                // Validation des données du formulaire
                'nom_fournisseur' => ['required', 'unique:fournisseurs'], // Champ nom_fournisseur requis et unique dans la table fournisseurs
                'adresse_fournisseur' => ['required'], // Champ adresse_fournisseur requis
                'email' => ['required', 'unique:fournisseurs', 'ends_with:@gmail.com'], // Champ email requis, unique dans la table fournisseurs et doit se terminer par @gmail.com
                'produit_id' => ['sometimes', 'array'], // Champ produit_id facultatif et doit être un tableau
                'produit_id.*' => ['exists:produits,id'], // Chaque élément de produit_id doit exister dans la table produits
            ]);

            DB::transaction(function () {
                // Débute une transaction
                $fournisseur = new Fournisseur(); // Instanciation d'un nouveau fournisseur
                $fournisseur->nom_fournisseur = request()->nom_fournisseur; // Affecte le nom du fournisseur depuis la requête
                $fournisseur->adresse_fournisseur = request()->adresse_fournisseur; // Affecte l'adresse du fournisseur depuis la requête
                $fournisseur->email = request()->email; // Affecte l'email du fournisseur depuis la requête
                $fournisseur->created_by = auth()->id(); // Affecte l'ID de l'utilisateur connecté comme créateur du fournisseur
                $fournisseur->save(); // Enregistre le fournisseur dans la base de données
                $fournisseur->produits()->sync(request()->produit_id); // Associe les produits sélectionnés au fournisseur
            });

            return redirect('/ajout_fournisseur')->with('status', 'reussi'); // Redirige avec un message de succès
        } else {
            return redirect('/connexion')->with('email', 'Vous devez être connecté pour ajouter un produit'); // Redirige vers la page de connexion
        }
    }

    public function read()
    {
        // Méthode pour afficher la liste des fournisseurs
        $fournisseurs = Fournisseur::with('produits')->orderBy('created_at', 'desc')->get(); // Récupère tous les fournisseurs avec leurs produits associés
        $pageTitle = 'Liste des fournisseurs'; // Titre de la page
        return view('pages.listefournisseur', compact('fournisseurs', 'pageTitle')); // Renvoie la vue avec les fournisseurs et le titre
    }

    public function delete($id)
    {
        // Méthode pour supprimer un fournisseur
        try {
            $fournisseur = Fournisseur::findOrFail($id); // Trouve le fournisseur par son ID
            $fournisseur->delete(); // Supprime le fournisseur de la base de données
            return redirect('/liste_fournisseur')->with('status', 'Fournisseur supprimé avec succès.'); // Redirige avec un message de succès
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                // Vérifie le code d'erreur
                return redirect('/liste_fournisseur')->with('error', 'Ce fournisseur ne peut pas être supprimé car il a des produits associés.'); // Redirige avec un message d'erreur
            }
        }
    }

    public function modifier()
    {
        // Méthode pour modifier les informations d'un fournisseur
        if (Auth::check()) {
            // Vérifie si l'utilisateur est connecté
            request()->validate([
                // Validation des données du formulaire de modification
                'nom_fournisseur' => ['required', 'unique:fournisseurs,nom_fournisseur,' . request()->id . ',id'], // Champ nom_fournisseur requis et unique dans la table fournisseurs (sauf pour l'ID actuel)
                'adresse_fournisseur' => ['required'], // Champ adresse_fournisseur requis
                'email' => ['required', 'unique:fournisseurs,email,' . request()->id . ',id'], // Champ email requis, unique dans la table fournisseurs (sauf pour l'ID actuel)
            ]);

            $fournisseur = Fournisseur::find(request()->id); // Trouve le fournisseur par son ID
            $fournisseur->nom_fournisseur = request()->nom_fournisseur; // Met à jour le nom du fournisseur
            $fournisseur->adresse_fournisseur = request()->adresse_fournisseur; // Met à jour l'adresse du fournisseur
            $fournisseur->email = request()->email; // Met à jour l'email du fournisseur
            $fournisseur->update(); // Met à jour les informations du fournisseur dans la base de données

            return redirect('/liste_fournisseur')->with('status', 'modifier'); // Redirige avec un message de succès
        } else {
            return redirect('/connexion')->with('error', 'Vous devez être connecté pour ajouter un produit'); // Redirige vers la page de connexion
        }
    }
}
