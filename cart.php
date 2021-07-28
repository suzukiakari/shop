<?php
session_start();
require('api/dbconnect.php');
require('api/func.php');

login_result();

$cart = '';
$count = '';
$name = [];
$price = [];
$picture = [];
$error['count'] = '';
$error['cart'] = '';
$_SESSION['num'] += 1;

if(isset($_SESSION['cart']) == true) {
    $cart = $_SESSION['cart'];
    $count = $_SESSION['count'];
}
if($cart != '') {
    $max = count($cart);
    for($i = 0; $i < $max; $i++) {
        $cart_data = $db->prepare('SELECT * FROM product WHERE id = ?');
        $cart_data->execute(array($cart[$i]));
        $datas = $cart_data->fetch();
        $name[] = $datas['name'];
        $price[] = $datas['price'];
        $picture[] = $datas['picture'];
    }
}
if($_SESSION['num'] == 3) {
    $max = count($_POST);
    if($cart == '') {
        $error['cart'] = 'blank';
    }
    if(in_array('', $_POST)) {
        $error['count'] = 'blank';
    }
    for($i = 0; $i < $max; $i++) {
        if(preg_match('/\A[0-9]+\z/', $_POST['count'.$i]) == 0) {
            $error['count'] = 'type';
            $count[$i] = $_POST['count'.$i];
        }
    }
    if($error['count'] != 'blank' && $error['count'] != 'type' && $count != '') {
        for($i = 0; $i < $max; $i++) {
            $count[$i] = $_POST['count'.$i];
        }
        $_SESSION['count'] = $count;  
        header('Location: cart_conf.php');
        exit();
    }
    $_SESSION['num'] -=1;
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
<h1 class="title">Cart</h1>
<?php if($cart == ''): ?>
<div class="result_message">選択された商品はありません</div>
<?php endif; ?>
<?php if($error['cart'] == 'blank') :?>
    商品選択してください
<?php endif; ?>
<form method="post" action="">
<?php if($cart != 0): ?>
<?php for($i = 0; $i < $max; $i++): ?>
<div class="cart_form">
<a href="cart_delete.php?num=<?php print $i;?>">
<img src="picture/images.jpg" class="del_pic" style="width:30px; height:30px;"></a>
<div class="cart_pic">
<img src="panel/product/product_picture/<?php print $picture[$i]; ?>"
style="width:300px; height:200px;">
</div>
<div class="cart_product">
<h2>●<?php print $name[$i];?></h2>
<br />
<?php
if($error['count'] == 'blank') {
    print '<div class="error">個数が指定されていない商品があります。</div>';
}
if($error['count'] == 'type') {
    print '<div class="error">個数には半角数字を入力してください。</div>';
}
?>
<?php print $price[$i].'円  ';?> × <input type="text" name="count<?php print $i; ?>" 
value="<?php print hsc($count[$i]); ?>">個<br />
<br />
</div>
</div>
<?php endfor; ?>
<?php endif; ?>
<div class="link_box">
<input type="submit" value="購入">
<span class="link_botton" id="cart_botton"><a href="index.php">トップへ</a></span>
</div>
</form>
</div>
</body>
</html>