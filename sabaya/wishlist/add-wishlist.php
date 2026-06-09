<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Wishlist.php';

$db = new Database();
$pdo = $db->getConnection();

$wishlistModel = new Wishlist($pdo);

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$id_client = $_SESSION['user_id'];
$id_produit = (int) $_GET['id'];

$wishlistModel->add(
    $id_client,
    $id_produit
);

$_SESSION['_toast'] = [
    'message' => 'Produit ajouté à votre liste de souhaits.',
    'type'    => 'success',
];
header('Location: ../products/products.php');
exit();