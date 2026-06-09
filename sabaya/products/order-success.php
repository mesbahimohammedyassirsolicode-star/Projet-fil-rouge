<?php
session_start();

// Page metadata for header.php
$pageTitle = 'Commande Confirmée | Sabaya Luxury';
$pageDescription = 'Votre commande sur Sabaya Luxury a été confirmée avec succès.';
$pageRobots = 'noindex, nofollow';

// Toast: confirm order placement
$toastMessage = 'Votre commande a été enregistrée avec succès !';
$toastType    = 'success';

require_once '../includes/header.php';
require_once '../includes/navbar.php';

?>

    <main class="order-success-page reveal">
        <section class="order-success-container reveal">
            
            <!-- Success Icon -->
            <div class="success-icon-wrapper">
                <svg class="success-icon" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="38" stroke="currentColor" stroke-width="2"/>
                    <path d="M24 40L35 51L56 30" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <!-- Success Title -->
            <h1 class="success-title">Commande enregistrée avec succès</h1>

            <!-- Confirmation Message -->
            <div class="success-message">
                <p>Merci pour votre confiance.</p>
                <p>Veuillez confirmer votre commande via WhatsApp afin que notre équipe puisse la traiter rapidement.</p>
            </div>

            <?php

            $orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

            $message = $_SESSION['whatsapp_message'] ?? '';

            $whatsappLink =
                "https://wa.me/212613623407?text="
                . urlencode($message);

            ?>

            <!-- Action Buttons -->
            <div class="success-actions reveal">
                <a
                    href="<?= $whatsappLink ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-whatsapp"
                >
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Confirmer via WhatsApp
                </a>

                <div class="secondary-links">
                    <a href="my-orders.php" class="link-secondary">
                        Voir mes commandes
                    </a>
                    <span class="link-divider">|</span>
                    <a href="products.php" class="link-secondary">
                        Continuer mes achats
                    </a>
                </div>
            </div>

        </section>
    </main>


<?php require_once '../includes/footer.php'; ?>

</body>
</html>