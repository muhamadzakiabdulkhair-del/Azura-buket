<?php
include "koneksi.php";

if (isset($_POST['edit'])) {

    $id    = $_POST['id'];
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];
    $gambar_lama = $_POST['gambar_lama'];

    // default pakai gambar lama
    $namaBaru = $gambar_lama;

    // cek upload gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != '') {

        $upload = $_FILES['gambar'];
        $tmp = $upload['tmp_name'];
        $namaFile = $upload['name'];

        // buat folder jika belum ada
        if (!is_dir("gambar")) {
            mkdir("gambar", 0777, true);
        }

        // beri nama unik
        $namaBaru = time() . "_" . $namaFile;

        // pindahkan file baru
        if (!move_uploaded_file($tmp, "gambar/" . $namaBaru)) {
            die("Gagal upload file!");
        }

        // hapus file lama jika ada
        if ($gambar_lama != "" && file_exists("gambar/" . $gambar_lama)) {
            unlink("gambar/" . $gambar_lama);
        }
    }

    // update database
    $sql = "UPDATE produk SET
        nama_produk='$nama',
        harga='$harga',
        stok='$stok',
        gambar='$namaBaru'
        WHERE id='$id'";

    if (!mysqli_query($conn, $sql)) {
        die("Error update: " . mysqli_error($conn));
    }

    header("Location: index.php?menu=produk");
    exit;
}
?>
