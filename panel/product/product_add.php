<?php
session_start();
require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

$product_name = '';
$product_price = '';
$product_text = '';
$error['name'] = '';
$error['price'] = '';
$error['text'] = '';
$error['picture'] = '';

if(!empty($_POST)) {
    //サニタイズ
    $post = sanitize($_POST);
    $product_name = $post['product_name'];
    $product_price = $post['product_price'];
    $product_text = $post['product_text'];
    $product_pic = $_FILES['picture']['name'];

    //バリデーションチェック
    if($product_name == '') {
        $error['name'] = 'blank';
    }
    if($product_price == '') {
        $error['price'] = 'blank';
    }
    if($product_text == '') {
        $error['text'] = 'blank';
    }
    if($_FILES['picture']['size'] > 1000000){
        $error['picture'] = 'size';
    }
    $ext = substr($product_pic, -3);
    if($ext != 'jpg' && $ext != 'png') {
        $error['picture'] = 'blank';
    }

    //データベースに接続し、データを登録
    if(!in_array('blank', $error) && !in_array('size', $error)) {
        $picture = date('YmdHis') . $product_pic;
        move_uploaded_file($_FILES['picture']['tmp_name'], 'product_picture/'. $picture);
        $product_data = $db->prepare('INSERT INTO product SET name=?, price=?, message=?, picture=?');
        $product_data->execute(array(
            $product_name,
            $product_price,
            $product_text,
            $picture
        ));
        // 成功したらproduct_add_result.phpへ飛ぶ
        header('Location: product_add_result.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/script.js"></script>
</head>
<body>
<div class="wrapper">
<h1 class="title">New</h1>
<div class="big_picture"><img src="picture/noimage.jpg" id="img1" style="width:600px;height:400px;"></div>
<form method="post" action="" enctype="multipart/form-data">
<?php
if($error['picture'] == 'size') {
    print '<div class="error">＊画像のサイズが大きすぎます</div>';
}
if($error['picture'] == 'blank') {
    print '<div class="error">＊画像が選択されていないか、<br />
    拡張子が「.jpg」または「.png」のものを指定してください</div>';
}
?>
<input type="file" id="myfile" name="picture"><br />
<table class="product_form" align="center">
<tr>
<th>商品名</th>
<td>
<?php
if($error['name'] == 'blank') {
    print '<div class="error">＊商品名を入力してください</div>';
}
?>
<input type="text" name="product_name" value="<?php print $product_name ?>">
</td>
</tr>
<tr>
<td>価格</td>
<td>
<?php
if($error['price'] == 'blank') {
    print '<div class="error">＊価格を入力してください</div>';
}
?>
<input type="text" name="product_price" value="<?php print $product_price ?>">
</td>
</tr>
<tr>
<td>商品詳細</td>
<td>
<?php
if($error['text'] == 'blank') {
    print '<div class="error">＊商品の詳細を入力してください</div>';
}
?>
<textarea name="product_text" value="<?php print $product_text ?>" cols="40", rows="10"></textarea>
</td>
</tr>
</table>
<input type="submit" value="登録">
<input type="button" onClick="history.back()" value="戻る">
</form>
</div>
</body>
</html>
