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
    <title>Mon Panier</title>
</head>
<body>

<h1>Mon Panier</h1>

<?php if (empty($cart)): ?>

    <p>Votre panier est vide.</p>

<?php else: ?>

<table border="1" cellpadding="10">

    <tr>
        <th>Image</th>
        <th>Produit</th>
        <th>Prix</th>
        <th>Quantité</th>
        <th>Sous-total</th>
        <th>Action</th>
    </tr>

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
                <img
                    src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                    width="80"
                >
            </td>

            <td>
                <?= htmlspecialchars($product['nom']) ?>
            </td>

            <td>
                <?= htmlspecialchars($product['prix']) ?> DH
            </td>

            <td>
                <?= $quantite ?>
            </td>

            <td>
                <?= $sousTotal ?> DH
            </td>

            <td>
                <a href="remove-cart.php?id=<?= $product['id_produit'] ?>">
                    Supprimer
                </a>
            </td>

        </tr>

    <?php endforeach; ?>

</table>

<h2>Total : <?= $total ?> DH</h2>

<?php endif; ?>

<br>
<br>

<a href="checkout.php">
    Passer la commande
</a>

<br><br>



<a href="products.php">
    Continuer mes achats
</a>

</body>
</html>