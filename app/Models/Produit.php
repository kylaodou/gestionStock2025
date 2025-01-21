<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importation du trait HasFactory pour la création de fabriques de modèles
use Illuminate\Database\Eloquent\Model; // Importation de la classe Model pour la définition du modèle
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importation de la relation BelongsTo pour définir les relations de clé étrangère
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Importation de la relation BelongsToMany pour définir une relation "plusieurs à plusieurs"
use Illuminate\Database\Eloquent\Relations\HasMany; // Importation de la relation HasMany pour définir une relation "un à plusieurs"

class Produit extends Model
{
    use HasFactory; // Utilisation du trait HasFactory

    // Les champs remplissables de la table
    protected $fillable = [
        'nom_produit', // Champ nom_produit remplissable
        'description', // Champ description remplissable
        'image', // Champ image remplissable
        'created_by', // Champ created_by remplissable
    ];

    // Relation avec l'utilisateur qui a créé le produit
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'created_by'); // Relation de type "belongsTo" avec la classe Utilisateur, sur la clé étrangère created_by
    }

    // Relation avec les fournisseurs qui fournissent ce produit
    public function fournisseurs(): BelongsToMany
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_produit', 'produit_id', 'fournisseur_id'); // Relation de type "belongsToMany" avec la classe Fournisseur, via la table de liaison fournisseur_produit, avec les clés étrangères produit_id et fournisseur_id
    }

    // Relation avec les commandes associées à ce produit
    public function commande(): HasMany
    {
        return $this->hasMany(Commande::class, 'produit'); // Relation de type "hasMany" avec la classe Commande, sur la clé étrangère produit
    }
}
