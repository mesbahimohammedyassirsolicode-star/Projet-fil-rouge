<?php

require_once '../config/Database.php';
require_once '../models/Product.php';

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

$products = $productModel->getAll();

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pageDescription = 'Découvrez notre collection d\'abayas modernes et élégantes sur Sabaya Luxury. Mode modeste, qualité premium, livraison au Maroc.';
$pageImage = $baseUrl . '/assets/images/logo/sabaya-logo.jpg';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="abayas, collection abaya, mode modeste, boutique en ligne, Maroc, Sabaya Luxury">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <title>Boutique Abayas | Collection Mode Modeste — Sabaya Luxury</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="Boutique Abayas | Collection Mode Modeste — Sabaya Luxury">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:locale" content="fr_MA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Boutique Abayas | Collection Mode Modeste — Sabaya Luxury">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">

    <!-- JSON-LD Structured Data: ItemList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "Collection Abayas Sabaya Luxury",
        "description": "Collection complète d'abayas modernes et élégantes disponibles sur Sabaya Luxury",
        "numberOfItems": <?= count($products) ?>,
        "itemListElement": [
            <?php
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
            echo implode(',', $items);
            ?>
        ]
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
        <section>
            <h1>Modern Collection</h1>

            <?php if(empty($products)): ?>
                <p>Aucun produit disponible.</p>
            <?php endif; ?>

            <?php foreach($products as $product): ?>
                <article class="card">
                    <img src="../assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="Photo de <?= htmlspecialchars($product['nom']) ?>" width="200">
                    <h3><?= htmlspecialchars($product['nom']) ?></h3>
                    <p><?= htmlspecialchars($product['prix']) ?> DH</p>
                    <a href="product-details.php?id=<?= $product['id_produit'] ?>">Voir détails</a>
                    <a href="add-cart.php?id=<?= $product['id_produit'] ?>">Ajouter au panier</a>
                    <a href="../contact/contact.php?id=<?= $product['id_produit'] ?>">Contacter l'administrateur</a>
                    <a href="my-orders.php">Mes Commandes</a>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>