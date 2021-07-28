<?php
session_start();

require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

$admin_list = $db->query('SELECT * FROM admin WHERE 1');
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
<h1 class="title">MemberList</h1>
<div class="link_box">
<div class="link_botton"><a href="../top.php">トップへ</a></div>
<div class="link_botton"><a href="admin_add.php">新規登録</a></div>
<div class="link_botton"><a href="../logout.php">ログアウト</a></div>
</div>
<table class="list" align="center">
<tr>
<th>管理者名</th><th>管理者ID</th><th>操作</th>
</tr>
<?php foreach($admin_list as $list): ?>
    <tr>
    <td><?php print $list['name']; ?></td>
    <td><?php print $list['mail']; ?></td>
    <td>
    <div class="ope_link"><a href="admin_edit.php?id=<?php print $list['id']; ?>">編集</a>
    <a href="admin_delete.php?id=<?php print $list['id']; ?>">削除</a></div>
    </td>
    </tr>
<?php endforeach; ?>
</table>
</div>
</body>
</html>
