<?php
// start session
    session_start();
require_once '../config/Database.php';

$db = new Database();
$pdo = $db->getConnection();
// set error array
    $error=[];
// check if the submit button is clicked
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // fetch the data from the form 
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $phone = htmlspecialchars($_POST['phone']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirme = htmlspecialchars($_POST['confirme']);
// check if the fields are empty
       if (empty($nom)) {
    $error[] = t('register_lastname_letters');
}

if (empty($prenom)) {
    $error[] = t('register_firstname_letters');
}

if (empty($email)) {
    $error[] = t('contact_err_email_required');
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = t('contact_err_email_invalid');
}

if (empty($phone)) {
    $error[] = t('register_phone') . " est obligatoire";
}

if (empty($password)) {
    $error[] = t('register_password') . " est obligatoire";
} elseif (strlen($password) < 8) {
    $error[] = t('register_password_length');
}

// check if the name and the prenom are valid
       if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $nom)) {
    $error[] = t('register_lastname_letters');
}
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $prenom)) {
            $error[] = t('register_firstname_letters');
        }
        // check if the phone number is valid
        if (!preg_match("/^[0-9]*$/", $phone)) {
            $error[] = t('register_phone_digits');
        }
           //check if email is valid
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = t('contact_err_email_invalid');
}
// check if the password is valid
        if($password != $confirme){
            $error[] = t('register_password_mismatch');
        }
        // check if the email is already in the database
        $sql = "SELECT * FROM client WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        if($user){
            $error[] = t('register_email_taken');
        }
        if(count($error) == 0){
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
           $sql = "INSERT INTO client (nom, prenom, telephone, email, password)
        VALUES (:nom, :prenom, :telephone, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':telephone' => $phone,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);
            $_SESSION['_toast'] = [
                'message' => t('register_success'),
                'type'    => 'success',
            ];
            header("Location:login.php"); 
            exit();
        }
    }

require_once '../config/lang.php';

$pageTitle = t('register_title') . ' | ' . t('site_name');
$pageDescription = 'Créez votre compte Sabaya Luxury et découvrez nos collections d\'abayas modernes et élégantes.';
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
        <section aria-label="Formulaire d'inscription">
            <h1><?= t('register_title') ?></h1>

            <?php if (!empty($error)):
                $toastMessage = implode(' ', $error);
                $toastType    = 'error';
            endif; ?>

            <form method="post">
                <fieldset>
                    <legend><?= t('register_legend') ?></legend>
                    <p>
                        <label for="nom"><?= t('register_nom') ?></label>
                        <input type="text" id="nom" name="nom">
                    </p>
                    <p>
                        <label for="prenom"><?= t('register_prenom') ?></label>
                        <input type="text" id="prenom" name="prenom">
                    </p>
                    <p>
                        <label for="phone"><?= t('register_phone') ?></label>
                        <input type="tel" id="phone" name="phone">
                    </p>
                    <p>
                        <label for="email"><?= t('register_email') ?></label>
                        <input type="email" id="email" name="email">
                    </p>
                    <p>
                        <label for="password"><?= t('register_password') ?></label>
                        <input type="password" id="password" name="password">
                    </p>
                    <p>
                        <label for="confirme"><?= t('register_confirm') ?></label>
                        <input type="password" id="confirme" name="confirme">
                    </p>
                    <button type="submit" id="submit" name="submit"><?= t('register_submit') ?></button>
                </fieldset>
            </form>
            <p class="auth-switch"><?= t('register_have_account') ?> <a href="login.php"><?= t('register_login_link') ?></a></p>
        </section>
    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
