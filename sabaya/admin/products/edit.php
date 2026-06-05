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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../categories/list.php">Gestion des catégories</a></li>
                <li><a href="list.php">Gestion des produits</a></li>
                <li><a href="../orders/list.php">Gestion des commandes</a></li>
                <li><a href="../users/list.php">Gestion des utilisateurs</a></li>
                <li><a href="../dashboard.php">Tableau de bord</a></li>
                <li><a href="../../auth/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h1>Modifier un produit</h1>

            <?php if (!empty($errors)): ?>
                <div style="color: red; margin-bottom: 15px;" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Détails du produit à modifier</legend>
                    <p>
                        <label for="nom">Nom du produit :</label><br>
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($product['nom']) ?>">
                    </p>
                    <p>
                        <label for="description">Description :</label><br>
                        <textarea id="description" name="description"><?= htmlspecialchars($product['description']) ?></textarea>
                    </p>
                    <p>
                        <label for="prix">Prix :</label><br>
                        <input type="number" id="prix" name="prix" step="0.01" value="<?= htmlspecialchars($product['prix']) ?>">
                    </p>
                    <p>
                        <label for="stock">Stock :</label><br>
                        <input type="number" id="stock" name="stock" step="1" value="<?= htmlspecialchars($product['stock']) ?>">
                    </p>
                    <p>
                        <label for="taille">Taille :</label><br>
                        <input type="text" id="taille" name="taille" value="<?= htmlspecialchars($product['taille']) ?>">
                    </p>
                    <p>
                        <label for="couleur">Couleur :</label><br>
                        <input type="text" id="couleur" name="couleur" value="<?= htmlspecialchars($product['couleur']) ?>">
                    </p>
                    <p>
                        <span>Image actuelle :</span><br>
                        <?php if (!empty($product['image'])): ?>
                            <img src="../../assets/images/products/<?= htmlspecialchars($product['image']) ?>" alt="Photo actuelle de <?= htmlspecialchars($product['nom']) ?>" width="100" style="margin-bottom: 10px;"><br>
                        <?php endif; ?>
                        <label for="image">Remplacer l'image (optionnel) :</label><br>
                        <input type="file" id="image" name="image">
                    </p>
                    <p>
                        <label for="categorie">Catégorie :</label><br>
                        <select id="categorie" name="categorie">
                            <?php
                            $sql = "SELECT * FROM categorie";
                            $stmt = $pdo->query($sql);
                            while ($row = $stmt->fetch()) {
                                $selected = ($row['id_categorie'] == $product['id_categorie']) ? 'selected' : '';
                                echo "<option value='" . $row['id_categorie'] . "' $selected>" . htmlspecialchars($row['nom']) . "</option>";
                            }
                            ?>
                        </select>
                    </p>
                    <button type="submit">Enregistrer les modifications</button>
                    <a href="list.php">Annuler</a>
                </fieldset>
            </form>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>
