<?php
session_start();
require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

//空の変数を変数
$admin_name = '';
$admin_id = '';
$admin_pass1 = '';
$admin_pass2 = '';
$error['name'] = '';
$error['id'] = '';
$error['pass1'] = '';
$error['pass2'] = '';

//サニタイズしてバリデーションチェック
if(!empty($_POST)) {
    $post = sanitize($_POST);
    $admin_name = $post['admin_name'];
    $admin_id = $post['admin_mail'];
    $admin_pass1 = $post['admin_pass1'];
    $admin_pass2 = $post['admin_pass2'];

    if($admin_name == '') {
        $error['name'] = 'blank';
    }
    if($admin_id == '') {
        $error['id'] = 'blank';
    }
    if($admin_pass1 == '') {
        $error['pass1'] = 'blank';
    }
    if($admin_pass2 == '') {
        $error['pass2'] = 'blank';
    }
    if($admin_pass1 != $admin_pass2) {
        $error['password'] = 'failed';
    }
    
    //エラーがなければセッションに管理者情報を入れ、admin_add_result.phpへ
    if(!in_array('blank', $error) && !in_array('failed', $error)) {
        $admin_data = $db->prepare('INSERT INTO admin SET name = ?, mail = ?, password = ?');
        $admin_data->execute(array(
            $admin_name,
            $admin_id,
            md5($admin_pass1)
        ));

        header('Location: admin_add_result.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body>
<div class="wrapper">
<h1 class="title">New</h1>
<div class="add_box">
<form method="post" action="">
<table class="add" align="center">
<tr>
<td>管理者名</td>
<td>
<?php 
if($error['name'] == 'blank') {
    print '<div class="error">＊管理者名を記入してください</div>';
}
?>
<input type="text" name="admin_name" value="<?php print hsc($admin_name); ?>">
</td>
</tr>
<tr>
<td>メールアドレス</td>
<td>
<?php
if($error['id'] == 'blank') {
    print '<div class="error">＊メールアドレスを記入してください</div>';
}
?>
<input type="text" name="admin_mail" value="<?php print hsc($admin_id); ?>">
</td>
</tr>
<tr>
<td>パスワード</td>
<td>
<?php
if($error['pass1'] == 'blank') {
    print '<div class="error">＊パスワードを記入してください</div>';
}
if($admin_pass1 != $admin_pass2) {
    print '<div class="error">＊パスワードが一致しません</div>';
}
?>
<input type="password" name="admin_pass1">
</td>
</tr>
<tr>
<td>確認用パスワード</td>
<td>
<?php
if($error['pass2'] == 'blank') {
    print '<div class="error">＊確認パスワードを記入してください</div>';
}
?>
<input type="password" name="admin_pass2">
</td>
</tr>
</table>
<input type="submit" value="登録">
<input type="button" onclick="history.back()" value="戻る">
</form>
</div>
</div>
</body>
</html>