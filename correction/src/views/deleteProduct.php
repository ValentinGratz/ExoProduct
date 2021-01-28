<?php
if (!isset($_GET['productId'])) {
    header('Location: /?response=missingIdEdit');
} else {
    $idProduct = htmlspecialchars(trim($_GET['productId']));
    if (!is_numeric($idProduct)) {
        header('Location: /?response=notNumId');
    } else {
        deleteProduct($idProduct);
    }
}