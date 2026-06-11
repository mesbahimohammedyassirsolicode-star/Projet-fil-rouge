<?php

require_once 'config/Database.php';
require_once 'models/Product.php';
require_once 'models/Category.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);
$categoryModel = new Category($pdo);

$products = $productModel->getAll();
$categories = $categoryModel->getAll();

$newArrivals = array_slice($products, 0, 8);

// Page metadata for header.php
$pageTitle = 'Sabaya Luxury | Abayas Modernes & Mode Modeste au Maroc';
$pageDescription = 'Sabaya Luxury - Boutique en ligne d\'abayas modernes et élégantes au Maroc. Découvrez nos collections de mode modeste, abayas premium, et vêtements raffinés pour femmes.';
$pageKeywords = 'abaya, abayas, mode modeste, hijab, vêtements femmes, Maroc, Tangier, Sabaya, luxury, abaya moderne, abaya élégante';
// $pageImage will use the default logo from header.php

require_once 'includes/header.php';
require_once 'includes/navbar.php';

?>

<main>
<section class="hero reveal">

    <div class="hero-bg"></div>

    <div class="hero-overlay"></div>

    <div class="hero-content">

        <span class="hero-subtitle">
            <?= t('home_hero_subtitle') ?>
        </span>

        <h1>
            <?= t('home_hero_title') ?>
        </h1>

        <div class="hero-line"></div>

        <p>
            <?= t('home_hero_desc') ?>
        </p>

        <div class="hero-actions">
            <a href="products/products.php" class="btn">
                <?= t('home_btn_collection') ?>
            </a>
            <a href="about.php" class="btn-outline btn-outline--light">
                <?= t('home_btn_story') ?>
            </a>
        </div>

    </div>

</section>
<section class="new-arrivals reveal">

    <div class="container">

        <h2><?= t('home_new_arrivals') ?></h2>

        <div class="grid grid-4">

            <?php foreach ($newArrivals as $product): ?>

            <article class="card reveal">

                <img
                    src="assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['nom']) ?> — Abaya Sabaya Luxury"
                    loading="lazy"
                >

                <div class="card-content">

                    <h3>
                        <?= htmlspecialchars($product['nom']) ?>
                    </h3>

                    <p class="price">
                        <?= htmlspecialchars($product['prix']) ?> DH
                    </p>

                    <a
                        class="btn"
                        href="products/product-details.php?id=<?= $product['id_produit'] ?>"
                    >
                        <?= t('home_view_details') ?>
                    </a>

                </div>

            </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>
</main>

<?php require_once 'includes/footer.php'; ?>

</body>

</html>