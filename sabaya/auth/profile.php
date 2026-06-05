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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gérez votre profil Sabaya Luxury.">
    <meta name="robots" content="noindex, nofollow">
    <title>Mon Profil | Sabaya Luxury</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="Mon Profil | Sabaya Luxury">
    <meta property="og:locale" content="fr_MA">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../products/products.php">Boutique</a></li>
                <li><a href="../products/cart.php">Mon Panier</a></li>
                <li><a href="../wishlist/wishlist.php">Ma Liste de souhaits</a></li>
                <li><a href="../products/my-orders.php">Mes Commandes</a></li>
                <li><a href="profile.php">Mon Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Mon Profil</h1>
            <p>Bienvenue <?= htmlspecialchars($_SESSION['user_name']); ?></p>
            <p>Rôle : <?= htmlspecialchars($_SESSION['role']); ?></p>
            <a href="logout.php">Déconnexion</a>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>