<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Order.php';

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

$orderModel = new Order($pdo);

$id_commande = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $status = trim($_POST['status']);

    $orderModel->updateStatus(
        $id_commande,
        $status
    );

    header('Location: list.php');
    exit();
}

$order = $orderModel->getOrderById($id_commande);

if (!$order) {
    header('Location: list.php');
    exit();
}

$statusClass = match($order['statuscmd']) {
    'En attente' => 'order-badge--pending',
    'Confirmée'  => 'order-badge--confirmed',
    'Expédiée'   => 'order-badge--shipped',
    'Livrée'     => 'order-badge--delivered',
    'Annulée'    => 'order-badge--cancelled',
    default      => 'order-badge--pending',
};

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Modifier Statut Commande #<?= htmlspecialchars($order['id_commande']) ?> | Sabaya Luxury Admin</title>
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
                <li class="nav-item active">
                    <a href="list.php" aria-current="page">
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
                <li class="nav-item">
                    <a href="../contact/list.php">
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
                <h1>Modifier le Statut</h1>
                <p class="header-subtitle">Commande #<?= htmlspecialchars($order['id_commande']) ?> — <?= htmlspecialchars($order['prenom']) ?> <?= htmlspecialchars($order['nom']) ?></p>
            </div>
            <div class="header-user">
                <span class="user-greeting">Bonjour, <?= htmlspecialchars(isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin') ?></span>
                <a href="../../auth/profile.php" class="user-avatar" aria-label="Mon profil">
                    <?= strtoupper(substr(isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'A', 0, 1)) ?>
                </a>
            </div>
        </header>

        <!-- ── Main Content ────────────────────────── -->
        <main class="admin-content">

            <!-- Breadcrumb / Back -->
            <nav class="order-breadcrumb" aria-label="Fil d'Ariane">
                <a href="details.php?id=<?= htmlspecialchars($order['id_commande']) ?>" class="breadcrumb-back">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                    Retour aux détails
                </a>
            </nav>

            <!-- Update form grid -->
            <div class="form-grid" style="max-width:900px;">

                <!-- Current order summary -->
                <section class="order-info-card" aria-label="Résumé de la commande">
                    <div class="order-info-card-header" style="margin-bottom:20px;">
                        <h2>Résumé de la Commande</h2>
                    </div>
                    <dl class="order-info-dl">
                        <div class="order-info-row">
                            <dt>Numéro</dt>
                            <dd><span class="order-id-cell">#<?= htmlspecialchars($order['id_commande']) ?></span></dd>
                        </div>
                        <div class="order-info-row">
                            <dt>Client</dt>
                            <dd><?= htmlspecialchars($order['prenom']) ?> <?= htmlspecialchars($order['nom']) ?></dd>
                        </div>
                        <div class="order-info-row">
                            <dt>Date</dt>
                            <dd><span class="order-date-cell"><?= htmlspecialchars($order['datecmd']) ?></span></dd>
                        </div>
                        <div class="order-info-row">
                            <dt>Total</dt>
                            <dd><strong class="order-total-value"><?= number_format((float)$order['total'], 2, '.', ' ') ?> DH</strong></dd>
                        </div>
                        <div class="order-info-row">
                            <dt>Statut actuel</dt>
                            <dd><span class="order-badge <?= $statusClass ?>"><?= htmlspecialchars($order['statuscmd']) ?></span></dd>
                        </div>
                    </dl>
                </section>

                <!-- Update Status Form -->
                <section class="form-card" aria-label="Formulaire de modification du statut">
                    <form method="POST" id="updateStatusForm" class="luxury-form" novalidate>
                        <fieldset class="form-card" style="border:none;padding:0;margin:0;box-shadow:none;">
                            <legend style="font-size:1.15rem;font-weight:600;color:var(--clr-dark);margin-bottom:24px;float:none;width:auto;padding:0;">
                                Nouveau Statut
                            </legend>

                            <!-- Status visual selector -->
                            <div class="form-group" style="margin-bottom:28px;">
                                <label for="status" style="margin-bottom:12px;">Sélectionner un statut</label>
                                <div class="status-selector" role="group" aria-label="Choisir le statut de la commande">
                                    <?php
                                    $statuses = [
                                        ['value' => 'En attente', 'class' => 'order-badge--pending',   'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
                                        ['value' => 'Confirmée',  'class' => 'order-badge--confirmed', 'icon' => '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
                                        ['value' => 'Expédiée',   'class' => 'order-badge--shipped',   'icon' => '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>'],
                                        ['value' => 'Livrée',     'class' => 'order-badge--delivered', 'icon' => '<polyline points="20 6 9 17 4 12"/>'],
                                        ['value' => 'Annulée',    'class' => 'order-badge--cancelled', 'icon' => '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'],
                                    ];
                                    foreach ($statuses as $s):
                                        $isSelected = ($order['statuscmd'] === $s['value']);
                                    ?>
                                    <label class="status-option <?= $isSelected ? 'is-selected' : '' ?>" for="status_<?= md5($s['value']) ?>">
                                        <input type="radio" name="status" id="status_<?= md5($s['value']) ?>"
                                               value="<?= htmlspecialchars($s['value']) ?>"
                                               <?= $isSelected ? 'checked' : '' ?>>
                                        <span class="status-option-inner">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $s['icon'] ?></svg>
                                            <span class="order-badge <?= $s['class'] ?>"><?= htmlspecialchars($s['value']) ?></span>
                                        </span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                                <!-- Hidden select for fallback accessibility -->
                                <select name="status" id="status" class="sr-only" aria-hidden="true" tabindex="-1">
                                    <option value="En attente" <?= $order['statuscmd'] === 'En attente' ? 'selected' : '' ?>>En attente</option>
                                    <option value="Confirmée"  <?= $order['statuscmd'] === 'Confirmée'  ? 'selected' : '' ?>>Confirmée</option>
                                    <option value="Expédiée"   <?= $order['statuscmd'] === 'Expédiée'   ? 'selected' : '' ?>>Expédiée</option>
                                    <option value="Livrée"     <?= $order['statuscmd'] === 'Livrée'     ? 'selected' : '' ?>>Livrée</option>
                                    <option value="Annulée"    <?= $order['statuscmd'] === 'Annulée'    ? 'selected' : '' ?>>Annulée</option>
                                </select>
                            </div>

                            <div class="form-actions">
                                <a href="details.php?id=<?= htmlspecialchars($order['id_commande']) ?>" class="btn-secondary">Annuler</a>
                                <button type="submit" class="btn-primary" id="submitStatusBtn">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    Enregistrer
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </section>
            </div>

        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <p>Copyright &copy; 2026 Sabaya Luxury</p>
        </footer>
    </div>

    <!-- JS Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sidebar toggle
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

        if (toggle) toggle.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
        if (overlay) overlay.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) { closeSidebar(); toggle.focus(); }
        });

        // Status visual selector sync
        const statusOptions = document.querySelectorAll('.status-option');
        const hiddenSelect   = document.getElementById('status');

        statusOptions.forEach(label => {
            const radio = label.querySelector('input[type="radio"]');
            radio.addEventListener('change', () => {
                statusOptions.forEach(l => l.classList.remove('is-selected'));
                label.classList.add('is-selected');
                if (hiddenSelect) hiddenSelect.value = radio.value;
            });
        });
    });
    </script>
</body>
</html>
