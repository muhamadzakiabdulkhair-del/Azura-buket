<?php
include 'koneksi.php';

$id = (int)$_GET['id'];

// Ambil nama gambar dulu sebelum dihapus
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM produk WHERE id='$id'"));

// Hapus file gambar jika ada
if ($row && $row['gambar'] != '' && file_exists("gambar/" . $row['gambar'])) {
    unlink("gambar/" . $row['gambar']);
}

// Hapus permanen dari database
mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

header("Location: index.php?menu=produk&msg=hapus");
exit;
?>
