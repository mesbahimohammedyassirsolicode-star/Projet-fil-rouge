<?php
require_once 'config/lang.php';

// Page metadata for header.php
$pageTitle = t('about_hero_label') . ' | ' . t('site_name');
$pageDescription = "Découvrez Sabaya Luxury — boutique marocaine spécialisée dans les abayas modernes et élégantes. Notre mission, vision et valeurs pour la mode modeste au Maroc.";
$pageKeywords = 'à propos Sabaya, abaya Maroc, mode modeste, boutique abayas, Casablanca, valeurs, mission, vision';

// Build page-specific JSON-LD for AboutPage
$extraHeadContent = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "' . t('about_hero_title') . '",
    "description": "' . htmlspecialchars($pageDescription) . '",
    "mainEntity": {
        "@type": "Organization",
        "name": "Sabaya Luxury",
        "url": "https://sabaya.ma",
        "foundingLocation": "Tangier, Maroc",
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
    <section class="about-hero reveal">
        <div class="about-hero__inner">
            <span class="about-hero__label"><?= t('about_hero_label') ?></span>
            <h1 class="about-hero__title"><?= t('about_hero_title') ?></h1>
            <div class="about-hero__line"></div>
            <p class="about-hero__subtitle"><?= t('about_hero_subtitle') ?></p>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 2 — NOTRE HISTOIRE
    ═══════════════════════════════════════════ -->
    <section class="about-story reveal">
        <div class="container about-story__inner">
            <div class="about-story__badge">
                <i class="fas fa-feather-alt"></i>
            </div>
            <h2 class="about-story__title"><?= t('about_story_title') ?></h2>
            <div class="about-story__divider"></div>
            <div class="about-story__content">
                <p><?= t('about_story_p1') ?></p>
                <p><?= t('about_story_p2') ?></p>
                <p><?= t('about_story_p3') ?></p>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 3 — NOTRE MISSION
    ═══════════════════════════════════════════ -->
    <section class="about-mission reveal">
        <div class="container about-mission__inner">
            <div class="about-mission__grid">
                <div class="about-mission__left">
                    <span class="section-label"><?= t('about_mission_label') ?></span>
                    <h2 class="about-mission__title"><?= t('about_mission_title') ?></h2>
                    <div class="about-mission__line"></div>
                </div>
                <div class="about-mission__right">
                    <p><?= t('about_mission_p1') ?></p>
                    <p><?= t('about_mission_p2') ?></p>
                    <p><?= t('about_mission_p3') ?></p>
                </div>
            </div>

            <!-- Three pillars -->
            <div class="about-mission__pillars">
                <div class="pillar">
                    <div class="pillar__icon">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <h3 class="pillar__title"><?= t('about_pillar_tradition_title') ?></h3>
                    <p class="pillar__text"><?= t('about_pillar_tradition_text') ?></p>
                </div>
                <div class="pillar">
                    <div class="pillar__icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3 class="pillar__title"><?= t('about_pillar_comfort_title') ?></h3>
                    <p class="pillar__text"><?= t('about_pillar_comfort_text') ?></p>
                </div>
                <div class="pillar">
                    <div class="pillar__icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h3 class="pillar__title"><?= t('about_pillar_luxe_title') ?></h3>
                    <p class="pillar__text"><?= t('about_pillar_luxe_text') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 4 — NOS VALEURS
    ═══════════════════════════════════════════ -->
    <section class="about-values reveal">
        <div class="container">
            <div class="about-values__header">
                <span class="section-label"><?= t('about_values_label') ?></span>
                <h2 class="about-values__title"><?= t('about_values_title') ?></h2>
                <div class="about-values__line"></div>
            </div>

            <div class="about-values__grid">
                <!-- Valeur 1 -->
                <div class="value-card">
                    <div class="value-card__number">01</div>
                    <div class="value-card__icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="value-card__title"><?= t('about_value_quality_title') ?></h3>
                    <p class="value-card__text"><?= t('about_value_quality_text') ?></p>
                </div>
                <!-- Valeur 2 -->
                <div class="value-card">
                    <div class="value-card__number">02</div>
                    <div class="value-card__icon">
                        <i class="fas fa-sparkles"></i>
                    </div>
                    <h3 class="value-card__title"><?= t('about_value_elegance_title') ?></h3>
                    <p class="value-card__text"><?= t('about_value_elegance_text') ?></p>
                </div>
                <!-- Valeur 3 -->
                <div class="value-card">
                    <div class="value-card__number">03</div>
                    <div class="value-card__icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="value-card__title"><?= t('about_value_authenticity_title') ?></h3>
                    <p class="value-card__text"><?= t('about_value_authenticity_text') ?></p>
                </div>
                <!-- Valeur 4 -->
                <div class="value-card">
                    <div class="value-card__number">04</div>
                    <div class="value-card__icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h3 class="value-card__title"><?= t('about_value_satisfaction_title') ?></h3>
                    <p class="value-card__text"><?= t('about_value_satisfaction_text') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 5 — WHY CHOOSE SABAYA
    ═══════════════════════════════════════════ -->
    <section class="about-why reveal">
        <div class="container">
            <div class="about-why__header">
                <span class="section-label"><?= t('about_why_label') ?></span>
                <h2 class="about-why__title"><?= t('about_why_title') ?></h2>
                <div class="about-why__line"></div>
            </div>

            <div class="about-why__grid">
                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-scissors"></i>
                    </div>
                    <div class="why-item__content">
                        <h3><?= t('about_why_craft_title') ?></h3>
                        <p><?= t('about_why_craft_text') ?></p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="why-item__content">
                        <h3><?= t('about_why_fabrics_title') ?></h3>
                        <p><?= t('about_why_fabrics_text') ?></p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="why-item__content">
                        <h3><?= t('about_why_design_title') ?></h3>
                        <p><?= t('about_why_design_text') ?></p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="why-item__content">
                        <h3><?= t('about_why_shipping_title') ?></h3>
                        <p><?= t('about_why_shipping_text') ?></p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="why-item__content">
                        <h3><?= t('about_why_service_title') ?></h3>
                        <p><?= t('about_why_service_text') ?></p>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-item__icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="why-item__content">
                        <h3><?= t('about_why_privacy_title') ?></h3>
                        <p><?= t('about_why_privacy_text') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════
         SECTION 6 — CALL TO ACTION
    ═══════════════════════════════════════════ -->
    <section class="about-cta reveal">
        <div class="about-cta__inner">
            <span class="about-cta__label"><?= t('about_cta_label') ?></span>
            <h2 class="about-cta__title"><?= t('about_cta_title') ?></h2>
            <div class="about-cta__line"></div>
            <a href="products/products.php" class="btn about-cta__btn"><?= t('about_cta_btn') ?></a>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>

</body>
</html>
