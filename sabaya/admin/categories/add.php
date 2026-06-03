<?php

session_start();
require_once '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);

    if (empty($nom)) {
        $errors[] = "Le nom de la catégorie est obligatoire";
    }

    if (empty($errors)) {

        $sql = "INSERT INTO categorie (nom)
                VALUES (:nom)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nom' => $nom
        ]);

        header('Location: list.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une catégorie</title>
</head>
<body>

<h1>Ajouter une catégorie</h1>

<?php foreach($errors as $error): ?>
    <p style="color:red;">
        <?= $error ?>
    </p>
<?php endforeach; ?>

<form method="POST">

    <label>Nom de la catégorie</label>
    <br>

    <input
        type="text"
        name="nom"
        placeholder="Ex : Abayas Casual"
    >

    <br><br>

    <button type="submit">
        Ajouter
    </button>

</form>

<br>

<a href="list.php">Retour à la liste</a>

</body>
</html>