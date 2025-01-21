<?php
// app/Models/Utilisateur.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Importation de la classe Authenticatable pour l'authentification utilisateur
use Illuminate\Notifications\Notifiable; // Importation du trait Notifiable pour la gestion des notifications

class Utilisateur extends Authenticatable
{
    use Notifiable; // Utilisation du trait Notifiable

    // Les champs remplissables de la table
    protected $fillable = [
        'email', // Champ email remplissable
        'password', // Champ password remplissable
    ];

    // Les champs cachés lors de la sérialisation
    protected $hidden = [
        'password', // Champ password caché
        'remember_token', // Champ remember_token caché
    ];

    // Relation avec les produits créés par cet utilisateur
    public function produit()
    {
        return $this->hasMany(Produit::class); // Relation "hasMany" avec la classe Produit
    }

    // Relation avec les fournisseurs créés par cet utilisateur
    public function fournisseur()
    {
        return $this->hasMany(Fournisseur::class); // Relation "hasMany" avec la classe Fournisseur
    }

    // Relation avec les commandes créées par cet utilisateur
    public function commande()
    {
        return $this->hasMany(Commande::class); // Relation "hasMany" avec la classe Commande
    }
}
