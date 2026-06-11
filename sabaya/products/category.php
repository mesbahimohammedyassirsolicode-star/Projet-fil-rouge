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

require_once '../config/lang.php';

// Page metadata for header.php
$pageTitle = t('category_title_prefix') . ' ' . $categoryName . ' | ' . t('site_name');
$pageDescription = 'Découvrez les abayas de la catégorie ' . $categoryName . ' sur Sabaya Luxury. Mode modeste et élégante au Maroc.';
$pageKeywords = $categoryName . ', abaya, mode modeste, Sabaya Luxury, Maroc';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

<main>

<section aria-label="Produits de la catégorie <?= $categoryName ?>">

    <h1><?= t('category_title_prefix') ?> <?= $categoryName ?></h1>

    <p><?= str_replace('{name}', $categoryName, t('category_desc')) ?></p>

    <?php if(empty($products)): ?>

        <p><?= t('category_empty') ?></p>

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
                    <?= t('products_view_details') ?>
                </a>

            </article>

        <?php endforeach; ?>

    <?php endif; ?>

</section>

</main>

<?php require_once '../includes/footer.php'; ?>

</body>

</html>
