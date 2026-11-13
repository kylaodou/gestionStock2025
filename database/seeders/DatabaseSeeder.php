<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Crée le premier utilisateur à partir des variables d'environnement
     * ADMIN_NOM, ADMIN_PRENOM, ADMIN_EMAIL et ADMIN_PASSWORD.
     * Les comptes suivants sont ajoutés depuis l'application par un utilisateur connecté.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password) {
            $this->command?->warn('ADMIN_EMAIL et ADMIN_PASSWORD ne sont pas définis : aucun utilisateur créé.');
            return;
        }

        if (Utilisateur::where('email', $email)->exists()) {
            $this->command?->info("L'utilisateur {$email} existe déjà.");
            return;
        }

        $user = new Utilisateur();
        $user->nom = env('ADMIN_NOM', 'Administrateur');
        $user->prenom = env('ADMIN_PRENOM', '');
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();

        $this->command?->info("Utilisateur {$email} créé.");
    }
}
