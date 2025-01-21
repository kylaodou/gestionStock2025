<?php

namespace App\Exports;

// Importe la classe Utilisateur du namespace App\Models pour pouvoir l'utiliser dans ce fichier
use App\Models\Utilisateur;

// Importe l'interface FromQuery du namespace Maatwebsite\Excel\Concerns, utilisée pour exporter des données basées sur une requête
use Maatwebsite\Excel\Concerns\FromQuery;

// Importe l'interface WithHeadings du namespace Maatwebsite\Excel\Concerns, utilisée pour définir les en-têtes des colonnes dans le fichier Excel
use Maatwebsite\Excel\Concerns\WithHeadings;

// Importe l'interface WithMapping du namespace Maatwebsite\Excel\Concerns, utilisée pour mapper les données exportées
use Maatwebsite\Excel\Concerns\WithMapping;

// Importe le trait Exportable du namespace Maatwebsite\Excel\Concerns, qui rend cette classe exportable
use Maatwebsite\Excel\Concerns\Exportable;

// Définition de la classe UtilisateursExport
class UtilisateursExport implements FromQuery, WithHeadings, WithMapping
{
    // Utilisation du trait Exportable pour rendre cette classe exportable
    use Exportable;

    // Méthode query() qui retourne une requête pour récupérer les utilisateurs
    public function query()
    {
        return Utilisateur::query();
    }

    // Méthode headings() qui définit les en-têtes des colonnes du fichier Excel
    public function headings(): array
    {
        return ['ID utilisateur', 'Nom', 'Prénom', 'Email', 'Créé le', 'Mise à jour le'];
    }

    // Méthode map() qui mappe chaque utilisateur à un tableau représentant une ligne du fichier Excel
    public function map($utilisateur): array
    {
        return [$utilisateur->id, $utilisateur->nom, $utilisateur->prenom, $utilisateur->email, $utilisateur->created_at->format('d/m/Y H:i:s'), $utilisateur->updated_at->format('d/m/Y H:i:s')];
    }
}
