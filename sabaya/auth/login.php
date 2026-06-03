<?php
// start session
    session_start();
//include the database connection
    require_once '../includes/db.php';
    // set error array
    $error=[];
    //check if the submit button is clicked
    if(isset($_POST['submit']))
    {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        //check if the fields are empty
         if (empty($email) || empty($password)) {
            $error[] = "Tous les champs sont obligatoires";
        }
        // check if the email is already in the database
        $sql = "SELECT * FROM client WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        // check if the user is valid password  
       if ($user && password_verify($password, $user['password'])) {
        // set the session variables 
    $_SESSION['user_id'] = $user['id_client'];
    $_SESSION['user_name'] = $user['nom'];
    $_SESSION['role'] = $user['role'];
    // check the role of the user and redirect to the appropriate page
        if($user['role'] == 'admin')
        {
            header("Location:/admin/dashboard.php");
        }
        elseif($user['role'] == 'client')
        {
            header("Location:/index.php");
        }
    exit();
} else {
    $error[] = "Email incorrect";
}
// display the errors
foreach($error as $err){
    echo $err . "<br>";
}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>    
    <!--start the form to login -->
    <form action="login.php" method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <button type="submit" id="submit" name="submit">Login</button>
    </form>
    
</body>
</html>