<?php
// Page metadata for header.php
$pageTitle = 'À propos de Sabaya Luxury | Notre Mission, Vision & Valeurs';
$pageDescription = 'Découvrez Sabaya Luxury — boutique marocaine spécialisée dans les abayas modernes et élégantes. Notre mission, vision et valeurs pour la mode modeste au Maroc.';
$pageKeywords = 'à propos Sabaya, abaya Maroc, mode modeste, boutique abayas, Casablanca, valeurs, mission, vision';

// Build page-specific JSON-LD for AboutPage
$extraHeadContent = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "À propos de Sabaya Luxury",
    "description": "' . htmlspecialchars($pageDescription) . '",
    "mainEntity": {
        "@type": "Organization",
        "name": "Sabaya Luxury",
        "url": "https://sabaya.ma",
        "foundingLocation": "Casablanca, Maroc",
        "description": "Boutique marocaine spécialisée dans les abayas modernes et élégantes"
    }
}
</script>';

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<main>
    <!-- ═══════════════════════════════════════════
         SECTION 1 — HERO
    ═══════════════════════════════════════════ -->
    <section class="about-hero">
        <div class="about-hero__inner">
            <span class="about-hero__label">Sabaya Luxury</span>
            <h1 class="about-hero__title">À propos de <em>Sabaya Luxury</em></h1>
            <div class="about-hero__line"></div>
            <p class="about-hero__subtitle">L'élégance intemporelle au service de la femme moderne.</p>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 2 — NOTRE HISTOIRE
    ═══════════════════════════════════════════ -->
    <section class="about-story">
        <div class="container about-story__inner">
            <div class="about-story__badge">
                <i class="fas fa-feather-alt"></i>
            </div>
            <h2 class="about-story__title">Notre Histoire</h2>
            <div class="about-story__divider"></div>
            <div class="about-story__content">
                <p>
                    Sabaya Luxury est née d'une passion profonde pour la mode modeste et l'artisanat d'exception.
                    Fondée à Casablanca, notre maison puise son inspiration dans la richesse du patrimoine marocain
                    et l'élégance contemporaine internationale.
                </p>
                <p>
                    Chaque pièce de notre collection est le fruit d'un savoir-faire méticuleux, où le luxe
                    se définit par la qualité des tissus, la précision des coupes et l'attention portée
                    aux moindres détails. Nous croyons que la vraie élégance ne crie pas — elle murmure.
                </p>
                <p>
                    Aujourd'hui, Sabaya Luxury accompagne une femme moderne, exigeante et raffinée,
                    qui refuse de choisir entre ses valeurs et son style. Notre vision : faire de chaque
                    abaya une œuvre d'art portable, intemporelle et profondément personnelle.
                </p>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 3 — NOTRE MISSION
    ═══════════════════════════════════════════ -->
    <section class="about-mission">
        <div class="container about-mission__inner">
            <div class="about-mission__grid">
                <div class="about-mission__left">
                    <span class="section-label">Notre Mission</span>
                    <h2 class="about-mission__title">L'art de la mode modeste, réinventé avec excellence.</h2>
                    <div class="about-mission__line"></div>
                </div>
                <div class="about-mission__right">
                    <p>
                        Notre mission est d'offrir aux femmes des abayas et des pièces de mode modeste
                        d'une qualité irréprochable, alliant tradition, confort et luxe contemporain.
                    </p>
                    <p>
                        Nous sélectionnons chaque tissu avec rigueur, collaborons avec des artisans
                        talentueux et concevons des silhouettes qui subliment sans jamais trahir
                        l'essence de la femme qui les porte.
                    </p>
                    <p>
                        Chez Sabaya Luxury, la mode est un acte de confiance — et nous nous engageons
                        à honorer cette confiance avec une exigence absolue.
                    </p>
                </div>
            </div>

            <!-- Three pillars -->
            <div class="about-mission__pillars">
                <div class="pillar">
                    <div class="pillar__icon">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <h3 class="pillar__title">Tradition</h3>
                    <p class="pillar__text">Un héritage culturel précieux, célébré dans chaque création.</p>
                </div>
                <div class="pillar">
                    <div class="pillar__icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3 class="pillar__title">Confort</h3>
                    <p class="pillar__text">Des matières nobles, douces et agréables à porter au quotidien.</p>
                </div>
                <div class="pillar">
                    <div class="pillar__icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h3 class="pillar__title">Luxe</h3>
                    <p class="pillar__text">L'excellence artisanale au service d'une élégance rare et raffinée.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 4 — NOS VALEURS
    ═══════════════════════════════════════════ -->
    <section class="about-values">
        <div class="container">
            <div class="about-values__header">
                <span class="section-label">Nos Valeurs</span>
                <h2 class="about-values__title">Les piliers de notre maison</h2>
                <div class="about-values__line"></div>
            </div>

            <div class="about-values__grid">
                <!-- Valeur 1 -->
                <div class="value-card">
                    <div class="value-card__number">01</div>
                    <div class="value-card__icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="value-card__title">Qualité</h3>
                    <p class="value-card__text">
                        Des tissus premium, des finitions impeccables et un contrôle rigoureux
                        pour des pièces qui traversent le temps.
                    </p>
                </div>
                <!-- Valeur 2 -->
                <div class="value-card">
                    <div class="value-card__number">02</div>
                    <div class="value-card__icon">
                        <i class="fas fa-sparkles"></i>
                    </div>
                    <h3 class="value-card__title">Élégance</h3>
                    <p class="value-card__text">
                        Une esthétique épurée, moderne et intemporelle qui transcende
                        les tendances passagères.
                    </p>
                </div>
                <!-- Valeur 3 -->
                <div class="value-card">
                    <div class="value-card__number">03</div>
                    <div class="value-card__icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="value-card__title">Authenticité</h3>
                    <p class="value-card__text">
                        Un engagement sincère envers nos racines, nos valeurs et la femme
                        que nous habillons.
                    </p>
                </div>
                <!-- Valeur 4 -->
                <div class="value-card">
                    <div class="value-card__number">04</div>
                    <div class="value-card__icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h3 class="value-card__title">Satisfaction Client</h3>
                    <p class="value-card__text">
                        Une expérience irréprochable, de la découverte à la livraison,
                        pour chaque cliente Sabaya.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 5 — WHY CHOOSE SABAYA
    ═══════════════════════════════════════════ -->
    <section class="about-why">
        <div class="container">
            <div class="about-why__header">
                <span class="section-label">Pourquoi Sabaya</span>
                <h2 class="about-why__title">L'excellence, à chaque détail</h2>
                <div class="about-why__line"></div>
            </div>

            <div class="about-why__grid">
                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-scissors"></i>
                    </div>
                    <div class="why-item__content">
                        <h3>Artisanat d'exception</h3>
                        <p>Chaque pièce est confectionnée avec un soin méticuleux par des artisans expérimentés, garantissant des finitions parfaites.</p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="why-item__content">
                        <h3>Tissus nobles et durables</h3>
                        <p>Nous sélectionnons uniquement des matières premium — soie, crêpe, lin — pour un confort absolu et une durabilité remarquable.</p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="why-item__content">
                        <h3>Designs exclusifs</h3>
                        <p>Nos collections sont pensées en éditions limitées, offrant à chaque femme la certitude de porter une pièce unique et rare.</p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="why-item__content">
                        <h3>Livraison soignée</h3>
                        <p>Un emballage luxueux et une livraison rapide à travers tout le Maroc, pour une expérience digne des plus grandes maisons.</p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="why-item__content">
                        <h3>Service personnalisé</h3>
                        <p>Notre équipe est à l'écoute de chaque cliente, offrant conseils de style et accompagnement sur-mesure, du choix à la livraison.</p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="why-item__content">
                        <h3>Confiance et discrétion</h3>
                        <p>Votre vie privée est sacrée. Paiements sécurisés, données protégées et livraison en toute confidentialité.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 6 — CALL TO ACTION
    ═══════════════════════════════════════════ -->
    <section class="about-cta">
        <div class="about-cta__inner">
            <span class="about-cta__label">Explorez notre univers</span>
            <h2 class="about-cta__title">Votre prochaine pièce d'exception vous attend.</h2>
            <div class="about-cta__line"></div>
            <a href="products/products.php" class="btn about-cta__btn">Découvrir Nos Collections</a>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>

</body>
</html>
