<?php
session_start();
require('../../api/func.php');

login_admin_result();
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
<p class="result">登録しました。</p>
<div class="link_box">
<div class="link_botton"><a href="product_list.php">商品管理TOPへ</a></div>
</div>
</div>
</body>
</html>