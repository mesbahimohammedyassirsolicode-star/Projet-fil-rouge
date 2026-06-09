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
 session_regenerate_id(true);
            $_SESSION['user_id']    = $user['id_client'];
            $_SESSION['user_name']  = $user['nom'] . ' ' . $user['prenom'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_phone'] = $user['telephone'] ?? '';
            $_SESSION['role']       = $user['role'];

            if ($user['role'] === 'admin') {
                $_SESSION['_toast'] = [
                    'message' => 'Bienvenue dans l\'espace administrateur.',
                    'type'    => 'success',
                ];
                header('Location: ../admin/dashboard.php');
                exit();

            } else {
                $_SESSION['_toast'] = [
                    'message' => 'Connexion réussie. Bienvenue, ' . htmlspecialchars($user['nom']) . ' !',
                    'type'    => 'success',
                ];
                header('Location: ../index.php');
                exit();
            }

        } else {

            $error[] = "Email ou mot de passe incorrect";
        }
       
    }

}
$pageTitle = 'Connexion | Sabaya Luxury';
$pageDescription = 'Connectez-vous à votre compte Sabaya Luxury pour accéder à vos commandes et votre liste de souhaits.';
$pageRobots = 'noindex, nofollow';

$_authProtocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$_authScriptDir = dirname($_SERVER['SCRIPT_NAME']);
if ($_authScriptDir !== '/' && $_authScriptDir !== '\\' && $_authScriptDir !== '') {
    $_authScriptDir = dirname($_authScriptDir);
}
$_authBaseUrl = $_authProtocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($_authScriptDir, '/\\');
$extraHeadContent = '<link rel="stylesheet" href="' . htmlspecialchars($_authBaseUrl . '/assets/css/auth.css') . '">';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

    <main>
        <section aria-label="Formulaire de connexion">
            <h1>Connexion</h1>

            <?php if (!empty($error)):
                $toastMessage = implode(' ', $error);
                $toastType    = 'error';
            endif; ?>

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
            <p class="auth-switch">Don't have an account? <a href="register.php">Sign Up</a></p>
        </section>
    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>