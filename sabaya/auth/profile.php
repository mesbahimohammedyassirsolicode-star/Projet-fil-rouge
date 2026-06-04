<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>

<h1>Mon Profil</h1>

<p>Bienvenue <?= htmlspecialchars($_SESSION['user_name']); ?></p>

<p>Role : <?= htmlspecialchars($_SESSION['role']); ?></p>

<a href="logout.php">Déconnexion</a>

</body>
</html>