<?php

require_once '../config/Database.php';
require_once '../models/Product.php';
require_once '../models/Category.php';

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);
$categoryModel = new Category($pdo);

$categoryId = (int) $_GET['id'];

$products = $productModel->getByCategory($categoryId);

$category = $categoryModel->find($categoryId);
$categoryName = $category ? htmlspecialchars($category['nom']) : 'Catégorie';

// Page metadata for header.php
$pageTitle = $categoryName . ' | Abayas — Sabaya Luxury';
$pageDescription = 'Découvrez les abayas de la catégorie ' . $categoryName . ' sur Sabaya Luxury. Mode modeste et élégante au Maroc.';
$pageKeywords = $categoryName . ', abaya, mode modeste, Sabaya Luxury, Maroc';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

<main>

<section aria-label="Produits de la catégorie <?= $categoryName ?>">

    <h1>Abayas <?= $categoryName ?></h1>

    <p>Découvrez notre sélection d'abayas dans la catégorie <?= $categoryName ?>. Des pièces élégantes et modernes, conçues pour la femme d'aujourd'hui.</p>

    <?php if(empty($products)): ?>

        <p>Aucun produit trouvé dans cette catégorie.</p>

    <?php else: ?>

        <?php foreach($products as $product): ?>

            <article>

                <img
                    src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                    width="150"
                    alt="<?= htmlspecialchars($product['nom']) ?> — Abaya <?= $categoryName ?> Sabaya Luxury"
                    loading="lazy"
                >

                <h3>
                    <?= htmlspecialchars($product['nom']) ?>
                </h3>

                <p>
                    <?= htmlspecialchars($product['prix']) ?> MAD
                </p>

                <a href="product-details.php?id=<?= $product['id_produit'] ?>">
                    Voir détails
                </a>

            </article>

        <?php endforeach; ?>

    <?php endif; ?>

</section>

</main>

<?php require_once '../includes/footer.php'; ?>

</body>

</html>
