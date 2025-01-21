@include('partials.header')

<body id="BodyConnect">
    <div class="container">
        <div class="connexionheader">
            <h1>SGS</h1>
            <p>Système de Gestion des Stocks</p>
        </div>
        <div class="connexionBody">
            <!-- Crée un formulaire interactif, les attribut sont : action(url du sript coté serveur),
    method(post ou get), enctype(encodage) et name(nom du formulaire) -->
            <div class="icone">
                <i class="fa-solid fa-user" style="color: #b63d5b;"></i>
            </div>
            <form action="/connexion" method="post" class="connform">
                @csrf
                <div class="connexionInput">
                    <label for="">Adresse
                        Email</label><!-- Utilisée pour associer un libellé à un élément de formulaire, for correspond à ID de l'élément -->
                    <input name="email" type="text" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <p class="email-error">{{ $errors->first('email') }}</p>
                    @endif
                    <!-- Vérifie si la variable error_message n'est pas vide -->
                </div>
                <div class="connexionInput">
                    <label for="">Mot de
                        passe</label><!-- Utilisée pour associer un libellé à un élément de formulaire, for correspond à ID de l'élément -->
                    <input name="password" type="password">
                    @if ($errors->has('password'))
                        <p class="password-error">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="connexionButton">
                    <button id="connect" type="submit">Connexion</button>
                    <div></div>
                </div>
            </form>
        </div>
    </div>
    @include('partials.script')

</body>

</html>
