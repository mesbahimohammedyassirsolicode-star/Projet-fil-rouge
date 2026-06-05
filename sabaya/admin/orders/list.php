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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des commandes</title>
</head>
<body>

    <header>
        <nav>
            <ul>
                <li><a href="list.php">Commandes</a></li>
                <li><a href="../dashboard.php">Tableau de bord</a></li>
                <li><a href="../../auth/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
<main class="container">
<h1>Gestion des commandes</h1>

<?php if (empty($orders)): ?>

<p>Aucune commande pour le moment.</p>

<a href="../dashboard.php">
    Retour Dashboard
</a>

<?php else: ?>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID commande</th>
            <th>Client</th>
            <th>Date</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= htmlspecialchars($order['id_commande']) ?></td>
            <td><?= htmlspecialchars($order['nom']) ?> <?= htmlspecialchars($order['prenom']) ?></td>
            <td><?= htmlspecialchars($order['datecmd']) ?></td>
            <td><?= htmlspecialchars($order['total']) ?> DH</td>
            <td><?= htmlspecialchars($order['statuscmd']) ?></td>
            <td>
<a href="update-status.php?id=<?= htmlspecialchars($order['id_commande']) ?>">
    Modifier
</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php endif; ?>
</main>
<footer>
    <p>Copyright &copy; 2026 Sabaya Luxury</p>
</footer>
</body>
</html>