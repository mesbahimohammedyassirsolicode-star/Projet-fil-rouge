<?php
/**
 * Shared Footer Include — Sabaya Luxury
 *
 * SEO-friendly footer with navigation links, contact section, and copyright.
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
?>
<footer class="footer" role="contentinfo">
    <div class="footer-content">
        <div class="footer-col">
            <h4>SABAYA</h4>
            <p>Votre destination pour des abayas modernes, élégantes et de haute qualité au Maroc.</p>
            <div class="social-links">
                <a href="https://www.instagram.com/brandsabaya_/" aria-label="Instagram Sabaya Luxury" rel="noopener noreferrer" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                <a href="https://www.instagram.com/brandsabaya_/" aria-label="Facebook Sabaya Luxury" rel="noopener noreferrer" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                <a href="https://www.instagram.com/brandsabaya_/" aria-label="TikTok Sabaya Luxury" rel="noopener noreferrer" target="_blank"><i class="fab fa-tiktok" aria-hidden="true"></i></a>
                <a href="https://www.instagram.com/brandsabaya_/" aria-label="WhatsApp Sabaya Luxury" rel="noopener noreferrer" target="_blank"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
            </div>
        </div>
        <nav class="footer-col" aria-label="Liens de navigation du pied de page">
            <h4>Liens Rapides</h4>
            <ul>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/index.php">Accueil</a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/products/products.php">Boutique</a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/about.php">À propos</a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/contact/contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="footer-col">
            <h4>Contact</h4>
            <address>
                <p><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Tangier, Maroc</p>
                <p><i class="fas fa-envelope" aria-hidden="true"></i> <a href="mailto:contact@sabaya.ma">contact@sabaya.ma</a></p>
                <p><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+212600000000">+212 6XX XXX XXX</a></p>
            </address>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Sabaya Luxury. Tous droits réservés.</p>
    </div>
</footer>

<!-- Global JS -->
<script src="<?= htmlspecialchars($baseUrl) ?>/assets/js/main.js"></script>
