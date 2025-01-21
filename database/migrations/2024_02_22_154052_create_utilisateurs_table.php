<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration anonyme pour créer la table "utilisateurs"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Création de la table "utilisateurs"
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id(); // Champ ID auto-incrémenté
            $table->string('nom'); // Champ nom de type chaîne de caractères
            $table->string('prenom'); // Champ prenom de type chaîne de caractères
            $table->string('email')->unique(); // Champ email de type chaîne de caractères avec contrainte d'unicité
            $table->string('password'); // Champ password de type chaîne de caractères
            $table->timestamps(); // Champs created_at et updated_at pour les horodatages de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la table "utilisateurs" si elle existe
        Schema::dropIfExists('utilisateurs');
    }
};
