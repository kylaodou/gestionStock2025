<?php

namespace App\Exports;

// Importation de la classe Fournisseur du namespace App\Models afin de pouvoir l'utiliser dans ce fichier
use App\Models\Fournisseur;

// Importation du trait FromQuery de la bibliothèque Maatwebsite Excel, qui permet d'exporter des données basées sur une requête
use Maatwebsite\Excel\Concerns\FromQuery;

// Importation du trait WithHeadings de la bibliothèque Maatwebsite Excel, qui permet de définir les en-têtes des colonnes dans le fichier Excel
use Maatwebsite\Excel\Concerns\WithHeadings;

// Importation du trait WithMapping de la bibliothèque Maatwebsite Excel, qui permet de mapper les données exportées
use Maatwebsite\Excel\Concerns\WithMapping;

// Importation du trait Exportable de la bibliothèque Maatwebsite Excel, qui rend cette classe exportable
use Maatwebsite\Excel\Concerns\Exportable;

// Définition de la classe FournisseursExport
class FournisseursExport implements FromQuery, WithHeadings, WithMapping
{
    // Utilisation du trait Exportable pour rendre cette classe exportable
    use Exportable;

    // Méthode query() qui retourne une requête pour récupérer les fournisseurs avec leurs relations
    public function query()
    {
        return Fournisseur::query()->with('utilisateur', 'produits');
    }

    // Méthode headings() qui définit les en-têtes des colonnes du fichier Excel
    public function headings(): array
    {
        return ['ID fournisseur', 'Nom fournisseur', 'Produit', 'Adresse fournisseur', 'Email', 'Créé par', 'Créé le', 'Mise à jour le'];
    }

    // Méthode map() qui mappe chaque fournisseur à un tableau représentant une ligne du fichier Excel
    public function map($fournisseur): array
    {
        // Concaténation des noms des produits du fournisseur en une chaîne séparée par des virgules
        $nomsProduits = $fournisseur->produits->pluck('nom_produit')->join(', ');

        return [$fournisseur->id, $fournisseur->nom_fournisseur, $nomsProduits, $fournisseur->adresse_fournisseur, $fournisseur->email, $fournisseur->utilisateur ? $fournisseur->utilisateur->nom . ' ' . $fournisseur->utilisateur->prenom : 'N/A', $fournisseur->created_at->format('d/m/Y H:i:s'), $fournisseur->updated_at->format('d/m/Y H:i:s')];
    }
}
