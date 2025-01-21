@include('partials.header')

<body>
    <div class="contenair">
        @include('partials.sidebar')
        <div class="tableau_content" id="tableau_content">
            @include('partials.topnav')
            <div class="content">
                <div class="content_mai">
                    <h2>Ajouter un produit</h2>
                    <form action="/ajout_produit" method="POST" class="addform produit" id="myForm" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <input type="text" id="nom_produit" name="nom_produit" value="{{ old('nom_produit') }}"
                                placeholder="Nom du produit">
                            @if ($errors->has('nom_produit'))
                                <p class="error">{{ $errors->first('nom_produit') }}</p>
                            @endif
                        </div>
                        <div>
                            <textarea name="description" id="description" cols="49" rows="3" placeholder="Entrez une description... ">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <p class="error">{{ $errors->first('description') }}</p>
                            @endif
                        </div>

                        <div>
                            <select name="fournisseur_id[]" id="fournisseur_id" class="select" multiple>
                                @foreach ($fournisseurs as $fournisseur)
                                    <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom_fournisseur }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('fournisseur_id'))
                                <p class="error">{{ $errors->first('fournisseur_id') }}</p>
                            @endif
                        </div>
                        <div>
                            <input type="file" id = "image" name="image" value="{{ old('image') }}">
                            @if ($errors->has('image'))
                                <p class="error">{{ $errors->first('image') }}</p>
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
                text: "Votre produit a ajouter avec succès",
                icon: "success",
                allowOutsideClick: false, // **Désactivation de la fermeture en cliquant en dehors**
                showConfirmButton: true, // **Affichage du bouton OK**
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var select = document.getElementById('fournisseur_id');
            var options = select.options;

            // Function to change the background color of an option
            function changeBackgroundColor(option, color) {
                option.style.backgroundColor = color;
            }

            // Add mouseover and mouseout event listeners to each option
            for (var i = 0; i < options.length; i++) {
                options[i].addEventListener('mouseover', function() {
                    changeBackgroundColor(this, '#ffb6c1'); // Light pink color on hover
                });

                options[i].addEventListener('mouseout', function() {
                    changeBackgroundColor(this, ''); // Reset background color on mouse out
                });
            }

            select.addEventListener('mousedown', function(e) {
                e.preventDefault(); // Prevent the default multiple selection behavior

                // Toggle the selected state of the option
                var option = e.target;
                option.selected = !option.selected;

                // Trigger the change event manually since preventDefault() stops it
                var event = new Event('change', {
                    bubbles: true
                });
                select.dispatchEvent(event);

                return false; // Prevent default behavior
            }, false);
        });
    </script>
    <script src="../js/script.js"></script>

</body>

</html>
