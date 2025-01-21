<div class="tableau_sidebar" id="tableau_sidebar">
    <div class="user">
        <img src="{{ asset('img/user1.png') }}" alt="Image de l'utilisateur" id="usersimg">
        <span id="username">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</span>
    </div>
    <div class="menu_tableau">
        <ul class="menu_list">
            <li class="limain">
                <a href="/dashboard">
                    <i class="fa-solid fa-house"></i>
                    <span class="menuText">Tableau de bord</span>
                    <i class="fa-solid fa-chevron-left hide"></i>
                </a>
            </li>

            <li class="lien_deroulant limain">
                <a href="javascript:void(0);" class="lien_deroulant">
                    <i class="fa-solid fa-truck-moving lien_deroulant"></i>
                    <span class="menuText lien_deroulant">Fournisseurs</span>
                    <i class="fa-solid fa-chevron-left lien_deroulant sousmenuicon"></i>
                </a>
                <ul class="sousmenu">
                    <li>
                        <a href="/ajout_fournisseur"><i class="fa-regular fa-circle"></i><span class="menuText">Ajouter
                                un fournisseur</span></a>
                    </li>
                    <li>
                        <a href="/liste_fournisseur"><i class="fa-regular fa-circle"></i><span class="menuText">Liste
                                des fournisseurs</span></a>
                    </li>
                </ul>
            </li>
            <li class="lien_deroulant limain">
                <a href="javascript:void(0);" class="lien_deroulant">
                    <i class="fa-solid fa-box lien_deroulant"></i>
                    <span class="menuText lien_deroulant">Produits</span>
                    <i class="fa-solid fa-chevron-left lien_deroulant sousmenuicon"></i>
                </a>
                <ul class="sousmenu">
                    <li>
                        <a href="/ajout_produit"><i class="fa-regular fa-circle"></i><span class="menuText">Ajouter un
                                produit</span></a>
                    </li>
                    <li>
                        <a href="/liste_produit"><i class="fa-regular fa-circle"></i><span class="menuText">Liste des
                                produits</span></a>
                    </li>
                </ul>
            </li>
            <li class="lien_deroulant limain">
                <a href="javascript:void(0);" class="lien_deroulant">
                    <i class="fa-solid fa-cart-shopping lien_deroulant"></i>
                    <span class="menuText lien_deroulant">Commande</span>
                    <i class="fa-solid fa-chevron-left lien_deroulant sousmenuicon"></i>
                </a>
                <ul class="sousmenu">
                    <li>
                        <a href="/commande"><i class="fa-regular fa-circle"></i><span class="menuText">Ajouter une
                                commande</span></a>
                    </li>
                    <li>
                        <a href="/liste_commande"><i class="fa-regular fa-circle"></i><span class="menuText">Liste des
                                commandes</span></a>
                    </li>
                </ul>
            </li>
            <li class="lien_deroulant limain">
                <a href="javascript:void(0);" class="lien_deroulant">
                    <i class="fa-solid fa-user lien_deroulant"></i>
                    <span class="menuText lien_deroulant">Utilisateurs</span>
                    <i class="fa-solid fa-chevron-left lien_deroulant sousmenuicon"></i>
                </a>
                <ul class="sousmenu">
                    <li>
                        <a href="/inscription"><i class="fa-regular fa-circle"></i><span class="menuText">Ajouter un
                                utilisateur</span></a>
                    </li>
                    <li>
                        <a href="/liste_utilisateur"><i class="fa-regular fa-circle"></i><span class="menuText">Liste
                                des utilisateurs</span></a>
                    </li>
                </ul>
            </li>
            <li class="limain">
                <a href="/rapport">
                    <i class="fa fa-file"></i>
                    <span class="menuText">Rapports</span>
                    <i class="fa-solid fa-chevron-left hide"></i>
                </a>
            </li>
            <li class="limain">
                <a href="/">
                    <i class="fa fa-file"></i>
                    <span class="menuText">A propos</span>
                    <i class="fa-solid fa-chevron-left hide"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
