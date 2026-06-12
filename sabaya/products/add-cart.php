<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Product.php';
require_once '../config/lang.php';

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$id = (int) $_GET['id'];

$db = new Database();
$pdo = $db->getConnection();
$productModel = new Product($pdo);

$product = $productModel->find($id);
if (!$product) {
    header('Location: products.php');
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$current_qty = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] : 0;
$requested_qty = $current_qty + 1;

if ($requested_qty > $product['stock']) {
    $msg = t('cart_err_stock_insufficient');
    $msg = str_replace('{stock}', $product['stock'], $msg);
    $_SESSION['_toast'] = [
        'message' => $msg,
        'type'    => 'error',
    ];
    header('Location: product-details.php?id=' . $id);
    exit();
}

$_SESSION['cart'][$id] = $requested_qty;

$_SESSION['_toast'] = [
    'message' => 'Produit ajouté au panier avec succès.',
    'type'    => 'success',
];
header('Location: cart.php');
exit();