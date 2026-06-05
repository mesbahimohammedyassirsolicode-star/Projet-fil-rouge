<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Order.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$orderModel = new Order($pdo);

$orders = $orderModel->getUserOrders(
    $_SESSION['user_id']
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes commandes</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="products.php">Boutique</a></li>
                <li><a href="cart.php">Mon Panier</a></li>
                <li><a href="../wishlist/wishlist.php">Ma Liste de souhaits</a></li>
                <li><a href="my-orders.php">Mes Commandes</a></li>
                <li><a href="../auth/profile.php">Mon Profil</a></li>
                <li><a href="../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h1>Mes commandes</h1>
            <table>
                <caption>Historique de vos commandes passées sur Sabaya Luxury</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['id_commande']) ?></td>
                            <td><?= htmlspecialchars($order['datecmd']) ?></td>
                            <td><?= htmlspecialchars($order['statuscmd']) ?></td>
                            <td><?= htmlspecialchars($order['total']) ?> DH</td>
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