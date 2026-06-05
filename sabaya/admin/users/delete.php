<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/User.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$userModel = new User($pdo);

$id = (int) $_GET['id'];
$user = $userModel->find($id);

if (!$user) {
    header('Location: list.php');
    exit();
}

if ($user['role'] === 'admin') {
    die('Impossible de supprimer un administrateur');
}

$userModel->delete($id);
$userModel->delete($id);

header('Location: list.php');
exit();