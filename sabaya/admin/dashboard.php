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

<h1>Dashboard Admin</h1>

<p>Bienvenue <?php echo $_SESSION['user_name']; ?></p>

<!-- links -->
<a href="/auth/logout.php">Logout</a>
<a href="/auth/profile.php">Profile</a>
<a href="categories/list.php">
    Gestion des catégories
</a>