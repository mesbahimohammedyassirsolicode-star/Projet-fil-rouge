<?php

session_start();

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$id = (int) $_GET['id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

$_SESSION['_toast'] = [
    'message' => 'Produit ajouté au panier avec succès.',
    'type'    => 'success',
];
header('Location: cart.php');
exit();