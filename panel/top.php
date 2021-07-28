<?php
session_start();
if(!isset($_SESSION['adminId']) && $_SESSION['time'] + 3600 < time()) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body>
<div class="wrapper">
<h1 class="title">TOP</h1>
<div class="link_box">
<div class="link_botton"><a href="admin/admin_list.php">管理者ページ</a></div>
<div class="link_botton"><a href="product/product_list.php">商品管理ページ</a></div>
</div>
</div>
</body>
</html>
