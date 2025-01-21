<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importation du trait HasFactory pour la création de fabriques de modèles
use Illuminate\Database\Eloquent\Model; // Importation de la classe Model pour la définition du modèle
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importation de la relation BelongsTo pour définir les relations de clé étrangère
use Illuminate\Database\Eloquent\Relations\HasMany; // Importation de la relation HasMany pour définir une relation "un à plusieurs"
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Importation de la relation BelongsToMany pour définir une relation "plusieurs à plusieurs"

class Fournisseur extends Model
{
    use HasFactory; // Utilisation du trait HasFactory

    // Les champs remplissables de la table
    protected $fillable = [
        'nom_fournisseur', // Champ nom_fournisseur remplissable
        'adresse_fournisseur', // Champ adresse_fournisseur remplissable
        'email', // Champ email remplissable
        'created_by', // Champ created_by remplissable
    ];

    // Relation avec l'utilisateur qui a créé le fournisseur
    public function connexion(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'created_by'); // Relation de type "belongsTo" avec la classe Utilisateur, sur la clé étrangère created_by
    }

    // Relation avec les commandes associées au fournisseur
    public function commande(): HasMany
    {
        return $this->hasMany(Commande::class); // Relation de type "hasMany" avec la classe Commande
    }

    // Relation avec les produits fournis par le fournisseur
    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class, 'fournisseur_produit', 'fournisseur_id', 'produit_id'); // Relation de type "belongsToMany" avec la classe Produit, via la table de liaison fournisseur_produit, avec les clés étrangères fournisseur_id et produit_id
    }
}
