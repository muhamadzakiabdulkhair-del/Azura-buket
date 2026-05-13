<?php
include "koneksi.php";

$id       = $_POST['id'];
$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];
$no_hp    = $_POST['no_hp'] ?? '';

// kalau password diisi
if (!empty($password)) {
    $password = md5($password);

    $query = "UPDATE staf SET
        nama='$nama',
        username='$username',
        password='$password',
        role='$role',
        no_hp='$no_hp'
        WHERE id='$id'
    ";
} else {
    // kalau password kosong → jangan diubah
    $query = "UPDATE staf SET
        nama='$nama',
        username='$username',
        role='$role',
        no_hp='$no_hp'
        WHERE id='$id'
    ";
}

$result = mysqli_query($conn, $query);

if(!$result){
    die("Query Error: " . mysqli_error($conn));
}

header("Location: index.php?menu=staf");
exit;
?>
