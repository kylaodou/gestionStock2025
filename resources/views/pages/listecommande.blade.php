@include('partials.header')

<body>
    <div class="contenair">
        @include('partials.sidebar')
        <div class="tableau_content" id="tableau_content">
            @include('partials.topnav')
            <div class="content">
                <div class="content_mai">
                    <h2>Liste des Commandes <strong class="total">{{ $commandes->count() }} Commandes</strong>
                        @php $current_batch = null; @endphp
                        @foreach ($commandes as $commande)
                            @if ($current_batch != $commande->batch)
                                @if ($current_batch != null)
                                    </table>
                                @endif
                                <h3 class="h3">Batch: {{ $commande->batch }}</h3>
                                @php $current_batch = $commande->batch; @endphp
                                <div class="action d-flex justify-content-end">
                                    <a href="#" style="text-decoration:none;" class="modifier modifiercom" data-bs-toggle="modal"
                                        data-bs-target="#ModalModifierCommande{{ $current_batch }}">
                                        <i class="fa fa-pencil"></i> Modifier
                                    </a>
                                    @include('pages.modifiercommande', [
                                        'commandes' => $commandes,
                                    ])
                                </div>
                                <div class="userlist">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fournisseur</th>
                                                <th>Produit</th>
                                                <th>Quantité Commandée</th>
                                                <th>Quantité Reçue</th>
                                                <th>Statut</th>
                                                <th>Créé par</th>
                                                <th>Crée le</th>
                                                <th>Mise à Jour</th>
                                                <th>Historique</th>
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
                                <td class="@if($commande->statut == 'En attente') bge-warning
                                    @elseif($commande->statut == 'Incomplet') bge-danger
                                    @elseif($commande->statut == 'Complet') bge-success
                                    @endif">
                                    {{ $commande->statut }}
                                </td>
                                <td>{{ $commande->utilisateur->nom }}
                                    {{ $commande->utilisateur->prenom }}</td>
                                <td>{{ $commande->created_at->format('d M Y à H:i:s') }}</td>
                                <td>{{ $commande->updated_at->format('d M Y à H:i:s') }}</td>
                                <td>
                                    <a href="#" class="modifier" data-bs-toggle="modal"
                                        data-bs-target="#ModalAfficherCommandeHistorique{{ $commande->id }}">
                                        Historique
                                    </a>
                                    @include('pages.affichercommandehistorique', [
                                        'commandes' => $commandes,
                                    ])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
        @include('partials.script')
        @if (session('status'))
            <script>
                Swal.fire({
                    title: "Félicitation!",
                    text: "Votre action a été réalisé avec succès",
                    icon: "success",
                    allowOutsideClick: false, // **Désactivation de la fermeture en cliquant en dehors**
                    showConfirmButton: true, // **Affichage du bouton OK**
                });
            </script>
        @endif
        <script>
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Êtes vous sûre?",
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Oui, supprimer!",
                    cancelButtonColor: "#3085d6",
                    cancelButtonText: "Annuler",
                    allowOutsideClick: false, // **Désactivation de la fermeture en cliquant en dehors**
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        </script>

        <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
