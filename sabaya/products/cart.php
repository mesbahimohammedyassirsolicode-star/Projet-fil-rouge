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
    <section class="cart-header reveal">
            <div class="cart-container">
                <p class="cart-subtitle"><?= t('cart_subtitle') ?></p>
                <h1 class="cart-title"><?= t('cart_title') ?></h1>
            </div>
        </section>

        <?php if (empty($cart)): ?>
            <section class="cart-empty-section">
                <div class="cart-container cart-empty-wrapper">
                    <i class="fa-regular fa-bag-shopping cart-empty-icon"></i>
                    <p class="cart-empty-text"><?= t('cart_empty_text') ?></p>
                    <a href="products.php" class="btn cart-empty-btn"><?= t('cart_discover_btn') ?></a>
                </div>
            </section>
        <?php else: ?>
            <section class="cart-content-section reveal">
                <div class="cart-container cart-layout">

                    <!-- Cart Table (Desktop) -->
                    <div class="cart-table-wrapper reveal">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th><?= t('cart_col_image') ?></th>
                                    <th><?= t('cart_col_product') ?></th>
                                    <th><?= t('cart_col_price') ?></th>
                                    <th><?= t('cart_col_qty') ?></th>
                                    <th><?= t('cart_col_subtotal') ?></th>
                                    <th><?= t('cart_col_action') ?></th>
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
                                        <td class="cart-cell cart-cell-action" data-label="<?= t('cart_col_action') ?>">
                                            <a href="remove-cart.php?id=<?= $product['id_produit'] ?>" class="cart-remove-btn" title="<?= t('cart_remove') ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                                <span class="cart-remove-label"><?= t('cart_remove') ?></span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Summary -->
                    <div class="cart-summary reveal">
                                <div class="cart-summary-card">
                            <h2 class="cart-summary-title"><?= t('cart_order_summary') ?></h2>
                            <div class="cart-summary-divider"></div>
                            <div class="cart-summary-total">
                                <span class="cart-summary-total-label"><?= t('cart_total') ?></span>
                                <span class="cart-summary-total-value"><?= $total ?> DH</span>
                            </div>
                            <div class="cart-summary-divider"></div>
                            <div class="cart-summary-actions">
                                <a href="checkout.php" class="btn cart-checkout-btn"><?= t('cart_checkout_btn') ?></a>
                                <a href="products.php" class="btn-outline cart-continue-btn"><?= t('cart_continue_btn') ?></a>
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
