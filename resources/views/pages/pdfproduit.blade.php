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
            <h2>Rapport produits</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Fournisseur</th>
                        <th>Stock</th>
                        <th>Crée par</th>
                        <th>Crée le</th>
                        <th>Mis à jour</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                        <tr>
                            <td>{{ $produit->id }}</td>
                            <td>
                                @if (file_exists(public_path('storage/img/' . $produit->image)))
                                    <img class="imgproduct" src="{{ public_path('storage/img/' . $produit->image) }}"
                                        alt="Image du produit">
                                @else
                                    <span>Image not found</span>
                                @endif

                            </td>
                            <td>{{ $produit->nom_produit }}</td>
                            <td>{{ $produit->description }}</td>
                            <td>
                                <ul>
                                    @foreach ($produit->fournisseurs as $fournisseur)
                                        <li class="list_prfr">{{ $fournisseur->nom_fournisseur }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $produit->stock }}</td>
                            <td>{{ optional($produit->utilisateur)->nom }} {{ optional($produit->utilisateur)->prenom }}
                            </td>
                            <td>{{ $produit->created_at->format('d M Y à H:i:s') }}</td>
                            <td>{{ $produit->updated_at->format('d M Y à H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
