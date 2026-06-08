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

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit();
}

$id = (int) $_GET['id'];

$categorie = $categoryModel->find($id);

if (!$categorie) {
    header('Location: list.php');
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);

    if (empty($nom)) {

        $errors[] = "Le nom de la catégorie est obligatoire";

    } else {

        $categoryModel->update($id, $nom);

        header('Location: list.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Modifier Catégorie | Sabaya Luxury Admin</title>
    <link rel="stylesheet" href="../../../assets/css/admin.css">
</head>
<body>
    <header>
        <nav aria-label="Navigation administration">
            <ul>
                <li><a href="list.php">Gestion des catégories</a></li>
                <li><a href="../products/list.php">Gestion des produits</a></li>
                <li><a href="../orders/list.php">Gestion des commandes</a></li>
                <li><a href="../users/list.php">Gestion des utilisateurs</a></li>
                <li><a href="../dashboard.php">Tableau de bord</a></li>
                <li><a href="../../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Modifier la catégorie</h1>

            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <p style="color:red;" role="alert">
                        <?= htmlspecialchars($error) ?>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>

            <form method="POST">
                <fieldset>
                    <legend>Détails de la catégorie</legend>
                    <p>
                        <label for="nom">Nom de la catégorie :</label><br>
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($categorie['nom']) ?>">
                    </p>
                    <button type="submit">Modifier</button>
                </fieldset>
            </form>
            <br>
            <a href="list.php">Retour à la liste</a>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>