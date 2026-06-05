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
    $error[] = "Le nom est obligatoire";
}

if (empty($prenom)) {
    $error[] = "Le prénom est obligatoire";
}

if (empty($email)) {
    $error[] = "L'email est obligatoire";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Adresse email invalide";
}

if (empty($phone)) {
    $error[] = "Le téléphone est obligatoire";
}

if (empty($password)) {
    $error[] = "Le mot de passe est obligatoire";
} elseif (strlen($password) < 8) {
    $error[] = "Le mot de passe doit contenir au moins 8 caractères";
}

// check if the name and the prenom are valid
       if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $nom)) {
    $error[] = "Le nom doit contenir uniquement des lettres";
}
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $prenom)) {
            $error[] = "Le prenom doit contenir uniquement des lettres";
        }
        // check if the phone number is valid
        if (!preg_match("/^[0-9]*$/", $phone)) {
            $error[] = "Le telephone doit contenir uniquement des chiffres";
        }
           //check if email is valid
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Adresse email invalide";
}
// check if the password is valid
        if($password != $confirme){
            $error[] = "Les mots de passe ne correspondent pas";
        }
        // check if the email is already in the database
        $sql = "SELECT * FROM client WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        if($user){
            $error[] = "L'email est deja utilise";
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
            header("Location:login.php"); 
            exit();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
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
            <h1>Créer un compte</h1>

            <?php if (!empty($error)): ?>
                <div style="color: red; margin-bottom: 15px;" role="alert">
                    <?php foreach($error as $err): ?>
                        <p><?php echo htmlspecialchars($err); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <fieldset>
                    <legend>Informations d'inscription</legend>
                    <p>
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom">
                    </p>
                    <p>
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom">
                    </p>
                    <p>
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone">
                    </p>
                    <p>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                    </p>
                    <p>
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password">
                    </p>
                    <p>
                        <label for="confirme">Confirmer le mot de passe</label>
                        <input type="password" id="confirme" name="confirme">
                    </p>
                    <button type="submit" id="submit" name="submit">S'inscrire</button>
                </fieldset>
            </form>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 Sabaya Luxury</p>
    </footer>
</body>
</html>