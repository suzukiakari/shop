<?php
session_start();

require('../../api/dbconnect.php');
require('../../api/func.php');

login_admin_result();

$_SESSION['num'] += 1;
$error = '';

    $admin_data = $db->prepare('SELECT * FROM admin WHERE id = ?');
    $admin_data->execute(array($_REQUEST['id']));
    $data = $admin_data->fetch();

if($_SESSION['num'] == 3) {
    if($_POST['admin_name'] == '' || $_POST['admin_mail'] == '') {
        $data['name'] = $_POST['admin_name'];
        $data['mail'] = $_POST['admin_mail'];
        $error = 'blank';
        $_SESSION['num'] -= 1;
    } else {
        $admin_new_data = $db->prepare('UPDATE admin SET name=?, mail=? WHERE id=?');
        $admin_new_data->execute(array(
            $_POST['admin_name'],
            $_POST['admin_mail'],
            $_POST['admin_id']
        ));
        $_SESSION['num'] = 1;
        header('Location: admin_edit_result.php');
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
<h1 class="title">Edit</h1>
<form method="post" action="" class="edit_form">
<?php
if($error == 'blank') {
    print '<div class="error">＊管理者名または管理者IDを入力してください</div>';   
}
?>
管理者名<br />
<input type="text" name="admin_name" value="<?php print hsc($data['name']); ?>"><br />
<br />
管理者ID<br />
<input type="text" name="admin_mail" value="<?php print hsc($data['mail']); ?>"><br />
<br />
<input type="hidden" name="admin_id" value="<?php print hsc($data['id']); ?>">
<input type="submit" value="登録">
<input type="button" value="戻る" onClick="history.back()">
</form>
</div>
</body>
</html>
