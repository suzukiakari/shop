<?php
session_start();
require('../api/dbconnect.php');
require('../api/func.php');

$id = '';
$password = '';
$error = '';

if(isset($_COOKIE['admin_id'])) {
  $_POST['id'] = $_COOKIE['admin_id'];
  $_POST['password'] = $_COOKIE['admin_password'];
  $_POST['save'] = 'on';
}

//フォームの値を変数に代入
if(!empty($_POST)) {
  $post = sanitize($_POST);    
  $id = $post['id'];
  $password = $post['password'];

//フォームの値が空でないかチェック
if($id != '' && $password != '') {
    //バリデーションチェックがOKだった場合、データベースに繋げて照合
    $login = $db->prepare('SELECT id, mail, password FROM admin WHERE mail = ? AND password = ?');
    $login->execute(array(
        $id,
        md5($_POST['password'])
    ));
    $resultAdmin = $login->fetch();
    if($resultAdmin) {
      if($_POST['save'] == 'on') {
        setcookie('admin_id', $_POST['id'], time()+60*60*24*14);
        setcookie('admin_password', $_POST['password'], time()+60*60*24*14);
      }
      $_SESSION['adminId'] = $resultAdmin['id'];
      $_SESSION['time'] = time();
      header('Location: top.php');
      exit();
    } else {
      $error = 'failed';
    }
  } else {
    $error = 'blank';
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
<div class="login_box">
<h1 class="title">Login</h1>
<form method="post" action="">
<?php
//入力内容が空であればメッセージを表示
if($error == 'failed') {
  print '<div class="error">＊管理IDもしくはパスワードが違います</div>';
}
if($error == 'blank') {
  print '<div class="error">＊入力内容が空の項目があります。</div>';
}
//入力内容がデータベースに存在しなければメッセージを表示
?>
管理者ID<br />
<input type="text" name="id" value="kfsa_luv3.7@icloud.com<?php //print $id; ?>"><br />
<br />
パスワード<br />
<input type="password" name="password" value="Afb0afb0"><br />
<br />
<input type="submit" value="ログイン"><br /><br />
<input type="checkbox" name="save"><small>ログイン情報を保存する</small>
</form>
</div>
</div>
</body>
</html>