<?php

require_once '../config/Database.php';
require_once '../models/Product.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

$products = $productModel->getAll();

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

<section class="collection-header">
    <h1>Modern Collection</h1>
    <p class="collection-subtitle">Elevated essentials for the contemporary woman.</p>
</section>

<section class="collection-search">
    <form method="GET" action="<?= htmlspecialchars($baseUrl) ?>/products/search.php" role="search" class="search-bar">
        <label for="collection-search-input" class="sr-only">Rechercher un produit</label>
        <input
            type="search"
            id="collection-search-input"
            name="q"
            placeholder="Rechercher dans la collection..."
        >
    </form>
</section>

<section class="collection-products">

    <?php if(empty($products)): ?>

        <p class="collection-empty">Aucun produit disponible.</p>

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
                        </div>
                    </a>

                    <div class="product-card-body">

                        <span class="product-card-brand">SABAYA</span>

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
                            Voir détails
                        </a>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>

<nav class="collection-pagination" aria-label="Pagination de la collection">
    <!-- Pagination placeholder -->
</nav>

</main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>