<?php
session_start();
require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

$_SESSION['num'] += 1;
$error['post'] = '';
$error['picture'] = '';

$product_data = $db->prepare('SELECT * FROM product WHERE id = ?');
$product_data->execute(array($_REQUEST['id']));
$data = $product_data->fetch();

if($_SESSION['num'] == 3) {
    if(in_array('', $_POST)) {
        $error['post'] = 'blank';
        $data['name'] = $_POST['product_name'];
        $data['price'] = $_POST['product_price'];
        $data['message'] = $_POST['product_text'];
    } 
    
    $_SESSION['num'] -= 1;

    if(!in_array('blank', $error) && !in_array('size', $error)) {
        $ext = substr($_FILES['product_picture']['name'], -3);
        $picture = '';
        
        if(!empty($_FILES['product_picture']['name'])) {
            $picture = date('YmdHis') . $_FILES['product_picture']['name'];
            unlink('product_picture/' . $data['picture']);
        } else {
            print 'ファイル' . $data['picture'];
            $picture = $data['picture'];
        }
        
        if($_FILES['product_picture']['size'] > 1000000) {
            $error['picture'] = 'size';
        } else if($ext != 'jpg' && $ext != 'png' && $ext != '') {
            $error['picture'] = 'blank';
        } else {
        move_uploaded_file($_FILES['product_picture']['tmp_name'], 'product_picture/'. $picture);
        $product_new_data = $db->prepare('UPDATE product SET name=?, price=?, message=?, picture=? WHERE id=?');
        $product_new_data->execute(array(
            $_POST['product_name'],
            $_POST['product_price'],
            $_POST['product_text'],
            $picture,
            $_REQUEST['id']
        ));
        $_SESSION['num'] = 1;
        header('Location: product_edit_result.php');
        exit();
    }
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
<h1 class="title">Edit</h1>
<div class="big_picture">
<img id="img1" src="product_picture/<?php print $data['picture']; ?>" style="width:600px; height: 400px;">
</div>
<form method="post" action="" enctype="multipart/form-data">
<?php
if($error['picture'] == 'size') {
    print '画像のサイズが大きすぎます';
}
if($error['picture'] == 'blank') {
    print '拡張子が「.jpg」または「.png」のものを指定してください';
}
?>
<input type="file" id="myfile" name="product_picture"><br />
<?php 
if($error['post'] == 'blank') {
    print '未記入の項目があります<br />';
}
?>
<table align="center" class="product_form">
<tr>
<th>商品名</th>
<td><input type="text" name="product_name" value="<?php print $data['name']; ?>"></td>
</tr>
<tr>
<th>価格</th>
<td><input type="text" name="product_price" value="<?php print $data['price']; ?>"></td>
</tr>
<tr>
<th>商品詳細</th>
<td><textarea name="product_text" cols="40", rows="10"><?php print $data['message']; ?></textarea></td>
</tr>
</table>
<input type="submit" value="登録">
<input type="button" onclick="history.back()" value="戻る">
</form>
</div>
</body>
</html>