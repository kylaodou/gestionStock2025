{{-- partials.fournisseurs --}}
@if(isset($produit->fournisseurs) && $produit->fournisseurs->isNotEmpty())
    @foreach($produit->fournisseurs as $fournisseur)
        <ul class="list-group list-group-flush">
            <li class="list-group-item">{{ $fournisseur->nom_fournisseur }}</li>
        </ul>
    @endforeach
@else
    <p>Aucun fournisseur trouvé pour ce produit.</p>
@endif
