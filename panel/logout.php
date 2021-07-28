<?php
session_start();

$_SESSION = array();
if(isset($_COOKIE[session_name()]) == true) {
    setcookie(session_name(), '', time()-42000, '/');
    setcookie('admin_id', '', time() - 3600);
    setcookie('admin_password', '', time()-3600);
}
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheets/style.css">
<meta charset="UTF-8">
</head>
<body id="login_page">
<div class="wrapper">
<h1 class="title">Logout</h1>
<div class="result_message">
ログアウトしました<br />
<br />
</div>
<div class="link_box">
<div class="logout_botton"><a href="login.php">ログインへ</a></div>
</div>
</div>
</body>
</html>