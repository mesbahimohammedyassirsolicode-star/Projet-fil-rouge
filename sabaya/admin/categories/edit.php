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
    <title>Modifier Catégorie</title>
</head>
<body>

<h1>Modifier Catégorie</h1>

<?php foreach ($errors as $error): ?>
    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endforeach; ?>

<form method="POST">

    <label>Nom de la catégorie</label>
    <br>

    <input
        type="text"
        name="nom"
        value="<?= htmlspecialchars($categorie['nom']) ?>"
    >

    <br><br>

    <button type="submit">
        Modifier
    </button>

</form>

<br>

<a href="list.php">Retour à la liste</a>

</body>
</html>