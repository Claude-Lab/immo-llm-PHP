"use strict";

let select = document.getElementById("create_user_roles"); // La liste déroulante de choix
let all = Array.prototype.slice.call(document.getElementsByClassName("all")); // nos éléments cachés


function hide(all) { // La fonction permettant de cacher tous nos éléments d'un coup
    all.classList.add("hide"); // L'ajout de la classe permettant de dissimuler l'élément
}

function displayAll(event) { // La fonction qui permet de gérer la sélection d'un nouvel élément
    let selected_all = event.target.value; // La valeur de notre liste déroulante

    all.map(hide); // On cache tous les éléments

    document.getElementById(selected_all).classList.remove("hide"); // On affiche seulement l'élément concerné
}

select.addEventListener("change", displayall); // On ajoute un écouteur d'événement à chaque changement