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

// Compute baseUrl (project root) and canonicalUrl before header.php so it's available for JSON-LD
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptDir !== '/' && $scriptDir !== '\\' && $scriptDir !== '') {
    $scriptDir = dirname($scriptDir);
}
$baseUrl  = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/\\');
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Page metadata for header.php
$pageTitle = t('category_title_prefix') . ' ' . $categoryName . ' | ' . t('site_name');
$pageDescription = 'Découvrez les abayas de la catégorie ' . $categoryName . ' sur Sabaya Luxury. Mode modeste et élégante au Maroc.';
$pageKeywords = $categoryName . ', abaya, mode modeste, Sabaya Luxury, Maroc';

// Build page-specific JSON-LD for ItemList & Breadcrumbs
$extraHeadContent = '';
$itemListElement = [];
$pos = 1;
if (!empty($products)) {
    foreach($products as $p) {
        $itemListElement[] = '{
            "@type": "ListItem",
            "position": ' . $pos . ',
            "url": "' . $baseUrl . '/products/product-details.php?id=' . $p['id_produit'] . '",
            "name": "' . htmlspecialchars($p['nom']) . '"
        }';
        $pos++;
    }
}

$extraHeadContent = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "Catégorie ' . $categoryName . ' — Sabaya Luxury",
    "description": "' . $pageDescription . '",
    "numberOfItems": ' . count($products) . ',
    "itemListElement": [' . implode(',', $itemListElement) . ']
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "' . t('product_breadcrumb_home') . '",
            "item": "' . $baseUrl . '/index.php"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "' . $categoryName . '",
            "item": "' . htmlspecialchars($canonicalUrl) . '"
        }
    ]
}
</script>';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

<main>

    <!-- Breadcrumb -->
    <div class="container" style="margin-top: 2rem; max-width: 1200px; padding: 0 20px; margin-left: auto; margin-right: auto;">
        <nav class="pd-breadcrumb" aria-label="<?= t('breadcrumb_label') ?>">
            <a href="../index.php"><?= t('product_breadcrumb_home') ?></a>
            <span class="pd-breadcrumb-sep">/</span>
            <span class="pd-breadcrumb-current"><?= $categoryName ?></span>
        </nav>
    </div>

    <section class="collection-header reveal">
        <h1><?= t('category_title_prefix') ?> <?= $categoryName ?></h1>
        <p class="collection-subtitle"><?= str_replace('{name}', $categoryName, t('category_desc')) ?></p>
    </section>

    <section class="collection-products reveal" style="padding-bottom: 5rem;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <?php if(empty($products)): ?>
                <p class="collection-empty" style="text-align: center; font-size: 1.2rem; color: var(--color-text-muted); margin: 3rem 0;"><?= t('category_empty') ?></p>
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
                                        <span class="product-card-overlay-btn product-card-overlay-btn--primary">
                                            <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                            <?= t('products_view_details_btn') ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <div class="product-card-body">
                                <span class="product-card-brand"><?= t('products_brand') ?></span>
                                <h3 class="product-card-name">
                                    <?= htmlspecialchars($product['nom']) ?>
                                </h3>
                                <p class="product-card-price">
                                    <?= htmlspecialchars($product['prix']) ?> MAD
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
        </div>
    </section>

</main>

<?php require_once '../includes/footer.php'; ?>

</body>

</html>
