<?php

session_start();

require_once '../config/Database.php';

$error = [];

$db = new Database();
$pdo = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {

        $error[] = "Tous les champs sont obligatoires";

    } else {

        $sql = "SELECT * FROM client WHERE email = :email";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id_client'];
            $_SESSION['user_name'] = $user['nom'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {

                header('Location: ../admin/dashboard.php');
                exit();

            } else {

                header('Location: ../index.php');
                exit();
            }

        } else {

            $error[] = "Email ou mot de passe incorrect";
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../products/products.php">Boutique</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Connexion</h1>

            <?php if (!empty($error)): ?>
                <div style="color: red; margin-bottom: 15px;" role="alert">
                    <?php foreach ($error as $err): ?>
                        <p><?php echo htmlspecialchars($err); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="post">
                <fieldset>
                    <legend>Identifiants de connexion</legend>
                    <p>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                    </p>
                    <p>
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password">
                    </p>
                    <button type="submit" id="submit" name="submit">Se connecter</button>
                </fieldset>
            </form>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>