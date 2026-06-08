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
    $errors[] = "La ville est obligatoire";
}

if (empty($adresse)) {
    $errors[] = "L'adresse est obligatoire";
}

if (empty($code_postal)) {
    $errors[] = "Le code postal est obligatoire";
}

// Vérification du stock AVANT création commande
foreach ($cart as $id_produit => $quantite) {

    $product = $productModel->find($id_produit);

    if (!$product) {
        continue;
    }

    if ($product['stock'] < $quantite) {
        $errors[] = "Stock insuffisant pour : " . $product['nom'];
    }
}

if (empty($errors)) {

    $id_client = $_SESSION['user_id'];

    $orderModel->createAddress(
        $ville,
        $adresse,
        $code_postal,
        $id_client
    );

    $id_commande = $orderModel->createOrder(
        $id_client,
        $total
    );

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
            ':id' => $id_produit
        ]);
    }
    $whatsappMessage = "Bonjour Sabaya Luxury\n\n";

$whatsappMessage .=
    "Je souhaite confirmer ma commande.\n\n";

$whatsappMessage .=
    "Commande N°" . $id_commande . "\n\n";

$whatsappMessage .=
    "Produits :\n";

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

$whatsappMessage .=
    "Total : " .
    $total .
    " DH\n";

$whatsappMessage .=
    "Ville : " .
    $ville .
    "\n";

$whatsappMessage .= "\nMerci.";
    
$_SESSION['whatsapp_message'] = $whatsappMessage;
$_SESSION['last_order_id'] = $id_commande;
    unset($_SESSION['cart']);

    header('Location: order-success.php?order_id=' . $id_commande);
    exit();
}


}


// Include cart.css via extraHeadContent
$baseUrl_hdr = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
    . '://' . $_SERVER['HTTP_HOST']
    . dirname(dirname($_SERVER['SCRIPT_NAME']));

$extraHeadContent = '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl_hdr) . '/assets/css/cart.css">';

$pageTitle = 'Finaliser la commande | Sabaya Luxury';
$pageDescription = 'Finalisez votre commande d\'abayas sur Sabaya Luxury.';
$pageRobots = 'noindex, nofollow';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>
    <main class="checkout-page">

        <!-- ─── Page Header ─── -->
        <section class="checkout-header">
            <div class="checkout-container">
                <p class="checkout-eyebrow">Sabaya Luxury</p>
                <h1 class="checkout-title">Finaliser la commande</h1>
                <p class="checkout-intro">Complétez vos informations de livraison pour confirmer votre achat.</p>
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
        <section class="checkout-content-section">
            <div class="checkout-container">
                <form method="POST" class="checkout-form" novalidate>
                    <div class="checkout-layout">

                        <!-- ═══ LEFT — Shipping Form ═══ -->
                        <div class="checkout-shipping">
                            <div class="checkout-section-card">
                                <h2 class="checkout-section-title">
                                    <i class="fas fa-shipping-fast"></i>
                                    Informations de livraison
                                </h2>
                                <div class="checkout-divider"></div>

                                <div class="checkout-field-group">
                                    <div class="checkout-field">
                                        <label for="ville" class="checkout-label">Ville</label>
                                        <input type="text" name="ville" id="ville"
                                               class="checkout-input"
                                               placeholder="Ex : Casablanca" required>
                                    </div>

                                    <div class="checkout-field">
                                        <label for="adresse" class="checkout-label">Adresse</label>
                                        <input type="text" name="adresse" id="adresse"
                                               class="checkout-input"
                                               placeholder="Ex : 12 Rue Al Amine, Maarif" required>
                                    </div>

                                    <div class="checkout-field">
                                        <label for="code_postal" class="checkout-label">Code Postal</label>
                                        <input type="text" name="code_postal" id="code_postal"
                                               class="checkout-input"
                                               placeholder="Ex : 20000" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ═══ RIGHT — Order Summary ═══ -->
                        <div class="checkout-summary">
                            <div class="checkout-summary-card">
                                <h2 class="checkout-summary-title">Récapitulatif</h2>
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
                                                <p class="checkout-item-qty">Quantité : <?= htmlspecialchars($quantite) ?></p>
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
                                    <span class="checkout-total-label">Total</span>
                                    <span class="checkout-total-value"><?= $total ?> DH</span>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="checkout-confirm-btn">
                                    <i class="fas fa-lock"></i>
                                    Confirmer la commande
                                </button>

                                <!-- Back to cart -->
                                <a href="cart.php" class="checkout-back-link">
                                    <i class="fas fa-arrow-left"></i>
                                    Retour au panier
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