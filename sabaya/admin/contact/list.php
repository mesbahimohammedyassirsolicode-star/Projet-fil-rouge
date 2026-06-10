<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Contact.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$contactModel = new Contact($pdo);

// ── Load localisation system ──────────────────────────────────────────────
require_once '../../config/lang.php';

$messages = $contactModel->getAll();

// Fetch database stats for cards
$stmtTotal = $pdo->query("SELECT COUNT(*) FROM contact");
$totalMessages = $stmtTotal->fetchColumn();

$stmtToday = $pdo->query("SELECT COUNT(*) FROM contact WHERE DATE(date_message) = CURDATE()");
$todayMessages = $stmtToday->fetchColumn();

$stmtWeek = $pdo->query("SELECT COUNT(*) FROM contact WHERE YEARWEEK(date_message, 1) = YEARWEEK(CURDATE(), 1)");
$weekMessages = $stmtWeek->fetchColumn();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Messages de Contact | Sabaya Luxury Admin</title>
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
            <h1>Messages de Contact</h1>
            <p class="header-subtitle">Consultez et gérez les messages envoyés par les clients.</p>
        </div>
        <div class="header-search">
            <label for="adminSearch" class="sr-only">Rechercher</label>
            <input type="search" id="adminSearch" placeholder="Rechercher un message..." aria-label="Rechercher dans les messages">
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

        <!-- Statistics Cards -->
        <section class="stats-cards contact-stats-cards" aria-label="Statistiques des messages">
            <article class="stat-card">
                <div class="stat-icon stat-icon--messages">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div class="stat-info">
                    <h2>Total Messages</h2>
                    <p class="stat-value"><?= htmlspecialchars($totalMessages) ?></p>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon stat-icon--today">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="stat-info">
                    <h2>Aujourd'hui</h2>
                    <p class="stat-value"><?= htmlspecialchars($todayMessages) ?></p>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon stat-icon--week">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div class="stat-info">
                    <h2>Cette Semaine</h2>
                    <p class="stat-value"><?= htmlspecialchars($weekMessages) ?></p>
                </div>
            </article>
        </section>

        <!-- Messages Table -->
        <section class="contact-table-wrapper" aria-label="Liste des messages">
            <header class="section-header">
                <h2>Tous les Messages</h2>
            </header>

            <?php if (empty($messages)): ?>
                <div class="contact-empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <p>Aucun message de contact pour le moment.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="contact-table">
                        <caption class="sr-only">Liste de tous les messages reçus via le formulaire de contact</caption>
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Email</th>
                                <th scope="col">Sujet</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td data-label="Nom">
                                    <div class="contact-sender-cell">
                                        <span class="contact-avatar-sm"><?= strtoupper(substr($msg['nom'], 0, 1)) ?></span>
                                        <span class="contact-sender-name"><?= htmlspecialchars($msg['nom']) ?></span>
                                    </div>
                                </td>
                                <td data-label="Email"><?= htmlspecialchars($msg['email']) ?></td>
                                <td data-label="Sujet"><?= htmlspecialchars($msg['sujet']) ?></td>
                                <td data-label="Date">
                                    <time datetime="<?= htmlspecialchars($msg['date_message']) ?>"><?= date('d M Y', strtotime($msg['date_message'])) ?></time>
                                </td>
                                <td data-label="Actions">
                                    <div class="contact-actions-cell">
                                        <a href="view.php?id=<?= $msg['id_contact'] ?>" class="action-btn-circle btn-view" aria-label="Voir le message de <?= htmlspecialchars($msg['nom']) ?>" title="Voir">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="delete.php?id=<?= $msg['id_contact'] ?>" class="action-btn-circle btn-delete" aria-label="Supprimer le message de <?= htmlspecialchars($msg['nom']) ?>" title="Supprimer">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

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

    /* ── Search Filter ────────────────────────── */
    const searchInput = document.getElementById('adminSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('.contact-table tbody tr');
            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
});
</script>

</body>
</html>
