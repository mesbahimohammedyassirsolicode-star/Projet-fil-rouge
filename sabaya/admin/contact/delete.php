<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Contact.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$contactModel = new Contact($pdo);

$id = (int) $_GET['id'];
$message = $contactModel->getById($id);

if (!$message) {
    header('Location: list.php');
    exit();
}

// Handle deletion when confirmed via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $contactModel->delete($id);
    header('Location: list.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Supprimer le Message | Sabaya Luxury Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body class="admin-dashboard">

<!-- ══ Sidebar ════════════════════════════════════ -->
<aside class="sidebar" id="sidebar" aria-label="Menu administration">
    <div class="sidebar-brand">
        <img src="../../assets/images/logo/logo.png" alt="Sabaya Luxury" class="sidebar-logo">
        <span class="sidebar-title">Sabaya Admin</span>
    </div>
    <nav aria-label="Navigation principale admin">
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="../dashboard.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../products/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    <span>Produits</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../categories/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                    <span>Catégories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../orders/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <span>Commandes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../users/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    <span>Clients</span>
                </a>
            </li>
            <li class="nav-item active">
                <a href="list.php" aria-current="page">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span>Messages</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../statistics/index.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <span>Statistiques</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="../../auth/logout.php" class="logout-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span>Déconnexion</span>
        </a>
    </div>
</aside>

<!-- ══ Overlay for mobile ════════════════════════ -->
<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

<!-- ══ Main Wrapper ══════════════════════════════ -->
<div class="admin-main-wrapper">

    <!-- ── Top Header ──────────────────────────── -->
    <header class="admin-top-header">
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="sidebar">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="header-title-block">
            <h1>Supprimer le Message</h1>
            <p class="header-subtitle">Confirmation de suppression</p>
        </div>
        <div class="header-user">
            <span class="user-greeting">Bonjour, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="../../auth/profile.php" class="user-avatar" aria-label="Mon profil">
                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
            </a>
        </div>
    </header>

    <!-- ── Main Content ────────────────────────── -->
    <main class="admin-content">

        <!-- Breadcrumb -->
        <nav class="order-breadcrumb" aria-label="Fil d'Ariane">
            <a href="list.php" class="breadcrumb-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Retour aux messages
            </a>
        </nav>

        <!-- Delete Confirmation Card -->
        <div class="delete-confirmation-wrapper">
            <article class="delete-confirmation-card">
                <div class="delete-confirmation-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <h2>Supprimer ce message ?</h2>
                <p class="delete-confirmation-text">Cette action est irréversible. Le message de <strong><?= htmlspecialchars($message['nom']) ?></strong> sera définitivement supprimé.</p>

                <!-- Message Preview -->
                <div class="delete-message-preview">
                    <dl class="order-info-dl">
                        <div class="order-info-row">
                            <dt>Nom</dt>
                            <dd><?= htmlspecialchars($message['nom']) ?></dd>
                        </div>
                        <div class="order-info-row">
                            <dt>Email</dt>
                            <dd><?= htmlspecialchars($message['email']) ?></dd>
                        </div>
                        <div class="order-info-row">
                            <dt>Sujet</dt>
                            <dd><?= htmlspecialchars($message['sujet']) ?></dd>
                        </div>
                        <div class="order-info-row">
                            <dt>Date</dt>
                            <dd>
                                <time datetime="<?= htmlspecialchars($message['date_message']) ?>"><?= date('d M Y', strtotime($message['date_message'])) ?></time>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <form method="POST" class="delete-confirmation-actions">
                    <input type="hidden" name="confirm_delete" value="1">
                    <button type="submit" class="btn-danger delete-confirm-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                        Confirmer
                    </button>
                    <a href="list.php" class="btn-secondary delete-cancel-btn">
                        Annuler
                    </a>
                </form>
            </article>
        </div>

    </main>

    <!-- ── Footer ──────────────────────────────── -->
    <footer class="admin-footer">
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    /* ── Sidebar Toggle ──────────────────────── */
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        toggle.setAttribute('aria-expanded', 'true');
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', function () {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });
    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
            toggle.focus();
        }
    });
});
</script>

</body>
</html>
