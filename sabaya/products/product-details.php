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

// Build page-specific JSON-LD for Product
$extraHeadContent = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "' . $productName . '",
    "description": "' . $productDesc . '",
    "image": "' . $productImage . '",
    "brand": {
        "@type": "Brand",
        "name": "Sabaya Luxury"
    },
    "offers": {
        "@type": "Offer",
        "url": "' . htmlspecialchars($canonicalUrl) . '",
        "priceCurrency": "MAD",
        "price": "' . $productPrice . '",
        "availability": "https://schema.org/InStock",
        "seller": {
            "@type": "Organization",
            "name": "Sabaya Luxury"
        }
    },
    "color": "' . htmlspecialchars($product['couleur']) . '",
    "size": "' . htmlspecialchars($product['taille']) . '"
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
            <a href="products.php"><?= t('product_breadcrumb_collection') ?></a>
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

                <p class="pd-description"><?= htmlspecialchars($product['description']) ?></p>

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
                    <a href="add-cart.php?id=<?= $product['id_produit'] ?>" class="btn pd-btn-cart">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <?= t('product_add_to_cart') ?>
                    </a>

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
