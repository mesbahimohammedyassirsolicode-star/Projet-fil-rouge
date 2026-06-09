<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Order.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$orderModel = new Order($pdo);

$orders = $orderModel->getAllOrders();

// Order statistics
$stmtTotal     = $pdo->query("SELECT COUNT(*) FROM commande");
$totalOrders   = $stmtTotal->fetchColumn();

$stmtPending   = $pdo->query("SELECT COUNT(*) FROM commande WHERE statuscmd = 'En attente'");
$pendingOrders = $stmtPending->fetchColumn();

$stmtConfirmed   = $pdo->query("SELECT COUNT(*) FROM commande WHERE statuscmd = 'Confirmée'");
$confirmedOrders = $stmtConfirmed->fetchColumn();

$stmtDelivered   = $pdo->query("SELECT COUNT(*) FROM commande WHERE statuscmd = 'Livrée'");
$deliveredOrders = $stmtDelivered->fetchColumn();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Gestion des Commandes | Sabaya Luxury Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="../../assets/css/toast.css">
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
                <h1>Gestion des Commandes</h1>
                <p class="header-subtitle">Suivez et gérez toutes les commandes clients.</p>
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

            <!-- Statistics Cards -->
            <section class="stats-cards reveal" aria-label="Statistiques des commandes">
                <article class="stat-card">
                    <div class="stat-icon stat-icon--orders">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <div class="stat-info">
                        <h2>Total Commandes</h2>
                        <p class="stat-value"><?= htmlspecialchars($totalOrders) ?></p>
                    </div>
                </article>
                <article class="stat-card">
                    <div class="stat-icon stat-icon--pending">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="stat-info">
                        <h2>En Attente</h2>
                        <p class="stat-value"><?= htmlspecialchars($pendingOrders) ?></p>
                    </div>
                </article>
                <article class="stat-card">
                    <div class="stat-icon stat-icon--confirmed">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div class="stat-info">
                        <h2>Confirmées</h2>
                        <p class="stat-value"><?= htmlspecialchars($confirmedOrders) ?></p>
                    </div>
                </article>
                <article class="stat-card">
                    <div class="stat-icon stat-icon--delivered">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </div>
                    <div class="stat-info">
                        <h2>Livrées</h2>
                        <p class="stat-value"><?= htmlspecialchars($deliveredOrders) ?></p>
                    </div>
                </article>
            </section>

            <!-- Orders Table -->
            <section class="products-table-wrapper reveal" aria-label="Liste des commandes">
                <div class="content-header-bar">
                    <div>
                        <h2>Liste des Commandes</h2>
                        <p class="section-subtitle">Gérez toutes les commandes de vos clients Sabaya Luxury.</p>
                    </div>
                </div>

                <?php if (empty($orders)): ?>
                    <div class="orders-empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <p>Aucune commande pour le moment.</p>
                        <a href="../dashboard.php" class="btn-secondary">Retour au Dashboard</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="products-table" id="ordersTable">
                            <caption class="sr-only">Liste de toutes les commandes passées</caption>
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <?php
                                        $status = $order['statuscmd'];
                                        $statusClass = match($status) {
                                            'En attente' => 'order-badge--pending',
                                            'Confirmée'  => 'order-badge--confirmed',
                                            'Expédiée'   => 'order-badge--shipped',
                                            'Livrée'     => 'order-badge--delivered',
                                            'Annulée'    => 'order-badge--cancelled',
                                            default      => 'order-badge--pending',
                                        };
                                    ?>
                                    <tr>
                                        <td data-label="ID">
                                            <span class="order-id-cell">#<?= htmlspecialchars($order['id_commande']) ?></span>
                                        </td>
                                        <td data-label="Client">
                                            <div class="product-info-cell">
                                                <span class="product-name-text"><?= htmlspecialchars($order['nom']) ?> <?= htmlspecialchars($order['prenom']) ?></span>
                                            </div>
                                        </td>
                                        <td data-label="Date">
                                            <span class="order-date-cell"><?= htmlspecialchars($order['datecmd']) ?></span>
                                        </td>
                                        <td data-label="Total">
                                            <span class="product-price-cell"><?= number_format((float)$order['total'], 2, '.', ' ') ?> DH</span>
                                        </td>
                                        <td data-label="Statut">
                                            <span class="order-badge <?= $statusClass ?>"><?= htmlspecialchars($status) ?></span>
                                        </td>
                                        <td data-label="Actions">
                                            <div class="product-actions-cell">
                                                <a href="details.php?id=<?= htmlspecialchars($order['id_commande']) ?>" class="action-btn-circle btn-view" title="Voir les détails">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    <span class="sr-only">Voir détails commande #<?= htmlspecialchars($order['id_commande']) ?></span>
                                                </a>
                                                <a href="update-status.php?id=<?= htmlspecialchars($order['id_commande']) ?>" class="action-btn-circle btn-edit" title="Modifier le statut">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    <span class="sr-only">Modifier statut commande #<?= htmlspecialchars($order['id_commande']) ?></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrapper reveal">
                        <span class="pagination-info">Affichage de <?= count($orders) ?> sur <?= $totalOrders ?> commandes</span>
                    </div>
                <?php endif; ?>
            </section>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <p>Copyright &copy; 2026 Sabaya Luxury</p>
        </footer>
    </div>

    <!-- Toast Container (Admin) -->
    <?php
    if (isset($_SESSION['_toast'])) {
        $toastMsg  = $_SESSION['_toast']['message'] ?? '';
        $toastType = $_SESSION['_toast']['type']    ?? 'success';
        unset($_SESSION['_toast']);
        echo '<div id="toast-container" aria-live="polite" aria-atomic="false"'
           . ' data-flash-message="' . htmlspecialchars($toastMsg,  ENT_QUOTES) . '"'
           . ' data-flash-type="'    . htmlspecialchars($toastType, ENT_QUOTES) . '"></div>';
    } else {
        echo '<div id="toast-container" aria-live="polite" aria-atomic="false"></div>';
    }
    ?>
    <!-- JS Script for mobile toggle -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
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

        if (toggle) {
            toggle.addEventListener('click', function () {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });
        }
        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
                closeSidebar();
                toggle.focus();
            }
        });
    });
    </script>
<script src="../../assets/js/toast.js"></script>
</body>
</html>