@include('partials.header')

<body>
    <div class="contenair">
        @include('partials.sidebar')
        <div class="tableau_content" id="tableau_content">
            @include('partials.topnav')
            <div class="content">
                <div class="content_mai">
                    <h2>Liste des fourniseurs <strong class="total">{{ $fournisseurs->count() }} Fournisseurs</strong>
                    </h2>
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($fournisseurs->count() > 0)
                        <div class="userlist">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Adresse</th>
                                        <th>Email</th>
                                        <th>Produits</th>
                                        <th>Crée par</th>
                                        <th>Crée le</th>
                                        <th>Mis à jour le</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fournisseurs as $fournisseur)
                                        <tr>
                                            <td>{{ $fournisseur->id }}</td>
                                            <td>{{ $fournisseur->nom_fournisseur }}</td>
                                            <td>{{ $fournisseur->adresse_fournisseur }}</td>
                                            <td>{{ $fournisseur->email }}</td>
                                            <td>
                                                @if ($fournisseur->produits()->count() > 0)
                                                    @foreach ($fournisseur->produits as $produit)
                                                        <li>{{ $produit->nom_produit }}</li>
                                                    @endforeach
                                                @else
                                                    <p style="color: red;"><i class="fa-solid fa-circle-exclamation"
                                                            style="color: red;"></i>Aucun produit</p>
                                                @endif
                                            </td>
                                            <td>{{ $fournisseur->utilisateur->nom }}
                                                {{ $fournisseur->utilisateur->prenom }}</td>
                                            <td>{{ $fournisseur->created_at->format('d M Y à H:i:s') }}</td>
                                            <td>{{ $fournisseur->updated_at->format('d M Y à H:i:s') }}</td>
                                            <td class="action">
                                                <a href="#" class="modifier" data-bs-toggle="modal"
                                                    data-bs-target="#ModalModifierFournisseur{{ $fournisseur->id }}">
                                                    <i class="fa fa-pencil"></i> Modifier
                                                </a>
                                                @include('pages.modifierfournisseur', [
                                                    'fournisseurs' => $fournisseurs,
                                                ])
                                                <form class="delete-form"
                                                    action="/liste_fournisseur/supprimer/{{ $fournisseur->id }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="delete">
                                                        <i class="fa fa-trash"></i>Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div>
                            <p>Aucun fournisseur trouvé</p>
                        </div>
                    @endif
                </div>
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
