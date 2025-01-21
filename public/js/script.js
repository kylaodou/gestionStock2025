// Récupérer l'état du menu depuis le stockage local (localStorage)
let menu_ouvert = localStorage.getItem('menu_ouvert') === 'true';

// Assurez-vous que les éléments sont correctement sélectionnés
const tableau_sidebar = document.querySelector('.tableau_sidebar');
const tableau_content = document.querySelector('.tableau_content');
const barBtn = document.querySelector('#barBtn'); // Remplacez #barBtn par le sélecteur correct de votre bouton

// Ajoutez un écouteur d'événement au bouton qui contrôle le menu
barBtn.addEventListener('click', (event) => {
    event.preventDefault();

    // Appliquer les transitions aux deux éléments
    tableau_sidebar.style.transition = 'width .5s';
    tableau_content.style.transition = 'margin-left .5s, width .5s';

    if (menu_ouvert) {
        // Réduire le menu
        tableau_sidebar.style.width = '10%';
        tableau_content.style.marginLeft = '10%'; // Ajustez la marge gauche
        tableau_content.style.width = '90%';
        username.style.fontSize = '20px';
        usersimg.style.width = '80px';
        username.style.textAlign = 'center';
        menuText = document.getElementsByClassName('menuText');
        for (let i = 0; i < menuText.length; i++) {
            menuText[i].style.display = 'none';
        }
    document.querySelector('.menu_list').style.textAlign = 'center';
        menu_ouvert = false;
    } else {
        // Étendre le menu
        tableau_sidebar.style.width = '15%';
        tableau_content.style.marginLeft = '15%'; // Ajustez la marge gauche
        tableau_content.style.width = '85%';
        usersimg.style.width = '120px';
    username.style.fontSize = '25px';

    menuText = document.getElementsByClassName('menuText');
    for (let i = 0; i < menuText.length; i++) {
        menuText[i].style.display = 'inline-block';
    }

    document.querySelector('.menu_list').style.textAlign = 'left';
        menu_ouvert = true;
    }

    // Sauvegarder l'état du menu dans le stockage local (localStorage)
    localStorage.setItem('menu_ouvert', menu_ouvert.toString());
});

// Initialiser le menu avec l'état stocké dans le stockage local (localStorage)
if (menu_ouvert) {
    // Code pour initialiser le menu ouvert
    tableau_sidebar.style.width = '15%';
    tableau_content.style.marginLeft = '15%';
    tableau_content.style.width = '85%';
    usersimg.style.width = '120px';
    username.style.fontSize = '25px';

    menuText = document.getElementsByClassName('menuText');
    for (let i = 0; i < menuText.length; i++) {
        menuText[i].style.display = 'inline-block';
    }

    document.querySelector('.menu_list').style.textAlign = 'left';
} else {
    // Code pour initialiser le menu fermé
    tableau_sidebar.style.width = '10%';
    tableau_content.style.marginLeft = '10%';
    tableau_content.style.width = '90%';
    username.style.fontSize = '20px';
        usersimg.style.width = '80px';
        username.style.textAlign = 'center';
        menuText = document.getElementsByClassName('menuText');
        for (let i = 0; i < menuText.length; i++) {
            menuText[i].style.display = 'none';
        }
    document.querySelector('.menu_list').style.textAlign = 'center';
}



document.addEventListener('click', function(e){
    let curent = e.target;
    if(curent.classList.contains('lien_deroulant')){
        let sousmenu = curent.closest('li').querySelector('.sousmenu');
        let sousmenuicon = curent.closest('li').querySelector('.sousmenuicon');

        let sousmenus = document.querySelectorAll('.sousmenu');
        sousmenus.forEach((sous) =>{
            if(sousmenu != sous){
                sous.style.display = 'none';

            }
        });

        menuderoulant(sousmenu, sousmenuicon);
    }
});

function menuderoulant(sousmenu, sousmenuicon){
    if(sousmenu != null){
        if(sousmenu.style.display === 'none'){
            sousmenu.style.display = 'block';
            sousmenuicon.classList.remove('fa-chevron-left');
            sousmenuicon.classList.add('fa-chevron-down');
        }
        else{
            sousmenu.style.display = 'none';
            sousmenuicon.classList.remove('fa-chevron-down');
            sousmenuicon.classList.add('fa-chevron-left');
        }
    }
}

let pathArray = window.location.pathname.split('/');
let curentFile = pathArray[pathArray.length - 1];

let curentNav = document.querySelector('a[href="/' + curentFile + '"]');

let mainNav = curentNav.closest('li.limain');
mainNav.style.background = '#d65479';
mainNav.style.borderRadius = '10px';

let sousmenu = curentNav.closest('.sousmenu');
let sousmenuicon = mainNav.querySelector('i.sousmenuicon');

menuderoulant(sousmenu, sousmenuicon);

const selectBtn = document.querySelector(".select-btn"),
      items = document.querySelectorAll(".item");

selectBtn.addEventListener("click", () => {
    selectBtn.classList.toggle("open");
});
