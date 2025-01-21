<?php

// Définition de l'espace de noms du contrôleur ConnexionController dans l'application Laravel
namespace App\Http\Controllers;

// Importation du modèle Utilisateur pour interagir avec les données des utilisateurs dans la base de données
use App\Models\Utilisateur;

// Importation de la classe Request pour gérer les requêtes HTTP entrantes
use Illuminate\Http\Request;

// Importation de la classe Auth pour gérer l'authentification des utilisateurs
use Illuminate\Support\Facades\Auth;

// Définition du contrôleur ConnexionController
class ConnexionController extends Controller
{
    // Méthode formulaire() pour afficher le formulaire de connexion
    public function formulaire()
    {
        // Titre de la page de connexion
        $pageTitle = 'Se connecter';

        // Retourne la vue du formulaire de connexion avec le titre de la page
        return view('pages.connect', compact('pageTitle'));
    }

    // Méthode deconnexion() pour gérer la déconnexion de l'utilisateur
    public function deconnexion()
    {
        // Déconnexion de l'utilisateur actuellement authentifié
        Auth::logout();

        // Redirection vers la page d'accueil après la déconnexion
        return redirect('/');
    }

    // Méthode traitement() pour traiter la soumission du formulaire de connexion
    public function traitement(Request $request)
    {
        // Validation des données du formulaire de connexion
        $request->validate([
            // Le champ 'email' est requis et doit être une adresse email se terminant par '@gmail.com'
            'email' => ['required', 'email', 'ends_with:@gmail.com'],
            // Le champ 'password' est requis
            'password' => ['required'],
        ]);

        // Récupération des identifiants de connexion à partir de la requête
        $credentials = $request->only('email', 'password');

        // Récupération de l'email depuis la requête
        $email = $request->email;

        // Tentative d'authentification de l'utilisateur avec les identifiants fournis
        if (Auth::attempt($credentials)) {
            // Redirection vers le tableau de bord en cas de succès de l'authentification
            return redirect('/dashboard');
        }

        // Vérification si l'email existe dans la base de données des utilisateurs
        if (!Utilisateur::where('email', $email)->first()) {
            // Retour à la page précédente avec un message d'erreur si l'email n'existe pas
            return redirect()
                ->back()
                ->withErrors(['email' => '*Email inexistant.']) // Message d'erreur
                ->withInput(); // Remplissage des champs du formulaire avec les données précédemment saisies
        } else {
            // L'email existe, mais l'authentification a échoué en raison d'un mot de passe incorrect
            // Retour à la page précédente avec un message d'erreur indiquant que le mot de passe est incorrect
            return redirect()
                ->back()
                ->withErrors(['password' => '*Le mot de passe est incorrect.']) // Message d'erreur
                ->withInput(); // Remplissage des champs du formulaire avec les données précédemment saisies
        }
    }
}
