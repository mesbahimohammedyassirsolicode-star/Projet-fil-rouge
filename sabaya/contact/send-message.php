<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Contact.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit();
}

$nom = trim($_POST['nom']);
$email = trim($_POST['email']);
$sujet = trim($_POST['sujet']);
$message = trim($_POST['message']);

$db = new Database();
$pdo = $db->getConnection();

$contactModel = new Contact($pdo);

$contactModel->create(
    $nom,
    $email,
    $sujet,
    $message,
    $_SESSION['user_id']
);

header('Location: contact.php?success=1');
exit();
?>
