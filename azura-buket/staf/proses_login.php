<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);
$captcha_input = $_POST['captcha'];

// CEK CAPTCHA
if ($captcha_input != $_SESSION['captcha']) {
    echo "<script>
        alert('Captcha salah');
        window.location.href='login.php';
    </script>";
    exit;
}

// CEK LOGIN
$query = mysqli_query($conn, "SELECT * FROM staf WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {

    $data = mysqli_fetch_assoc($query);

    $_SESSION['login'] = true;
    $_SESSION['username'] = $data['username'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['role'] = $data['role'];

    echo "<script>
        alert('Login berhasil');
        window.location.href='index.php';
    </script>";

} else {

    echo "<script>
        alert('Username atau password salah');
        window.location.href='login.php';
    </script>";

}
?>
