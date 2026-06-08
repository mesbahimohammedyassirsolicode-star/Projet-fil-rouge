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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Commande #<?= htmlspecialchars($order['id_commande']) ?> | Sabaya Luxury Admin</title>
    <link rel="stylesheet" href="../../../assets/css/admin.css">
</head>
<body>
    <header>
        <nav aria-label="Navigation administration">
            <ul>
                <li><a href="../categories/list.php">Gestion des catégories</a></li>
                <li><a href="../products/list.php">Gestion des produits</a></li>
                <li><a href="list.php">Gestion des commandes</a></li>
                <li><a href="../users/list.php">Gestion des utilisateurs</a></li>
                <li><a href="../dashboard.php">Tableau de bord</a></li>
                <li><a href="../../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Détails de la commande #<?= htmlspecialchars($order['id_commande']) ?></h1>

            <h2>Informations de la commande</h2>

            <table>
                <thead>
                    <tr>
                        <th>Champ</th>
                        <th>Valeur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID Commande</td>
                        <td><?= htmlspecialchars($order['id_commande']) ?></td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td><?= htmlspecialchars($order['datecmd']) ?></td>
                    </tr>
                    <tr>
                        <td>Statut</td>
                        <td><?= htmlspecialchars($order['statuscmd']) ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?= htmlspecialchars($order['total']) ?> DH</td>
                    </tr>
                </tbody>
            </table>

            <br>

            <h2>Informations du client</h2>

            <table>
                <thead>
                    <tr>
                        <th>Champ</th>
                        <th>Valeur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID Client</td>
                        <td><?= htmlspecialchars($order['id_client']) ?></td>
                    </tr>
                    <tr>
                        <td>Nom</td>
                        <td><?= htmlspecialchars($order['nom']) ?></td>
                    </tr>
                    <tr>
                        <td>Prénom</td>
                        <td><?= htmlspecialchars($order['prenom']) ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?= htmlspecialchars($order['email']) ?></td>
                    </tr>
                    <tr>
                        <td>Téléphone</td>
                        <td><?= htmlspecialchars($order['telephone']) ?></td>
                    </tr>
                </tbody>
            </table>

            <br>

            <?php if (!empty($items)): ?>
                <h2>Produits commandés</h2>

                <table>
                    <caption class="sr-only">Liste des produits de cette commande</caption>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['produit_nom']) ?></td>
                                <td><?= htmlspecialchars($item['qte']) ?></td>
                                <td><?= htmlspecialchars($item['prix']) ?> DH</td>
                                <td><?= htmlspecialchars($item['qte'] * $item['prix']) ?> DH</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun produit trouvé pour cette commande.</p>
            <?php endif; ?>

            <br>
            <a href="update-status.php?id=<?= htmlspecialchars($order['id_commande']) ?>">Modifier le statut</a>
            |
            <a href="list.php">Retour à la liste des commandes</a>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>
