<?php
/**
 * Shared Navigation Include — Sabaya Luxury
 *
 * Premium luxury fashion navbar with language switcher (FR | EN).
 * Semantic HTML5, accessible, with consistent internal linking.
 *
 * Expected variables (set BEFORE including this file):
 *   $baseUrl — Computed automatically by header.php or manually
 */

// ── Ensure lang system is loaded ─────────────────────────────────────────────
if (!function_exists('t')) {
    require_once __DIR__ . '/../config/lang.php';
}

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

// Active language for switcher
$activeLang = $_SESSION['lang'] ?? 'fr';

// Build the current URL without the lang parameter (for switcher links)
$currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
$queryParams = $_GET;
unset($queryParams['lang']);
$queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) . '&' : '?';
?>
<header role="banner" class="nav-header">
    <nav class="navbar" aria-label="Navigation principale">

        <!-- LEFT: Navigation Links -->
        <ul class="nav-left" role="menubar" aria-label="Liens principaux">
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/index.php" role="menuitem"><?= t('nav_home') ?></a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/products.php" role="menuitem"><?= t('nav_products') ?></a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/about.php" role="menuitem"><?= t('nav_about') ?></a></li>
        </ul>

        <!-- CENTER: Logo -->
        <a href="<?= htmlspecialchars($baseUrl) ?>/index.php" class="nav-logo" aria-label="Accueil Sabaya Luxury">
            <img src="<?= htmlspecialchars($baseUrl) ?>/assets/images/logo/logo.png" alt="Sabaya Luxury" width="140" height="auto">
        </a>

        <!-- RIGHT: Icon Actions + Language Switcher -->
        <ul class="nav-right" role="menubar" aria-label="Actions">
            <li role="none">
                <a href="<?= htmlspecialchars($baseUrl) ?>/products/search.php" role="menuitem" aria-label="<?= t('nav_search') ?>">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                </a>
            </li>
            <li role="none">
                <a href="<?= htmlspecialchars($baseUrl) ?>/wishlist/wishlist.php" role="menuitem" aria-label="<?= t('nav_wishlist') ?>">
                    <i class="fa-regular fa-heart" aria-hidden="true"></i>
                </a>
            </li>
            <li role="none">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="<?= htmlspecialchars($baseUrl) ?>/admin/dashboard.php" role="menuitem" aria-label="<?= t('nav_dashboard_admin') ?>">
                            <i class="fa-regular fa-user" aria-hidden="true"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?= htmlspecialchars($baseUrl) ?>/auth/profile.php" role="menuitem" aria-label="<?= t('nav_account') ?>">
                            <i class="fa-regular fa-user" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($baseUrl) ?>/auth/login.php" role="menuitem" aria-label="<?= t('nav_login') ?>">
                        <i class="fa-regular fa-user" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>
            </li>
            <li role="none">
                <a href="<?= htmlspecialchars($baseUrl) ?>/products/cart.php" role="menuitem" aria-label="<?= t('nav_cart') ?><?php if ($cartCount > 0) echo ' (' . $cartCount . ')'; ?>" class="nav-cart-link">
                    <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-badge" aria-label="<?= $cartCount ?> article(s) dans le panier"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- LANGUAGE SWITCHER: FR | EN -->
            <li role="none" class="language-switcher" aria-label="<?= t('lang_switcher_label') ?>">
                <a
                    href="<?= htmlspecialchars($currentUrl . $queryString) ?>lang=fr"
                    class="lang-btn<?= $activeLang === 'fr' ? ' lang-btn--active' : '' ?>"
                    aria-label="Passer en français"
                    hreflang="fr"
                >FR</a>
                <span class="lang-divider" aria-hidden="true">|</span>
                <a
                    href="<?= htmlspecialchars($currentUrl . $queryString) ?>lang=en"
                    class="lang-btn<?= $activeLang === 'en' ? ' lang-btn--active' : '' ?>"
                    aria-label="Switch to English"
                    hreflang="en"
                >EN</a>
            </li>
        </ul>

        <!-- MOBILE: Hamburger Toggle -->
        <button class="nav-toggle" aria-label="<?= t('nav_menu_open') ?>" aria-expanded="false" aria-controls="mobile-nav">
            <span class="nav-toggle-icon" aria-hidden="true"></span>
            <span class="sr-only">Menu</span>
        </button>

        <!-- MOBILE: Slide-in Menu -->
        <ul id="mobile-nav" class="nav-mobile" role="menubar" aria-label="Menu mobile">
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/index.php" role="menuitem"><?= t('nav_home') ?></a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/products.php" role="menuitem"><?= t('nav_products') ?></a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/about.php" role="menuitem"><?= t('nav_about') ?></a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/search.php" role="menuitem"><?= t('nav_search') ?></a></li>
            <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/wishlist/wishlist.php" role="menuitem"><?= t('nav_wishlist') ?></a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/admin/dashboard.php" role="menuitem"><?= t('nav_dashboard_admin') ?></a></li>
                <?php else: ?>
                    <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/auth/profile.php" role="menuitem"><?= t('nav_account') ?></a></li>
                <?php endif; ?>
                <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/cart.php" role="menuitem"><?= t('nav_cart') ?> <?php if ($cartCount > 0) echo '(' . $cartCount . ')'; ?></a></li>
            <?php else: ?>
                <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/auth/login.php" role="menuitem"><?= t('nav_account') ?></a></li>
                <li role="none"><a href="<?= htmlspecialchars($baseUrl) ?>/products/cart.php" role="menuitem"><?= t('nav_cart') ?> <?php if ($cartCount > 0) echo '(' . $cartCount . ')'; ?></a></li>
            <?php endif; ?>
            <!-- Mobile language switcher -->
            <li role="none" class="language-switcher language-switcher--mobile">
                <a href="<?= htmlspecialchars($currentUrl . $queryString) ?>lang=fr" class="lang-btn<?= $activeLang === 'fr' ? ' lang-btn--active' : '' ?>" hreflang="fr">FR</a>
                <span class="lang-divider" aria-hidden="true">|</span>
                <a href="<?= htmlspecialchars($currentUrl . $queryString) ?>lang=en" class="lang-btn<?= $activeLang === 'en' ? ' lang-btn--active' : '' ?>" hreflang="en">EN</a>
            </li>
        </ul>

    </nav>
</header>
