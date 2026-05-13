<?php
include "koneksi.php";
// hitung jumlah staf
$query = mysqli_query($conn, "SELECT COUNT(*) as total FROM staf WHERE role='staf'");
$data = mysqli_fetch_assoc($query);

$total_staf = $data['total'];
echo $total_staf;
?>
