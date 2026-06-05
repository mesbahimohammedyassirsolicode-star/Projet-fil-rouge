<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/User.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$userModel = new User($pdo);

$users = $userModel->getAll();

?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
</head>

<body>

<header>
    <h1>Gestion des utilisateurs</h1>
</header>

<main>


<?php if (empty($users)): ?>

    <p>Aucun utilisateur trouvé.</p>

<?php else: ?>

    <table border="1" cellpadding="10">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($users as $user): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($user['id_client']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($user['nom']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($user['prenom']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($user['email']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($user['role']) ?>
                    </td>

                    <td>

                        <a href="details.php?id=<?= $user['id_client'] ?>">
                            Voir
                        </a>

                        <?php if ($user['role'] !== 'admin'): ?>

                            |

                            <a
                                href="delete.php?id=<?= $user['id_client'] ?>"
                                onclick="return confirm('Supprimer cet utilisateur ?')"
                            >
                                Supprimer
                            </a>

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

<?php endif; ?>


</main>

<footer>

<br>

<a href="../dashboard.php">
    Retour Dashboard
</a>


</footer>

</body>

</html>
