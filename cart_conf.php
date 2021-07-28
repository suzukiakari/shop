<?php
session_start();
require('api/dbconnect.php');
require('api/func.php');

login_result();

$_SESSION['num'] = 1;
$name = [];
$price = [];
$picture = [];
$cart = '';
$count = '';

if(isset($_SESSION['cart']) == true) {
    $cart = $_SESSION['cart'];
    $count = $_SESSION['count'];
}

$max = count($_SESSION['cart']);
for($i = 0; $i < $max; $i++) {
    $cart_data = $db->prepare('SELECT * FROM product WHERE id = ?');
    $cart_data->execute(array($cart[$i]));
    $datas = $cart_data->fetch();
    $name[] = $datas['name'];
    $price[] = $datas['price'];
    $picture[] = $datas['picture'];
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
<h1 class="title">Confirmation</h1>
<?php for($i = 0; $i < $max; $i++): ?>
<div class="conf_form">
<div class="conf_pic">
<img src="panel/product/product_picture/<?php print $picture[$i]; ?>"
style="width:300px; height:200px;"></div>
<div class="conf_product">
<h2>●<?php print $name[$i]; ?></h2>
<?php print $price[$i].'円'; ?> ×　<?php print $count[$i].'個'; ?>
</div>
</div>
<?php endfor; ?>
<div class="link_box">
<div class="link_botton"><a href="cart_conf_result.php">購入</a></div>
<div class="link_botton"><a href="cart.php">戻る</a></div>
</div>
</div>
</body>
</html>