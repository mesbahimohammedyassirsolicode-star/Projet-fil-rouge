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

// Page metadata for header.php
$pageTitle = 'Sabaya Luxury | Abayas Modernes & Mode Modeste au Maroc';
$pageDescription = 'Sabaya Luxury - Boutique en ligne d\'abayas modernes et élégantes au Maroc. Découvrez nos collections de mode modeste, abayas premium, et vêtements raffinés pour femmes.';
$pageKeywords = 'abaya, abayas, mode modeste, hijab, vêtements femmes, Maroc, Casablanca, Sabaya, luxury, abaya moderne, abaya élégante';
// $pageImage will use the default logo from header.php

require_once 'includes/header.php';
require_once 'includes/navbar.php';

?>

<main>
<section class="hero">

    <div class="container">

        <span class="hero-subtitle">
            SABAYA LUXURY
        </span>

        <h1>
            The Art of Modesty
        </h1>

        <p>
            Découvrez des collections d'abayas raffinées,
            conçues pour les femmes modernes qui recherchent
            élégance, confort et distinction.
        </p>

        <a href="products/products.php" class="btn">
            Explorer la collection
        </a>

    </div>

</section>
<section class="new-arrivals">

    <div class="container">

        <h2>New Arrivals</h2>

        <div class="grid grid-4">

            <?php foreach ($newArrivals as $product): ?>

            <article class="card">

                <img
                    src="assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['nom']) ?> — Abaya Sabaya Luxury"
                    loading="lazy"
                >

                <div class="card-content">

                    <h3>
                        <?= htmlspecialchars($product['nom']) ?>
                    </h3>

                    <p class="price">
                        <?= htmlspecialchars($product['prix']) ?> DH
                    </p>

                    <a
                        class="btn"
                        href="products/product-details.php?id=<?= $product['id_produit'] ?>"
                    >
                        Voir détails
                    </a>

                </div>

            </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>
</main>

<?php require_once 'includes/footer.php'; ?>

</body>

</html>