<dv class="modal fade" id="ModalModifierCommande{{ $current_batch }}" tabindex="-1"
    aria-labelledby="ModalModifierCommandeLabel{{ $current_batch }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalModifierCommandeLabel">Modifier la commande Batch: {{ $current_batch }}
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/liste_commande/modifier/{{ $current_batch }}" method="post"
                    id="FormBatch{{ $current_batch }}">
                    @csrf
                    <table>
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité commandée</th>
                                <th>Quantité reçue</th>
                                <th>Quantité livré</th>
                                <th>Fournisseur</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commandes as $commande)
                                @if ($commande->batch == $current_batch)
                                    <tr>
                                        <td>
                                            <label>{{ $commande->produits->nom_produit }}</label>
                                            <input type="hidden" name="commande[{{ $commande->id }}][id]"
                                                value="{{ $commande->id }}">
                                        </td>
                                        <td>
                                            <p>{{ $commande->quantite_commander }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $commande->quantite_recu }}</p>
                                        </td>
                                        <td>
                                            <input required type="number"
                                                name="commande[{{ $commande->id }}][quantite_livre]" value="0"
                                                min="0"
                                                max="{{ $commande->quantite_commander - $commande->quantite_recu }}"
                                                placeholder="Quantité livrée">
                                        <td>
                                            <p>{{ $commande->fournisseurs->nom_fournisseur }}</p>
                                        </td>
                                        <td>
                                            <select name="commande[{{ $commande->id }}][statut]" required>
                                                <option value="En attente"
                                                    {{ $commande->statut == 'En attente' ? 'selected' : '' }}>En
                                                    attente</option>
                                                <option value="Complet"
                                                    {{ $commande->statut == 'Complet' ? 'selected' : '' }}>Complet
                                                </option>
                                                <option value="Incomplet"
                                                    {{ $commande->statut == 'Incomplet' ? 'selected' : '' }}>Incomplet
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</dv>
