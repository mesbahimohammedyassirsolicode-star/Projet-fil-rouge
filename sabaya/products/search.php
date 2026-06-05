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

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');
$searchQuery = htmlspecialchars($_GET['q'] ?? '');
$pageDescription = !empty($searchQuery) ? 'Résultats de recherche pour « ' . $searchQuery . ' » sur Sabaya Luxury.' : 'Recherchez des abayas et vêtements sur Sabaya Luxury.';

?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <title>Recherche<?= !empty($searchQuery) ? ' : ' . $searchQuery : '' ?> | Sabaya Luxury</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="Recherche<?= !empty($searchQuery) ? ' : ' . $searchQuery : '' ?> | Sabaya Luxury">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:locale" content="fr_MA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Recherche<?= !empty($searchQuery) ? ' : ' . $searchQuery : '' ?> | Sabaya Luxury">
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

<section>

    <form method="GET">

        <input
            type="text"
            name="q"
            placeholder="Rechercher un produit..."
            value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
        >

        <button type="submit">
            Rechercher
        </button>

    </form>

</section>

<hr>

<section>

    <?php if (!empty($products)): ?>

        <?php foreach ($products as $product): ?>

            <article>

                <img
                    src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                    width="150"
                    alt="<?= htmlspecialchars($product['nom']) ?>"
                >

                <h3>
                    <?= htmlspecialchars($product['nom']) ?>
                </h3>

                <p>
                    <?= htmlspecialchars($product['prix']) ?> DH
                </p>

                <a href="product-details.php?id=<?= $product['id_produit'] ?>">
                    Voir détails
                </a>

            </article>

            <hr>

        <?php endforeach; ?>

    <?php elseif(isset($_GET['q'])): ?>

        <p>Aucun produit trouvé.</p>

    <?php endif; ?>

</section>

</main>

</body>

</html>
