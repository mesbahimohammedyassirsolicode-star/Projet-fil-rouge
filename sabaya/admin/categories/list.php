<?php
session_start();
require_once '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

$sql = "SELECT * FROM categorie ORDER BY id_categorie ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catégories</title>
</head>
<body>

<h1>Gestion des catégories</h1>

<a href="add.php">+ Ajouter une catégorie</a>

<br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

    <?php if(count($categories) > 0): ?>

        <?php foreach($categories as $categorie): ?>

        <tr>

            <td><?= htmlspecialchars($categorie['nom']); ?></td>

            <td>
                <a href="edit.php?id=<?= $categorie['id_categorie']; ?>">
                    Modifier
                </a>

                |

                <a href="delete.php?id=<?= $categorie['id_categorie']; ?>"
                   onclick="return confirm('Supprimer cette catégorie ?')">
                    Supprimer
                </a>
            </td>
        </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>
            <td colspan="3">
                Aucune catégorie trouvée
            </td>
        </tr>

    <?php endif; ?>

    </tbody>
</table>

</body>
</html>