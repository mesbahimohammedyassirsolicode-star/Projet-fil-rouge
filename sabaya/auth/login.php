<?php
session_start();
require_once '../config/lang.php';
require_once '../config/Database.php';

$error = [];

$db = new Database();
$pdo = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {

        $error[] = t('login_all_fields_required');

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
                    'message' => t('login_welcome_admin'),
                    'type'    => 'success',
                ];
                header('Location: ../admin/dashboard.php');
                exit();

            } else {
                $_SESSION['_toast'] = [
                    'message' => t('login_welcome_user'),
                    'type'    => 'success',
                ];
                header('Location: ../index.php');
                exit();
            }

        } else {

            $error[] = t('login_invalid_credentials');
        }
       
    }

}

require_once '../config/lang.php';

$pageTitle = t('login_page_title');
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
            <h1><?= t('login_title') ?></h1>

            <?php if (!empty($error)):
                $toastMessage = implode(' ', $error);
                $toastType    = 'error';
            endif; ?>

            <form action="login.php" method="post">
                <fieldset>
                    <legend><?= t('login_legend') ?></legend>
                    <p>
                        <label for="email"><?= t('login_email') ?></label>
                        <input type="email" id="email" name="email">
                    </p>
                    <p>
                        <label for="password"><?= t('login_password') ?></label>
                        <input type="password" id="password" name="password">
                    </p>
                    <button type="submit" id="submit" name="submit"><?= t('login_submit') ?></button>
                </fieldset>
            </form>
            <p class="auth-switch"><?= t('login_no_account') ?> <a href="register.php"><?= t('login_sign_up_link') ?></a></p>
        </section>
    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
