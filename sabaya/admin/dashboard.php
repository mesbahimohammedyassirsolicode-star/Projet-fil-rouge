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
    <header>
        <nav>
            <ul>
                <li><a href="categories/list.php">Gestion des catégories</a></li>
                <li><a href="products/list.php">Gestion des produits</a></li>
                <li><a href="orders/list.php">Gestion des commandes</a></li>
                <li><a href="/auth/profile.php">Profil</a></li>
                <li><a href="/auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Dashboard Admin</h1>
            <p>Bienvenue <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>

