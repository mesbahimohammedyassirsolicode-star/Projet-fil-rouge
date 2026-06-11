<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../config/Database.php';
require_once '../models/User.php';
require_once '../config/lang.php';

$db = new Database();
$pdo = $db->getConnection();
$userModel = new User($pdo);

$success = '';
$errors = [];

// Fetch fresh user data from database
$user = $userModel->find($_SESSION['user_id']);

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom      = trim($_POST['nom'] ?? '');
    $prenom   = trim($_POST['prenom'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    if (empty($nom)) {
        $errors[] = t('profile_err_last_name_required');
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $nom)) {
        $errors[] = t('profile_err_last_name_letters');
    }

    if (empty($prenom)) {
        $errors[] = t('profile_err_first_name_required');
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $prenom)) {
        $errors[] = t('profile_err_first_name_letters');
    }

    if (empty($email)) {
        $errors[] = t('profile_err_email_required');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = t('profile_err_email_invalid');
    } else {
        // Check if email is already used by another user
        $stmt = $pdo->prepare("SELECT id_client FROM client WHERE email = :email AND id_client != :id");
        $stmt->execute([':email' => $email, ':id' => $_SESSION['user_id']]);
        if ($stmt->fetch()) {
            $errors[] = t('profile_err_email_taken');
        }
    }

    if (!empty($telephone) && !preg_match("/^[0-9]+$/", $telephone)) {
        $errors[] = t('profile_err_phone_digits');
    }

    if (empty($errors)) {
        $userModel->update($_SESSION['user_id'], $nom, $prenom, $email, $telephone);

        // Update session with new values
        $_SESSION['user_name']  = $nom . ' ' . $prenom;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_phone'] = $telephone;

        // Refresh user data
        $user = $userModel->find($_SESSION['user_id']);
        $success = t('profile_success');
    }
}

$pageTitle = t('profile_page_title');
$pageDescription = t('profile_page_description');
$pageRobots = 'noindex, nofollow';

$_proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$_host  = $_SERVER['HTTP_HOST'];
$_scriptDir = dirname($_SERVER['SCRIPT_NAME']);
if ($_scriptDir !== '/' && $_scriptDir !== '\\' && $_scriptDir !== '') {
    $_scriptDir = dirname($_scriptDir);
}
$baseUrl = $_proto . '://' . $_host . rtrim($_scriptDir, '/\\');
$extraHeadContent = '<link rel="stylesheet" href="' . $baseUrl . '/assets/css/profile.css">';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

$userName  = htmlspecialchars($user['nom'] . ' ' . $user['prenom']);
$userEmail = htmlspecialchars($user['email']);
$initials  = strtoupper(substr($user['nom'], 0, 1) . substr($user['prenom'], 0, 1));
?>

    <main class="profile-page">
        <!-- Top Banner -->
    <div class="profile-banner reveal">
            <h1 class="profile-banner__title"><?= t('profile_title') ?></h1>
            <p class="profile-banner__welcome"><?= t('profile_welcome') ?> <span class="profile-banner__name"><?= $userName ?></span></p>
            <a href="logout.php" class="profile-banner__logout">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i> <?= t('profile_logout') ?>
            </a>
        </div>

        <!-- Two-Column Layout -->
        <div class="profile-container">
            <!-- LEFT SIDEBAR -->
            <aside class="profile-sidebar reveal">
                <ul class="profile-menu">
                    <li class="profile-menu__item profile-menu__item--active">
                        <a href="#personal-info" class="profile-menu__link">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <span><?= t('profile_menu_personal_info') ?></span>
                        </a>
                    </li>
                    <li class="profile-menu__item">
                        <a href="<?= htmlspecialchars($baseUrl) ?>/products/cart.php" class="profile-menu__link">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                            <span><?= t('profile_menu_cart') ?></span>
                        </a>
                    </li>
                    <li class="profile-menu__item">
                        <a href="<?= htmlspecialchars($baseUrl) ?>/wishlist/wishlist.php" class="profile-menu__link">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                            <span><?= t('profile_menu_wishlist') ?></span>
                        </a>
                    </li>
                    <li class="profile-menu__item">
                        <a href="<?= htmlspecialchars($baseUrl) ?>/products/my-orders.php" class="profile-menu__link">
                            <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                            <span><?= t('profile_menu_orders') ?></span>
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- RIGHT CONTENT -->
            <section class="profile-content reveal" id="personal-info">
                <h2 class="profile-content__title"><?= t('profile_edit_title') ?></h2>

                <!-- Success message -->
                <?php if ($success): ?>
                    <div class="profile-alert profile-alert--success">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <!-- Error messages -->
                <?php if (!empty($errors)): ?>
                    <div class="profile-alert profile-alert--error">
                        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                        <ul>
                            <?php foreach ($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" class="profile-form">
                    <div class="profile-card">
                        <!-- Avatar -->
                        <div class="profile-card__avatar">
                            <div class="profile-card__avatar-circle">
                                <span><?= $initials ?></span>
                            </div>
                        </div>

                        <!-- Editable Fields -->
                        <div class="profile-card__details">
                            <div class="profile-card__field">
                                <label class="profile-card__label" for="nom"><?= t('profile_last_name') ?></label>
                                <input
                                    type="text"
                                    id="nom"
                                    name="nom"
                                    class="profile-card__input"
                                    value="<?= htmlspecialchars($user['nom']) ?>"
                                    required
                                >
                            </div>

                            <div class="profile-card__field">
                                <label class="profile-card__label" for="prenom"><?= t('profile_first_name') ?></label>
                                <input
                                    type="text"
                                    id="prenom"
                                    name="prenom"
                                    class="profile-card__input"
                                    value="<?= htmlspecialchars($user['prenom']) ?>"
                                    required
                                >
                            </div>

                            <div class="profile-card__field">
                                <label class="profile-card__label" for="email"><?= t('profile_email') ?></label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="profile-card__input"
                                    value="<?= htmlspecialchars($user['email']) ?>"
                                    required
                                >
                            </div>

                            <div class="profile-card__field">
                                <label class="profile-card__label" for="telephone"><?= t('profile_phone') ?></label>
                                <input
                                    type="tel"
                                    id="telephone"
                                    name="telephone"
                                    class="profile-card__input"
                                    value="<?= htmlspecialchars($user['telephone'] ?? '') ?>"
                                    placeholder="<?= t('profile_phone_placeholder') ?>"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="profile-actions reveal">
                        <button type="submit" class="profile-actions__btn profile-actions__btn--primary">
                            <i class="fas fa-save" aria-hidden="true"></i> <?= t('profile_save_btn') ?>
                        </button>
                        <a href="logout.php" class="profile-actions__btn profile-actions__btn--secondary">
                            <i class="fas fa-sign-out-alt" aria-hidden="true"></i> <?= t('profile_logout') ?>
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
