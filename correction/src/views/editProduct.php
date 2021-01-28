<?php
if (!isset($_GET['productId'])) {
    header('Location: /?response=missingIdEdit');
} else {
    $idProduct = htmlspecialchars(trim($_GET['productId']));
    if (!is_numeric($idProduct)) {
        header('Location: /?response=notNumId');
    } else {
        $data = updateProduct($idProduct);
    }
}
?>
<h2 class="mb-4">Editer un produit</h2>
<div class="text-center">
    <a href="/">
        <button class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Retour à la liste des produits</button>
    </a>
    <a href="/?page=cat_manage">
        <button class="btn btn-warning"><i class="fas fa-cogs"></i> Gérer les catégories</button>
    </a>
</div>
<div class="card mt-5">
    <form method="post" action="/?page=edit&productId=<?= $data->id ?>&action=edit" autocomplete="off">
        <div class="card-body">
            <div class="form-group row">
                <label for="nameProduct" class="col-sm-2 col-form-label">Nom du Produit</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nameProduct" name="nameProduct" placeholder="produit"
                           value="<?= $data->name ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="descriptionProduct" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea id="descriptionProduct" name="descriptionProduct"
                              class="note-codable w-100"><?= $data->description ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="priceProduct" class="col-sm-2 col-form-label">Prix du Produit</label>
                <div class="col-sm-10">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">€</div>
                        </div>
                        <input type="number" class="form-control" id="priceProduct" name="priceProduct"
                               placeholder="prix" value="<?= $data->price ?>">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="catProducts" class="col-sm-2 col-form-label">
                    Catégorie
                </label>
                <div class="col-sm-10">
                    <input type="text" name="catProducts" id="catProducts" class="form-control"
                           value="<?= $data->catName ?>">
                </div>
            </div>


        </div>
        <div class="card-footer text-center">
            <button class="btn btn-warning" type="submit"><i class="fas fa-cogs"></i> Editer le produit</button>
            <button class="btn btn-danger" type="reset"><i class="fas fa-trash"></i> Reset</button>
        </div>
    </form>
</div>
