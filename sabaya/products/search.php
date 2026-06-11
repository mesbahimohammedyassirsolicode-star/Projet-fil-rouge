<?php

require_once '../config/Database.php';
require_once '../models/Product.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

$products = [];

if (isset($_GET['q']) && !empty(trim($_GET['q']))) {

    $keyword = trim($_GET['q']);

    $products = $productModel->search($keyword);

}

require_once '../config/lang.php';

// Page metadata for header.php
$searchQuery = htmlspecialchars($_GET['q'] ?? '');
$pageTitle = t('search_title') . (!empty($searchQuery) ? ' : ' . $searchQuery : '') . ' | ' . t('site_name');
$pageDescription = !empty($searchQuery) ? 'Résultats de recherche pour « ' . $searchQuery . ' » sur Sabaya Luxury.' : 'Recherchez des abayas et vêtements sur Sabaya Luxury.';
$pageRobots = 'noindex, follow';

// Build baseUrl for JSON-LD
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptDir !== '/' && $scriptDir !== '\\' && $scriptDir !== '') {
    $scriptDir = dirname($scriptDir);
}
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/\\');

// JSON-LD for SearchResultsPage (GEO)
$extraHeadContent = '<script type="application/ld+json">' .
    '{' .
    '"@context": "https://schema.org",' .
    '"@type": "SearchResultsPage",' .
    '"name": "Recherche de Produits — Sabaya Luxury",' .
    '"description": "Recherchez des abayas et vêtements de luxe sur Sabaya Luxury",' .
    '"url": "' . $baseUrl . '/products/search.php"' .
    '}';
if (!empty($products)) {
    $items = [];
    $pos = 1;
    foreach ($products as $p) {
        $items[] = '{' .
            '"@type": "ListItem",' .
            '"position": ' . $pos . ',' .
            '"url": "' . $baseUrl . '/products/product-details.php?id=' . $p['id_produit'] . '",' .
            '"name": "' . htmlspecialchars($p['nom']) . '"' .
        '}';
        $pos++;
    }
    $extraHeadContent .= '</script>' .
        '<script type="application/ld+json">' .
        '{' .
        '"@context": "https://schema.org",' .
        '"@type": "ItemList",' .
        '"name": "Résultats de recherche — Sabaya Luxury",' .
        '"numberOfItems": ' . count($products) . ',' .
        '"itemListElement": [' . implode(',', $items) . ']' .
        '}' .
        '</script>';
} else {
    $extraHeadContent .= '</script>';
}

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

<main>

<section class="search-hero reveal">
    <div class="search-hero__inner">
        <span class="search-hero__label"><?= t('site_name') ?></span>
        <h1 class="search-hero__title"><?= t('search_title') ?></h1>
        <div class="search-hero__line" aria-hidden="true"></div>
        <p class="search-hero__subtitle"><?= t('search_subtitle') ?></p>
    </div>
</section>

<section class="search-form-section reveal">
    <form method="GET" role="search" aria-label="<?= t('search_title') ?>" class="search-form">
        <label for="search-input" class="sr-only"><?= t('search_sr_label') ?></label>
        <div class="search-form__field">
            <i class="fa-solid fa-magnifying-glass search-form__icon" aria-hidden="true"></i>
            <input
                type="search"
                id="search-input"
                name="q"
                placeholder="<?= t('search_placeholder') ?>"
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                autocomplete="off"
                aria-describedby="search-hint"
            >
        </div>
        <p id="search-hint" class="sr-only"><?= t('search_label_hint') ?></p>
        <button type="submit" class="search-form__btn">
            <?= t('search_btn') ?>
        </button>
    </form>
</section>

<section class="search-results reveal">

    <?php if (isset($_GET['q'])): ?>

    <header class="search-results__header reveal">
            <h2 class="search-results__title"><?= t('search_results_title') ?></h2>
            <p class="search-results__count">
                <strong><?= count($products) ?></strong> <?= t('search_results_count') ?>
                <?php if (!empty($searchQuery)): ?>
                    <?= t('admin_products_results_text') ?>&nbsp;<span class="search-results__keyword"><?= $searchQuery ?></span>
                <?php endif; ?>
            </p>
        </header>

    <?php endif; ?>

    <?php if (!empty($products)): ?>

        <div class="products-grid">

            <?php foreach ($products as $product): ?>

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
                                    aria-label="<?= t('products_view_details_btn') . ' ' . htmlspecialchars($product['nom']) ?>"
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

    <?php elseif (isset($_GET['q'])): ?>

        <div class="search-empty">
            <i class="fa-solid fa-magnifying-glass search-empty__icon" aria-hidden="true"></i>
            <p class="search-empty__title"><?= t('search_empty_title') ?></p>
            <p class="search-empty__text"><?= t('search_empty_text') ?></p>
            <a href="products.php" class="btn btn-outline search-empty__btn"><?= t('search_back_to_store') ?></a>
        </div>

    <?php endif; ?>

</section>

</main>

<?php require_once '../includes/footer.php'; ?>

</body>

</html>
