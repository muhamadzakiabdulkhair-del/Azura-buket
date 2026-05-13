<?php
session_start();

// CEK LOGIN
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    // kalau sudah login → ke dashboard
    include 'dashboard.php';
} else {
    // kalau belum login → ke login
    include 'login.php';
}
?>
