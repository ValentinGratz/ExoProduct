<?php
$db = getDb();
if (isset($_GET['action'])) {
    if ($_GET['action'] == "add_cat") {
        if (isset($_POST['nameCat'])) {
            $nameCat = htmlspecialchars(trim($_POST['nameCat']));
            if (!empty($nameCat) || $nameCat != '') {
                $sqlSelectCatByName = "SELECT * FROM categories WHERE name = ? ";
                $reqSelectCatByName = $db->prepare($sqlSelectCatByName);
                $reqSelectCatByName->bindParam(1, $nameCat);
                $reqSelectCatByName->execute();
                $nbCatResult = $reqSelectCatByName->rowCount();
                if ($nbCatResult != 0) {
                    echo "Une catégorie porte déjà ce nom";
                } else {
                    if (addCat($nameCat) != 0) {
                        echo "La catégorie a bien été ajoutée";
                    }
                }
            } else {
                echo "Des champs sont manquants dans le formulaire d'ajout de catégorie";
            }
        } else {
            echo "Des champs sont manquants dans le formulaire d'ajout de catégorie";
        }

    } else if ($_GET['action'] == "cat_edit") {
        if (!isset($_POST['catId']) || !isset($_POST['catName'])) {
            echo "Des champs sont manquants dans le formulaire d'édition de catégorie";
        } else {
            if (!is_numeric($_POST['catId'])) {
                echo "L'id de la catégorie doit etre numérique avez vous essayez de modifié le code ? ";
            } else {
                $idCat = htmlspecialchars(trim($_POST['catId']));
                $catName = htmlspecialchars(trim($_POST['catName']));

                $nbCatResult = count(getCatByName($catName));
                if ($nbCatResult != 0) {
                    echo "Une catégorie porte déjà ce nom";
                } else {
                    if(editCat($idCat, $catName)){
                        echo "Catégorie modifiée";
                    }else{
                        echo "Erreur de modification de la catégorie";
                    }
                }
            }
        }
    }
    else if($_GET['action'] == "cat_delete"){
        $idCat = htmlspecialchars(trim($_GET['catId']));
        if (!empty($idCat)){
            deleteCat($idCat);
        }else{
            echo "Missing id";
        }

    }
    else {
        echo "Unknown action";
    }
}

?>
<h2 class="mb-4">Gestion des catégories</h2>
<div class="text-center">
    <a href="/">
        <button class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Retour à la liste des produits</button>
    </a>
    <a href="/?page=add">
        <button class="btn btn-warning"><i class="fas fa-cart-plus"></i> Ajouter un produit</button>
    </a>
</div>
<div class="card mt-4">
    <div class="card-header">Ajouter une categorie</div>
    <form method="post" action="/?page=cat_manage&action=add_cat">
        <div class="card-body">
            <div class="form-group row">
                <label for="nameCat" class="col-sm-2 col-form-label">Nom de la catégorie</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nameCat" name="nameCat" placeholder="catégorie">
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-success" type="submit"><i class="fas fa-plus"></i> Ajouter la catégorie</button>
            <button class="btn btn-danger" type="reset"><i class="fas fa-trash"></i> Reset</button>
        </div>
    </form>
</div>


<table class="table table-hover mt-5">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nom</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (getAllCat() as $cat) { ?>
        <tr>
            <form action="/?&page=cat_manage&action=cat_edit" method="post">
                <input type="hidden" name="catId" value="<?= $cat->id ?>">
                <th scope="row"><?= $cat->id ?></th>
                <td><input type="text" class="form-control" name="catName" value="<?= $cat->name ?>"></td>
                <td>
                    <button class="btn btn-warning" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i>
                        Modifier
                    </button>
                    <a href="/?&page=cat_manage&action=cat_delete&catId=<?= $cat->id ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Supprimer</a>
                </td>
            </form>
        </tr>
    <?php } ?>
    </tbody>
</table>
