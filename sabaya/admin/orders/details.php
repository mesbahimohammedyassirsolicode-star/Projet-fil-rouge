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

$order = $orderModel->getOrderById($id_commande);

if (!$order) {
    header('Location: list.php');
    exit();
}

$items = $orderModel->getOrderItems($id_commande);

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
    <title>Détails Commande #<?= htmlspecialchars($order['id_commande']) ?> | Sabaya Luxury Admin</title>
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
                <h1>Commande #<?= htmlspecialchars($order['id_commande']) ?></h1>
                <p class="header-subtitle">Détails complets de la commande client.</p>
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
                <a href="list.php" class="breadcrumb-back">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                    Retour aux commandes
                </a>
            </nav>

            <!-- Details Grid -->
            <div class="order-details-grid">

                <!-- Order Info + Customer Info -->
                <div class="order-details-left">

                    <!-- Order Summary Card -->
                    <section class="order-info-card" aria-label="Informations de la commande">
                        <div class="order-info-card-header">
                            <div>
                                <h2>Informations de la Commande</h2>
                                <span class="order-badge <?= $statusClass ?>"><?= htmlspecialchars($order['statuscmd']) ?></span>
                            </div>
                            <a href="update-status.php?id=<?= htmlspecialchars($order['id_commande']) ?>" class="btn-add-product" style="font-size:0.85rem;padding:10px 18px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Modifier Statut
                            </a>
                        </div>
                        <dl class="order-info-dl">
                            <div class="order-info-row">
                                <dt>Numéro de commande</dt>
                                <dd><span class="order-id-cell">#<?= htmlspecialchars($order['id_commande']) ?></span></dd>
                            </div>
                            <div class="order-info-row">
                                <dt>Date de commande</dt>
                                <dd><span class="order-date-cell"><?= htmlspecialchars($order['datecmd']) ?></span></dd>
                            </div>
                            <div class="order-info-row">
                                <dt>Statut</dt>
                                <dd><span class="order-badge <?= $statusClass ?>"><?= htmlspecialchars($order['statuscmd']) ?></span></dd>
                            </div>
                            <div class="order-info-row">
                                <dt>Total</dt>
                                <dd><strong class="order-total-value"><?= number_format((float)$order['total'], 2, '.', ' ') ?> DH</strong></dd>
                            </div>
                        </dl>
                    </section>

                    <!-- Products Ordered -->
                    <section class="products-table-wrapper" aria-label="Produits commandés">
                        <div class="content-header-bar" style="margin-bottom:20px;">
                            <div>
                                <h2>Produits Commandés</h2>
                                <p class="section-subtitle"><?= count($items) ?> article(s) dans cette commande.</p>
                            </div>
                        </div>

                        <?php if (!empty($items)): ?>
                            <div class="table-responsive">
                                <table class="products-table" id="orderItemsTable">
                                    <caption class="sr-only">Liste des produits de cette commande</caption>
                                    <thead>
                                        <tr>
                                            <th scope="col">Produit</th>
                                            <th scope="col">Quantité</th>
                                            <th scope="col">Prix unitaire</th>
                                            <th scope="col">Sous-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td data-label="Produit">
                                                    <div class="product-info-cell">
                                                        <span class="product-name-text"><?= htmlspecialchars($item['produit_nom']) ?></span>
                                                    </div>
                                                </td>
                                                <td data-label="Quantité">
                                                    <span class="order-qty-badge"><?= htmlspecialchars($item['qte']) ?></span>
                                                </td>
                                                <td data-label="Prix unitaire">
                                                    <span class="product-price-cell"><?= number_format((float)$item['prix'], 2, '.', ' ') ?> DH</span>
                                                </td>
                                                <td data-label="Sous-total">
                                                    <span class="product-price-cell"><?= number_format((float)($item['qte'] * $item['prix']), 2, '.', ' ') ?> DH</span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="order-total-row">
                                            <td colspan="3" data-label=""><strong>Total commande</strong></td>
                                            <td data-label="Total"><strong class="order-total-value"><?= number_format((float)$order['total'], 2, '.', ' ') ?> DH</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="empty-state">Aucun produit trouvé pour cette commande.</p>
                        <?php endif; ?>
                    </section>
                </div>

                <!-- Customer Info Sidebar -->
                <aside class="order-details-right" aria-label="Informations du client">
                    <section class="order-info-card">
                        <div class="order-info-card-header" style="margin-bottom:20px;">
                            <h2>Informations Client</h2>
                        </div>
                        <div class="customer-avatar-block">
                            <div class="customer-avatar">
                                <?= strtoupper(substr($order['prenom'] ?? 'C', 0, 1)) ?>
                            </div>
                            <div>
                                <strong class="product-name-text"><?= htmlspecialchars($order['prenom']) ?> <?= htmlspecialchars($order['nom']) ?></strong>
                                <span class="product-ref-text">ID client : #<?= htmlspecialchars($order['id_client']) ?></span>
                            </div>
                        </div>
                        <dl class="order-info-dl" style="margin-top:20px;">
                            <div class="order-info-row">
                                <dt>Nom</dt>
                                <dd><?= htmlspecialchars($order['nom']) ?></dd>
                            </div>
                            <div class="order-info-row">
                                <dt>Prénom</dt>
                                <dd><?= htmlspecialchars($order['prenom']) ?></dd>
                            </div>
                            <div class="order-info-row">
                                <dt>Email</dt>
                                <dd><a href="mailto:<?= htmlspecialchars($order['email']) ?>" style="word-break:break-all;"><?= htmlspecialchars($order['email']) ?></a></dd>
                            </div>
                            <?php if (!empty($order['telephone'])): ?>
                            <div class="order-info-row">
                                <dt>Téléphone</dt>
                                <dd><a href="tel:<?= htmlspecialchars($order['telephone']) ?>"><?= htmlspecialchars($order['telephone']) ?></a></dd>
                            </div>
                            <?php endif; ?>
                        </dl>
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
