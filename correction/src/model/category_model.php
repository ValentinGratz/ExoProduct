<?php
function getAllCat()
{
    $db = getDb();
    $sqlSelect = "SELECT * FROM categories ";
    $reqSelect = $db->prepare($sqlSelect);
    $reqSelect->execute();
    $data = $reqSelect->fetchAll(5);
    return $data;
}

function getCatByName($catName){
    $db = getDb();

    $sqlSelectCatByName = "SELECT * FROM categories WHERE name = ? ";
    $reqSelectCatByName = $db->prepare($sqlSelectCatByName);
    $reqSelectCatByName->bindParam(1, $catName);
    $reqSelectCatByName->execute();
    return $reqSelectCatByName->fetchAll(5);
}

function addCat($catName)
{
    $db = getDb();
    $sqlInsert = "INSERT INTO categories (name, created) VALUES(?, now())";
    $reqInsert = $db->prepare($sqlInsert);
    $reqInsert->bindParam(1, $catName);
    $reqInsert->execute();
    return $db->lastInsertId();
}

function editCat($idCat, $catName)
{
    $db = getDb();
    $sqlUpdateCatName = "UPDATE categories SET name = ? WHERE id = ?";
    $reqUpdate = $db->prepare($sqlUpdateCatName);
    $reqUpdate->bindParam(1, $catName);
    $reqUpdate->bindParam(2, $idCat);
    try {
        $reqUpdate->execute();
        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function deleteCat($idCat)
{

    $db = getDb();
    $selectSql = "SELECT * FROM products WHERE category_id = ? ";
    $reqSelect = $db->prepare($selectSql);
    $reqSelect->bindParam(1, $idCat);
    $reqSelect->execute();
    $data = $reqSelect->fetchAll(5);
    if (count($data) != 0) {
        echo "<b>ATTENTION</b> certains articles sont dans la catégorie elle n'as donc pas été supprimée";
    } else {
        $deleteSQL = "DELETE FROM categories WHERE id = ?";
        $reqDelete = $db->prepare($deleteSQL);
        $reqDelete->bindParam(1, $idCat);
        try {
            $reqDelete->execute();
            echo "Le delete a bien été effectué";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}