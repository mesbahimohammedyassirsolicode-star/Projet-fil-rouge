<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

require_once '../../config/Database.php';

$db = new Database();
$pdo = $db->getConnection();

/* Produits */
$stmt = $pdo->query("SELECT COUNT(*) FROM produits");
$totalProducts = $stmt->fetchColumn();

/* Catégories */
$stmt = $pdo->query("SELECT COUNT(*) FROM categorie");
$totalCategories = $stmt->fetchColumn();

/* Clients */
$stmt = $pdo->query("SELECT COUNT(*) FROM client");
$totalClients = $stmt->fetchColumn();

/* Commandes */
$stmt = $pdo->query("SELECT COUNT(*) FROM commande");
$totalOrders = $stmt->fetchColumn();

/* Chiffre d'affaires */
$stmt = $pdo->query("
    SELECT COALESCE(SUM(total),0)
    FROM commande
    WHERE statuscmd != 'Annulée'
");
$totalRevenue = $stmt->fetchColumn();

/* Commandes par mois – Chart */
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

/* Commandes par statut */
$stmt = $pdo->query("
    SELECT statuscmd, COUNT(*) AS nb
    FROM commande
    GROUP BY statuscmd
");
$ordersByStatus = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

/* Panier moyen */
$avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Statistiques | Sabaya Luxury Admin</title>
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
            <li class="nav-item">
                <a href="../contact/list.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span>Messages</span>
                </a>
            </li>
            <li class="nav-item active">
                <a href="index.php" aria-current="page">
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
            <h1>Statistiques</h1>
            <p class="header-subtitle">Analyse des performances de la boutique Sabaya Luxury.</p>
        </div>
        <div class="header-user">
            <span class="user-greeting">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="../../auth/profile.php" class="user-avatar" aria-label="Mon profil">
                <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
            </a>
        </div>
    </header>

    <!-- ── Main Content ────────────────────────── -->
    <main class="admin-content">

        <!-- ══ KPI Section ═════════════════════════ -->
        <section class="stats-kpi-grid" aria-label="Indicateurs clés de performance">

            <article class="kpi-card" tabindex="0">
                <div class="kpi-icon kpi-icon--products">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                </div>
                <div class="kpi-body">
                    <h2 class="kpi-label">Produits</h2>
                    <p class="kpi-value"><span class="counter" data-count="<?= (int)$totalProducts ?>" aria-label="<?= (int)$totalProducts ?> produits">0</span></p>
                </div>
                <span class="kpi-tag"><?= htmlspecialchars($totalCategories) ?> catégories</span>
            </article>

            <article class="kpi-card" tabindex="0">
                <div class="kpi-icon kpi-icon--categories">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                </div>
                <div class="kpi-body">
                    <h2 class="kpi-label">Catégories</h2>
                    <p class="kpi-value"><span class="counter" data-count="<?= (int)$totalCategories ?>" aria-label="<?= (int)$totalCategories ?> catégories">0</span></p>
                </div>
                <span class="kpi-tag">Organisation</span>
            </article>

            <article class="kpi-card" tabindex="0">
                <div class="kpi-icon kpi-icon--clients">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div class="kpi-body">
                    <h2 class="kpi-label">Clients</h2>
                    <p class="kpi-value"><span class="counter" data-count="<?= (int)$totalClients ?>" aria-label="<?= (int)$totalClients ?> clients">0</span></p>
                </div>
                <span class="kpi-tag">Base clients</span>
            </article>

            <article class="kpi-card" tabindex="0">
                <div class="kpi-icon kpi-icon--orders">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div class="kpi-body">
                    <h2 class="kpi-label">Commandes</h2>
                    <p class="kpi-value"><span class="counter" data-count="<?= (int)$totalOrders ?>" aria-label="<?= (int)$totalOrders ?> commandes">0</span></p>
                </div>
                <span class="kpi-tag">Total traitées</span>
            </article>

            <article class="kpi-card kpi-card--revenue" tabindex="0">
                <div class="kpi-icon kpi-icon--revenue">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                </div>
                <div class="kpi-body">
                    <h2 class="kpi-label">Chiffre d'affaires</h2>
                    <p class="kpi-value">
                        <span class="counter"
                              data-count="<?= number_format($totalRevenue, 2, '.', '') ?>"
                              data-decimals="2"
                              data-separator=" "
                              data-decimal-sep=","
                              data-suffix=" DH"
                              aria-label="<?= number_format($totalRevenue, 2, ',', ' ') ?> DH">0 DH</span>
                    </p>
                </div>
                <span class="kpi-tag">Panier moyen : <?= number_format($avgOrderValue, 0, ',', ' ') ?> DH</span>
            </article>

        </section>

        <!-- ══ Analytics Chart Section ═════════════ -->
        <section class="analytics-section" aria-label="Analytique des commandes">
            <header class="section-header">
                <h2>Évolution des Commandes & Revenus</h2>
            </header>
            <div class="chart-container">
                <canvas id="statsChart" aria-label="Graphique d'évolution des commandes et revenus mensuels" role="img"></canvas>
            </div>
        </section>

        <!-- ══ Business Insights Section ═══════════ -->
        <section class="insights-grid" aria-label="Analyse métier">

            <!-- Catalogue Produits -->
            <article class="insight-card" tabindex="0">
                <header class="insight-card-header">
                    <div class="insight-icon insight-icon--catalog">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    </div>
                    <h3>Catalogue Produits</h3>
                </header>
                <div class="insight-body">
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Total produits</span>
                        <span class="insight-stat-value"><span class="counter" data-count="<?= (int)$totalProducts ?>">0</span></span>
                    </div>
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Catégories actives</span>
                        <span class="insight-stat-value"><span class="counter" data-count="<?= (int)$totalCategories ?>">0</span></span>
                    </div>
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Moyenne / catégorie</span>
                        <span class="insight-stat-value"><?= $totalCategories > 0 ? round($totalProducts / $totalCategories, 1) : '0' ?></span>
                    </div>
                </div>
            </article>

            <!-- Activité Commandes -->
            <article class="insight-card" tabindex="0">
                <header class="insight-card-header">
                    <div class="insight-icon insight-icon--orders">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <h3>Activité Commandes</h3>
                </header>
                <div class="insight-body">
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Total commandes</span>
                        <span class="insight-stat-value"><span class="counter" data-count="<?= (int)$totalOrders ?>">0</span></span>
                    </div>
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Panier moyen</span>
                        <span class="insight-stat-value"><?= number_format($avgOrderValue, 0, ',', ' ') ?> DH</span>
                    </div>
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">En cours</span>
                        <span class="insight-stat-value"><?= htmlspecialchars($ordersByStatus['En_cours'] ?? 0) ?></span>
                    </div>
                </div>
            </article>

            <!-- Croissance Clients -->
            <article class="insight-card" tabindex="0">
                <header class="insight-card-header">
                    <div class="insight-icon insight-icon--growth">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    </div>
                    <h3>Croissance Clients</h3>
                </header>
                <div class="insight-body">
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Total inscrits</span>
                        <span class="insight-stat-value"><span class="counter" data-count="<?= (int)$totalClients ?>">0</span></span>
                    </div>
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Commandes / client</span>
                        <span class="insight-stat-value"><?= $totalClients > 0 ? round($totalOrders / $totalClients, 1) : '0' ?></span>
                    </div>
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Dépense / client</span>
                        <span class="insight-stat-value"><?= $totalClients > 0 ? number_format($totalRevenue / $totalClients, 0, ',', ' ') : '0' ?> DH</span>
                    </div>
                </div>
            </article>

            <!-- Performance Boutique -->
            <article class="insight-card" tabindex="0">
                <header class="insight-card-header">
                    <div class="insight-icon insight-icon--perf">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    </div>
                    <h3>Performance Boutique</h3>
                </header>
                <div class="insight-body">
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Chiffre d'affaires</span>
                        <span class="insight-stat-value"><?= number_format($totalRevenue, 0, ',', ' ') ?> DH</span>
                    </div>
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Livrées</span>
                        <span class="insight-stat-value insight-stat-value--success"><?= htmlspecialchars($ordersByStatus['Livrée'] ?? 0) ?></span>
                    </div>
                    <div class="insight-stat-row">
                        <span class="insight-stat-label">Annulées</span>
                        <span class="insight-stat-value insight-stat-value--danger"><?= htmlspecialchars($ordersByStatus['Annulée'] ?? 0) ?></span>
                    </div>
                </div>
            </article>

        </section>

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

    /* ── Statistics Chart ────────────────────── */
    const ctx = document.getElementById('statsChart');
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
                        borderWidth: 2.5,
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
                        borderWidth: 2.5,
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
<script src="../../assets/js/counter.js"></script>

</body>

</html>