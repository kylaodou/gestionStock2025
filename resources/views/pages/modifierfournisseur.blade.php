<div class="modal fade" id="ModalModifierFournisseur{{ $fournisseur->id }}" tabindex="-1"
    aria-labelledby="ModalModifierFournisseurLabel{{ $fournisseur->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalModifierFournisseurLabel">Modifier un fournisseur</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/liste_fournisseur/modifier/{{ $fournisseur->id }}" method="post"
                    class="addform formfourn" id="myForm{{ $fournisseur->id }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $fournisseur->id }}">
                    <div>
                        <input type="text" id = "nom_fournisseur" name="nom_fournisseur"
                            value="{{ $fournisseur->nom_fournisseur }}" placeholder="Nom du founisseur">
                        @if ($errors->has('nom_fournisseur'))
                            <p class="error">{{ $errors->first('nom_fournisseur') }}</p>
                        @endif
                    </div>
                    <div>
                        <input type="email" id = "email" name="email" value="{{ $fournisseur->email }}"
                            placeholder="Adresse Email">
                        @if ($errors->has('email'))
                            <p class="error">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div>
                        <input type="text" id = "adresse_fournisseur" name="adresse_fournisseur"
                            placeholder="Adresse" value="{{ $fournisseur->adresse_fournisseur }}">
                        @if ($errors->has('adresse_fournisseur'))
                            <p class="error">{{ $errors->first('adresse_fournisseur') }}</p>
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
