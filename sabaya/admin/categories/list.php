<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Category.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$categoryModel = new Category($pdo);

// Handle Search logic
$searchKeyword = '';
if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $searchKeyword = trim($_GET['search']);
    // Search inline using PDO prepared statement (same style as product search)
    $stmtSearch = $pdo->prepare("SELECT * FROM categorie WHERE nom LIKE :keyword ORDER BY nom ASC");
    $stmtSearch->execute([':keyword' => '%' . $searchKeyword . '%']);
    $categories = $stmtSearch->fetchAll();
} else {
    $categories = $categoryModel->getAll();
}

// Flash message handling
// Flash message success/failure
$flashSuccess = '';
$flashError   = '';
if (isset($_SESSION['flash_success'])) {
    $flashSuccess = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}
if (isset($_SESSION['flash_error'])) {
    $flashError = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
}

// Fetch database stats for cards
$stmtTotal = $pdo->query("SELECT COUNT(*) FROM categorie");
$totalCategories = $stmtTotal->fetchColumn();

$stmtWithImage = $pdo->query("SELECT COUNT(*) FROM categorie WHERE image IS NOT NULL AND image != ''");
$categoriesWithImage = $stmtWithImage->fetchColumn();

$stmtProducts = $pdo->query("SELECT COUNT(*) FROM produits");
$totalProducts = $stmtProducts->fetchColumn();

$stmtOrders = $pdo->query("SELECT COUNT(*) FROM commande");
$totalOrders = $stmtOrders->fetchColumn();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Gestion des Catégories | Sabaya Luxury Admin</title>
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
                <li class="nav-item active">
                    <a href="list.php" aria-current="page">
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
                <h1>Category Management</h1>
                <p class="header-subtitle">View, edit, and manage your product categories.</p>
            </div>
            <div class="header-search">
                <form method="GET" action="" role="search" class="search-form">
                    <label for="adminSearch" class="sr-only">Rechercher une catégorie</label>
                    <input type="search" id="adminSearch" name="search" placeholder="Rechercher une catégorie..." value="<?= htmlspecialchars($searchKeyword) ?>" aria-label="Rechercher une catégorie">
                </form>
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

            <!-- Flash message success/failure -->
            <?php if ($flashSuccess !== ''): ?>
                <div class="error-notification-card" role="status" style="background: var(--color-success, #16a34a20); border-color: var(--color-success, #16a34a);">
                    <p><?= htmlspecialchars($flashSuccess) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($flashError !== ''): ?>
                <div class="error-notification-card" role="alert">
                    <p><?= htmlspecialchars($flashError) ?></p>
                </div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <section class="stats-cards" aria-label="Statistiques catégories">
                <article class="stat-card">
                    <div class="stat-icon stat-icon--products">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div class="stat-info">
                        <h2>Total Catégories</h2>
                        <p class="stat-value"><?= htmlspecialchars($totalCategories) ?></p>
                    </div>
                </article>
                <article class="stat-card">
                    <div class="stat-icon stat-icon--clients">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                    </div>
                    <div class="stat-info">
                        <h2>Avec Image</h2>
                        <p class="stat-value"><?= htmlspecialchars($categoriesWithImage) ?></p>
                    </div>
                </article>
                <article class="stat-card">
                    <div class="stat-icon stat-icon--orders">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    </div>
                    <div class="stat-info">
                        <h2>Total Produits</h2>
                        <p class="stat-value"><?= htmlspecialchars($totalProducts) ?></p>
                    </div>
                </article>
                <article class="stat-card">
                    <div class="stat-icon stat-icon--messages">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <div class="stat-info">
                        <h2>Commandes</h2>
                        <p class="stat-value"><?= htmlspecialchars($totalOrders) ?></p>
                    </div>
                </article>
            </section>

            <!-- Categories Table Area -->
            <section class="products-table-wrapper" aria-label="Liste des catégories">
                <div class="content-header-bar">
                    <div>
                        <h2>Liste des Catégories</h2>
                        <?php if ($searchKeyword !== ''): ?>
                            <p class="section-subtitle">Résultats de recherche pour "<strong><?= htmlspecialchars($searchKeyword) ?></strong>" (<?= count($categories) ?> catégorie(s) trouvée(s))</p>
                        <?php else: ?>
                            <p class="section-subtitle">Gérez les catégories de votre catalogue Sabaya Luxury.</p>
                        <?php endif; ?>
                    </div>
                    <a href="add.php" class="btn-add-product">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        <span>New Category</span>
                    </a>
                </div>

                <table class="products-table">
                    <caption class="sr-only">Liste de toutes les catégories de produits</caption>
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">ID</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="4" class="empty-state">Aucune catégorie trouvée</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $categorie): ?>
                                <tr>
                                    <td data-label="Image">
                                        <div class="product-img-wrapper">
                                            <?php if (!empty($categorie['image'])): ?>
                                                <img src="../../assets/images/categories/<?= htmlspecialchars($categorie['image']) ?>" alt="Image de <?= htmlspecialchars($categorie['nom']) ?>" width="60" height="60" loading="lazy">
                                            <?php else: ?>
                                                <div style="width:60px;height:60px;background:var(--color-surface,#1e1e1e);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td data-label="Category Name">
                                        <div class="product-info-cell">
                                            <span class="product-name-text"><?= htmlspecialchars($categorie['nom']) ?></span>
                                        </div>
                                    </td>
                                    <td data-label="ID">
                                        <div class="product-info-cell">
                                            <span class="product-ref-text">ID: #<?= htmlspecialchars($categorie['id_categorie']) ?></span>
                                        </div>
                                    </td>
                                    <td data-label="Actions">
                                        <div class="product-actions-cell">
                                            <a href="edit.php?id=<?= $categorie['id_categorie'] ?>" class="action-btn-circle btn-edit" title="Edit category">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                <span class="sr-only">Edit</span>
                                            </a>
                                            <a href="delete.php?id=<?= $categorie['id_categorie'] ?>" onclick="return confirm('Supprimer cette catégorie ?')" class="action-btn-circle btn-delete" title="Delete category">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                <span class="sr-only">Delete</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination design -->
                <div class="pagination-wrapper">
                    <span class="pagination-info">Affichage de <?= count($categories) ?> sur <?= $totalCategories ?> catégories</span>
                    <nav aria-label="Pagination des catégories">
                        <ul class="pagination-list">
                            <li class="pagination-item"><span aria-hidden="true">&laquo;</span></li>
                            <li class="pagination-item active"><span>1</span></li>
                            <li class="pagination-item"><span aria-hidden="true">&raquo;</span></li>
                        </ul>
                    </nav>
                </div>
            </section>
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