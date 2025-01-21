<?php

namespace App\Http\Controllers;

// Importation des modèles et des classes nécessaires
use App\Models\Utilisateur; // Importe le modèle Utilisateur pour interagir avec la table des utilisateurs
use Illuminate\Database\QueryException; // Importe l'exception QueryException pour gérer les exceptions liées aux requêtes SQL
use Illuminate\Support\Facades\Hash; // Importe la classe Hash pour utiliser les fonctionnalités de hachage de Laravel

class UsersController extends Controller
{
    // Affiche la page d'accueil
    public function home()
    {
        $pageTitle = 'Acceuil'; // Titre de la page
        return view('home', compact('pageTitle')); // Retourne la vue avec le titre
    }

    // Affiche la liste des utilisateurs
    public function read()
    {
        $users = Utilisateur::orderBy('created_at', 'desc')->get(); // Récupère tous les utilisateurs par ordre décroissant de création
        $pageTitle = 'Liste des utilisateurs'; // Titre de la page
        return view('pages.listeutilisateur', compact('users', 'pageTitle')); // Retourne la vue avec la liste des utilisateurs et le titre
    }

    // Supprime un utilisateur
    public function delete($id)
    {
        try {
            $user = Utilisateur::findOrFail($id); // Trouve l'utilisateur par son ID
            $user->delete(); // Supprime l'utilisateur
            return redirect('/liste_utilisateur')->with('status', 'Utilisateur supprimé avec succès.'); // Redirige avec un message de succès
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect('/liste_utilisateur')->with('error', 'Cet utilisateur ne peut pas être supprimé car il a des relations associées.'); // Redirige avec un message d'erreur
            }
        }
    }

    // Modifie les informations d'un utilisateur
    public function modifier()
    {
        request()->validate([
            'nom' => ['required'],
            'prenom' => ['required'],
            'email' => ['required', 'email', 'unique:utilisateurs,email,' . request()->id . ',id', 'ends_with:@gmail.com'],
            'password' => ['required', 'min:8'],
        ]);
        $user = Utilisateur::find(request()->id); // Trouve l'utilisateur par son ID
        if (Hash::check(request()->password, $user->password)) {
            // Vérifie si le mot de passe correspond
            $user->nom = request()->nom; // Met à jour le nom de l'utilisateur
            $user->prenom = request()->prenom; // Met à jour le prénom de l'utilisateur
            $user->email = request()->email; // Met à jour l'email de l'utilisateur
            $user->update(); // Enregistre les modifications
            return redirect('/liste_utilisateur')->with('status', 'modifier'); // Redirige avec un message de succès
        } else {
            return redirect()
                ->back()
                ->withErrors(['password' => '*Le mot de passe est incorrect.'])
                ->withInput(); // Redirige avec un message d'erreur si le mot de passe est incorrect
        }
    }

    // Affiche le formulaire d'ajout d'un utilisateur
    public function formulaire()
    {
        $pageTitle = 'Ajouter un utilisateur'; // Titre de la page
        return view('pages.ajoututilisateur', compact('pageTitle')); // Retourne la vue avec le titre
    }

    // Traite l'ajout d'un utilisateur
    public function traitement()
    {
        request()->validate([
            'nom' => ['required'],
            'prenom' => ['required'],
            'email' => ['required', 'email', 'unique:utilisateurs'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
        ]);
        $user = new Utilisateur(); // Crée une nouvelle instance d'utilisateur
        $user->nom = request()->nom; // Récupère le nom de l'utilisateur depuis le formulaire
        $user->prenom = request()->prenom; // Récupère le prénom de l'utilisateur depuis le formulaire
        $user->email = request()->email; // Récupère l'email de l'utilisateur depuis le formulaire
        $user->password = bcrypt(request()->password); // Hache le mot de passe de l'utilisateur
        $user->save(); // Enregistre l'utilisateur dans la base de données
        return redirect('/inscription')->with('status', 'reussi'); // Redirige avec un message de succès
    }
}
