<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Product.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

$cart = $_SESSION['cart'] ?? [];

$total = 0;

// Page metadata for header.php
$pageTitle = 'Mon Panier | Sabaya Luxury';
$pageDescription = 'Consultez votre panier d\'achats sur Sabaya Luxury.';
$pageRobots = 'noindex, nofollow';

// Include cart.css via extraHeadContent
$protocol_hdr = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$scriptDir_hdr = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptDir_hdr !== '/' && $scriptDir_hdr !== '\\' && $scriptDir_hdr !== '') {
    $scriptDir_hdr = dirname($scriptDir_hdr);
}
$baseUrl_hdr = $protocol_hdr . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir_hdr, '/\\');
$extraHeadContent = '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl_hdr) . '/assets/css/cart.css">';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

    <main class="cart-page">
        <section class="cart-header">
            <div class="cart-container">
                <p class="cart-subtitle">Votre Sélection</p>
                <h1 class="cart-title">Mon Panier</h1>
            </div>
        </section>

        <?php if (empty($cart)): ?>
            <section class="cart-empty-section">
                <div class="cart-container cart-empty-wrapper">
                    <i class="fa-regular fa-bag-shopping cart-empty-icon"></i>
                    <p class="cart-empty-text">Votre panier est vide.</p>
                    <a href="products.php" class="btn cart-empty-btn">Découvrir la Collection</a>
                </div>
            </section>
        <?php else: ?>
            <section class="cart-content-section">
                <div class="cart-container cart-layout">

                    <!-- Cart Table (Desktop) -->
                    <div class="cart-table-wrapper">
                        <table class="cart-table">
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
                                    <tr class="cart-row">
                                        <td class="cart-cell cart-cell-image" data-label="Image">
                                            <div class="cart-product-img">
                                                <img src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="Photo de <?= htmlspecialchars($product['nom']) ?>">
                                            </div>
                                        </td>
                                        <td class="cart-cell cart-cell-name" data-label="Produit">
                                            <span class="cart-product-name"><?= htmlspecialchars($product['nom']) ?></span>
                                        </td>
                                        <td class="cart-cell cart-cell-price" data-label="Prix">
                                            <span class="cart-product-price"><?= htmlspecialchars($product['prix']) ?> DH</span>
                                        </td>
                                        <td class="cart-cell cart-cell-qty" data-label="Quantité">
                                            <span class="cart-product-qty"><?= $quantite ?></span>
                                        </td>
                                        <td class="cart-cell cart-cell-subtotal" data-label="Sous-total">
                                            <span class="cart-product-subtotal"><?= $sousTotal ?> DH</span>
                                        </td>
                                        <td class="cart-cell cart-cell-action" data-label="Action">
                                            <a href="remove-cart.php?id=<?= $product['id_produit'] ?>" class="cart-remove-btn" title="Supprimer">
                                                <i class="fa-regular fa-trash-can"></i>
                                                <span class="cart-remove-label">Supprimer</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Summary -->
                    <div class="cart-summary">
                        <div class="cart-summary-card">
                            <h2 class="cart-summary-title">Résumé de la Commande</h2>
                            <div class="cart-summary-divider"></div>
                            <div class="cart-summary-total">
                                <span class="cart-summary-total-label">Total</span>
                                <span class="cart-summary-total-value"><?= $total ?> DH</span>
                            </div>
                            <div class="cart-summary-divider"></div>
                            <div class="cart-summary-actions">
                                <a href="checkout.php" class="btn cart-checkout-btn">Passer la Commande</a>
                                <a href="products.php" class="btn-outline cart-continue-btn">Continuer mes Achats</a>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        <?php endif; ?>
    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
