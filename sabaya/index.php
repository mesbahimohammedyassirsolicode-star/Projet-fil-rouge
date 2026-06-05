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

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$siteName = 'Sabaya Luxury';
$pageDescription = 'Sabaya Luxury - Boutique en ligne d\'abayas modernes et élégantes au Maroc. Découvrez nos collections de mode modeste, abayas premium, et vêtements raffinés pour femmes.';
$pageImage = $baseUrl . '/assets/images/logo/sabaya-logo.jpg';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="abaya, abayas, mode modeste, hijab, vêtements femmes, Maroc, Casablanca, Sabaya, luxury, abaya moderne, abaya élégante">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Sabaya Luxury">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <title>Sabaya Luxury | Abayas Modernes & Mode Modeste au Maroc</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= htmlspecialchars($siteName) ?>">
    <meta property="og:title" content="Sabaya Luxury | Abayas Modernes & Mode Modeste au Maroc">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:locale" content="fr_MA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sabaya Luxury | Abayas Modernes & Mode Modeste au Maroc">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">

    <!-- JSON-LD Structured Data: Organization + Store + Website -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "Organization",
                "@id": "<?= htmlspecialchars($baseUrl) ?>/#organization",
                "name": "Sabaya Luxury",
                "url": "<?= htmlspecialchars($baseUrl) ?>",
                "logo": {
                    "@type": "ImageObject",
                    "url": "<?= htmlspecialchars($pageImage) ?>"
                },
                "contactPoint": {
                    "@type": "ContactPoint",
                    "telephone": "+212-6XX-XXX-XXX",
                    "contactType": "customer service",
                    "availableLanguage": ["French", "Arabic"]
                },
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "Casablanca",
                    "addressCountry": "MA"
                },
                "email": "contact@sabaya.ma",
                "sameAs": []
            },
            {
                "@type": "Store",
                "@id": "<?= htmlspecialchars($baseUrl) ?>/#store",
                "name": "Sabaya Luxury",
                "description": "Boutique en ligne d'abayas modernes et élégantes au Maroc. Mode modeste et raffinée pour femmes.",
                "url": "<?= htmlspecialchars($baseUrl) ?>",
                "currenciesAccepted": "MAD",
                "paymentAccepted": "Cash, Credit Card",
                "priceRange": "$$",
                "image": "<?= htmlspecialchars($pageImage) ?>",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "Casablanca",
                    "addressCountry": "MA"
                }
            },
            {
                "@type": "WebSite",
                "@id": "<?= htmlspecialchars($baseUrl) ?>/#website",
                "name": "Sabaya Luxury",
                "url": "<?= htmlspecialchars($baseUrl) ?>",
                "description": "Boutique en ligne d'abayas modernes et élégantes au Maroc",
                "publisher": {
                    "@id": "<?= htmlspecialchars($baseUrl) ?>/#organization"
                },
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": "<?= htmlspecialchars($baseUrl) ?>/products/search.php?q={search_term_string}",
                    "query-input": "required name=search_term_string"
                }
            }
        ]
    }
    </script>
</head>

<body>

<header>
    <nav aria-label="Navigation principale">
        <a href="index.php" aria-label="Accueil Sabaya Luxury">SABAYA</a>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="products/products.php">Boutique</a></li>
            <li><a href="about.php">À propos</a></li>
            <li><a href="contact/contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main>

<section aria-label="Bannière principale">

    <h1>Sabaya Luxury — The Art of Modesty</h1>

    <p>
        Sabaya Luxury est une boutique marocaine spécialisée dans les abayas modernes et élégantes.
        Découvrez nos collections de mode modeste, alliant tradition et modernité pour sublimer chaque femme.
    </p>

    <a href="products/products.php">
        Explorer la collection
    </a>

</section>

<section aria-label="Nos catégories">

    <h2>Nos Catégories</h2>

    <?php foreach ($categories as $category): ?>

        <article>

            <h3>
                <?= htmlspecialchars($category['nom']) ?>
            </h3>

            <a href="products/category.php?id=<?= $category['id_categorie'] ?>">
                Voir produits
            </a>

        </article>

    <?php endforeach; ?>

</section>

<section aria-label="Nouveautés">

    <h2>New Arrivals</h2>

    <?php foreach ($newArrivals as $product): ?>

        <article>

            <img
                src="assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                width="150"
                alt="<?= htmlspecialchars($product['nom']) ?> — Abaya disponible sur Sabaya Luxury"
            >

            <h3>
                <?= htmlspecialchars($product['nom']) ?>
            </h3>

            <p>
                <?= htmlspecialchars($product['prix']) ?> DH
            </p>

            <a href="products/product-details.php?id=<?= $product['id_produit'] ?>">
                Voir détails
            </a>

        </article>

    <?php endforeach; ?>

</section>

</main>

<footer>

    <nav aria-label="Liens du footer">
        <a href="index.php">Accueil</a>
        <a href="products/products.php">Boutique</a>
        <a href="about.php">À propos</a>
        <a href="contact/contact.php">Contact</a>
    </nav>
    <p>&copy; <?= date('Y') ?> Sabaya Luxury. Tous droits réservés.</p>

</footer>

</body>

</html>