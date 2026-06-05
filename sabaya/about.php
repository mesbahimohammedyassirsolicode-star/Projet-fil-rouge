<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pageDescription = 'Découvrez Sabaya Luxury — boutique marocaine spécialisée dans les abayas modernes et élégantes. Notre mission, vision et valeurs pour la mode modeste au Maroc.';
$pageImage = $baseUrl . '/assets/images/logo/sabaya-logo.jpg';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="à propos Sabaya, abaya Maroc, mode modeste, boutique abayas, Casablanca, valeurs, mission, vision">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Sabaya Luxury">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <title>À propos de Sabaya Luxury | Notre Mission, Vision & Valeurs</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="À propos de Sabaya Luxury | Notre Mission, Vision & Valeurs">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:locale" content="fr_MA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="À propos de Sabaya Luxury | Notre Mission, Vision & Valeurs">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">

    <!-- JSON-LD Structured Data: AboutPage -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AboutPage",
        "name": "À propos de Sabaya Luxury",
        "description": "<?= htmlspecialchars($pageDescription) ?>",
        "url": "<?= htmlspecialchars($canonicalUrl) ?>",
        "mainEntity": {
            "@type": "Organization",
            "name": "Sabaya Luxury",
            "description": "Boutique marocaine spécialisée dans les abayas modernes et élégantes. Mode modeste et raffinée pour femmes.",
            "url": "<?= htmlspecialchars($baseUrl) ?>",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Casablanca",
                "addressCountry": "MA"
            }
        }
    }
    </script>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="index.php" class="logo">SABAYA</a>
        <ul class="nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="products/products.php">Boutique</a></li>
            <li><a href="contact/contact.php">Contact</a></li>
            <li><a href="about.php">À propos</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>À propos de <span>Sabaya</span></h1>
            <p>L'élégance modeste, une vision moderne</p>
            <div class="decorative-line"></div>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-section">

        <!-- Introduction -->
        <div class="about-intro">
            <h2>Qui sommes-nous ?</h2>
            <p>
                Sabaya Luxury est une boutique marocaine spécialisée dans les abayas modernes et élégantes. 
                Nous croyons que chaque femme mérite de se sentir belle et confiante tout en 
                restant fidèle à ses valeurs. Notre passion pour la mode modeste nous pousse à 
                créer des collections uniques qui allient tradition et modernité. Fondée à Casablanca, 
                Sabaya Luxury s'adresse aux femmes qui recherchent l'élégance discrète et le raffinement dans leur quotidien.
            </p>
        </div>

        <!-- Cards -->
        <div class="cards-container">
            <div class="card">
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Notre Mission</h3>
                <p>
                    Offrir aux femmes des collections qui allient modestie, confort et raffinement. 
                    Chaque pièce est pensée pour sublimer tout en respectant les valeurs de chacune.
                </p>
            </div>

            <div class="card">
                <div class="icon">
                    <i class="fas fa-gem"></i>
                </div>
                <h3>Notre Engagement</h3>
                <p>
                    Nous sélectionnons soigneusement nos produits afin de garantir qualité, style 
                    et satisfaction à nos clientes. Chaque abaya est choisie avec le plus grand soin.
                </p>
            </div>

            <div class="card">
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Notre Qualité</h3>
                <p>
                    Des tissus premium, des finitions impeccables et des designs contemporains 
                    font de chaque pièce Sabaya un choix d'exception pour la femme moderne.
                </p>
            </div>
        </div>

        <!-- Vision Section -->
        <div class="vision-section">
            <div class="vision-icon">
                <i class="fas fa-eye"></i>
            </div>
            <h2>Notre Vision</h2>
            <p>
                Notre vision est de devenir une référence dans la mode modeste au Maroc. 
                Nous aspirons à redéfinir l'abaya en tant que pièce incontournable du dressing 
                féminin, en alliant héritage culturel et tendances contemporaines pour créer 
                une mode qui inspire et qui rassemble.
            </p>
        </div>

    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-col">
                <h4>SABAYA</h4>
                <p>Votre destination pour des abayas modernes, élégantes et de haute qualité au Maroc.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Liens Rapides</h4>
                <a href="index.php">Accueil</a>
                <a href="products/products.php">Boutique</a>
                <a href="about.php">À propos</a>
                <a href="contact/contact.php">Contact</a>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-map-marker-alt"></i> Casablanca, Maroc</p>
                <p><i class="fas fa-envelope"></i> contact@sabaya.ma</p>
                <p><i class="fas fa-phone"></i> +212 6XX XXX XXX</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Sabaya. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>
