<?php

function sanitize($before) {
    foreach($before as $key=>$value) {
        $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $after;
}
function hsc($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
function login_result() {
    if(!isset($_SESSION['member_id']) && $_SESSION['time'] + 3600 < time()) {
        header('Location: login.php');
        exit();
    }
}
function login_admin_result() {
    if(!isset($_SESSION['adminId']) && $_SESSION['time'] + 3600 < time()) {
        header('Location: ../login.php');
        exit();
    }
}
?>