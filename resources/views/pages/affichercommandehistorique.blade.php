    <div class="modal fade" id="ModalAfficherCommandeHistorique{{ $commande->id }}" tabindex="-1"
        aria-labelledby="ModalAfficherCommandeHistoriqueLabel{{ $commande->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalAfficherCommandeHistoriqueLabel{{ $commande->id }}">Historique de la
                        Commande #{{ $commande->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($commande->historiqueCommandes->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Produit</th>
                                <th>Quantité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach ($commande->historiqueCommandes as $historique)
                                <tr>
                                    <td>{{ $historique->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $commande->produits->nom_produit }}</td>
                                    <td>{{ $historique->quantite }}</td>
                                </tr>
                                @php $counter++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <div>
                            <p>Aucun historique trouvé</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
