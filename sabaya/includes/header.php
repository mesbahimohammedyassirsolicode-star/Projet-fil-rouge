<?php
/**
 * Shared Header Include — Sabaya Luxury
 *
 * Provides: Dynamic <head>, SEO meta, Open Graph, Twitter Card, JSON-LD schemas, global CSS, Google Fonts.
 *
 * Expected variables (set BEFORE including this file):
 *   $pageTitle        — Page title (e.g. "Boutique Abayas")
 *   $pageDescription  — Meta description text
 *   $pageKeywords     — (optional) Meta keywords
 *   $pageImage        — (optional) OG/Twitter image URL
 *   $canonicalUrl     — (optional) Canonical URL
 *   $pageRobots       — (optional) Robots directive, default "index, follow"
 *   $ogType           — (optional) OG type, default "website"
 *   $extraHeadContent — (optional) Additional <head> content (page-specific JSON-LD, etc.)
 *
 * Safe defaults are used when variables are not defined.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Load localisation system ──────────────────────────────────────────────
require_once __DIR__ . '/../config/lang.php';

// ── Base URL (always points to project root) ────────────────────────────
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
// Go up one level if we're in a subdirectory (e.g. /products → /)
if ($scriptDir !== '/' && $scriptDir !== '\\' && $scriptDir !== '') {
    $scriptDir = dirname($scriptDir);
}
$baseUrl  = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/\\');

// ── Defaults ───────────────────────────────────────────────────────────────
$siteName       = 'Sabaya Luxury';
$siteTagline    = 'Luxury Abaya and Modest Fashion Boutique';
$defaultTitle   = $siteName . ' — ' . $siteTagline;
$defaultDesc    = 'Sabaya Luxury — Boutique en ligne d\'abayas modernes et élégantes au Maroc. Découvrez nos collections de mode modeste, abayas premium, et vêtements raffinés pour femmes.';
$defaultImage   = $baseUrl . '/assets/images/logo/sabaya-logo.jpg';
$defaultRobots  = 'index, follow';

// Resolve with safe fallbacks
$pageTitle       = $pageTitle       ?? $defaultTitle;
$pageDescription = $pageDescription ?? $defaultDesc;
$pageKeywords    = $pageKeywords    ?? 'abaya, abayas, mode modeste, hijab, vêtements femmes, Maroc, Casablanca, Sabaya, luxury, abaya moderne, abaya élégante';
$pageImage       = $pageImage       ?? $defaultImage;
$canonicalUrl    = $canonicalUrl    ?? $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pageRobots      = $pageRobots      ?? $defaultRobots;
$ogType          = $ogType          ?? 'website';
$extraHeadContent = $extraHeadContent ?? '';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($activeLang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta -->
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($pageKeywords) ?>">
    <meta name="robots" content="<?= htmlspecialchars($pageRobots) ?>">
    <meta name="author" content="Sabaya Luxury">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">

    <!-- Open Graph -->
    <meta property="og:type"         content="<?= htmlspecialchars($ogType) ?>">
    <meta property="og:site_name"    content="<?= htmlspecialchars($siteName) ?>">
    <meta property="og:title"        content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description"  content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image"        content="<?= htmlspecialchars($pageImage) ?>">
    <meta property="og:url"          content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:locale"       content="fr_MA">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image"       content="<?= htmlspecialchars($pageImage) ?>">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Global CSS -->
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl) ?>/assets/css/style.css">

    <!-- Product Card Hover Effects -->
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl) ?>/assets/css/product-hover.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- JSON-LD: Organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "@id": "<?= htmlspecialchars($baseUrl) ?>/#organization",
        "name": "Sabaya Luxury",
        "description": "<?= htmlspecialchars($siteTagline) ?>",
        "url": "<?= htmlspecialchars($baseUrl) ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "<?= htmlspecialchars($defaultImage) ?>"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "customer service",
            "availableLanguage": ["French", "Arabic"]
        },
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Casablanca",
            "addressCountry": "MA"
        },
        "email": "contact@sabaya.ma",
        "sameAs": []
    }
    </script>

    <!-- JSON-LD: WebSite with SearchAction -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "@id": "<?= htmlspecialchars($baseUrl) ?>/#website",
        "name": "Sabaya Luxury",
        "description": "<?= htmlspecialchars($siteTagline) ?>",
        "url": "<?= htmlspecialchars($baseUrl) ?>",
        "publisher": {
            "@id": "<?= htmlspecialchars($baseUrl) ?>/#organization"
        },
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?= htmlspecialchars($baseUrl) ?>/products/search.php?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- Page-specific head content (extra JSON-LD, custom CSS, etc.) -->
    <?= $extraHeadContent ?>
</head>
