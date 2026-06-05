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
    <h1>Modifier le statut de la commande</h1>
</header>

<main>


<section>

    <form method="POST">

        <div>

            <label for="status">
                Statut de la commande
            </label>

            <br><br>

            <select
                name="status"
                id="status"
            >

                <option value="En attente">
                    En attente
                </option>

                <option value="Confirmée">
                    Confirmée
                </option>

                <option value="Expédiée">
                    Expédiée
                </option>

                <option value="Livrée">
                    Livrée
                </option>

                <option value="Annulée">
                    Annulée
                </option>

            </select>

        </div>

        <br><br>

        <button type="submit">
            Enregistrer
        </button>

    </form>

</section>

</main>

<footer>


<a href="list.php">
    Retour à la liste des commandes
</a>


</footer>

</body>

</html>
