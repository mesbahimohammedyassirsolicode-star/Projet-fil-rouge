<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Category.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../auth/login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

$db = new Database();

$pdo = $db->getConnection();

$categoryModel = new Category($pdo);

$categories = $categoryModel->getAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Gestion des Catégories | Sabaya Luxury Admin</title>
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
            <h1>Gestion des catégories</h1>

            <a href="add.php">Ajouter une catégorie</a>

            <br><br>

            <table>
                <caption class="sr-only">Liste de toutes les catégories de produits</caption>
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
                                <td><?= htmlspecialchars($categorie['nom']) ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $categorie['id_categorie'] ?>">Modifier</a>
                                    |
                                    <a href="delete.php?id=<?= $categorie['id_categorie'] ?>" onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Aucune catégorie trouvée</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <br>
            <a href="../dashboard.php">Retour au dashboard</a>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>