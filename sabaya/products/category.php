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

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pageDescription = 'Découvrez les abayas de la catégorie ' . $categoryName . ' sur Sabaya Luxury. Mode modeste et élégante au Maroc.';

?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="<?= $categoryName ?>, abaya, mode modeste, Sabaya Luxury, Maroc">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <title><?= $categoryName ?> | Abayas — Sabaya Luxury</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="<?= $categoryName ?> | Abayas — Sabaya Luxury">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:locale" content="fr_MA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= $categoryName ?> | Abayas — Sabaya Luxury">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
</head>

<body>

<header>
    <nav aria-label="Navigation principale">
        <a href="../index.php">SABAYA</a>
        <ul>
            <li><a href="products.php">Boutique</a></li>
            <li><a href="../about.php">À propos</a></li>
            <li><a href="../contact/contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main>

```
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
                >

                <h2>
                    <?= htmlspecialchars($product['nom']) ?>
                </h2>

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

</body>

</html>
