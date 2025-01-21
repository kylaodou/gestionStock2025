<link rel="stylesheet" href="{{ asset('fontawesome-free-6.5.1-web/css/all.min.css') }}">
<div class="modal fade" id="ModalModifierUser{{ $user->id }}" tabindex="-1"
    aria-labelledby="ModalModifierLabelUser{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalModifierLabelUser">Modifier un utilisateur</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/liste_utilisateur/modifier/{{ $user->id }}" method="post" class="addform"
                    id="myForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div>
                        <label for="nom">Nom de famille</label>
                        <input type="text" id = "nom" name="nom" value="{{ $user->nom }}">
                        @if ($errors->has('nom'))
                            <p class="error">{{ $errors->first('nom') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="prenom">Prénom</label>
                        <input type="text" id = "prenom" name="prenom" value="{{ $user->prenom }}">
                        @if ($errors->has('prenom'))
                            <p class="error">{{ $errors->first('prenom') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="email">Adresse Email</label>
                        <input type="email" id = "email" name="email" value="{{ $user->email }}">
                        @if ($errors->has('email'))
                            <p class="error">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="password">Mot de passe</label>
                        <input type="password" id ="password" name="password" required>
                        @if ($errors->has('password'))
                            <p class="error">{{ $errors->first('password') }}</p>
                        @endif
                    </div>
                    <div class="envoi modifenvoiuti">
                        <button type="submit"><i class="fa-solid fa-pen-to-square"></i> Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
