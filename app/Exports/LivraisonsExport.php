<?php

namespace App\Exports;

// Importation de la classe Commande du namespace App\Models pour pouvoir l'utiliser dans ce fichier
use App\Models\Commande;

// Importation du trait FromQuery de la bibliothèque Maatwebsite Excel qui permet d'exporter des données basées sur une requête
use Maatwebsite\Excel\Concerns\FromQuery;

// Importation du trait WithHeadings de la bibliothèque Maatwebsite Excel qui permet de définir les en-têtes des colonnes dans le fichier Excel
use Maatwebsite\Excel\Concerns\WithHeadings;

// Importation du trait WithMapping de la bibliothèque Maatwebsite Excel qui permet de mapper les données exportées
use Maatwebsite\Excel\Concerns\WithMapping;

// Importation du trait Exportable de la bibliothèque Maatwebsite Excel qui rend cette classe exportable
use Maatwebsite\Excel\Concerns\Exportable;

class LivraisonsExport implements FromQuery, WithHeadings, WithMapping
{
    // Utilisation du trait Exportable pour permettre à cette classe d'être exportée
    use Exportable;

    public function query()
    {
        // Requête pour récupérer les données des commandes avec les relations 'historiqueCommandes' et 'produits'
        return Commande::query()->with('historiqueCommandes', 'produits');
    }

    public function headings(): array
    {
        // Définition des en-têtes des colonnes du fichier Excel
        return ['Date', 'Produit', 'Quantité reçu'];
    }

    public function map($commande): array
    {
        $rows = [];

        foreach ($commande->historiqueCommandes as $historique) {
            $productName = $commande->produits->nom_produit; // Remplacer 'produit' et 'nom_produit' par les noms de la relation et du champ réels.

            // Création des lignes de données à exporter
            $rows[] = [
                $historique->created_at->format('d/m/Y'), // Date de l'historique de la commande.
                $productName, // Nom du produit lié.
                $historique->quantite, // Quantité reçue.
            ];
        }

        // Retourne le tableau des lignes de données.
        return $rows;
    }
}
