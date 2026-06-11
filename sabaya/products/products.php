<?php

require_once '../config/Database.php';
require_once '../models/Product.php';
require_once '../models/Category.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);
$categoryModel = new Category($pdo);

// Fetch all categories for the filter bar
$categories = $categoryModel->getAll();

// Handle category filter via GET parameter
$currentCategoryId = null;
$currentPageUrl = 'products.php';

if (!empty($_GET['categorie'])) {
    $currentCategoryId = (int) $_GET['categorie'];
    $products = $productModel->getByCategory($currentCategoryId);
    $currentPageUrl = 'products.php?categorie=' . $currentCategoryId;
} else {
    $products = $productModel->getAll();
}

// Page metadata for header.php
$pageTitle = 'Boutique Abayas | Collection Mode Modeste — Sabaya Luxury';
$pageDescription = 'Découvrez notre collection d\'abayas modernes et élégantes sur Sabaya Luxury. Mode modeste, qualité premium, livraison au Maroc.';
$pageKeywords = 'abayas, collection abaya, mode modeste, boutique en ligne, Maroc, Sabaya Luxury';

// Compute baseUrl (project root) before header.php so it's available for JSON-LD
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptDir !== '/' && $scriptDir !== '\\' && $scriptDir !== '') {
    $scriptDir = dirname($scriptDir);
}
$baseUrl  = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/\\');

// Build page-specific JSON-LD for ItemList
$extraHeadContent = '';
if (!empty($products)) {
    $items = [];
    $pos = 1;
    foreach($products as $p) {
        $items[] = '{' .
            '"@type": "ListItem",' .
            '"position": ' . $pos . ',' .
            '"url": "' . $baseUrl . '/products/product-details.php?id=' . $p['id_produit'] . '",' .
            '"name": "' . htmlspecialchars($p['nom']) . '"' .
        '}';
        $pos++;
    }
    $extraHeadContent = '<script type="application/ld+json">' .
        '{' .
        '"@context": "https://schema.org",' .
        '"@type": "ItemList",' .
        '"name": "Collection Abayas Sabaya Luxury",' .
        '"description": "Collection complète d\'abayas modernes et élégantes disponibles sur Sabaya Luxury",' .
        '"numberOfItems": ' . count($products) . ',' .
        '"itemListElement": [' . implode(',', $items) . ']' .
        '}' .
        '</script>';
}

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

<main>

<section class="collection-header reveal">
    <h1><?= t('products_page_title') ?></h1>
    <p class="collection-subtitle"><?= t('products_page_subtitle') ?></p>
</section>

<section class="collection-search reveal">
    <form method="GET" action="<?= htmlspecialchars($baseUrl) ?>/products/search.php" role="search" class="search-bar">
        <label for="collection-search-input" class="sr-only"><?= t('search_sr_label') ?></label>
        <input
            type="search"
            id="collection-search-input"
            name="q"
            placeholder="<?= t('products_search_placeholder') ?>"
        >
    </form>
</section>

<section class="collection-filters reveal">
    <nav class="category-filters" aria-label="Filtrer par catégorie">
        <a
            href="products.php"
            class="category-filter-btn<?= $currentCategoryId === null ? ' category-filter-btn--active' : '' ?>"
        >
            <?= t('products_filter_all') ?>
        </a>
        <?php foreach ($categories as $cat): ?>
            <a
                href="products.php?categorie=<?= (int) $cat['id_categorie'] ?>"
                class="category-filter-btn<?= $currentCategoryId === (int) $cat['id_categorie'] ? ' category-filter-btn--active' : '' ?>"
            >
                <?= htmlspecialchars($cat['nom']) ?>
            </a>
        <?php endforeach; ?>
    </nav>
</section>

<section class="collection-products reveal">

    <?php if(empty($products)): ?>

        <p class="collection-empty"><?= t('products_empty') ?></p>

    <?php else: ?>

        <div class="products-grid">

            <?php foreach($products as $product): ?>

                <article class="product-card">

                    <a href="product-details.php?id=<?= $product['id_produit'] ?>" class="product-card-link">
                        <div class="product-card-image">
                            <img
                                src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['nom']) ?> — Abaya Sabaya Luxury"
                                loading="lazy"
                            >
                            <!-- Slide-up overlay -->
                            <div class="product-card-overlay" aria-hidden="true">
                                <a
                                    class="product-card-overlay-btn product-card-overlay-btn--primary"
                                    href="product-details.php?id=<?= $product['id_produit'] ?>"
                                    tabindex="-1"
                                    aria-label="Voir les détails de <?= htmlspecialchars($product['nom']) ?>"
                                >
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    <?= t('products_view_details_btn') ?>
                                </a>
                            </div>
                        </div>
                    </a>

                    <div class="product-card-body">

        <span class="product-card-brand"><?= t('products_brand') ?></span>

                        <h3 class="product-card-name">
                            <?= htmlspecialchars($product['nom']) ?>
                        </h3>

                        <p class="product-card-price">
                            <?= htmlspecialchars($product['prix']) ?> DH
                        </p>

                        <a
                            class="product-card-btn"
                            href="product-details.php?id=<?= $product['id_produit'] ?>"
                        >
                            <?= t('products_view_details') ?>
                        </a>

                    </div>

                </article>


            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>

<nav class="collection-pagination reveal" aria-label="Pagination de la collection">
    <!-- Pagination placeholder -->
</nav>

</main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>