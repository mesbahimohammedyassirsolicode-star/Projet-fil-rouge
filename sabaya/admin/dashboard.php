<?php

session_start();

require_once '../config/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: /index.php");
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

// ── Load localisation system ──────────────────────────────────────────────
require_once '../config/lang.php';

/* ── Statistics Counts ──────────────────────────── */
$stmt = $pdo->query("SELECT COUNT(*) FROM produits");
$totalProducts = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM commande");
$totalOrders = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM client");
$totalClients = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM contact");
$totalMessages = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM categorie");
$totalCategories = $stmt->fetchColumn();

$stmt = $pdo->query("
    SELECT COALESCE(SUM(total),0)
    FROM commande
    WHERE statuscmd != 'Annulée'
");
$totalRevenue = $stmt->fetchColumn();

/* ── Monthly Orders for Chart ───────────────────── */
$stmt = $pdo->query("
    SELECT
        DATE_FORMAT(datecmd, '%Y-%m') AS mois,
        COUNT(*) AS nb_commandes,
        COALESCE(SUM(total),0) AS revenu_mois
    FROM commande
    WHERE statuscmd != 'Annulée'
    GROUP BY DATE_FORMAT(datecmd, '%Y-%m')
    ORDER BY mois ASC
    LIMIT 12
");
$monthlyData = $stmt->fetchAll();

$chartLabels = [];
$chartOrders = [];
$chartRevenue = [];
foreach ($monthlyData as $row) {
    $chartLabels[] = $row['mois'];
    $chartOrders[] = (int)$row['nb_commandes'];
    $chartRevenue[] = (float)$row['revenu_mois'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Dashboard Admin | Sabaya Luxury</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-dashboard">

<!-- ══ Sidebar ════════════════════════════════════ -->
<aside class="sidebar" id="sidebar" aria-label="Menu administration">
    <div class="sidebar-brand">
        <img src="../assets/images/logo/logo.png" alt="Sabaya Luxury" class="sidebar-logo">
        <span class="sidebar-title">Sabaya Admin</span>
    </div>
    <nav aria-label="Navigation principale admin">
        <ul class="sidebar-nav">
            <li class="nav-item active">
                <a href="dashboard.php" aria-current="page">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="products/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    <span>Produits</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="categories/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                    <span>Catégories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="orders/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <span>Commandes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="users/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    <span>Clients</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="contact/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span>Messages</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="statistics/index.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <span>Statistiques</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="/auth/logout.php" class="logout-btn">
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
            <h1><?= t('admin_overview_title') ?></h1>
            <p class="header-subtitle"><?= t('admin_overview_subtitle') ?></p>
        </div>
        <div class="header-search">
            <label for="adminSearch" class="sr-only">Rechercher</label>
            <input type="search" id="adminSearch" placeholder="Rechercher..." aria-label="Rechercher dans le dashboard">
        </div>
        <div class="header-user">
            <span class="user-greeting">Bonjour, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="/auth/profile.php" class="user-avatar" aria-label="Mon profil">
                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
            </a>
        </div>
    </header>

    <!-- ── Main Content ────────────────────────── -->
    <main class="admin-content">

        <!-- Statistics Cards -->
    <section class="stats-cards reveal" aria-label="Statistiques générales">
            <article class="stat-card">
                <div class="stat-icon stat-icon--products">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                </div>
                <div class="stat-info">
                    <h2>Total Produits</h2>
                    <p class="stat-value"><span class="counter" data-count="<?= (int)$totalProducts ?>" aria-label="<?= (int)$totalProducts ?> produits">0</span></p>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon stat-icon--orders">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div class="stat-info">
                    <h2>Total Commandes</h2>
                    <p class="stat-value"><span class="counter" data-count="<?= (int)$totalOrders ?>" aria-label="<?= (int)$totalOrders ?> commandes">0</span></p>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon stat-icon--clients">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div class="stat-info">
                    <h2>Total Clients</h2>
                    <p class="stat-value"><span class="counter" data-count="<?= (int)$totalClients ?>" aria-label="<?= (int)$totalClients ?> clients">0</span></p>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon stat-icon--messages">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div class="stat-info">
                    <h2>Messages Contact</h2>
                    <p class="stat-value"><span class="counter" data-count="<?= (int)$totalMessages ?>" aria-label="<?= (int)$totalMessages ?> messages">0</span></p>
                </div>
            </article>
        </section>

        <!-- Revenue Banner -->
    <section class="revenue-banner reveal" aria-label="Chiffre d'affaires">
            <div class="revenue-content">
                <h2>Chiffre d'Affaires</h2>
                <p class="revenue-value">
                    <span class="counter"
                          data-count="<?= number_format($totalRevenue, 2, '.', '') ?>"
                          data-decimals="2"
                          data-separator=" "
                          data-decimal-sep=","
                          data-suffix=" DH"
                          aria-label="<?= number_format($totalRevenue, 2, ',', ' ') ?> DH">0 DH</span>
                </p>
            </div>
            <div class="revenue-meta">
                <span><span class="counter" data-count="<?= (int)$totalCategories ?>" aria-label="<?= (int)$totalCategories ?>">0</span> catégories</span>
                <span class="separator">·</span>
                <span><span class="counter" data-count="<?= (int)$totalOrders ?>" aria-label="<?= (int)$totalOrders ?>">0</span> commandes traitées</span>
            </div>
        </section>

        <!-- Analytics Chart -->
    <section class="analytics-section reveal" aria-label="Analytique des commandes">
            <header class="section-header">
                <h2>Évolution des Commandes</h2>
            </header>
            <div class="chart-container">
                <canvas id="ordersChart" aria-label="Graphique d'évolution des commandes mensuelles" role="img"></canvas>
            </div>
        </section>

        <!-- Quick Actions -->
    <section class="quick-actions reveal" aria-label="Actions rapides">
            <header class="section-header">
                <h2>Actions Rapides</h2>
            </header>
            <div class="actions-grid">
                <a href="products/add.php" class="action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span>Ajouter Produit</span>
                </a>
                <a href="categories/add.php" class="action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span>Ajouter Catégorie</span>
                </a>
                <a href="orders/list.php" class="action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span>Voir Commandes</span>
                </a>
                <a href="users/list.php" class="action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <span>Voir Clients</span>
                </a>
            </div>
        </section>

        <!-- Two-Column: Recent Orders + Top Products -->
        <div class="dashboard-grid">

            <?php
            $stmt = $pdo->query("
                SELECT
                    commande.id_commande,
                    commande.datecmd,
                    commande.total,
                    commande.statuscmd,
                    client.nom,
                    client.prenom
                FROM commande
                INNER JOIN client
                    ON commande.id_client = client.id_client
                ORDER BY commande.id_commande DESC
                LIMIT 5
            ");
            $recentOrders = $stmt->fetchAll();
            ?>

            <!-- Recent Orders -->
            <section class="table-section reveal" aria-label="Dernières commandes">
                <header class="section-header">
                    <h2>Dernières Commandes</h2>
                    <a href="orders/list.php" class="view-all-link">Tout voir</a>
                </header>
                <div class="table-responsive">
                    <table>
                        <caption class="sr-only">Liste des 5 dernières commandes</caption>
                        <thead>
                            <tr>
                                <th scope="col">Commande</th>
                                <th scope="col">Client</th>
                                <th scope="col">Date</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>#<?= htmlspecialchars($order['id_commande']) ?></td>
                                <td><?= htmlspecialchars($order['prenom']) ?> <?= htmlspecialchars($order['nom']) ?></td>
                                <td><?= htmlspecialchars($order['datecmd']) ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower(htmlspecialchars($order['statuscmd'])) ?>">
                                        <?= htmlspecialchars($order['statuscmd']) ?>
                                    </span>
                                </td>
                                <td class="amount"><?= number_format($order['total'], 2, ',', ' ') ?> DH</td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($recentOrders)): ?>
                            <tr>
                                <td colspan="5" class="empty-state">Aucune commande pour le moment.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <?php
            $stmt = $pdo->query("
                SELECT
                    produits.nom,
                    SUM(ligne_commande.qte) AS total_vendu
                FROM ligne_commande
                INNER JOIN produits
                    ON ligne_commande.id_produit = produits.id_produit
                GROUP BY produits.id_produit
                ORDER BY total_vendu DESC
                LIMIT 5
            ");
            $bestProducts = $stmt->fetchAll();
            ?>

            <!-- Top Products -->
            <section class="table-section" aria-label="Top produits vendus">
                <header class="section-header">
                    <h2>Top Produits Vendus</h2>
                </header>
                <div class="table-responsive">
                    <table>
                        <caption class="sr-only">Classement des 5 produits les plus vendus</caption>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Produit</th>
                                <th scope="col">Quantité Vendue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rank = 1; foreach ($bestProducts as $product): ?>
                            <tr>
                                <td><span class="rank-badge"><?= $rank++ ?></span></td>
                                <td><?= htmlspecialchars($product['nom']) ?></td>
                                <td>
                                    <div class="quantity-bar">
                                        <span class="quantity-value"><?= htmlspecialchars($product['total_vendu']) ?></span>
                                        <div class="bar-track">
                                            <div class="bar-fill" style="width: <?= min(100, ($product['total_vendu'] / max(1, $bestProducts[0]['total_vendu'])) * 100) ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($bestProducts)): ?>
                            <tr>
                                <td colspan="3" class="empty-state">Aucune vente enregistrée.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

    </main>

    <!-- ── Footer ──────────────────────────────── -->
    <footer class="admin-footer">
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>

</div>

<!-- ══ Chart.js ═══════════════════════════════════ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
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

    /* ── Orders Chart ────────────────────────── */
    const ctx = document.getElementById('ordersChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chartLabels) ?>,
                datasets: [
                    {
                        label: 'Commandes',
                        data: <?= json_encode($chartOrders) ?>,
                        borderColor: '#C5AD59',
                        backgroundColor: 'rgba(197, 173, 89, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#C5AD59',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Revenu (DH)',
                        data: <?= json_encode($chartRevenue) ?>,
                        borderColor: '#1A1A1A',
                        backgroundColor: 'rgba(26, 26, 26, 0.05)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointBackgroundColor: '#1A1A1A',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: 'Poppins', size: 12 },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1A1A1A',
                        titleFont: { family: 'Poppins' },
                        bodyFont: { family: 'Poppins' },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Poppins', size: 11 } }
                    },
                    y: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        title: { display: true, text: 'Commandes', font: { family: 'Poppins' } },
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { font: { family: 'Poppins', size: 11 }, stepSize: 1 }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        title: { display: true, text: 'Revenu (DH)', font: { family: 'Poppins' } },
                        grid: { drawOnChartArea: false },
                        ticks: { font: { family: 'Poppins', size: 11 } }
                    }
                }
            }
        });
    }
});
</script>

<!-- ══ Counter Animations ═════════════════════════ -->
<script src="../assets/js/counter.js"></script>

</body>
</html>
