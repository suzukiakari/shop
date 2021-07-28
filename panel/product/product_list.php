<?php
session_start();
require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

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
$maxPage = ceil($cnt['cnt'] / 5);
$page = min($page, $maxPage);

$start = ($page -1) * 5;

$product_list = $db->prepare('SELECT * FROM product LIMIT ?, 5');
$product_list->bindParam(1, $start, PDO::PARAM_INT);
$product_list->execute();

$_SESSION['num'] = 1;
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
<div class="link_box">
<div class="link_botton"><a href="../top.php">トップへ</a></div>
<div class="link_botton"><a href="product_add.php">新規登録</a></div>
<div class="link_botton"><a href="../logout.php">ログアウト</a></div>
</div>
<table class="list" align="center">
<tr><th>画像</th><th>商品名</th><th>価格</th><th>操作</th></tr>
<?php foreach($product_list as $list): ?>
<tr>
<td><img src="product_picture/<?php print $list['picture']; ?>" style="width:300px; height=200px;"></td>
<td><?php print $list['name']; ?></td>
<td><?php print $list['price']; ?></td>
<td>
<div class="ope_link"><a href="product_view.php?id=<?php print $list['id']; ?>">詳細</a>
<a href="product_edit.php?id=<?php print $list['id']; ?>">編集</a>
<a href="product_delete.php?id=<?php print $list['id']; ?>">削除</a></div>
</td>
</tr>
<?php endforeach; ?>
</table>
<ul class="paging">
<?php if($page > 1) { ?>
<li><a href="product_list.php?page=<?php print($page - 1); ?>">&lt;&lt;</a></li>
<?php } else { ?>
<li>&lt;&lt;</li>
<?php } ?>
<?php for($i = 1; $i < $maxPage + 1; $i++) {?>
<?php if($i == $page) { ?>
<li class="page_count"><?php print $i; ?></li>
<?php } else { ?>
<li><a href="product_list.php?page=<?php print $i; ?>"><?php print $i; ?></a></li>
<?php } ?>
<?php } ?>
<?php if($page < $maxPage) { ?>
<li><a href="product_list.php?page=<?php print($page + 1) ?>">&gt;&gt;</a></li>
<?php } else { ?>
<li>&gt;&gt;</li>
<?php } ?>
</ul>
</div>
</body>
</html>