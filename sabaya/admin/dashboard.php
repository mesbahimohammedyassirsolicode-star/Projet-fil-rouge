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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Dashboard Admin | Sabaya Luxury</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <header>
        <nav aria-label="Navigation administration">
            <ul>
                <li><a href="dashboard.php">Tableau de bord</a></li>
                <li><a href="categories/list.php">Gestion des catégories</a></li>
                <li><a href="products/list.php">Gestion des produits</a></li>
                <li><a href="orders/list.php">Gestion des commandes</a></li>
                <li><a href="users/list.php">Gestion des utilisateurs</a></li>
                <li><a href="statistics/index.php">Statistiques</a></li>
                <li><a href="contact/list.php">Gestion des Messages</a></li>
                <li><a href="/auth/profile.php">Profil</a></li>
                <li><a href="/auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h1>Dashboard Admin</h1>
            <p>Bienvenue <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        </section>
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

<section>

    <h2>Dernières Commandes</h2>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Date</th>
                <th>Total</th>
                <th>Statut</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($recentOrders as $order): ?>

            <tr>

                <td><?= htmlspecialchars($order['id_commande']) ?></td>

                <td>
                    <?= htmlspecialchars($order['nom']) ?>
                    <?= htmlspecialchars($order['prenom']) ?>
                </td>

                <td><?= htmlspecialchars($order['datecmd']) ?></td>

                <td><?= htmlspecialchars($order['total']) ?> DH</td>

                <td><?= htmlspecialchars($order['statuscmd']) ?></td>

            </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

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

<section>

    <h2>Top Produits Vendus</h2>

    <table>

        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité Vendue</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($bestProducts as $product): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($product['nom']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($product['total_vendu']) ?>
                </td>

            </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</section>

    </main>
    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>

