<?php
session_start();
require_once '../../config/Database.php';
require_once '../../models/Product.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$productModel = new Product($pdo);

// ── Load localisation system ──────────────────────────────────────────────
require_once '../../config/lang.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: list.php');
    exit();
}

$id = $_GET['id'];
$product = $productModel->find($id);

if (!$product) {
    header('Location: list.php');
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $taille = trim($_POST['taille']);
    $couleur = trim($_POST['couleur']);
    $categorie_id = $_POST['categorie'];
    $imageName = $product['image']; // Keep existing image by default

    if (empty($nom)) {
        $errors[] = "Le nom du produit est obligatoire";
    }
    if (empty($description)) {
        $errors[] = "La description du produit est obligatoire";
    }
    if ($prix <= 0) {
        $errors[] = "Le prix doit être supérieur à zéro";
    }
    if ($stock < 0) {
        $errors[] = "Le stock ne peut pas être négatif";
    }
    if (empty($taille)) {
        $errors[] = "La taille du produit est obligatoire";
    }
    if (empty($couleur)) {
        $errors[] = "La couleur du produit est obligatoire";
    }
    if (empty($categorie_id)) {
        $errors[] = "La catégorie est obligatoire";
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = time() . '_' . $_FILES['image']['name'];
        $destination = "../../assets/images/products/" . $imageName;

        // Ensure the directory exists
        if (!is_dir("../../assets/images/products/")) {
            mkdir("../../assets/images/products/", 0777, true);
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $errors[] = "Erreur lors de l'importation de la nouvelle image";
        }
    }

    if (empty($errors)) {
        $productModel->update(
            $id,
            $nom,
            $description,
            $prix,
            $stock,
            $imageName,
            $taille,
            $couleur,
            $categorie_id
        );

        header('Location: list.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Modifier un Produit | Sabaya Luxury Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body class="admin-dashboard">

    <!-- ══ Sidebar ════════════════════════════════════ -->
    <aside class="sidebar" id="sidebar" aria-label="Menu administration">
        <div class="sidebar-brand">
            <img src="../../assets/images/logo/logo.png" alt="Sabaya Luxury" class="sidebar-logo">
            <span class="sidebar-title">Sabaya Admin</span>
        </div>
        <nav aria-label="Navigation principale admin">
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a href="../dashboard.php">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="list.php" aria-current="page">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                        <span>Produits</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../categories/list.php">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                        <span>Catégories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../orders/list.php">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        <span>Commandes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../users/list.php">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        <span>Clients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../contact/list.php">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../statistics/index.php">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        <span>Statistiques</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="../../auth/logout.php" class="logout-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span>Déconnexion</span>
            </a>
        </div>
    </aside>

    <!-- ══ Overlay for mobile ════════════════════════ -->
    <div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

    <!-- ══ Main Wrapper ══════════════════════════════ -->
    <div class="admin-main-wrapper">

        <!-- ── Top Header ──────────────────────────── -->
        <header class="admin-top-header">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="sidebar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="header-title-block">
                <h1>Modifier un Produit</h1>
                <p class="header-subtitle">Mettez à jour les informations du produit.</p>
            </div>
            <div class="header-user" style="margin-left: auto;">
                <span class="user-greeting">Bonjour, <?= htmlspecialchars(isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin') ?></span>
                <a href="../../auth/profile.php" class="user-avatar" aria-label="Mon profil">
                    <?= strtoupper(substr(isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'A', 0, 1)) ?>
                </a>
            </div>
        </header>

        <!-- ── Main Content ────────────────────────── -->
        <main class="admin-content">
            <section aria-label="Formulaire de modification de produit">
                
                <?php if (!empty($errors)): ?>
                    <div class="error-notification-card" role="alert">
                        <?php foreach ($errors as $error): ?>
                            <p><?= htmlspecialchars($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data" class="luxury-form">
                    <div class="form-grid">
                        
                        <!-- LEFT COLUMN: Informations Produit -->
                        <fieldset class="form-card">
                            <legend>Informations Produit</legend>
                            
                            <div class="form-group">
                                <label for="nom">Nom du produit</label>
                                <input type="text" id="nom" name="nom" required placeholder="Ex: Coffret Royal Oud" value="<?= htmlspecialchars($product['nom']) ?>">
                            </div>

                            <div class="form-row-2">
                                <div class="form-group">
                                    <label for="categorie">Catégorie</label>
                                    <select id="categorie" name="categorie" required>
                                        <?php
                                        $sql = "SELECT * FROM categorie";
                                        $stmt = $pdo->query($sql);
                                        while ($row = $stmt->fetch()) {
                                            $selected = ($row['id_categorie'] == $product['id_categorie']) ? 'selected' : '';
                                            echo "<option value='" . $row['id_categorie'] . "' " . $selected . ">" . htmlspecialchars($row['nom']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="prix">Prix (DH)</label>
                                    <input type="number" id="prix" name="prix" step="0.01" min="0.01" required placeholder="0.00" value="<?= htmlspecialchars($product['prix']) ?>">
                                </div>
                            </div>

                            <div class="form-row-3">
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" id="stock" name="stock" step="1" min="0" required placeholder="0" value="<?= htmlspecialchars($product['stock']) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="taille">Taille</label>
                                    <input type="text" id="taille" name="taille" required placeholder="Ex: 100ml / Unique" value="<?= htmlspecialchars($product['taille']) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="couleur">Couleur</label>
                                    <input type="text" id="couleur" name="couleur" required placeholder="Ex: Or / Noir" value="<?= htmlspecialchars($product['couleur']) ?>">
                                </div>
                            </div>
                        </fieldset>

                        <!-- RIGHT COLUMN: Image Produit -->
                        <fieldset class="form-card media-card">
                            <legend>Image Produit</legend>
                            
                            <div class="form-group">
                                <label for="image">Remplacer l'image (optionnel)</label>
                                <div class="file-upload-wrapper">
                                    <div class="file-upload-dropzone" id="dropzone">
                                        <svg class="upload-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        <p class="upload-text">Glissez-déposez ou cliquez pour remplacer l'image</p>
                                        <p class="upload-tip">Formats acceptés: PNG, JPG, JPEG (Max. 5Mo)</p>
                                        <input type="file" id="image" name="image" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="image-preview-wrapper" id="preview-container">
                                <label>Aperçu de l'image</label>
                                <div class="image-preview-container">
                                    <?php if (!empty($product['image'])): ?>
                                        <img id="image-preview" src="../../assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="Aperçu de l'image du produit" class="image-preview">
                                        <div id="image-placeholder" class="image-placeholder" style="display: none;">
                                            <span>Aucune image sélectionnée</span>
                                        </div>
                                    <?php else: ?>
                                        <img id="image-preview" src="#" alt="Aperçu de l'image du produit" class="image-preview hidden">
                                        <div id="image-placeholder" class="image-placeholder">
                                            <span>Aucune image sélectionnée</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Description Section (Full width card) -->
                    <fieldset class="form-card description-card">
                        <legend>Description du produit</legend>
                        <div class="form-group">
                            <label for="description" class="sr-only">Description du produit</label>
                            <textarea id="description" name="description" required placeholder="Rédigez une description détaillée et raffinée de cette création..."><?= htmlspecialchars($product['description']) ?></textarea>
                        </div>
                    </fieldset>

                    <!-- Actions (Buttons) -->
                    <div class="form-actions">
                        <a href="list.php" class="btn-secondary">Retour à la liste</a>
                        <button type="submit" class="btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </section>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <p>Copyright &copy; 2026 Sabaya Luxury</p>
        </footer>
    </div>

    <!-- JS Scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        /* ── Sidebar Toggle ──────────────────────── */
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            if (sidebar && overlay && toggle) {
                sidebar.classList.add('open');
                overlay.classList.add('active');
                toggle.setAttribute('aria-expanded', 'true');
            }
        }
        function closeSidebar() {
            if (sidebar && overlay && toggle) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
            }
        }

        if (toggle) {
            toggle.addEventListener('click', function () {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });
        }
        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
                closeSidebar();
                toggle.focus();
            }
        });

        /* ── Image Upload & Preview ──────────────── */
        const fileInput = document.getElementById('image');
        const previewImg = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');
        const dropzone = document.getElementById('dropzone');

        // Store the original image source
        const originalSrc = previewImg ? previewImg.src : '';
        const hasOriginalSrc = originalSrc && !originalSrc.endsWith('#') && originalSrc !== window.location.href;

        if (fileInput && previewImg) {
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('hidden');
                        if (placeholder) placeholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    if (hasOriginalSrc) {
                        previewImg.src = originalSrc;
                        previewImg.classList.remove('hidden');
                        if (placeholder) placeholder.style.display = 'none';
                    } else {
                        previewImg.src = '#';
                        previewImg.classList.add('hidden');
                        if (placeholder) placeholder.style.display = 'flex';
                    }
                }
            });
        }

        if (dropzone && fileInput) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.add('dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.remove('dragover');
                }, false);
            });

            dropzone.addEventListener('drop', function (e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length) {
                    fileInput.files = files;
                    // trigger change event
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            }, false);
        }
    });
    </script>
</body>
</html>
