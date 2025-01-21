@include('partials.header')

<body>
    <div class="contenair">
        @include('partials.sidebar')
        <div class="tableau_content" id="tableau_content">
            @include('partials.topnav')
            <div class="content">
                <div class="content_mai">
                    <h2>Ajouter un utilisateur</h2>
                    <form action="/inscription" method="POST" class="addform" id="myForm">
                        @csrf
                        <div>
                            <input type="text" id = "nom" name="nom" value="{{ old('nom') }}" required
                                placeholder="Nom de famille">
                            @if ($errors->has('nom'))
                                <p class="error">{{ $errors->first('nom') }}</p>
                            @endif
                        </div>
                        <div>
                            <input type="text" id = "prenom" name="prenom" value="{{ old('prenom') }}" required
                                placeholder="Prénom">
                            @if ($errors->has('prenom'))
                                <p class="error">{{ $errors->first('prenom') }}</p>
                            @endif
                        </div>
                        <div>
                            <input type="email" id = "email" name="email" value="{{ old('email') }}" required
                                placeholder="Adresse Email">
                            @if ($errors->has('email'))
                                <p class="error">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div>
                            <input type="password" id = "password" name="password" placeholder="Mot de passe" required>
                            <i id="passwordicon" class="fa-solid fa-eye-slash" onclick="changer()"></i>
                            @if ($errors->has('password'))
                                <p class="error">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                        <div>
                            <input type="password" id = "confirmpassword" name="password_confirmation" required
                                placeholder="Confirmer mot de passe">
                            <i id="confirmicon" class="fa-solid fa-eye-slash" onClick="confirmchanger()"></i>
                            @if ($errors->has('confirmpassword'))
                                <p class="error">{{ $errors->first('confirmpassword') }}</p>
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
                text: "Votre utilisateur a ajouter avec succès",
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
