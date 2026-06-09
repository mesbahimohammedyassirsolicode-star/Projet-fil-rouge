<?php


// ── Read from session flash bag ──────────────────────────────
if (!isset($toastMessage) && isset($_SESSION['_toast'])) {
    $toastMessage = $_SESSION['_toast']['message'] ?? '';
    $toastType    = $_SESSION['_toast']['type']    ?? 'success';
    $toastTitle   = $_SESSION['_toast']['title']   ?? '';
    unset($_SESSION['_toast']); // consume — show only once
}

// ── Resolve defaults ─────────────────────────────────────────
$toastMessage = $toastMessage ?? '';
$toastType    = $toastType    ?? 'success';
$toastTitle   = $toastTitle   ?? '';

// ── Render container ─────────────────────────────────────────
$dataAttrs = '';
if ($toastMessage !== '') {
    $dataAttrs .= ' data-flash-message="' . htmlspecialchars($toastMessage, ENT_QUOTES) . '"';
    $dataAttrs .= ' data-flash-type="'    . htmlspecialchars($toastType,    ENT_QUOTES) . '"';
    if ($toastTitle !== '') {
        $dataAttrs .= ' data-flash-title="' . htmlspecialchars($toastTitle, ENT_QUOTES) . '"';
    }
}

// Reset so next include on the same page doesn't re-fire
$toastMessage = '';
$toastType    = 'success';
$toastTitle   = '';
?>
<div id="toast-container"
     aria-live="polite"
     aria-atomic="false"
     <?= $dataAttrs ?>></div>
