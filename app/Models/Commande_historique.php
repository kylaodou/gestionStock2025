<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importation du trait HasFactory pour la création de fabriques de modèles
use Illuminate\Database\Eloquent\Model; // Importation de la classe Model pour la définition du modèle

class Commande_historique extends Model
{
    use HasFactory; // Utilisation du trait HasFactory

    // Les champs remplissables de la table
    protected $fillable = [
        'quantite', // Champ quantite remplissable
        'commande_id', // Champ commande_id remplissable
    ];

    // Relation avec la commande associée
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id'); // Relation de type "belongsTo" avec la classe Commande, sur la clé étrangère commande_id
    }
}
