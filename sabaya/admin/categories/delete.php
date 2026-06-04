<?php

session_start();

require_once '../../config/Database.php';
require_once '../../models/Category.php';

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

$categoryModel = new Category($pdo);

$id =  $_GET['id'];

$categoryModel->delete($id);

header('Location: list.php');
exit();