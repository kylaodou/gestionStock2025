<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport de produits</title>
    <style>
        @page {
            size: A4 landscape;
            /* Changer l'orientation en paysage */
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 16px;
            /* Augmenter la taille de la police */
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            /* Centrer le contenu */
            vertical-align: middle;
            /* Centrer verticalement */
            overflow: hidden;
            white-space: normal;
            /* Permettre au texte de revenir à la ligne */
            word-wrap: break-word;
            /* Permettre la césure des mots */
        }

        th {
            background-color: #d65479;
            color: white;
        }

        td {
            background-color: #ece2e5;
        }

        img {
            width: auto;
            /* Ajuster la taille des images */
            max-width: 100px;
            /* Limiter la largeur maximale de l'image */
            height: auto;
            display: block;
            /* Centrer l'image dans la cellule */
            margin: 0 auto;
        }

        /* Ajouter des styles pour les listes dans les cellules de la table */
        ul {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        li {
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>
    <div class="content_mai">
        <div class="userlist">
            <h2>Rapport livraison</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Produit</th>
                        <th>Quantité Reçu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commandes as $commande)
                        @foreach ($commande->historiqueCommandes as $historique)
                            <tr>
                                <td>{{ $historique->created_at->format('d/m/Y') }}</td>
                                <td>{{ $commande->produits->nom_produit }}</td>
                                <td>{{ $historique->quantite }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
