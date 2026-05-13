<?php
include "koneksi.php";
// hitung jumlah produk
$query = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
$data = mysqli_fetch_assoc($query);

$total_produk = $data['total'];
echo $total_produk;
?>
