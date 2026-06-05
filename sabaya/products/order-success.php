<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande Confirmée</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="products.php">Boutique</a></li>
                <li><a href="cart.php">Mon Panier</a></li>
                <li><a href="../wishlist/wishlist.php">Ma Liste de souhaits</a></li>
                <li><a href="my-orders.php">Mes Commandes</a></li>
                <li><a href="../auth/profile.php">Mon Profil</a></li>
                <li><a href="../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Commande enregistrée avec succès ✅</h1>
            <p>Merci pour votre commande.</p>
            <a href="products.php">Continuer mes achats</a>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>