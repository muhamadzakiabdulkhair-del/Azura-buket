<?php
include 'koneksi.php';

$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$role     = $_POST['role'];
$no_hp    = $_POST['no_hp'] ?? '';

mysqli_query($conn, "INSERT INTO staf
(nama, username, password, role, no_hp)
VALUES
('$nama',
'$username',
'$password',
'$role',
'$no_hp'
)");

header("Location: index.php?menu=staf");
exit;
?>
