<?php
//on charge les éléments utiles ici
// nos vue utilisé tout le temps (head et footer)
// notre fichier de config
// notre fichier de connexion a la base de donnée
// nos différents models (ici le product et le category)
require_once "src/views/elements/head.php"; // => réecrire le fichier php a cet endroit
require_once "src/views/elements/footer.php";
require_once "src/config/config.php";
require_once "src/model/database.php";
require_once "src/model/product_model.php";
require_once "src/model/category_model.php";

//on regarde si une variable get page existe
if (!isset($_GET['page'])) {
    //si elle n'existe pas on créer une variable $page ayant pour valeur "list"
    $page = "list";
} else {
    //si notre get page existe alors notre variable $page prend ça valeur
    $page = $_GET['page'];
}
//on affiche notre head
head();
//on crée un switch pour charger la page correspondante a notre $page
//nb mb_strtolower permet de transformer une chaine de charactère en minuscule (plus facile pour faire de la comparaison)
switch (mb_strtolower($page)) {
    case 'list':
    default:
        include "src/views/productsList.php";
        break;
    case 'add':
        include "src/views/addProduct.php";
        break;
    case 'edit':
        include "src/views/editProduct.php";
        break;
    case 'delete':
        include "src/views/deleteProduct.php";
        break;
    case 'read':
        include "src/views/readProduct.php";
        break;
    case 'cat_manage':
        include "src/views/catManage.php";
        break;

}
//on affiche notre foot ici
foot();

