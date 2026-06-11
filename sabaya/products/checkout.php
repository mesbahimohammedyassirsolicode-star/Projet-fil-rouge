<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Product.php';
require_once '../models/Order.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);
$orderModel = new Order($pdo);

$cart = $_SESSION['cart'];

$total = 0;

foreach ($cart as $id_produit => $quantite) {

    $product = $productModel->find($id_produit);

    if (!$product) {
        continue;
    }

    $total += $product['prix'] * $quantite;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


$ville = trim($_POST['ville']);
$adresse = trim($_POST['adresse']);
$code_postal = trim($_POST['code_postal']);

if (empty($ville)) {
    $errors[] = t('checkout_err_city_required');
}

if (empty($adresse)) {
    $errors[] = t('checkout_err_address_required');
}

if (empty($code_postal)) {
    $errors[] = t('checkout_err_postal_required');
}

// Vérification du stock AVANT création commande
foreach ($cart as $id_produit => $quantite) {

    $product = $productModel->find($id_produit);

    if (!$product) {
        continue;
    }

    if ($product['stock'] < $quantite) {
        $errors[] = str_replace('{product}', $product['nom'], t('checkout_err_stock_insufficient'));
    }
}

if (empty($errors)) {

    $id_client = $_SESSION['user_id'];

    try {
        $orderModel->beginTransaction();

        // ── 1. Create the delivery address ──────────────────────────────────
        $id_adresse = $orderModel->createAddress(
            $ville,
            $adresse,
            $code_postal,
            $id_client
        );

        if (!$id_adresse) {
            throw new Exception("Impossible de créer l'adresse de livraison.");
        }

        // ── 2. Create the order (with the valid id_adresse) ─────────────────
        $id_commande = $orderModel->createOrder(
            $id_client,
            $total,
            $id_adresse
        );

        if (!$id_commande) {
            throw new Exception("Impossible de créer la commande.");
        }

        // ── 3. Create order lines + update stock ────────────────────────────
        foreach ($cart as $id_produit => $quantite) {

            $product = $productModel->find($id_produit);

            if (!$product) {
                continue;
            }

            $orderModel->createOrderLine(
                $quantite,
                $product['prix'],
                $id_commande,
                $id_produit
            );

            $stmt = $pdo->prepare("
                UPDATE produits
                SET stock = stock - :qte
                WHERE id_produit = :id
            ");

            $stmt->execute([
                ':qte' => $quantite,
                ':id'  => $id_produit
            ]);
        }

        // ── 4. All good — commit ────────────────────────────────────────────
        $orderModel->commit();

    } catch (Exception $e) {
        $orderModel->rollBack();
        $errors[] = t('checkout_err_generic');
    }

    if (empty($errors)) {
        // ── 5. Build WhatsApp message ───────────────────────────────────────
        $whatsappMessage = t('whatsapp_order_intro') . $id_commande . "\n\n";

        $whatsappMessage .= t('whatsapp_products') . "\n";

        foreach ($cart as $id_produit => $quantite) {

            $product = $productModel->find($id_produit);

            if (!$product) {
                continue;
            }

            $whatsappMessage .=
                "- " .
                $product['nom'] .
                " × " .
                $quantite .
                "\n";
        }

        $whatsappMessage .= "\n";

        $whatsappMessage .= t('whatsapp_total') . " : " . $total . " DH\n";

        $whatsappMessage .= t('whatsapp_city') . " : " . $ville . "\n";

        $whatsappMessage .= "\n" . t('whatsapp_thanks');

        $_SESSION['whatsapp_message'] = $whatsappMessage;
        $_SESSION['last_order_id']    = $id_commande;

        unset($_SESSION['cart']);

        header('Location: order-success.php?order_id=' . $id_commande);
        exit();
    }
}


}


// Include cart.css via extraHeadContent
$baseUrl_hdr = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
    . '://' . $_SERVER['HTTP_HOST']
    . dirname(dirname($_SERVER['SCRIPT_NAME']));

$extraHeadContent = '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl_hdr) . '/assets/css/cart.css">';

require_once '../config/lang.php';

$pageTitle = t('checkout_title') . ' | ' . t('site_name');
$pageDescription = 'Finalisez votre commande d\'abayas sur Sabaya Luxury.';
$pageRobots = 'noindex, nofollow';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>
    <main class="checkout-page">

        <!-- ─── Page Header ─── -->
    <section class="checkout-header reveal">
            <div class="checkout-container">
                <p class="checkout-eyebrow"><?= t('checkout_eyebrow') ?></p>
                <h1 class="checkout-title"><?= t('checkout_title') ?></h1>
                <p class="checkout-intro"><?= t('checkout_intro') ?></p>
            </div>
        </section>

        <!-- ─── Errors ─── -->
        <?php if (isset($errors) && !empty($errors)): ?>
        <section class="checkout-errors-section">
            <div class="checkout-container">
                <div class="checkout-errors">
                    <?php foreach ($errors as $error): ?>
                        <p class="checkout-error-msg">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= htmlspecialchars($error) ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ─── Checkout Content ─── -->
    <section class="checkout-content-section reveal">
            <div class="checkout-container">
                <form method="POST" class="checkout-form" novalidate>
                    <div class="checkout-layout">

                        <!-- ═══ LEFT — Shipping Form ═══ -->
                        <div class="checkout-shipping reveal">
                            <div class="checkout-section-card">
                                <h2 class="checkout-section-title">
                                    <i class="fas fa-shipping-fast"></i>
                                    <?= t('checkout_shipping_title') ?>
                                </h2>
                                <div class="checkout-divider"></div>

                                <div class="checkout-field-group">
                                    <div class="checkout-field">
                                        <label for="ville" class="checkout-label"><?= t('checkout_city') ?></label>
                                        <input type="text" name="ville" id="ville"
                                               class="checkout-input"
                                               placeholder="<?= t('checkout_placeholder_city') ?>" required>
                                    </div>

                                    <div class="checkout-field">
                                        <label for="adresse" class="checkout-label"><?= t('checkout_address') ?></label>
                                        <input type="text" name="adresse" id="adresse"
                                               class="checkout-input"
                                               placeholder="<?= t('checkout_placeholder_addr') ?>" required>
                                    </div>

                                    <div class="checkout-field">
                                        <label for="code_postal" class="checkout-label"><?= t('checkout_postal_code') ?></label>
                                        <input type="text" name="code_postal" id="code_postal"
                                               class="checkout-input"
                                               placeholder="<?= t('checkout_placeholder_postal') ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ═══ RIGHT — Order Summary ═══ -->
                        <div class="checkout-summary reveal">
                            <div class="checkout-summary-card">
                                <h2 class="checkout-summary-title"><?= t('checkout_summary_title') ?></h2>
                                <div class="checkout-divider"></div>

                                <!-- Line Items -->
                                <ul class="checkout-items-list">
                                    <?php foreach ($cart as $id_produit => $quantite): ?>
                                        <?php
                                        $product = $productModel->find($id_produit);
                                        if (!$product) {
                                            continue;
                                        }
                                        $sousTotal = $product['prix'] * $quantite;
                                        ?>
                                        <li class="checkout-item">
                                            <div class="checkout-item-info">
                                                <p class="checkout-item-name"><?= htmlspecialchars($product['nom']) ?></p>
                                                <p class="checkout-item-qty"><?= t('checkout_qty_label') ?> <?= htmlspecialchars($quantite) ?></p>
                                            </div>
                                            <div class="checkout-item-pricing">
                                                <p class="checkout-item-unit"><?= htmlspecialchars($product['prix']) ?> DH</p>
                                                <p class="checkout-item-subtotal"><?= htmlspecialchars($sousTotal) ?> DH</p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <div class="checkout-divider"></div>

                                <!-- Total -->
                                <div class="checkout-total-row">
                                    <span class="checkout-total-label"><?= t('cart_total') ?></span>
                                    <span class="checkout-total-value"><?= $total ?> DH</span>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="checkout-confirm-btn">
                                    <i class="fas fa-lock"></i>
                                    <?= t('checkout_confirm_btn') ?>
                                </button>

                                <!-- Back to cart -->
                                <a href="cart.php" class="checkout-back-link">
                                    <i class="fas fa-arrow-left"></i>
                                    <?= t('checkout_back_to_cart') ?>
                                </a>
                            </div>
                        </div>

                    </div><!-- /checkout-layout -->
                </form>
            </div>
        </section>

    </main>
<?php require_once '../includes/footer.php'; ?>

</body>
</html>
