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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails utilisateur</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../categories/list.php">Gestion des catégories</a></li>
                <li><a href="../products/list.php">Gestion des produits</a></li>
                <li><a href="../orders/list.php">Gestion des commandes</a></li>
                <li><a href="list.php">Gestion des utilisateurs</a></li>
                <li><a href="../dashboard.php">Tableau de bord</a></li>
                <li><a href="../../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Détails de l'utilisateur</h1>

            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Champ</th>
                        <th>Valeur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td><?= htmlspecialchars($user['id_client']) ?></td>
                    </tr>
                    <tr>
                        <td>Nom</td>
                        <td><?= htmlspecialchars($user['nom']) ?></td>
                    </tr>
                    <tr>
                        <td>Prénom</td>
                        <td><?= htmlspecialchars($user['prenom']) ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                    </tr>
                    <tr>
                        <td>Téléphone</td>
                        <td><?= htmlspecialchars($user['telephone']) ?></td>
                    </tr>
                    <tr>
                        <td>Rôle</td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                    </tr>
                    <tr>
                        <td>Nombre de commandes</td>
                        <td><?= htmlspecialchars($orderCount) ?></td>
                    </tr>
                </tbody>
            </table>

            <br>

            <?php if ($orderCount > 0): ?>
                <h2>Commandes de l'utilisateur</h2>

                <table border="1" cellpadding="10">
                    <caption>Liste des commandes passées par cet utilisateur</caption>
                    <thead>
                        <tr>
                            <th>ID commande</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id_commande']) ?></td>
                                <td><?= htmlspecialchars($order['datecmd']) ?></td>
                                <td><?= htmlspecialchars($order['total']) ?> DH</td>
                                <td><?= htmlspecialchars($order['statuscmd']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Cet utilisateur n'a pas encore passé de commande.</p>
            <?php endif; ?>

            <br>
            <a href="list.php">Retour à la liste des utilisateurs</a>
            |
            <a href="delete.php?id=<?= $user['id_client'] ?>" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer cet utilisateur</a>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>