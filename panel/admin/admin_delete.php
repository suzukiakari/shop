<?php
session_start();

require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

$admin_data = $db->prepare('SELECT * FROM admin WHERE id = ?');
$admin_data->execute(array($_REQUEST['id']));
$data = $admin_data->fetch();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body>
<div class="wrapper">
<h1 class="title">Edit</h1>
<div class="delete_box">
<p>この管理者を削除しますか？</p>
<br />
管理者名：<?php print hsc($data['name']); ?><br />
管理者ID：<?php print hsc($data['mail']); ?><br />
<form method="post" action="admin_delete_result.php">
<input type="hidden" name="admin_id" value="<?php print hsc($data['id']); ?>">
<input type="submit" value="削除">
<input type="button" onClick="history.back()" value="戻る">
</form>
</div>
</div>
</body>
</html>
