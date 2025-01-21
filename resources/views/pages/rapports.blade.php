@include('partials.header')

<body>
    <div class="contenair">
        @include('partials.sidebar')
        <div class="tableau_content" id="tableau_content">
            @include('partials.topnav')
            <div class="content">
                <div class="content_mai">
                    <h2>Rapports <strong class="total"></strong></h2>
                    <div id="reportsContainer">
                        <div class="row g-3"> <!-- 'g-3' ajoute un espacement (gutter) entre les colonnes -->
                            <div class="col-md-6">
                                <!-- 'col-md-6' crée une colonne qui prend la moitié de la largeur du conteneur sur les écrans de taille 'md' ou plus grande -->
                                <div class="reportType">
                                    <p>Rapport des produits</p>
                                    <div class="d-flex justify-content-end">
                                        <a href="/export-produits" class="reportExportBtn ">Excel</a>
                                        <a href="/pdf-produits" class="reportExportBtn">PDF</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="reportType">
                                    <p>Rapport des fournisseurs</p>
                                    <div class="d-flex justify-content-end">
                                        <a href="/export-fournisseurs" class="reportExportBtn ">Excel</a>
                                        <a href="/pdf-fournisseurs" class="reportExportBtn">PDF</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="reportType">
                                    <p>Rapport des commandes</p>
                                    <div class="d-flex justify-content-end">
                                        <a href="/export-commandes" class="reportExportBtn ">Excel</a>
                                        <a href="/pdf-commandes" class="reportExportBtn">PDF</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="reportType">
                                    <p>Rapport des utilisateurs</p>
                                    <div class="d-flex justify-content-end">
                                        <a href="/export-utilisateurs" class="reportExportBtn">Excel</a>
                                        <a href="/pdf-utilisateurs" class="reportExportBtn">PDF</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="reportType">
                                    <p>Historique de libraison</p>
                                    <div class="d-flex justify-content-end">
                                        <a href="/export-livraisons" class="reportExportBtn">Excel</a>
                                        <a href="/pdf-livraisons" class="reportExportBtn">PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                        <img class="imgproducte" src="/img/${data.image}" alt="Image du produit">
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
