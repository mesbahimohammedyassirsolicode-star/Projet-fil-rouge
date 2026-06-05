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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $status = trim($_POST['status']);

    $orderModel->updateStatus(
        $id_commande,
        $status
    );

    header('Location: list.php');
    exit();
}

?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le statut</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="../categories/list.php">Gestion des catégories</a></li>
                <li><a href="../products/list.php">Gestion des produits</a></li>
                <li><a href="list.php">Gestion des commandes</a></li>
                <li><a href="../dashboard.php">Tableau de bord</a></li>
                <li><a href="../../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Modifier le statut de la commande</h1>

            <form method="POST">
                <fieldset>
                    <legend>Nouveau statut de la commande</legend>
                    <p>
                        <label for="status">Statut de la commande :</label><br>
                        <select name="status" id="status">
                            <option value="En attente">En attente</option>
                            <option value="Confirmée">Confirmée</option>
                            <option value="Expédiée">Expédiée</option>
                            <option value="Livrée">Livrée</option>
                            <option value="Annulée">Annulée</option>
                        </select>
                    </p>
                    <button type="submit">Enregistrer</button>
                </fieldset>
            </form>
            <br>
            <a href="list.php">Retour à la liste des commandes</a>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>
