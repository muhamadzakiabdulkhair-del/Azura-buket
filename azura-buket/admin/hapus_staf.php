<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM staf WHERE id='$id'");

header("Location: index.php?menu=staf");
exit;
?>
