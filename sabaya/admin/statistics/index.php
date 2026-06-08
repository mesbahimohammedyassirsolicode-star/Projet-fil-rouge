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

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Statistiques | Sabaya Luxury Admin</title>
    <link rel="stylesheet" href="../../../assets/css/admin.css">
</head>

<body>

<header>
    <nav aria-label="Navigation administration">
        <ul>
            <li><a href="../dashboard.php">Tableau de bord</a></li>
            <li><a href="../categories/list.php">Gestion des catégories</a></li>
            <li><a href="../products/list.php">Gestion des produits</a></li>
            <li><a href="../orders/list.php">Gestion des commandes</a></li>
            <li><a href="../users/list.php">Gestion des utilisateurs</a></li>
            <li><a href="../../auth/logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<main>

    <h1>Dashboard Statistiques</h1>

    <section>

        <article>
            <h2>Produits</h2>
            <p><?= htmlspecialchars($totalProducts) ?></p>
        </article>

        <article>
            <h2>Catégories</h2>
            <p><?= htmlspecialchars($totalCategories) ?></p>
        </article>

        <article>
            <h2>Clients</h2>
            <p><?= htmlspecialchars($totalClients) ?></p>
        </article>

        <article>
            <h2>Commandes</h2>
            <p><?= htmlspecialchars($totalOrders) ?></p>
        </article>

        <article>
            <h2>Chiffre d'affaires</h2>
            <p><?= htmlspecialchars($totalRevenue) ?> DH</p>
        </article>

    </section>

</main>

<footer>

    <a href="../dashboard.php">
        Retour Dashboard
    </a>

</footer>

</body>

</html>