<?php
/**
 * Shared Navigation Include — Sabaya Luxury
 *
 * Premium luxury fashion navbar — Zara / Massimo Dutti inspired.
 * Semantic HTML5, accessible, with consistent internal linking.
 *
 * Expected variables (set BEFORE including this file):
 *   $baseUrl — Computed automatically by header.php or manually
 */

if (!isset($baseUrl)) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    if ($scriptDir !== '/' && $scriptDir !== '\\' && $scriptDir !== '') {
        $scriptDir = dirname($scriptDir);
    }
    $baseUrl  = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/\\');
}

// Cart count (used in right icons)
$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum($_SESSION['cart']);
}
?>
<header role="banner" class="nav-header">
    <nav class="navbar" aria-label="Navigation principale">

        <!-- LEFT: Navigation Links -->
        <ul class="nav-left" role="menubar" aria-label="Liens principaux">
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/index.php" role="menuitem">Accueil</a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/products.php" role="menuitem">Produits</a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/about.php" role="menuitem">À propos</a></li>
        </ul>

        <!-- CENTER: Logo -->
        <a href="<?= htmlspecialchars($baseUrl) ?>/index.php" class="nav-logo" aria-label="Accueil Sabaya Luxury">
            <img src="<?= htmlspecialchars($baseUrl) ?>/assets/images/logo/logo.png" alt="Sabaya Luxury" width="140" height="auto">
        </a>

        <!-- RIGHT: Icon Actions -->
        <ul class="nav-right" role="menubar" aria-label="Actions">
            <li role="none">
                <a href="<?= htmlspecialchars($baseUrl) ?>/products/search.php" role="menuitem" aria-label="Rechercher">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                </a>
            </li>
            <li role="none">
                <a href="<?= htmlspecialchars($baseUrl) ?>/wishlist/wishlist.php" role="menuitem" aria-label="Liste de souhaits">
                    <i class="fa-regular fa-heart" aria-hidden="true"></i>
                </a>
            </li>
            <li role="none">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?= htmlspecialchars($baseUrl) ?>/auth/profile.php" role="menuitem" aria-label="Mon compte">
                        <i class="fa-regular fa-user" aria-hidden="true"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($baseUrl) ?>/auth/login.php" role="menuitem" aria-label="Se connecter">
                        <i class="fa-regular fa-user" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>
            </li>
            <li role="none">
                <a href="<?= htmlspecialchars($baseUrl) ?>/products/cart.php" role="menuitem" aria-label="Panier<?php if ($cartCount > 0) echo ' (' . $cartCount . ')'; ?>" class="nav-cart-link">
                    <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-badge" aria-label="<?= $cartCount ?> article(s) dans le panier"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>

        <!-- MOBILE: Hamburger Toggle -->
        <button class="nav-toggle" aria-label="Ouvrir le menu de navigation" aria-expanded="false" aria-controls="mobile-nav">
            <span class="nav-toggle-icon" aria-hidden="true"></span>
            <span class="sr-only">Menu</span>
        </button>

        <!-- MOBILE: Slide-in Menu -->
        <ul id="mobile-nav" class="nav-mobile" role="menubar" aria-label="Menu mobile">
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/index.php" role="menuitem">Accueil</a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/products.php" role="menuitem">Produits</a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/about.php" role="menuitem">À propos</a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/search.php" role="menuitem">Recherche</a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/wishlist/wishlist.php" role="menuitem">Liste de souhaits</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/auth/profile.php" role="menuitem">Compte</a></li>
                <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/cart.php" role="menuitem">Panier <?php if ($cartCount > 0) echo '(' . $cartCount . ')'; ?></a></li>
            <?php else: ?>
                <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/auth/login.php" role="menuitem">Compte</a></li>
                <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/cart.php" role="menuitem">Panier <?php if ($cartCount > 0) echo '(' . $cartCount . ')'; ?></a></li>
            <?php endif; ?>
        </ul>

    </nav>
</header>
