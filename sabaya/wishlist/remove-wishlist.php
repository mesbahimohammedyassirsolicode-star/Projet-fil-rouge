<?php

session_start();

require_once '../config/Database.php';
require_once '../models/Wishlist.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: wishlist.php');
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$wishlistModel = new Wishlist($pdo);

$id = (int) $_GET['id'];

$wishlistModel->delete($id);

header('Location: wishlist.php');
exit();