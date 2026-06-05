<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: /index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Dashboard Admin</h1>

<p>Bienvenue <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>

<!-- links -->
<a href="/auth/logout.php">Logout</a>
<a href="/auth/profile.php">Profile</a>
<a href="categories/list.php">
    Gestion des catégories
</a>
<a href="products/list.php">
    Gestion des produits
</a>
<a href="orders/list.php">
    Gestion des commandes
</a>
</body>
</html>

