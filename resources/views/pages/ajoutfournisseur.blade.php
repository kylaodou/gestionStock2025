@include('partials.header')

<body>
    <div class="contenair">
        @include('partials.sidebar')
        <div class="tableau_content" id="tableau_content">
            @include('partials.topnav')
            <div class="content">
                <div class="content_mai fourn">
                    <h2>Ajouter un fournisseur</h2>
                    <form action="/ajout_fournisseur" method="POST" class="addform formfourn" id="myForm">
                        @csrf
                        <div>
                            <input type="text" id = "nom_fournisseur" name="nom_fournisseur"
                                value="{{ old('nom_fournisseur') }}" placeholder="Nom du founisseur">
                            @if ($errors->has('nom_fournisseur'))
                                <p class="error">{{ $errors->first('nom_fournisseur') }}</p>
                            @endif
                        </div>
                        <div>
                            <input type="email" id = "email" name="email" value="{{ old('email') }}"
                                placeholder="Adresse Email">
                            @if ($errors->has('email'))
                                <p class="error">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div>
                            <input type="text" id = "adresse_fournisseur" name="adresse_fournisseur"
                                placeholder="Adresse" value="{{ old('adresse_fournisseur') }}">
                            @if ($errors->has('adresse_fournisseur'))
                                <p class="error">{{ $errors->first('adresse_fournisseur') }}</p>
                            @endif
                        </div>
                        <div class="envoi">
                            <button type="submit"><i class="fa-solid fa-plus"></i> Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('partials.script')
    @if (session('status'))
        <script>
            Swal.fire({
                title: "Félicitation!",
                text: "Votre fournisseur a ajouter avec succès",
                icon: "success",
                allowOutsideClick: false, // **Désactivation de la fermeture en cliquant en dehors**
                showConfirmButton: true, // **Affichage du bouton OK**
            });
        </script>
    @endif
    <script src="../js/script.js"></script>
    <script>
        const passwordInput = document.getElementById('password');

        function changer() {
            if (passwordInput.type === 'password') {
                passwordInput.setAttribute("type", "text");
                const icon = document.getElementById('passwordicon');
                icon.classList.remove("fa-solid", "fa-eye-slash");
                icon.classList.add("fa-solid", "fa-eye");
            } else {
                passwordInput.setAttribute("type", "password");
                const icon = document.getElementById('passwordicon');
                icon.classList.remove("fa-solid", "fa-eye");
                icon.classList.add("fa-solid", "fa-eye-slash");
            }
        }
        const confirmpassword = document.getElementById('confirmpassword');

        function confirmchanger() {
            if (confirmpassword.type === 'password') {
                confirmpassword.setAttribute("type", "text");
                const icon = document.getElementById('confirmicon');
                icon.classList.remove("fa-solid", "fa-eye-slash");
                icon.classList.add("fa-solid", "fa-eye");
            } else {
                confirmpassword.setAttribute("type", "password");
                const icon = document.getElementById('confirmicon');
                icon.classList.remove("fa-solid", "fa-eye");
                icon.classList.add("fa-solid", "fa-eye-slash");
            }
        }
    </script>

</body>

</html>
