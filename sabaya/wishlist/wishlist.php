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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Consultez votre liste de souhaits d'abayas sur Sabaya Luxury.">
    <meta name="robots" content="noindex, nofollow">
    <title>Ma Liste de Souhaits | Sabaya Luxury</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="Ma Liste de Souhaits | Sabaya Luxury">
    <meta property="og:locale" content="fr_MA">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../products/products.php">Boutique</a></li>
                <li><a href="../products/cart.php">Mon Panier</a></li>
                <li><a href="wishlist.php">Ma Liste de souhaits</a></li>
                <li><a href="../products/my-orders.php">Mes Commandes</a></li>
                <li><a href="../auth/profile.php">Mon Profil</a></li>
                <li><a href="../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Your Wishlist</h1>

            <?php if (empty($wishlist)): ?>
                <p>Votre liste de souhaits est vide.</p>
            <?php else: ?>
                <table border="1" cellpadding="10">
                    <caption>Liste de vos produits favoris</caption>
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
                                         alt="Image de <?= htmlspecialchars($item['nom']) ?>">
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
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>
