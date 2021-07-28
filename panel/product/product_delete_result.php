<?php
require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

//サニタイズ
$post = sanitize($_POST);
$product_id = $post['product_id'];

//データベースに接続し管理者を削除
$product_delete = $db->prepare('DELETE FROM product WHERE id = ?');
$product_delete->execute(array($product_id));
$delete = $product_delete->fetch();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body>
<div class="wrapper">
<h1 class="title">Done</h1>
<p class="result">削除しました。</p>
<div class="link_box">
<div class="link_botton"><a href="product_list.php">商品管理TOPへ</a></div>
</div>
</div>
</body>
</html>
