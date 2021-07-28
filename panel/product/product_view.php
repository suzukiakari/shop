<?php
require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

$product_data = $db->prepare('SELECT * FROM product WHERE id = ?');
$product_data->execute(array($_REQUEST['id']));
$data = $product_data->fetch();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body>
<div class="wrapper">
<h1 class="title">ProductList</h1>
<img src="product_picture/<?php print $data['picture']; ?>" style="width:500px; height:350px;"><br />
<div class="view_list_box">
<table class="view_list" align="center">
<tr><th>商品名</th><td><?php print $data['name']; ?></td></tr>
<tr><th>価格</th><td><?php print $data['price']; ?></td></tr>
<tr><th>詳細</th><td><?php print $data['message']; ?></td></tr>
</table>
</div>
<div class="link_box">
<div class="link_botton" id="botton"><a href="product_list.php">商品管理TOPへ</a></div>
</div>
</div>
</body>
</html>