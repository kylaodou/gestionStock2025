# Gestion de stock

Application web de gestion de stock : produits, fournisseurs, commandes et livraisons, avec
rapports et exports Excel / PDF.

Une copie de ce projet préparée pour le déploiement sur Heroku se trouve dans
[`sgsHeroku`](https://github.com/kylaodou/sgsHeroku).

## Fonctionnalités

- Inscription, connexion et déconnexion des utilisateurs.
- **Produits** : ajout, liste, modification, suppression.
- **Fournisseurs** : ajout, liste, modification, suppression.
- **Commandes** : saisie d'une commande de plusieurs produits (informations du produit chargées
  automatiquement), liste, modification par lot, suppression, historique.
- **Utilisateurs** : liste, modification, suppression.
- **Rapport** de synthèse sur le tableau de bord.
- **Exports** Excel et PDF des produits, fournisseurs, commandes, utilisateurs et livraisons.

## Stack technique

- PHP 8.2+, Laravel 12
- MySQL
- maatwebsite/excel (Excel), barryvdh/laravel-dompdf (PDF)
- Bootstrap, Font Awesome

## Prérequis

- PHP 8.2+ avec les extensions `pdo_mysql`, `gd`, `zip`
- Composer 2
- MySQL 8 (ou MariaDB)

## Installation

```bash
git clone https://github.com/kylaodou/gestionStock2025.git
cd gestionStock2025

composer install
cp .env.example .env
php artisan key:generate
```

Créez une base de données MySQL et renseignez-la dans `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_stock
DB_USERNAME=root
DB_PASSWORD=
```

Ajoutez aussi le premier utilisateur dans `.env` :

```env
ADMIN_NOM=Ouedraogo
ADMIN_PRENOM=Awa
ADMIN_EMAIL=admin@gmail.com
ADMIN_PASSWORD=un-mot-de-passe-solide
```

Puis créez les tables et ce compte :

```bash
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

L'application est disponible sur http://localhost:8000. Les autres comptes s'ajoutent ensuite depuis l'application,
par un utilisateur connecté : la création de compte n'est pas ouverte au public.

## Tests

```bash
php artisan test
```

## Auteur

[@kylaodou](https://github.com/kylaodou)
