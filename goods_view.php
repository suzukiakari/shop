<?php
session_start();
require('api/dbconnect.php');
require('api/func.php');

login_result();

$error['count'] = '';
$count = 1;

$goods_data = $db->prepare('SELECT * FROM product WHERE id=?');
$goods_data->execute(array($_REQUEST['id']));
$data = $goods_data->fetch();

if(!empty($_POST)) {
    $count = hsc($_POST['count']);
    if(preg_match('/\A[0-9]+\z/', $count) == 0) {
        $error['count'] = 'type';
    }
    if($error['count'] == '') {
        header('Location: goods_view_result.php?value[]=' . $data['id'].'&value[]=' . $count);
        exit();
    }
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
<h1 class="title">View</h1>
<div class="login_box">
<img src="panel/product/product_picture/<?php print $data['picture']; ?>"><br />
<br />
<form method="post" action="">
<table class="view_form" align="center">
<tr>
<td>商品名</td><td><?php print $data['name']; ?></td>
</tr>
<tr>
<td>価格</td><td><?php print $data['price'].'円'; ?></td>
</tr>
<tr>
<td>注文数</td>
<td>
<?php
if($error['count'] == 'type') {
    print '<div class="error">＊個数を半角数字を入力してください</div>';
}
?>
<input type="text" name="count" value=<?php print $count ?>>個</td>
</tr>
<tr>
<td>詳細</td><td><?php print $data['message']; ?></td>
</tr>
</table>
<br />
<input type="submit" value="カートに入れる">
<input type="button" onclick="history.back()" value="戻る">
</form>
</div>
</div>
</body>
</html>