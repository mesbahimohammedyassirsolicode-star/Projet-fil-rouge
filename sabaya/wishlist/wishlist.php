<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Wishlist.php';

$db = new Database();
$pdo = $db->getConnection();

$wishlistModel = new Wishlist($pdo);

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$id_client = $_SESSION['user_id'];

$wishlist = $wishlistModel->getUserWishlist($id_client);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
</head>
<body>
    <h1>Your Wishlist</h1>

    <?php if (empty($wishlist)): ?>
        <p>Votre liste de souhaits est vide.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom du produit</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wishlist as $item): ?>
                    <tr>
                        <td>
                            <img src="../assets/images/products/<?= htmlspecialchars($item['image']) ?>"
                                 alt="<?= htmlspecialchars($item['nom']) ?>">
                        </td>
                        <td>
                            <?= htmlspecialchars($item['nom']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($item['prix']) ?> DH
                        </td>
                        <td>
                            <!-- Bouton vers page produit -->
                            <a href="../products/product-details.php?id=<?= $item['id_produit'] ?>">
                                Voir le produit
                            </a>
                            <!-- Bouton supprimer -->
                            <a href="remove-wishlist.php?id=<?= $item['id_wishlist'] ?>">
                                Supprimer
                            </a>
                            <a href="../products/products.php">
                                Retour aux produits
                            </a>    
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
