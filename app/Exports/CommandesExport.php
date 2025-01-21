<?php

namespace App\Exports;

// Importation de la classe Commande du namespace App\Models afin de pouvoir l'utiliser dans ce fichier
use App\Models\Commande;

// Importation du trait FromQuery de la bibliothèque Maatwebsite Excel, qui permet d'exporter des données basées sur une requête
use Maatwebsite\Excel\Concerns\FromQuery;

// Importation du trait WithHeadings de la bibliothèque Maatwebsite Excel, qui permet de définir les en-têtes des colonnes dans le fichier Excel
use Maatwebsite\Excel\Concerns\WithHeadings;

// Importation du trait WithMapping de la bibliothèque Maatwebsite Excel, qui permet de mapper les données exportées
use Maatwebsite\Excel\Concerns\WithMapping;

// Importation du trait Exportable de la bibliothèque Maatwebsite Excel, qui rend cette classe exportable
use Maatwebsite\Excel\Concerns\Exportable;

// Définition de la classe CommandesExport
class CommandesExport implements FromQuery, WithHeadings, WithMapping
{
    // Utilisation du trait Exportable pour rendre cette classe exportable
    use Exportable;

    // Méthode query() qui retourne une requête pour récupérer les commandes avec leurs relations
    public function query()
    {
        return Commande::query()->with('utilisateur', 'produits', 'fournisseurs');
    }

    // Méthode headings() qui définit les en-têtes des colonnes du fichier Excel
    public function headings(): array
    {
        return ['ID commande', 'Fournisseur', 'Produit', 'Quantité commander', 'Quantité reçue', 'Quantité restante', 'Statut', 'Batch', 'Créé par', 'Créé le', 'Mise à jour le'];
    }

    // Méthode map() qui mappe chaque commande à un tableau représentant une ligne du fichier Excel
    public function map($commande): array
    {
        return [
            $commande->id,
            $commande->fournisseurs->nom_fournisseur,
            $commande->produits->nom_produit,
            (string) $commande->quantite_commander, // Cast en string pour s'assurer que 0 est traité comme '0'
            (string) $commande->quantite_recu,
            (string) $commande->quantite_restante,
            $commande->statut,
            $commande->batch,
            $commande->utilisateur ? $commande->utilisateur->nom . ' ' . $commande->utilisateur->prenom : 'N/A',
            $commande->created_at->format('d/m/Y H:i:s'),
            $commande->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
