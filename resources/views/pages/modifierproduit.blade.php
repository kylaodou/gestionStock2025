<div class="modal fade" id="ModalModifier{{ $produit->id }}" tabindex="-1"
    aria-labelledby="ModalModifierLabel{{ $produit->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalModifierLabel">Modifier un produit</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/liste_produit/modifier/{{ $produit->id }}" method="post" class="addform modif"
                    enctype="multipart/form-data" id="myForm{{ $produit->id }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $produit->id }}">
                    <div>
                        <input type="text" id="nom_produit{{ $produit->id }}" name="nom_produit"
                            value="{{ $produit->nom_produit }}" placeholder="Nom du produit">
                        @if ($errors->has('nom_produit'))
                            <p class="error">{{ $errors->first('nom_produit') }}</p>
                        @endif
                    </div>
                    <div>
                        <textarea name="description" id="description{{ $produit->id }}" cols="49" rows="3">{{ $produit->description }}</textarea>
                        @if ($errors->has('description'))
                            <p class="error">{{ $errors->first('description') }}</p>
                        @endif
                    </div>
                    <div>
                        <select name="fournisseur_id[]" id="fournisseur{{ $produit->id }}" class="select" multiple>
                            @foreach ($fournisseurs as $fournisseur)
                                {{-- Vérifier si le fournisseur est associé au produit --}}
                                @php
                                    $isSelected = in_array(
                                        $fournisseur->id,
                                        $produit->fournisseurs->pluck('id')->toArray(),
                                    );
                                @endphp
                                <option value="{{ $fournisseur->id }}" {{ $isSelected ? 'selected' : '' }}>
                                    {{ $fournisseur->nom_fournisseur }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('fournisseur'))
                            <p class="error">{{ $errors->first('fournisseur') }}</p>
                        @endif
                    </div>
                    <div>
                        <img class="imgmodif" src="{{ asset('storage/img/' . $produit->image) }}"
                            alt="Image du produit">
                        <input type="file" id="image{{ $produit->id }}" name="image" class="imginput">
                        @if ($errors->has('image'))
                            <p class="error">{{ $errors->first('image') }}</p>
                        @endif
                    </div>
                    <div class="envoi modifenvoi">
                        <button type="submit"><i class="fa-solid fa-pen-to-square"></i> Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Utilisez une classe pour sélectionner tous les éléments <select> concernés.
        var selects = document.querySelectorAll('.select');

        selects.forEach(function(select) {
            // Ajoutez des écouteurs d'événements pour le survol des options.
            Array.from(select.options).forEach(function(option) {
                option.addEventListener('mouseover', function() {
                    this.style.backgroundColor =
                    '#ffb6c1'; // Couleur rose clair au survol
                });

                option.addEventListener('mouseout', function() {
                    this.style.backgroundColor =
                    ''; // Réinitialisez la couleur de fond au sortir
                });
            });
        });
    });
</script>
