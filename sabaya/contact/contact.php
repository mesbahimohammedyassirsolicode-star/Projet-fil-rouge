<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Contact.php';

$db = new Database();
$pdo = $db->getConnection();

$contactModel = new Contact($pdo);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $sujet = trim($_POST['sujet']);
    $message = trim($_POST['message']);

    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire";
    }

    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $nom)) {
        $errors[] = "Le nom doit contenir uniquement des lettres";
    }

    if (empty($email)) {
        $errors[] = "L'email est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide";
    }

    if (empty($sujet)) {
        $errors[] = "Le sujet est obligatoire";
    }

    if (empty($message)) {
        $errors[] = "Le message est obligatoire";
    }

    if (empty($errors)) {

        $id_client = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        $contactModel->create($nom, $email, $sujet, $message, $id_client);

        header('Location: contact.php?success=1');
        exit();
    }
}

?>
<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$canonicalUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pageDescription = 'Contactez Sabaya Luxury — boutique d\'abayas modernes au Maroc. Envoyez-nous un message pour toute question sur nos collections.';
$pageImage = $baseUrl . '/assets/images/logo/sabaya-logo.jpg';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="contact Sabaya, service client, abaya Maroc, boutique en ligne, Casablanca">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <title>Contactez-nous | Sabaya Luxury — Boutique Abayas Maroc</title>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sabaya Luxury">
    <meta property="og:title" content="Contactez-nous | Sabaya Luxury">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:locale" content="fr_MA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Contactez-nous | Sabaya Luxury">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">

    <!-- JSON-LD Structured Data: ContactPage -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ContactPage",
        "name": "Contact Sabaya Luxury",
        "description": "<?= htmlspecialchars($pageDescription) ?>",
        "url": "<?= htmlspecialchars($canonicalUrl) ?>",
        "mainEntity": {
            "@type": "Organization",
            "name": "Sabaya Luxury",
            "telephone": "+212-6XX-XXX-XXX",
            "email": "contact@sabaya.ma",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Casablanca",
                "addressCountry": "MA"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+212-6XX-XXX-XXX",
                "contactType": "customer service",
                "availableLanguage": ["French", "Arabic"]
            }
        }
    }
    </script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../products/products.php">Boutique</a></li>
                <li><a href="../wishlist/wishlist.php">Ma Liste de souhaits</a></li>
                <li><a href="../auth/profile.php">Mon Profil</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section aria-label="Formulaire de contact">
            <h1>Contactez Sabaya Luxury</h1>
            <p>Une question sur nos abayas ? Besoin d\'conseil sur une collection ? N\'hésitez pas à nous écrire. Notre équipe vous répondra dans les plus brefs délais.</p>

            <?php if (isset($_GET['success'])): ?>
                <p style="color:green;" role="alert">
                    Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.
                </p>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <p style="color:red;" role="alert">
                        <?= htmlspecialchars($error) ?>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>

            <form action="contact.php" method="POST">
                <fieldset>
                    <legend>Envoyez-nous un message</legend>
                    <p>
                        <label for="nom">Nom :</label><br>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
                    </p>
                    <p>
                        <label for="email">Email :</label><br>
                        <input type="email" id="email" name="email" placeholder="Votre email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </p>
                    <p>
                        <label for="sujet">Sujet :</label><br>
                        <input type="text" id="sujet" name="sujet" placeholder="Sujet de votre message" value="<?= isset($_POST['sujet']) ? htmlspecialchars($_POST['sujet']) : '' ?>">
                    </p>
                    <p>
                        <label for="message">Message :</label><br>
                        <textarea id="message" name="message" rows="6" placeholder="Votre message"><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
                    </p>
                    <button type="submit">Envoyer</button>
                </fieldset>
            </form>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>