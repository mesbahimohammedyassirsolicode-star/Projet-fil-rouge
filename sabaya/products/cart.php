<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Product.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

$cart = $_SESSION['cart'] ?? [];

$total = 0;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Consultez votre panier d'achats sur Sabaya Luxury.">
    <meta name="robots" content="noindex, nofollow">
    <title>Mon Panier | Sabaya Luxury</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="Mon Panier | Sabaya Luxury">
    <meta property="og:locale" content="fr_MA">
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

    <main>
        <section>
            <h1>Mon Panier</h1>

            <?php if (empty($cart)): ?>
                <p>Votre panier est vide.</p>
            <?php else: ?>
                <table border="1" cellpadding="10">
                    <caption>Articles actuellement dans votre panier de commande</caption>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $id_produit => $quantite): ?>
                            <?php
                            $product = $productModel->find($id_produit);
                            if (!$product) {
                                continue;
                            }
                            $sousTotal = $product['prix'] * $quantite;
                            $total += $sousTotal;
                            ?>
                            <tr>
                                <td>
                                    <img src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="Photo de <?= htmlspecialchars($product['nom']) ?>" width="80">
                                </td>
                                <td><?= htmlspecialchars($product['nom']) ?></td>
                                <td><?= htmlspecialchars($product['prix']) ?> DH</td>
                                <td><?= $quantite ?></td>
                                <td><?= $sousTotal ?> DH</td>
                                <td>
                                    <a href="remove-cart.php?id=<?= $product['id_produit'] ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h2>Total : <?= $total ?> DH</h2>
            <?php endif; ?>

            <br>
            <p>
                <a href="checkout.php">Passer la commande</a>
                <br><br>
                <a href="products.php">Continuer mes achats</a>
            </p>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>