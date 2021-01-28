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
$select=$connexion->query("SELECT * FROM products WHERE products.id=id");
/* select from where table.clé = clé */

         while($s = $select->fetch(PDO::FETCH_OBJ)){

             echo $s->id."</br>";
             echo $s->name."</br>";
             echo $s->created."</br>";
             echo $s->modified."</br>";
             echo $s->description."</br>";
             echo $s->price." € </br>";
             echo $s->category_id."</br>";
             echo "<br><br>";
         }
?>