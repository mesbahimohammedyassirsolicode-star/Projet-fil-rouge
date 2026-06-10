<?php
/**
 * Configuration du système de localisation — Sabaya Luxury
 *
 * Ce fichier doit être inclus UNE SEULE FOIS, avant tout affichage.
 * Il initialise la session, résout la langue active et charge le
 * tableau $lang correspondant.
 *
 * Utilisation dans les templates :
 *   <?= $lang['clé'] ?>
 *
 * Pour ajouter une nouvelle langue (ex. Arabe) :
 *   1. Créer lang/ar.php avec le tableau $lang complet.
 *   2. Ajouter 'ar' au tableau $supportedLangs ci-dessous.
 *   3. Ajouter le lien dans le sélecteur de langue de navbar.php.
 */

// ── Démarrer la session si elle n'est pas encore active ─────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Langues supportées ───────────────────────────────────────────────────────
$supportedLangs = ['fr', 'en'];
// Pour ajouter l'arabe : $supportedLangs = ['fr', 'en', 'ar'];

// ── Résolution de la langue active ──────────────────────────────────────────
// Priorité : paramètre GET → session → cookie → défaut FR
if (isset($_GET['lang']) && in_array($_GET['lang'], $supportedLangs, true)) {
    $activeLang = $_GET['lang'];
    $_SESSION['lang'] = $activeLang;
    // Conserver le choix 30 jours
    setcookie('sabaya_lang', $activeLang, time() + (30 * 24 * 3600), '/');
} elseif (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $supportedLangs, true)) {
    $activeLang = $_SESSION['lang'];
} elseif (isset($_COOKIE['sabaya_lang']) && in_array($_COOKIE['sabaya_lang'], $supportedLangs, true)) {
    $activeLang = $_COOKIE['sabaya_lang'];
    $_SESSION['lang'] = $activeLang;
} else {
    // Défaut : français
    $activeLang = 'fr';
    $_SESSION['lang'] = 'fr';
}

// ── Chargement du fichier de langue ─────────────────────────────────────────
$langFile = __DIR__ . '/../lang/' . $activeLang . '.php';

if (file_exists($langFile)) {
    require_once $langFile;
} else {
    // Repli sur le français si le fichier demandé est absent
    require_once __DIR__ . '/../lang/fr.php';
    $activeLang = 'fr';
}

// ── Fonction helper t() — retourne la traduction ou la clé si absente ───────
if (!function_exists('t')) {
    /**
     * Translate a key. Falls back to French if key is missing in active lang,
     * then falls back to the key itself.
     *
     * @param string $key
     * @param string|null $fallback Optional custom fallback string
     * @return string
     */
    function t(string $key, ?string $fallback = null): string
    {
        global $lang, $activeLang;

        // Key found in active language
        if (isset($lang[$key])) {
            return $lang[$key];
        }

        // Key missing — try French fallback (only if active lang is not already FR)
        if ($activeLang !== 'fr') {
            static $frLang = null;
            if ($frLang === null) {
                $frFile = __DIR__ . '/../lang/fr.php';
                if (file_exists($frFile)) {
                    $savedLang = $lang;
                    require $frFile;
                    $frLang = $lang;
                    $lang = $savedLang;
                }
            }
            if (isset($frLang[$key])) {
                return $frLang[$key];
            }
        }

        // Last resort: return custom fallback or the key itself
        return $fallback ?? $key;
    }
}
