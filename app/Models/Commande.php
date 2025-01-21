<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importation du trait HasFactory pour la création de fabriques de modèles
use Illuminate\Database\Eloquent\Model; // Importation de la classe Model pour la définition du modèle
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importation de la relation BelongsTo pour définir les relations de clé étrangère
use Illuminate\Database\Eloquent\Relations\HasMany; // Importation de la relation HasMany pour définir une relation "un à plusieurs"

class Commande extends Model
{
    use HasFactory; // Utilisation du trait HasFactory

    // Les champs remplissables de la table
    protected $fillable = [
        'quantite_commander', // Champ quantite_commander remplissable
        'quantite_recu', // Champ quantite_recu remplissable
        'quantite_restante', // Champ quantite_restante remplissable
        'statut', // Champ statut remplissable
        'created_by', // Champ created_by remplissable
        'fournisseur', // Champ fournisseur remplissable
        'produit', // Champ produit remplissable
        'batch', // Champ batch remplissable
    ];

    // Relation avec l'utilisateur qui a créé la commande
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'created_by'); // Relation de type "belongsTo" avec la classe Utilisateur, sur la clé étrangère created_by
    }

    // Relation avec les produits associés à la commande
    public function produits(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit'); // Relation de type "belongsTo" avec la classe Produit, sur la clé étrangère produit
    }

    // Relation avec les fournisseurs associés à la commande
    public function fournisseurs(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur'); // Relation de type "belongsTo" avec la classe Fournisseur, sur la clé étrangère fournisseur
    }

    // Relation avec l'historique des commandes associées à la commande
    public function historiqueCommandes(): HasMany
    {
        return $this->hasMany(Commande_historique::class, 'commande_id'); // Relation de type "hasMany" avec la classe Commande_historique, sur la clé étrangère commande_id
    }
}
