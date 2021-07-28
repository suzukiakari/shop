<?php
session_start();
require('api/dbconnect.php');
require('api/func.php');

login_result();

$id = $_REQUEST['value'][0];
$value = $_REQUEST['value'][1];
$error['cart'] = '';
$cart = [];

if(isset($_SESSION['cart']) == true) {
    $cart = $_SESSION['cart'];
    $count = $_SESSION['count'];
}
if(isset($_SESSION['cart']) == true && in_array($id, $cart)) {
    $error['cart'] = 'dup';
} else {
    $cart[] = $id;
    $count[] = $value;
    $_SESSION['cart'] = $cart;
    $_SESSION['count'] = $count;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body id="login_page">
<div class="wrapper">
<h1 class="title">Result</h1>
<div class="result_message">
<?php
if($error['cart'] == 'dup') {
    print 'すでにカートに同じ商品が入っています。<br />';
} else {
    print 'カートに追加しました。<br />';
}
?>
<br />
<div class="link_box">
<div class="link_botton"><a href="index.php">トップへ</a></div>
<div class="link_botton"><a href="cart.php">カートへ</a></div>
</div>
</div>
</div>
</body>
</html>