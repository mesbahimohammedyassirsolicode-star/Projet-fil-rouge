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
            <article class="product-details">
                <img src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="Photo de <?= htmlspecialchars($product['nom']) ?>">

                <h1><?= htmlspecialchars($product['nom']) ?></h1>

                <p><?= htmlspecialchars($product['description']) ?></p>

                <p><?= htmlspecialchars($product['prix']) ?> DH</p>

                <p>Taille : <?= htmlspecialchars($product['taille']) ?></p>

                <p>Couleur : <?= htmlspecialchars($product['couleur']) ?></p>
            </article>

            <aside class="product-actions">
                <a href="add-cart.php?id=<?= $product['id_produit'] ?>">
                    Ajouter au panier
                </a>

                <a href="../wishlist/add-wishlist.php?id=<?= $product['id_produit'] ?>">
                    Ajouter à la wishlist
                </a>
                <a href="../wishlist/wishlist.php">
                    Voir la wishlist
                </a>
            </aside>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>
