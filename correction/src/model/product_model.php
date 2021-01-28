<?php

function getAllProducts()
{
    $db = getDb();

    $sqlSelect = "SELECT products.*, categories.name as catName FROM products
                    INNER JOIN categories on products.category_id = categories.id ORDER BY products.id ASC";
    $reqSelect = $db->prepare($sqlSelect);
    $reqSelect->execute();
    $data = $reqSelect->fetchAll(5);
    return $data;
}

function readProduct($idProduct)
{
    $db = getDb();
    $sqlSelect = "SELECT products.*, categories.name as catName 
                    FROM products  
                    INNER JOIN categories 
                    on products.category_id = categories.id  
                    WHERE products.id = ?";
    $reqSelect = $db->prepare($sqlSelect);
    $reqSelect->bindParam(1, $idProduct);
    $reqSelect->execute();
    $nbresult = $reqSelect->rowCount();
    if ($nbresult == 0) {
        header('Location: /?response=notExistRead');
    } else {
        return $reqSelect->fetchObject();
    }
}


function addProduct($productName, $productDesc, $productPrice, $productCat, $newProductCat)
{
    if (empty($productName) || empty($productDesc) || $productPrice == '' || empty($productCat)) {
        echo "Des champs sont manquants dans le formulaire d'ajout de produit";
    } else {
        $db = getDb();
        if($newProductCat != null || $newProductCat != "" || !empty($newProductCat)){
            $lastIdCat = addCat($newProductCat);
        } else {
            $lastIdCat = $productCat;
        }
        $sqlInsertProduct = "INSERT INTO products (name, description, price, category_id, created)
                                            VALUES(?, ?, ?, ?, now())";
        $reqInsertProduct = $db->prepare($sqlInsertProduct);
        $reqInsertProduct->bindParam(1, $productName);
        $reqInsertProduct->bindParam(2, $productDesc);
        $reqInsertProduct->bindParam(3, $productPrice);
        $reqInsertProduct->bindParam(4, $lastIdCat);
        try {
            $reqInsertProduct->execute();
            header('Location: /?response=success');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

function updateProduct($idProduct)
{
    $db = getDb();
    $sqlSelect = "SELECT products.*, categories.name as catName FROM products INNER JOIN categories on products.category_id = categories.id  WHERE products.id = ?";
    $reqSelect = $db->prepare($sqlSelect);
    $reqSelect->bindParam(1, $idProduct);
    $reqSelect->execute();
    $nbresult = $reqSelect->rowCount();
    if ($nbresult == 0) {
        header('Location: /?response=notExistEdit');
    } else {
        if (isset($_GET['action']) and $_GET['action'] == "edit") {
            if (isset($_POST['nameProduct']) && isset($_POST['descriptionProduct']) && isset($_POST['priceProduct']) && isset($_POST['catProducts'])) {
                $productName = htmlspecialchars(trim($_POST['nameProduct']));
                $productDesc = htmlspecialchars(trim($_POST['descriptionProduct']));
                $productPrice = htmlspecialchars(trim($_POST['priceProduct']));
                $productCat = htmlspecialchars(trim($_POST['catProducts']));
                if (empty($productName) || empty($productDesc) || $productPrice == '' || empty($productCat)) {
                    echo "Des champs sont manquants dans le formulaire d'édition de produit";
                } else {
                    $sqlSelectCatByName = "SELECT * FROM categories WHERE name = ?";
                    $reqSelectCatByName = $db->prepare($sqlSelectCatByName);
                    $reqSelectCatByName->bindParam(1, $productCat);
                    $reqSelectCatByName->execute();
                    $nbResultCat = $reqSelectCatByName->rowCount();
                    if ($nbResultCat == 0) {
                        $lastIdCat = addCat($productCat);
                    } else {
                        $dataCat = $reqSelectCatByName->fetchObject();
                        $lastIdCat = $dataCat->id;
                    }
                    $sqlUpdate = "UPDATE products SET name = ? ,
                                                        description = ?, 
                                                        price = ? , 
                                                        category_id = ?
                                                    WHERE id = ?";
                    $reqUpdate = $db->prepare($sqlUpdate);
                    $reqUpdate->bindParam(1, $productName);
                    $reqUpdate->bindParam(2, $productDesc);
                    $reqUpdate->bindParam(3, $productPrice);
                    $reqUpdate->bindParam(4, $lastIdCat);
                    $reqUpdate->bindParam(5, $idProduct);
                    try {
                        $reqUpdate->execute();
                        header('Location: /?response=successEdit');
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
            } else {
                echo "Des champs sont manquants dans le formulaire d'édition de produit";
            }
        }
    }
    $data = $reqSelect->fetchObject();
    return $data;
}

function deleteProduct($idProduct)
{
    $db = getDb();
    $sqlSelect = "SELECT products.*, categories.name as catName FROM products INNER JOIN categories on products.category_id = categories.id  WHERE products.id = ?";
    $reqSelect = $db->prepare($sqlSelect);
    $reqSelect->bindParam(1, $idProduct);
    $reqSelect->execute();
    $nbresult = $reqSelect->rowCount();
    if ($nbresult == 0) {
        header('Location: /?response=notExistEdit');
    } else {
        $sqlDelete = "DELETE FROM products WHERE id = ?";
        $reqDelete = $db->prepare($sqlDelete);
        $reqDelete->bindParam(1, $idProduct);
        try {
            $reqDelete->execute();
            header('Location: /?response=successDelete');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
