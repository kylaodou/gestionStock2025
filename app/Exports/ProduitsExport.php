<?php

namespace App\Exports;

// Importe la classe Produit du namespace App\Models pour pouvoir l'utiliser dans ce fichier
use App\Models\Produit;

// Importe l'interface FromQuery du namespace Maatwebsite\Excel\Concerns, utilisée pour exporter des données basées sur une requête
use Maatwebsite\Excel\Concerns\FromQuery;

// Importe l'interface WithHeadings du namespace Maatwebsite\Excel\Concerns, utilisée pour définir les en-têtes des colonnes dans le fichier Excel
use Maatwebsite\Excel\Concerns\WithHeadings;

// Importe l'interface WithMapping du namespace Maatwebsite\Excel\Concerns, utilisée pour mapper les données exportées
use Maatwebsite\Excel\Concerns\WithMapping;

// Importe le trait Exportable du namespace Maatwebsite\Excel\Concerns, qui rend cette classe exportable
use Maatwebsite\Excel\Concerns\Exportable;

// Définition de la classe ProduitsExport
class ProduitsExport implements FromQuery, WithHeadings, WithMapping
{
    // Utilisation du trait Exportable pour rendre cette classe exportable
    use Exportable;

    // Méthode query() qui retourne une requête pour récupérer les produits avec leurs relations
    public function query()
    {
        return Produit::query()->with('utilisateur', 'fournisseurs');
    }

    // Méthode headings() qui définit les en-têtes des colonnes du fichier Excel
    public function headings(): array
    {
        return ['ID du produit', 'Nom du produit', 'Description', 'Fournisseur', 'Stock', 'Créé par', 'Créé le', 'Mise à jour le'];
    }

    // Méthode map() qui mappe chaque produit à un tableau représentant une ligne du fichier Excel
    public function map($produit): array
    {
        // Récupérer les noms des fournisseurs et les concaténer en une seule chaîne séparée par des virgules
        $nomsFournisseurs = $produit->fournisseurs->pluck('nom_fournisseur')->join(', ');

        return [
            $produit->id,
            $produit->nom_produit,
            $produit->description,
            $nomsFournisseurs, // Utiliser la chaîne de noms de fournisseurs
            $produit->stock == 0 ? '0' : $produit->stock,
            $produit->utilisateur ? $produit->utilisateur->nom . ' ' . $produit->utilisateur->prenom : 'N/A',
            $produit->created_at->format('d/m/Y H:i:s'),
            $produit->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
