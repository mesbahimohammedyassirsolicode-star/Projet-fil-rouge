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
    <header>
        <nav>
            <ul>
                <li><a href="products.php">Boutique</a></li>
                <li><a href="cart.php">Mon Panier</a></li>
                <li><a href="../wishlist/wishlist.php">Ma Liste de souhaits</a></li>
                <li><a href="my-orders.php">Mes Commandes</a></li>
                <li><a href="../auth/profile.php">Mon Profil</a></li>
                <li><a href="../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <section>
            <h1>Modern Collection</h1>

            <?php if(empty($products)): ?>
                <p>Aucun produit disponible.</p>
            <?php endif; ?>

            <?php foreach($products as $product): ?>
                <article class="card">
                    <img src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="Photo de <?= htmlspecialchars($product['nom']) ?>" width="200">
                    <h3><?= htmlspecialchars($product['nom']) ?></h3>
                    <p><?= htmlspecialchars($product['prix']) ?> DH</p>
                    <a href="product-details.php?id=<?= $product['id_produit'] ?>">Voir détails</a>
                    <a href="add-cart.php?id=<?= $product['id_produit'] ?>">Ajouter au panier</a>
                    <a href="my-orders.php">Mes Commandes</a>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>