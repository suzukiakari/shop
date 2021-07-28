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
<h1 class="title">Edit</h1>
<div class="big_picture">
<p>この管理者を削除しますか？</p>
<img src="product_picture/<?php print $data['picture']; ?>" style="width:500px; height:350px;">
</div>
<table align="center" class="product_form">
<tr><th>商品名</th><td><?php print $data['name']; ?></td></tr>
<tr><th>価格</th><td><?php print $data['price']; ?></td></tr>
<tr><th>詳細</th><td><?php print $data['message']; ?></td></tr>
</table>
<form method="post" action="product_delete_result.php">
<input type="hidden" name="product_id" value="<?php print $data['id']; ?>">
<input type="submit" value="削除">
<input type="button" onClick="history.back()" value="戻る">
</form>
</div>
</body>
</html>