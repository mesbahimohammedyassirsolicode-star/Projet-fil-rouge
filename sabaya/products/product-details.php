<?php

require_once '../config/Database.php';
require_once '../models/Product.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$id = (int) $_GET['id'];

$product = $productModel->find($id);

if (!$product) {
    header('Location: products.php');
    exit();
}

require_once '../config/lang.php';

// Page metadata for header.php
$productName = htmlspecialchars($product['nom']);
$productDesc = htmlspecialchars($product['description']);
$productPrice = htmlspecialchars($product['prix']);
$pageTitle = $productName . ' | ' . t('product_page_title_suffix');
$pageDescription = $productName . ' — ' . $productDesc . ' | ' . t('product_page_description_suffix');
$pageKeywords = $productName . ', ' . t('product_page_keywords');
$ogType = 'product';

// Compute baseUrl (project root) before header.php so it's available for JSON-LD and pageImage
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptDir !== '/' && $scriptDir !== '\\' && $scriptDir !== '') {
    $scriptDir = dirname($scriptDir);
}
$baseUrl  = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/\\');
$productImage = $baseUrl . '/assets/images/products/' . htmlspecialchars($product['image']);
$pageImage = $productImage;
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Build page-specific JSON-LD for Product and Breadcrumbs
$categoryName = htmlspecialchars($product['categorie_nom'] ?? t('product_breadcrumb_collection'));
$availability = $product['stock'] > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
$sku = 'SAB-' . (int)$product['id_produit'];
$priceValidUntil = date('Y-12-31', strtotime('+1 year'));

$extraHeadContent = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "' . $productName . '",
    "description": "' . $productDesc . '",
    "image": "' . $productImage . '",
    "sku": "' . $sku . '",
    "mpn": "' . $sku . '",
    "category": "' . $categoryName . '",
    "brand": {
        "@type": "Brand",
        "name": "Sabaya Luxury"
    },
    "offers": {
        "@type": "Offer",
        "url": "' . htmlspecialchars($canonicalUrl) . '",
        "priceCurrency": "MAD",
        "price": "' . $productPrice . '",
        "priceValidUntil": "' . $priceValidUntil . '",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "' . $availability . '",
        "seller": {
            "@type": "Organization",
            "name": "Sabaya Luxury",
            "url": "' . $baseUrl . '"
        }
    },
    "color": "' . htmlspecialchars($product['couleur']) . '",
    "size": "' . htmlspecialchars($product['taille']) . '"
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
            "item": "' . $baseUrl . '/products/category.php?id=' . (int)$product['id_categorie'] . '"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "' . $productName . '",
            "item": "' . htmlspecialchars($canonicalUrl) . '"
        }
    ]
}
</script>';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

    <main class="pd-wrapper">

        <!-- Breadcrumb -->
        <nav class="pd-breadcrumb" aria-label="<?= t('breadcrumb_label') ?>">
            <a href="../index.php"><?= t('product_breadcrumb_home') ?></a>
            <span class="pd-breadcrumb-sep">/</span>
            <?php if (!empty($product['id_categorie'])): ?>
                <a href="category.php?id=<?= (int)$product['id_categorie'] ?>"><?= htmlspecialchars($product['categorie_nom'] ?? t('product_breadcrumb_collection')) ?></a>
            <?php else: ?>
                <a href="products.php"><?= t('product_breadcrumb_collection') ?></a>
            <?php endif; ?>
            <span class="pd-breadcrumb-sep">/</span>
            <span class="pd-breadcrumb-current"><?= htmlspecialchars($product['nom']) ?></span>
        </nav>

    <section class="pd-layout reveal" aria-label="<?= t('product_details_label') ?>">

            <!-- LEFT: Product Image -->
            <div class="pd-gallery reveal">
                <div class="pd-gallery-main">
                    <img
                        src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['nom']) ?> — <?= t('product_alt_abaya') ?> <?= htmlspecialchars($product['couleur']) ?> <?= t('product_alt_size') ?> <?= htmlspecialchars($product['taille']) ?>"
                    >
                </div>
            </div>

            <!-- RIGHT: Product Information -->
            <div class="pd-info reveal">

                <span class="pd-brand"><?= t('site_name') ?></span>

                <h1 class="pd-title"><?= htmlspecialchars($product['nom']) ?></h1>

                <div class="pd-price">
                    <span class="pd-price-value"><?= htmlspecialchars($product['prix']) ?></span>
                    <span class="pd-price-currency"> MAD</span>
                </div>

                <div class="pd-divider"></div>

                <h2 class="sr-only"><?= t('product_details_label') ?></h2>
                <p class="pd-description"><?= htmlspecialchars($product['description']) ?></p>

                <h2 class="pd-specs-title" style="font-size: 1.1rem; margin-top: 1.5rem; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted, #666);"><?= t('product_specs_heading', 'Details & Specs') ?></h2>
                <div class="pd-specs">
                    <div class="pd-spec">
                                <span class="pd-spec-label"><?= t('product_color') ?></span>
                        <span class="pd-spec-value"><?= htmlspecialchars($product['couleur']) ?></span>
                    </div>
                    <div class="pd-spec">
                                <span class="pd-spec-label"><?= t('product_size') ?></span>
                        <span class="pd-spec-value"><?= htmlspecialchars($product['taille']) ?></span>
                    </div>
                </div>

                <div class="pd-divider"></div>

                <div class="pd-actions">
                    <?php if ($product['stock'] > 0): ?>
                        <a href="add-cart.php?id=<?= $product['id_produit'] ?>" class="btn pd-btn-cart">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <?= t('product_add_to_cart') ?>
                        </a>
                    <?php else: ?>
                        <button class="btn pd-btn-cart" disabled style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fa-solid fa-ban"></i>
                            <?= t('product_out_of_stock') ?>
                        </button>
                    <?php endif; ?>

                    <a href="../wishlist/add-wishlist.php?id=<?= $product['id_produit'] ?>" class="btn-outline pd-btn-wishlist" data-wishlist-pulse>
                        <i class="fa-regular fa-heart"></i>
                        <?= t('product_add_to_wishlist') ?>
                    </a>
                </div>

                <a href="../wishlist/wishlist.php" class="pd-wishlist-link">
                    <i class="fa-solid fa-arrow-right"></i>
                    <?= t('product_view_wishlist') ?>
                </a>

            </div>

        </section>
    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
