<?php
require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();
//サニタイズ
$post = sanitize($_POST);
$admin_id = $post['admin_id'];

//データベースに接続し管理者を削除
$admin_delete = $db->prepare('DELETE FROM admin WHERE id = ?');
$admin_delete->execute(array($admin_id));
$delete = $admin_delete->fetch();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body>
<div class="wrapper">
<h1 class="title">Login</h1>
<p class="result">削除しました。</p>
<div class="link_box">
<div class="link_botton"><a href="admin_list.php">管理者TOPへ</a></div>
</div>
</div>
</body>
</html>
