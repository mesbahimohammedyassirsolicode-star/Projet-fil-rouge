<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../config/Database.php';
require_once '../models/User.php';

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
        $errors[] = 'Last name is required.';
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $nom)) {
        $errors[] = 'Last name must contain only letters.';
    }

    if (empty($prenom)) {
        $errors[] = 'First name is required.';
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $prenom)) {
        $errors[] = 'First name must contain only letters.';
    }

    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    } else {
        // Check if email is already used by another user
        $stmt = $pdo->prepare("SELECT id_client FROM client WHERE email = :email AND id_client != :id");
        $stmt->execute([':email' => $email, ':id' => $_SESSION['user_id']]);
        if ($stmt->fetch()) {
            $errors[] = 'This email is already used by another account.';
        }
    }

    if (!empty($telephone) && !preg_match("/^[0-9]+$/", $telephone)) {
        $errors[] = 'Phone number must contain only digits.';
    }

    if (empty($errors)) {
        $userModel->update($_SESSION['user_id'], $nom, $prenom, $email, $telephone);

        // Update session with new values
        $_SESSION['user_name']  = $nom . ' ' . $prenom;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_phone'] = $telephone;

        // Refresh user data
        $user = $userModel->find($_SESSION['user_id']);
        $success = 'Your profile has been updated successfully.';
    }
}

$pageTitle = 'Mon Profil | Sabaya Luxury';
$pageDescription = 'Gérez votre profil Sabaya Luxury.';
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
            <h1 class="profile-banner__title">My Account</h1>
            <p class="profile-banner__welcome">Welcome back, <span class="profile-banner__name"><?= $userName ?></span></p>
            <a href="logout.php" class="profile-banner__logout">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout
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
                            <span>Personal Info</span>
                        </a>
                    </li>
                    <li class="profile-menu__item">
                        <a href="<?= htmlspecialchars($baseUrl) ?>/products/cart.php" class="profile-menu__link">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                            <span>Cart</span>
                        </a>
                    </li>
                    <li class="profile-menu__item">
                        <a href="<?= htmlspecialchars($baseUrl) ?>/wishlist/wishlist.php" class="profile-menu__link">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                            <span>Wishlist</span>
                        </a>
                    </li>
                    <li class="profile-menu__item">
                        <a href="<?= htmlspecialchars($baseUrl) ?>/products/my-orders.php" class="profile-menu__link">
                            <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                            <span>Order History</span>
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- RIGHT CONTENT -->
            <section class="profile-content reveal" id="personal-info">
                <h2 class="profile-content__title">Edit Details</h2>

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
                                <label class="profile-card__label" for="nom">Last Name</label>
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
                                <label class="profile-card__label" for="prenom">First Name</label>
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
                                <label class="profile-card__label" for="email">Email</label>
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
                                <label class="profile-card__label" for="telephone">Phone</label>
                                <input
                                    type="tel"
                                    id="telephone"
                                    name="telephone"
                                    class="profile-card__input"
                                    value="<?= htmlspecialchars($user['telephone'] ?? '') ?>"
                                    placeholder="e.g. 0612345678"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="profile-actions reveal">
                        <button type="submit" class="profile-actions__btn profile-actions__btn--primary">
                            <i class="fas fa-save" aria-hidden="true"></i> Save Changes
                        </button>
                        <a href="logout.php" class="profile-actions__btn profile-actions__btn--secondary">
                            <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
