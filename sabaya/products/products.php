<?php

require_once '../config/Database.php';
require_once '../models/Product.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

$products = $productModel->getAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Shop Catalog - Sabaya Luxury</title>
</head>
<body>
    <?php if(empty($products)): ?>

<p>Aucun produit disponible.</p>

<?php endif; ?>
<main class="container">
    <h1>Modern Collection</h1>
   <?php foreach($products as $product): ?>

<div class="card">

    <img
    src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>"
    width="200"
    >

    <h3>
        <?= htmlspecialchars($product['nom']) ?>
    </h3>

    <p>
        <?= htmlspecialchars($product['prix']) ?> DH
    </p>

    <a href="product-details.php?id=<?= $product['id_produit'] ?>">
        Voir détails
    </a>

</div>

<?php endforeach; ?>
</main>
</body>
</html>