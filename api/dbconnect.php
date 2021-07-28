<?php
try {
    $db = new PDO('mysql:dbname=hamorudo_shop;host=mysql57.hamorudo.sakura.ne.jp;charset=utf8', 'hamorudo', 'Afb0afb0');
} catch (PDOException $e) {
    echo 'DB接続エラー：'. $e->getMessage();
}
?>