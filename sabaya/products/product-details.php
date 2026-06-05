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

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$productName = htmlspecialchars($product['nom']);
$productDesc = htmlspecialchars($product['description']);
$productPrice = htmlspecialchars($product['prix']);
$productImage = $baseUrl . '/assets/images/products/' . htmlspecialchars($product['image']);
$pageDescription = $productName . ' — ' . $productDesc . ' | Disponible sur Sabaya Luxury au Maroc.';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="<?= $productName ?>, abaya, mode modeste, Sabaya Luxury, Maroc">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <title><?= $productName ?> | Sabaya Luxury — Abayas Modernes</title>

    <!-- Open Graph -->
    <meta property="og:type" content="product">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="<?= $productName ?> | Sabaya Luxury">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image" content="<?= $productImage ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:locale" content="fr_MA">
    <meta property="product:price:amount" content="<?= $productPrice ?>">
    <meta property="product:price:currency" content="MAD">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $productName ?> | Sabaya Luxury">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= $productImage ?>">

    <!-- JSON-LD Structured Data: Product -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Product",
        "name": "<?= $productName ?>",
        "description": "<?= $productDesc ?>",
        "image": "<?= $productImage ?>",
        "brand": {
            "@type": "Brand",
            "name": "Sabaya Luxury"
        },
        "offers": {
            "@type": "Offer",
            "url": "<?= htmlspecialchars($canonicalUrl) ?>",
            "priceCurrency": "MAD",
            "price": "<?= $productPrice ?>",
            "availability": "https://schema.org/InStock",
            "seller": {
                "@type": "Organization",
                "name": "Sabaya Luxury"
            }
        },
        "color": "<?= htmlspecialchars($product['couleur']) ?>",
        "size": "<?= htmlspecialchars($product['taille']) ?>"
    }
    </script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="products.php">Boutique</a></li>
                <li><a href="cart.php">Mon Panier</a></li>
                <li><a href="../wishlist/wishlist.php">Ma Liste de souhaits</a></li>
                <li><a href="my-orders.php">Mes Commandes</a></li>
                <li><a href="../auth/profile.php">Mon Profil</a></li>
                <li><a href="../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <section aria-label="Détails du produit">
            <article class="product-details">
                <img src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['nom']) ?> — Abaya <?= htmlspecialchars($product['couleur']) ?> taille <?= htmlspecialchars($product['taille']) ?>">

                <h1><?= htmlspecialchars($product['nom']) ?></h1>

                <p><?= htmlspecialchars($product['description']) ?></p>

                <p>Prix : <span itemprop="price"><?= htmlspecialchars($product['prix']) ?></span> <span itemprop="priceCurrency">MAD</span></p>

                <p>Taille : <?= htmlspecialchars($product['taille']) ?></p>

                <p>Couleur : <?= htmlspecialchars($product['couleur']) ?></p>
            </article>

            <aside class="product-actions">
                <a href="add-cart.php?id=<?= $product['id_produit'] ?>">
                    Ajouter au panier
                </a>

                <a href="../wishlist/add-wishlist.php?id=<?= $product['id_produit'] ?>">
                    Ajouter à la wishlist
                </a>
                <a href="../wishlist/wishlist.php">
                    Voir la wishlist
                </a>
            </aside>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>
