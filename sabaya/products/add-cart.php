<?php

session_start();

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$id = (int) $_GET['id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

header('Location: cart.php');
exit();