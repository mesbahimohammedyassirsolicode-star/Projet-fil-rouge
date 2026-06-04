<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Product.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

$products = $productModel->getAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
</head>
<body>
    <h1>Gestion des Produits</h1>

<a href="add.php">Ajouter un produit</a>

<br><br>

<table border="1" cellpadding="10">

    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>
    </thead>
<?php if(empty($products)): ?>

<tr>
    <td colspan="6">
        Aucun produit trouvé
    </td>
</tr>

<?php endif; ?>
    <tbody>

    <?php foreach($products as $product): ?>

        <tr>

            <td>

                <img
                src="../../assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                width="80"
                height="80"
                >

            </td>

            <td>
                <?= htmlspecialchars($product['nom']) ?>
            </td>

            <td>
                <?= htmlspecialchars($product['prix']) ?> DH
            </td>

            <td>
                <?= htmlspecialchars($product['stock']) ?>
            </td>

            <td>
                <?= htmlspecialchars($product['categorie_nom']) ?>
            </td>

            <td>

                <a href="edit.php?id=<?= $product['id_produit'] ?>">
                    Modifier
                </a>

                |

                <a
                href="delete.php?id=<?= $product['id_produit'] ?>"
                onclick="return confirm('Supprimer ce produit ?')"
                >
                    Supprimer
                </a>

            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>

</table>
<br><br>
<a href="./dashboard.php">Retour au dashboard</a>

</body>
</html>