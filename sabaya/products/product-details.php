<?php

require_once '../config/Database.php';
require_once '../models/Product.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$id = (int) $_GET['id'];

$product = $productModel->find($id);

if (!$product) {
    header('Location: products.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
</head>
<body>
    <main class="container">
        <div class="product">
<img src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>">

<h1><?= htmlspecialchars($product['nom']) ?></h1>

<p><?= htmlspecialchars($product['description']) ?></p>

<p><?= htmlspecialchars($product['prix']) ?> DH</p>

<p><?= htmlspecialchars($product['taille']) ?></p>

<p><?= htmlspecialchars($product['couleur']) ?></p>
</div>
<div class="product-actions">
 <button>
Ajouter au panier
</button>

<button>
Ajouter à la wishlist
</button>
</div>
    </main>
</body>
</html>
