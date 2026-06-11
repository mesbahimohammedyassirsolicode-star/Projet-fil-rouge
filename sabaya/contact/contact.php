<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Contact.php';

$db = new Database();
$pdo = $db->getConnection();

$contactModel = new Contact($pdo);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $sujet = trim($_POST['sujet']);
    $message = trim($_POST['message']);

    if (empty($nom)) {
        $errors[] = t('contact_err_name_required');
    }

    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $nom)) {
        $errors[] = t('contact_err_name_invalid');
    }

    if (empty($email)) {
        $errors[] = t('contact_err_email_required');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = t('contact_err_email_invalid');
    }

    if (empty($sujet)) {
        $errors[] = t('contact_err_subject_required');
    }

    if (empty($message)) {
        $errors[] = t('contact_err_message_required');
    }

    if (empty($errors)) {

        $id_client = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        $contactModel->create($nom, $email, $sujet, $message, $id_client);

        header('Location: contact.php?success=1');
        exit();
    }
}

?>
<?php
require_once '../config/lang.php';

// Page metadata for header.php
$pageTitle = t('contact_page_title');
$pageDescription = "Contactez Sabaya Luxury — boutique d'abayas modernes au Maroc. Service client, conseils collections et informations sur nos abayas premium.";
$pageKeywords = 'contact Sabaya, service client, abaya Maroc, boutique en ligne, Casablanca, support mode modeste';

// Build page-specific JSON-LD for ContactPage
$extraHeadContent = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact Sabaya Luxury",
    "description": "' . htmlspecialchars($pageDescription) . '",
    "url": "' . htmlspecialchars((!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) . '",
    "inLanguage": "fr",
    "mainEntity": {
        "@type": "ClothingStore",
        "name": "Sabaya Luxury",
        "description": "Boutique de mode modeste et abayas premium au Maroc",
        "email": "contact@sabaya.ma",
        "telephone": "+212 5 22 00 00 00",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "AHLAN AVENUE",
            "addressLocality": "TANGIER",
            "addressCountry": "MA"
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
            "opens": "09:00",
            "closes": "19:00"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "customer service",
            "availableLanguage": ["French", "Arabic"],
            "email": "contact@sabaya.ma",
            "telephone": "+212 5 22 00 00 00"
        },
        "priceRange": "$$"
    }
}
</script>';

require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

    <main id="main-content">

        <!-- Hero Section -->
    <section class="contact-hero reveal" aria-labelledby="contact-heading">
            <div class="contact-hero__inner">
                <span class="contact-hero__label"><?= t('contact_hero_label') ?></span>
                <h1 id="contact-heading" class="contact-hero__title"><?= t('contact_hero_title') ?></h1>
                <div class="contact-hero__line" aria-hidden="true"></div>
                <p class="contact-hero__subtitle"><?= t('contact_hero_subtitle') ?></p>
            </div>
        </section>

        <!-- Contact Content: Two Columns -->
    <section class="contact-content reveal" aria-labelledby="contact-info-heading">
            <div class="contact-content__container">

                <!-- Success / Error Messages -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="contact-alert contact-alert--success" role="alert">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <p><?= t('contact_success_message') ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="contact-alert contact-alert--error" role="alert">
                        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="contact-grid">

                    <!-- LEFT: Contact Information -->
                    <article class="contact-info reveal">
                        <h2 id="contact-info-heading" class="contact-info__title"><?= t('contact_info_title') ?></h2>
                        <div class="contact-info__line" aria-hidden="true"></div>
                        <p class="contact-info__intro"><?= t('contact_info_intro') ?></p>

                        <address class="contact-info__list">
                            <div class="contact-info__item">
                                <div class="contact-info__icon" aria-hidden="true">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="contact-info__text">
                                    <span class="contact-info__label"><?= t('contact_label_email') ?></span>
                                    <a href="mailto:contact@sabaya.ma" class="contact-info__value">contact@sabaya.ma</a>
                                </div>
                            </div>

                            <div class="contact-info__item">
                                <div class="contact-info__icon" aria-hidden="true">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div class="contact-info__text">
                                    <span class="contact-info__label"><?= t('contact_label_phone') ?></span>
                                    <a href="tel:+212522000000" class="contact-info__value">+212 5 22 00 00 00</a>
                                </div>
                            </div>

                            <div class="contact-info__item">
                                <div class="contact-info__icon" aria-hidden="true">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="contact-info__text">
                                    <span class="contact-info__label"><?= t('contact_label_address') ?></span>
                                    <span class="contact-info__value">Boulevard Mohammed V<br>Casablanca, Maroc</span>
                                </div>
                            </div>

                            <div class="contact-info__item">
                                <div class="contact-info__icon" aria-hidden="true">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div class="contact-info__text">
                                    <span class="contact-info__label"><?= t('contact_label_hours') ?></span>
                                    <span class="contact-info__value"><?= t('contact_hours_value') ?></span>
                                </div>
                            </div>
                        </address>
                    </article>

                    <!-- RIGHT: Contact Form -->
                    <article class="contact-form-wrapper reveal">
                        <h2 class="contact-form__title"><?= t('contact_form_title') ?></h2>
                        <div class="contact-form__line" aria-hidden="true"></div>

                        <form action="contact.php" method="POST" class="contact-form" novalidate>
                            <div class="contact-form__group">
                                <label for="nom" class="contact-form__label">
                                    <?= t('contact_form_name') ?> <span class="contact-form__required" aria-label="<?= t('contact_required') ?>">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nom"
                                    name="nom"
                                    placeholder="<?= t('contact_form_name_placeholder') ?>"
                                    required
                                    aria-required="true"
                                    autocomplete="name"
                                    value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>"
                                >
                            </div>

                            <div class="contact-form__group">
                                <label for="email" class="contact-form__label">
                                    <?= t('contact_form_email') ?> <span class="contact-form__required" aria-label="<?= t('contact_required') ?>">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="<?= t('contact_form_email_placeholder') ?>"
                                    required
                                    aria-required="true"
                                    autocomplete="email"
                                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                >
                            </div>

                            <div class="contact-form__group">
                                <label for="sujet" class="contact-form__label">
                                    <?= t('contact_form_subject') ?> <span class="contact-form__required" aria-label="<?= t('contact_required') ?>">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="sujet"
                                    name="sujet"
                                    placeholder="<?= t('contact_form_subject_placeholder') ?>"
                                    required
                                    aria-required="true"
                                    value="<?= isset($_POST['sujet']) ? htmlspecialchars($_POST['sujet']) : '' ?>"
                                >
                            </div>

                            <div class="contact-form__group">
                                <label for="message" class="contact-form__label">
                                    <?= t('contact_form_message') ?> <span class="contact-form__required" aria-label="<?= t('contact_required') ?>">*</span>
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="6"
                                    placeholder="<?= t('contact_form_message_placeholder') ?>"
                                    required
                                    aria-required="true"
                                ><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
                            </div>

                            <button type="submit" class="btn contact-form__btn">
                                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                                <?= t('contact_form_submit') ?>
                            </button>
                        </form>
                    </article>

                </div>
            </div>
        </section>

    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
