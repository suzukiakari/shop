<?php
session_start();
require('api/dbconnect.php');
require('api/func.php');

login_result();

$cart = $_SESSION['cart'];
$count = $_SESSION['count'];
$max = count($cart);

$lock_sql = $db->prepare('LOCK TABLES sales WRITE, product_sales WRITE');
$lock_sql->execute();

$sales_data = $db->prepare('INSERT INTO sales SET member_id = ?');
$sales_data->execute(array($_SESSION['member_id']));

$sql = $db->prepare('SELECT LAST_INSERT_ID()');
$sql->execute();
$rec = $sql->fetch();
$last_code = $rec['LAST_INSERT_ID()'];

for($i = 0; $i < $max; $i++) {
    $product_sales_data = $db->prepare('INSERT INTO product_sales SET sales_id=?,
    product_id=?, count=?');
    $product_sales_data->execute(array(
        $last_code,
        $cart[$i],
        $count[$i]
    ));
}
$unlock_sql = $db->prepare('UNLOCK TABLES');
$unlock_sql->execute();

$text = '';

//会員情報を持ってくる
$member_data = $db->prepare('SELECT * FROM member WHERE id = ?');
$member_data->execute(array($_SESSION['member_id']));
$member_rec = $member_data->fetch();
$text .= $member_rec['name']."ご注文ありがとうございます。\n";

//商品のデータを数分持ってくる
$text .= "------------ご注文の商品------------\n";
for($i = 0; $i < $max; $i++) {
    $product_data = $db->prepare('SELECT * FROM product WHERE id = ?');
    $product_data->execute(array($cart[$i]));
    $product_rec = $product_data->fetch();
    $text .= "・".$product_rec['name']."\n";
    $text .= $product_rec['price']." × ".$count[$i]."\n";
    $text .= "\n";
}
$text .= "-----------------------------------\n";
$text .= "お届け先\n";
$text .= $member_rec['post1']."-".$member_rec['post2']."\n";
$text .= $member_rec['address']."\n";

// $title = 'ご注文ありがとうございます';
// $header = 'From:suzuki.akari@acrovision.jp';
// $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
// mb_language('Japanese');
// mb_internal_encoding('UTF-8');
// mb_send_mail('kfsa_luv3.7@icloud.com', $title, $text, $header);

// $title = 'ご注文の承り';
// $header = 'From:kfsa_luv3.7@icloud.com';
// $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
// mb_language('Japanese');
// mb_internal_encoding('UTF-8');
// mb_send_mail('suzuki.akari.acrovision@gmail.com', $title, $text, $header);

unset($_SESSION["cart"]);
unset($_SESSION["count"]);
unset($_SESSION["num"]);
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
購入が完了しました。
ご請求金額の振込が確認でき次第、<br />
商品を発送させていただきます。
詳しくはメールをご覧ください
</div>
<br />
<div class="link_box">
<div class="link_botton"><a href="index.php">トップへ</a></div>
</div>
</div>
</body>
</html>