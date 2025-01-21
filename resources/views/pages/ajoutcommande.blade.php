@include('partials.header')

<body>
    <div class="contenair">
        @include('partials.sidebar')
        <div class="tableau_content" id="tableau_content">
            @include('partials.topnav')
            <div class="content">
                <div class="content_mai">
                    <h2>Commander un ou des produits <strong class="total"></strong></h2>
                    @if ($produits->count() > 0)
                        <form action="/ajout_commande" method="post">
                            @csrf
                            <div>
                                <label style="font-weight: bold; font-size: 18px;">Sélectionnez un produit:</label>
                                <div class="checkbox-container">
                                    @foreach ($produits as $produit)
                                        <div class="check">
                                            <input name="checkbox[]" type="checkbox" class="product-checkbox"
                                                id="produit-{{ $produit->id }}" value="{{ $produit->id }}">
                                            <label for="produit-{{ $produit->id }}">{{ $produit->nom_produit }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="productInfoContainer">
                                    <!-- Les informations des produits sélectionnés seront affichées ici -->
                                </div>
                                <button type="submit" class="ajoutercomm">Commander</button>
                            </div>
                        </form>
                    @else
                        <p>Aucun produit trouvé</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        // JavaScript to handle checkbox changes and display product information
        document.querySelectorAll('.product-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var productId = this.value;
                var productInfoContainer = document.getElementById('productInfoContainer');
                if (this.checked) {
                    fetch(`/produits/${productId}/infos`)
                        .then(response => response.json())
                        .then(data => {
                            var productInfoDiv = document.createElement('div');
                            productInfoDiv.id = `productInfo-${productId}`;
                            productInfoDiv.innerHTML = `
                                    <div class="listcommande">
                                        <p><span>Identifiant du produit : </span>${data.id}</p>
                                        <img class="imgproduct" src="/storage/img/${data.image}" alt="Image du produit">
                                        <p><span>Nom du produit : </span>${data.nom_produit}</p>
                                        ${data.fournisseurs.map(fournisseur => `
                                                        <div class="fourni">
                                                            <li>${fournisseur.nom_fournisseur}</li>
                                                            <input type="number" name="quantite[${productId}][${fournisseur.id}]" id="quantite-${productId}-${fournisseur.id}" placeholder="Quantité" value="0" min="0">
                                                        </div>
                                                    `).join('')}
                                    </div>
                            `;
                            productInfoContainer.appendChild(productInfoDiv);
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                        });
                } else {
                    var productInfoDiv = document.getElementById(`productInfo-${productId}`);
                    productInfoContainer.removeChild(productInfoDiv);
                }
            });
        });
    </script>

    @include('partials.script')


    @if (session('status'))
        <script>
            Swal.fire({
                title: "Félicitation!",
                text: "Votre commande a été ajouter avec succès",
                icon: "success",
                allowOutsideClick: false, // **Désactivation de la fermeture en cliquant en dehors**
                showConfirmButton: true, // **Affichage du bouton OK**
            });
        </script>
    @endif
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
