<?php
session_start();
require('api/dbconnect.php');
require('api/func.php');

login_result();

$_SESSION['num'] = 1; 
$count = 1;
$page = 0;

if(isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}
if($page == '') {
    $page = 1;
}
$page = max($page, 1);

$counts = $db->query('SELECT COUNT(*) AS cnt FROM product');
$cnt = $counts->fetch();
$maxPage = ceil($cnt['cnt'] / 6);
$page = min($page, $maxPage);

$start = ($page -1) * 6;

$product_list = $db->prepare('SELECT * FROM product LIMIT ?, 6');
$product_list->bindParam(1, $start, PDO::PARAM_INT);
$product_list->execute();
?> 
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body id="login_page">
<div class="wrapper">
<h1 class="title">List</h1>
<div class="link_box">
<div class="link_botton"><a href="cart.php">カートを見る</a></div>
<div class="link_botton"><a href="">会員情報</a></div>
<div class="link_botton"><a href="logout.php">ログアウト</a></div><br />
<br />
</div>
<div class="card_box">
<?php foreach($product_list as $list): ?>
<div class="card">
<a href="goods_view.php?id=<?php print $list['id']; ?>">
<div class="card_pic"><img class="card-img-top" src="panel/product/product_picture/<?php print $list['picture']; ?>"
style="width:250px;height:175px;"></div>
<?php print $list['name']; ?><br />
<?php print $list['price'].'円'; ?><br /></a>
</div>
<?php if($count % 3 == 0): ?>
</div>
<div class="card_box">
<?php endif; ?>
<?php  $count++;?>
<?php endforeach; ?>
</div>
<ul class="paging">
<?php if($page > 1) { ?>
<li><a href="index.php?page=<?php print($page - 1); ?>">&lt;&lt;</a></li>
<?php } else { ?>
<li>&lt;&lt;</li>
<?php } ?>
<?php for($i = 1; $i < $maxPage + 1; $i++) {?>
<?php if($i == $page) { ?>
<li class="page_count"><?php print $i; ?></li>
<?php } else { ?>
<li><a href="index.php?page=<?php print $i; ?>"><?php print $i; ?></a></li>
<?php } ?>
<?php } ?>
<?php if($page < $maxPage) { ?>
<li><a href="index.php?page=<?php print($page + 1) ?>">&gt;&gt;</a></li>
<?php } else { ?>
<li>&gt;&gt;</li>
<?php } ?>
</ul>
</div>
</body>
</html>