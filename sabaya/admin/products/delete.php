<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Product.php';

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

$productModel = new Product($pdo);

$id = (int) $_GET['id'];

$productModel->delete($id);

header('Location: list.php');
exit();