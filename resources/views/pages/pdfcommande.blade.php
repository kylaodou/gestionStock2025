<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport des fournisseurs</title>
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
            <h2>Rapport commandes</h2>
            @php $current_batch = null; @endphp
            @foreach ($commandes as $commande)
                @if ($current_batch != $commande->batch)
                    @if ($current_batch != null)
                        </table>
                    @endif
                    <h3 class="h3">Batch: {{ $commande->batch }}</h3>
                    @php $current_batch = $commande->batch; @endphp
                    <div class="userlist">
                        <table>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fournisseur</th>
                                    <th>Produit</th>
                                    <th>Quantité Commandée</th>
                                    <th>Quantité Reçue</th>
                                    <th>Statut</th>
                                    <th>Créé par</th>
                                    <th>Crée le</th>
                                    <th>Mise à Jour</th>
                                </tr>
                            </thead>
                            <tbody>
                @endif
                <tr>
                    <td>{{ $commande->id }}</td>
                    <td>{{ $commande->fournisseurs->nom_fournisseur }}</td>
                    <td>{{ $commande->produits->nom_produit }}</td>
                    <td>{{ $commande->quantite_commander }}</td>
                    <td>{{ $commande->quantite_recu }}</td>
                    <td>{{ $commande->statut }}</td>
                    <td>{{ $commande->utilisateur->nom }}
                        {{ $commande->utilisateur->prenom }}</td>
                    <td>{{ $commande->created_at->format('d M Y à H:i:s') }}</td>
                    <td>{{ $commande->updated_at->format('d M Y à H:i:s') }}</td>
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>

</body>

</html>
