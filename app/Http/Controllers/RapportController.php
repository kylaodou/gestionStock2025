<?php

namespace App\Http\Controllers;

// Importation des classes nécessaires
use App\Exports\CommandesExport; // Importe la classe CommandesExport pour exporter les commandes
use App\Exports\ProduitsExport; // Importe la classe ProduitsExport pour exporter les produits
use App\Exports\FournisseursExport; // Importe la classe FournisseursExport pour exporter les fournisseurs
use App\Exports\LivraisonsExport; // Importe la classe LivraisonsExport pour exporter les livraisons
use App\Exports\UtilisateursExport; // Importe la classe UtilisateursExport pour exporter les utilisateurs
use App\Models\Fournisseur; // Importe le modèle Fournisseur pour interagir avec la table des fournisseurs
use Maatwebsite\Excel\Facades\Excel; // Importe la facade Excel pour utiliser les fonctionnalités d'exportation Excel
use Barryvdh\DomPDF\Facade\PDF; // Importe la facade PDF pour utiliser les fonctionnalités de génération de PDF
use App\Models\Produit; // Importe le modèle Produit pour interagir avec la table des produits
use App\Models\Commande; // Importe le modèle Commande pour interagir avec la table des commandes
use App\Models\Utilisateur; // Importe le modèle Utilisateur pour interagir avec la table des utilisateurs
use Illuminate\Http\Request; // Importe la classe Request pour gérer les requêtes HTTP

class RapportController extends Controller
{
    // Méthode pour afficher la page des rapports
    public function read()
    {
        $pageTitle = 'Rapports'; // Titre de la page
        return view('pages.rapports', compact('pageTitle')); // Renvoie la vue avec le titre
    }

    // Méthode pour exporter les produits au format Excel
    public function exportproduits()
    {
        return Excel::download(new ProduitsExport(), 'produits.xlsx'); // Télécharge le fichier Excel des produits
    }

    // Méthode pour exporter les fournisseurs au format Excel
    public function exportfournisseurs()
    {
        return Excel::download(new FournisseursExport(), 'fournisseurs.xlsx'); // Télécharge le fichier Excel des fournisseurs
    }

    // Méthode pour exporter les commandes au format Excel
    public function exportcommandes()
    {
        return Excel::download(new CommandesExport(), 'commandes.xlsx'); // Télécharge le fichier Excel des commandes
    }

    // Méthode pour exporter les utilisateurs au format Excel
    public function exportutilisateurs()
    {
        return Excel::download(new UtilisateursExport(), 'utilisateurs.xlsx'); // Télécharge le fichier Excel des utilisateurs
    }

    // Méthode pour exporter les livraisons au format Excel
    public function exportlivraisons()
    {
        return Excel::download(new LivraisonsExport(), 'livraisons.xlsx'); // Télécharge le fichier Excel des livraisons
    }

    // Méthode pour exporter les produits au format PDF
    public function exportProduitsToPDF()
    {
        $produits = Produit::with('utilisateur', 'fournisseurs')->get(); // Récupère tous les produits avec leurs informations associées

        $pdf = PDF::loadView('pages.pdfproduit', compact('produits')); // Charge la vue PDF avec les produits

        // Pour télécharger le PDF généré
        return $pdf->download('produits.pdf'); // Télécharge le fichier PDF des produits
    }

    // Méthode pour exporter les fournisseurs au format PDF
    public function exportFournisseursToPDF()
    {
        $fournisseurs = Fournisseur::with('utilisateur', 'produits')->get(); // Récupère tous les fournisseurs avec leurs informations associées

        $pdf = PDF::loadView('pages.pdffournisseur', compact('fournisseurs')); // Charge la vue PDF avec les fournisseurs

        // Pour télécharger le PDF généré
        return $pdf->download('fournisseurs.pdf'); // Télécharge le fichier PDF des fournisseurs
    }

    // Méthode pour exporter les commandes au format PDF
    public function exportCommandesToPDF()
    {
        $commandes = Commande::with('utilisateur', 'produits', 'fournisseurs')->get(); // Récupère toutes les commandes avec leurs informations associées

        $pdf = PDF::loadView('pages.pdfcommande', compact('commandes')); // Charge la vue PDF avec les commandes

        // Pour télécharger le PDF généré
        return $pdf->download('commandes.pdf'); // Télécharge le fichier PDF des commandes
    }

    // Méthode pour exporter les utilisateurs au format PDF
    public function exportUtilisateursToPDF()
    {
        $utilisateurs = Utilisateur::get(); // Récupère tous les utilisateurs

        $pdf = PDF::loadView('pages.pdfutilisateur', compact('utilisateurs')); // Charge la vue PDF avec les utilisateurs

        // Pour télécharger le PDF généré
        return $pdf->download('utilisateurs.pdf'); // Télécharge le fichier PDF des utilisateurs
    }

    // Méthode pour exporter les livraisons au format PDF
    public function exportLivraisonsToPDF()
    {
        $commandes = Commande::with('historiqueCommandes', 'produits')->get(); // Récupère toutes les commandes avec leurs historiques de livraison et les produits associés

        $pdf = PDF::loadView('pages.pdflivraison', compact('commandes')); // Charge la vue PDF avec les livraisons

        // Pour télécharger le PDF généré
        return $pdf->download('livraisons.pdf'); // Télécharge le fichier PDF des livraisons
    }
}
