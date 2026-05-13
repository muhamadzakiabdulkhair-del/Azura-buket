<?php
session_start();

// CEK LOGIN
if (isset($_SESSION['login'])) {

    if ($_SESSION['role'] == 'admin') {
        include 'dashboard.php';
    } elseif ($_SESSION['role'] == 'staf') {
        include 'dashboard.php';
    } elseif ($_SESSION['role'] == 'pemilik') {
        include 'dashboard.php';
    } else {
        include 'login.php';
    }

} else {
    include 'login.php';
}
?>
