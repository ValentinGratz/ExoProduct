<?php
    $serveur ="localhost";
    $login="root";
    $pass="";
    /* acceder à sa base de donnée*/
    try{
    $connexion= new PDO('mysql:host=localhost;dbname=productromuald', 'root','');
    
    $connexion-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Tentative de connexion localhost -essai'.'</br>'.'Connexion reussie, sélection de base'.'<br>'.
    'Selection de base OK'.'<br>'.'<br>';
    
    }
    catch(PDOException $e){
        echo 'echec de la connexion : ' .$e->getMessage();
    }
    
    /*Supprime l'entrée avec l'id = 8 */
    $products.id = id; /* product = id product = id */
    $req = $dbco->prepare("DELETE FROM product WHERE products.id = id");
?>