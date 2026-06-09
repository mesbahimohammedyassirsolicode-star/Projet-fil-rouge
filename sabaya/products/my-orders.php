<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Order.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$orderModel = new Order($pdo);

$orders = $orderModel->getUserOrders(
    $_SESSION['user_id']
);

$pageTitle = 'Mes Commandes | Sabaya Luxury';
$pageDescription = 'Consultez l\'historique de vos commandes sur Sabaya Luxury.';
$pageRobots = 'noindex, nofollow';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

<main class="orders-page reveal">
    <div class="orders-container">

        <!-- Page Header -->
        <header class="orders-header reveal">
            <span class="orders-header-label">Votre Historique</span>
            <h1 class="orders-title">Mes Commandes</h1>
            <p class="orders-subtitle">Retrouvez l'ensemble de vos commandes passées sur Sabaya Luxury</p>
        </header>

        <!-- Orders List -->
        <?php if (empty($orders)): ?>
            <div class="orders-empty">
                <i class="fas fa-box-open orders-empty-icon"></i>
                <h2 class="orders-empty-title">Aucune commande</h2>
                <p class="orders-empty-text">Vous n'avez pas encore passé de commande.</p>
                <a href="products.php" class="btn btn-orders-empty">Découvrir la Collection</a>
            </div>
            <?php else: ?>
            <div class="orders-list reveal">
                <?php foreach($orders as $order):
                    $status = htmlspecialchars($order['statuscmd']);
                    // Determine badge class
                    $badgeClass = 'orders-badge--pending';
                    if (stripos($status, 'confirm') !== false) $badgeClass = 'orders-badge--confirmed';
                    elseif (stripos($status, 'expédi') !== false || stripos($status, 'ship') !== false) $badgeClass = 'orders-badge--shipped';
                    elseif (stripos($status, 'livr') !== false || stripos($status, 'deliver') !== false) $badgeClass = 'orders-badge--delivered';
                ?>
                <article class="order-card reveal">
                    <div class="order-card-inner">

                        <!-- Left: Order Info -->
                        <div class="order-card-info">
                            <div class="order-card-meta">
                                <span class="order-card-label">Commande</span>
                                <span class="order-card-id">#<?= htmlspecialchars($order['id_commande']) ?></span>
                            </div>
                            <div class="order-card-date">
                                <i class="far fa-calendar-alt order-card-date-icon"></i>
                                <time><?= htmlspecialchars($order['datecmd']) ?></time>
                            </div>
                        </div>

                        <!-- Center: Total -->
                        <div class="order-card-total">
                            <span class="order-card-total-label">Total</span>
                            <span class="order-card-total-value"><?= number_format((float)$order['total'], 2, ',', ' ') ?> <span class="order-card-currency">DH</span></span>
                        </div>

                        <!-- Right: Status + Action -->
                        <div class="order-card-actions">
                            <span class="orders-badge <?= $badgeClass ?>"><?= $status ?></span>
                            <a href="#" class="btn-outline btn-orders-details" aria-label="Voir les détails de la commande #<?= htmlspecialchars($order['id_commande']) ?>">
                                Voir Détails
                            </a>
                        </div>

                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>