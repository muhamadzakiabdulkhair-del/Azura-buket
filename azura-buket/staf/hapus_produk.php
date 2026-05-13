<?php
include 'koneksi.php';

$id = (int)$_GET['id'];

// Ambil gambar dulu
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM produk WHERE id='$id'"));

// Hapus file gambar jika ada
if ($row && $row['gambar'] != '' && file_exists("../admin/gambar/" . $row['gambar'])) {
    unlink("../admin/gambar/" . $row['gambar']);
}

// Hapus permanen
mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

header("Location: index.php?menu=produk");
exit;
?>
