<?php
if (!isset($_GET['productId'])) {
    header('Location: /?response=missingIdRead');
} else {
    $idProduct = htmlspecialchars(trim($_GET['productId']));
    if (!is_numeric($idProduct)) {
        header('Location: /?response=notNumId');
    } else {
        $data = readProduct($idProduct);
    }
}
?>
<h2 class="mb-4">Lecture du produit : <?= $data->name ?> </h2>
<div class="text-center">
    <a href="/">
        <button class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Retour à la liste des produits</button>
    </a>
    <a href="/?page=add">
        <button class="btn btn-warning"><i class="fas fa-cart-plus"></i> Ajouter un produit</button>
    </a>
</div>
<div class="card mt-5">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4 border-right">
                <span class="font-weight-bolder">Nom du produit: </span><?= $data->name ?><br>
                <span class="font-weight-bolder">Catégorie: </span><?= $data->catName ?><br>
                <span class="font-weight-bolder">Prix: </span><?= $data->price ?>€ <br>
                <span class="font-weight-bolder">Date d'ajout: </span><?= $data->created ?> <br>
                <span class="font-weight-bolder">Date modif: </span><?= $data->modified ?> <br>
            </div>
            <div class="col-sm-7">
                <?= $data->description ?>
            </div>
        </div>
    </div>
</div>
