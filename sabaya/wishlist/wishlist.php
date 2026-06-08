<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Wishlist.php';

$db = new Database();
$pdo = $db->getConnection();

$wishlistModel = new Wishlist($pdo);

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$id_client = $_SESSION['user_id'];

$wishlist = $wishlistModel->getUserWishlist($id_client);

$wishlistCount = count($wishlist);

$pageTitle = 'Ma Liste de Souhaits | Sabaya Luxury — Abayas Favorites & Collection Luxe';
$pageDescription = 'Retrouvez vos abayas et produits favoris enregistrés sur Sabaya Luxury. Votre sélection personnelle de mode modeste haut de gamme.';
$pageRobots = 'noindex, nofollow';

$pageKeywords = 'liste de souhaits, wishlist, abaya favorite, abaya luxe, mode modeste, Sabaya Luxury, collection personnelle';

$extraHeadContent = '
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "Ma Liste de Souhaits — Sabaya Luxury",
    "description": "Votre sélection personnelle d\'abayas et produits favoris sur Sabaya Luxury.",
    "isPartOf": {
        "@type": "WebSite",
        "name": "Sabaya Luxury"
    },
    "numberOfItems": ' . $wishlistCount . '
}
</script>
';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

    <main id="main-content">

        <!-- ══ HERO SECTION ════════════════════════════════════════ -->
        <section class="wishlist-hero" aria-labelledby="wishlist-title">
            <div class="wishlist-hero__inner">
                <span class="wishlist-hero__label" aria-hidden="true">Collection Personnelle</span>
                <h1 id="wishlist-title" class="wishlist-hero__title">Ma Liste de Souhaits</h1>
                <div class="wishlist-hero__line" aria-hidden="true"></div>
                <p class="wishlist-hero__subtitle">Retrouvez vos produits favoris enregistrés.</p>
                <?php if ($wishlistCount > 0): ?>
                    <p class="wishlist-hero__count"><?= $wishlistCount ?> article<?= $wishlistCount > 1 ? 's' : '' ?> enregistré<?= $wishlistCount > 1 ? 's' : '' ?></p>
                <?php endif; ?>
            </div>
        </section>

        <!-- ══ WISHLIST CONTENT ════════════════════════════════════ -->
        <section class="wishlist-content" aria-label="Vos produits favoris">

            <?php if (empty($wishlist)): ?>

                <!-- Empty State -->
                <div class="wishlist-empty" role="status">
                    <div class="wishlist-empty__icon-wrapper" aria-hidden="true">
                        <i class="far fa-heart"></i>
                    </div>
                    <h2 class="wishlist-empty__title">Aucun produit dans votre liste de souhaits.</h2>
                    <p class="wishlist-empty__text">Explorez notre collection d'abayas luxueuses et enregistrez vos pièces favorites pour les retrouver ici.</p>
                    <a href="../products/products.php" class="btn wishlist-empty__btn" aria-label="Découvrir nos produits — aller à la boutique">
                        Découvrir nos produits
                    </a>
                </div>

            <?php else: ?>

                <!-- Wishlist Grid -->
                <div class="wishlist-grid" role="list" aria-label="Grille de vos produits favoris">

                    <?php foreach ($wishlist as $item): ?>
                        <article class="wishlist-card" role="listitem">

                            <!-- Product Image -->
                            <a href="../products/product-details.php?id=<?= $item['id_produit'] ?>"
                               class="wishlist-card__image-link"
                               aria-label="Voir les détails de <?= htmlspecialchars($item['nom']) ?>">
                                <img src="../assets/images/products/<?= htmlspecialchars($item['image']) ?>"
                                     alt="<?= htmlspecialchars($item['nom']) ?> — Abaya Sabaya Luxury"
                                     loading="lazy"
                                     width="400"
                                     height="500">
                            </a>

                            <!-- Product Info -->
                            <div class="wishlist-card__body">
                                <span class="wishlist-card__brand" aria-label="Marque">Sabaya Luxury</span>
                                <h2 class="wishlist-card__name"><?= htmlspecialchars($item['nom']) ?></h2>
                                <p class="wishlist-card__price" aria-label="Prix : <?= htmlspecialchars($item['prix']) ?> Dirhams">
                                    <span class="wishlist-card__price-value"><?= htmlspecialchars($item['prix']) ?></span>
                                    <span class="wishlist-card__price-currency"> DH</span>
                                </p>

                                <!-- Card Actions -->
                                <div class="wishlist-card__actions">
                                    <a href="../products/product-details.php?id=<?= $item['id_produit'] ?>"
                                       class="wishlist-card__btn-details"
                                       aria-label="Voir les détails de <?= htmlspecialchars($item['nom']) ?>">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                        Voir Détails
                                    </a>
                                    <a href="remove-wishlist.php?id=<?= $item['id_wishlist'] ?>"
                                       class="wishlist-card__btn-remove"
                                       aria-label="Retirer <?= htmlspecialchars($item['nom']) ?> de votre liste de souhaits">
                                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                                        Retirer
                                    </a>
                                </div>
                            </div>

                        </article>
                    <?php endforeach; ?>

                </div>

                <!-- Bottom CTA -->
                <div class="wishlist-bottom-cta">
                    <a href="../products/products.php" class="btn-outline wishlist-bottom-cta__btn" aria-label="Continuer vos achats — retourner à la boutique">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        Continuer vos achats
                    </a>
                </div>

            <?php endif; ?>

        </section>

    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
