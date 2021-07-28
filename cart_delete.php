<?php
session_start();
$num = $_REQUEST['num'];
$cart = $_SESSION['cart'];
$count = $_SESSION['count'];

array_splice($cart, $num, 1);
array_splice($count, $num, 1);

$_SESSION['cart'] = $cart;
$_SESSION['count'] = $count;
$_SESSION['num'] = 1;

if(empty($cart)) {
    unset($_SESSION["cart"]);
}

header('location: cart.php');
exit();
?>
