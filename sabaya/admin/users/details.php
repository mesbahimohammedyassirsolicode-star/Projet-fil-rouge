<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/User.php';

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

$userModel = new User($pdo);

$id = (int) $_GET['id'];

$user = $userModel->find($id);

if (!$user) {
    header('Location: list.php');
    exit();
}

$orderCount = $userModel->getOrderCount($id);
$orders = $userModel->getUserOrders($id);

// ── Load localisation system ──────────────────────────────────────────────
require_once '../../config/lang.php';

$roleClass = ($user['role'] === 'admin') ? 'role-badge--admin' : 'role-badge--client';
$roleText = ($user['role'] === 'admin') ? t('admin_role_admin') : t('admin_role_client');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Détails Utilisateur | Sabaya Luxury Admin</title>
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
                <li class="nav-item active">
                    <a href="list.php" aria-current="page">
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
                <h1><?= htmlspecialchars($user['prenom']) ?> <?= htmlspecialchars($user['nom']) ?></h1>
                <p class="header-subtitle">Profil utilisateur Sabaya Luxury.</p>
            </div>
            <div class="header-user" style="margin-left: auto;">
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
                <a href="list.php" class="breadcrumb-back">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                    Retour aux utilisateurs
                </a>
            </nav>

            <!-- Details Grid -->
            <div class="user-details-grid">

                <!-- User Profile + Order History -->
                <div class="user-details-left">

                    <!-- User Profile Card -->
                    <section class="order-info-card" aria-label="Informations de l'utilisateur">
                        <div class="order-info-card-header">
                            <div>
                                <h2>Informations de l'Utilisateur</h2>
                                <span class="role-badge <?= $roleClass ?>"><?= $roleText ?></span>
                            </div>
                            <?php if ($user['role'] !== 'admin'): ?>
                            <a href="edit.php?id=<?= htmlspecialchars($user['id_client']) ?>" class="btn-add-product" style="font-size:0.85rem;padding:10px 18px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Modifier
                            </a>
                            <?php endif; ?>
                        </div>

                        <div class="customer-avatar-block" style="margin-bottom: 20px;">
                            <div class="customer-avatar">
                                <?= strtoupper(substr($user['prenom'] ?? $user['nom'], 0, 1)) ?>
                            </div>
                            <div>
                                <strong class="product-name-text"><?= htmlspecialchars($user['prenom']) ?> <?= htmlspecialchars($user['nom']) ?></strong>
                                <span class="product-ref-text">ID utilisateur : #<?= htmlspecialchars($user['id_client']) ?></span>
                            </div>
                        </div>

                        <dl class="order-info-dl">
                            <div class="order-info-row">
                                <dt>Nom</dt>
                                <dd><?= htmlspecialchars($user['nom']) ?></dd>
                            </div>
                            <div class="order-info-row">
                                <dt>Prénom</dt>
                                <dd><?= htmlspecialchars($user['prenom']) ?></dd>
                            </div>
                            <div class="order-info-row">
                                <dt>Email</dt>
                                <dd><a href="mailto:<?= htmlspecialchars($user['email']) ?>" style="word-break:break-all;"><?= htmlspecialchars($user['email']) ?></a></dd>
                            </div>
                            <?php if (!empty($user['telephone'])): ?>
                            <div class="order-info-row">
                                <dt>Téléphone</dt>
                                <dd><a href="tel:<?= htmlspecialchars($user['telephone']) ?>"><?= htmlspecialchars($user['telephone']) ?></a></dd>
                            </div>
                            <?php endif; ?>
                            <div class="order-info-row">
                                <dt>Rôle</dt>
                                <dd><span class="role-badge <?= $roleClass ?>"><?= $roleText ?></span></dd>
                            </div>
                            <div class="order-info-row">
                                <dt>Nombre de commandes</dt>
                                <dd><span class="order-qty-badge"><?= htmlspecialchars($orderCount) ?></span></dd>
                            </div>
                        </dl>
                    </section>

                    <!-- User Orders -->
                    <?php if ($orderCount > 0): ?>
                    <section class="products-table-wrapper" aria-label="Commandes de l'utilisateur">
                        <div class="content-header-bar" style="margin-bottom:20px;">
                            <div>
                                <h2>Commandes de l'Utilisateur</h2>
                                <p class="section-subtitle"><?= htmlspecialchars($orderCount) ?> commande(s) passée(s).</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="products-table">
                                <caption class="sr-only">Liste des commandes passées par cet utilisateur</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Commande</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                    <?php
                                    $orderStatusClass = match($order['statuscmd']) {
                                        'En attente' => 'order-badge--pending',
                                        'Confirmée'  => 'order-badge--confirmed',
                                        'Expédiée'   => 'order-badge--shipped',
                                        'Livrée'     => 'order-badge--delivered',
                                        'Annulée'    => 'order-badge--cancelled',
                                        default      => 'order-badge--pending',
                                    };
                                    ?>
                                    <tr>
                                        <td data-label="Commande">
                                            <span class="order-id-cell">#<?= htmlspecialchars($order['id_commande']) ?></span>
                                        </td>
                                        <td data-label="Date">
                                            <span class="order-date-cell"><?= htmlspecialchars($order['datecmd']) ?></span>
                                        </td>
                                        <td data-label="Total" class="product-price-cell">
                                            <?= number_format((float)$order['total'], 2, ',', ' ') ?> DH
                                        </td>
                                        <td data-label="Statut">
                                            <span class="order-badge <?= $orderStatusClass ?>"><?= htmlspecialchars($order['statuscmd']) ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <?php else: ?>
                    <section class="order-info-card" aria-label="Aucune commande">
                        <div style="text-align:center;padding:40px 20px;color:var(--clr-text-muted);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="opacity:0.3;margin-bottom:12px;"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <p style="font-weight:500;font-size:1rem;">Cet utilisateur n'a pas encore passé de commande.</p>
                        </div>
                    </section>
                    <?php endif; ?>
                </div>

                <!-- Quick Info Sidebar -->
                <aside class="user-details-right" aria-label="Actions rapides">
                    <section class="order-info-card">
                        <div class="order-info-card-header" style="margin-bottom:20px;">
                            <h2>Actions</h2>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <?php if ($user['role'] !== 'admin'): ?>
                            <a href="edit.php?id=<?= $user['id_client'] ?>" class="action-btn" style="justify-content:center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                <span>Modifier l'utilisateur</span>
                            </a>
                            <a href="delete.php?id=<?= $user['id_client'] ?>" onclick="return confirm('Supprimer cet utilisateur ?')" class="action-btn" style="justify-content:center;border-color:#e74c3c;color:#e74c3c;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                <span>Supprimer l'utilisateur</span>
                            </a>
                            <?php endif; ?>
                            <a href="../orders/list.php?user=<?= $user['id_client'] ?>" class="action-btn" style="justify-content:center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <span>Voir les commandes</span>
                            </a>
                        </div>
                    </section>
                </aside>
            </div>

        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <p>Copyright &copy; 2026 Sabaya Luxury</p>
        </footer>
    </div>

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
</body>
</html>