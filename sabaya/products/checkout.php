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

    unset($_SESSION['cart']);

    header('Location: order-success.php');
    exit();
}


}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Finalisez votre commande d'abayas sur Sabaya Luxury.">
    <meta name="robots" content="noindex, nofollow">
    <title>Finaliser la commande | Sabaya Luxury</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="Finaliser la commande | Sabaya Luxury">
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
            <h1>Finaliser la commande</h1>

            <?php if (isset($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <p style="color:red;">
                        <?= htmlspecialchars($error) ?>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>

            <form method="POST">
                <fieldset>
                    <legend>Informations de livraison</legend>
                    <p>
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" id="ville">
                    </p>
                    <p>
                        <label for="adresse">Adresse</label>
                        <input type="text" name="adresse" id="adresse">
                    </p>
                    <p>
                        <label for="code_postal">Code Postal</label>
                        <input type="text" name="code_postal" id="code_postal">
                    </p>
                </fieldset>

                <fieldset>
                    <legend>Récapitulatif de la commande</legend>
                    <table border="1" cellpadding="10">
                        <caption>Articles dans votre commande</caption>
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Quantité</th>
                                <th>Sous Total</th>
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
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['nom']) ?></td>
                                    <td><?= htmlspecialchars($product['prix']) ?> DH</td>
                                    <td><?= htmlspecialchars($quantite) ?></td>
                                    <td><?= htmlspecialchars($sousTotal) ?> DH</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <h3>Total Général : <?= $total ?> DH</h3>
                    <button type="submit">Confirmer la commande</button>
                </fieldset>
            </form>

            <br>
            <a href="cart.php">Retour au panier</a>
        </section>
    </main>
    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>