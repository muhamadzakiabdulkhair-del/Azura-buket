<?php
include "koneksi.php";

// Jika tombol tambah diklik
if (isset($_POST['tambah'])) {

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];
    $namaBaru = "";

    // cek upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != '') {
        $upload   = $_FILES['gambar'];
        $tmp      = $upload['tmp_name'];
        $namaFile = $upload['name'];

        $targetDir = "../admin/gambar/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $namaBaru = time() . "_" . $namaFile;

        if (!move_uploaded_file($tmp, $targetDir . $namaBaru)) {
            die("Gagal upload file!");
        }
    }

    $sql = "INSERT INTO produk (nama_produk, harga, stok, gambar)
            VALUES ('$nama', '$harga', '$stok', '$namaBaru')";

    if (!mysqli_query($conn, $sql)) {
        die("Error tambah produk: " . mysqli_error($conn));
    }

    header("Location: index.php?menu=produk");
    exit;
}

// Jika tombol edit diklik
if (isset($_POST['edit'])) {

    $id          = $_POST['id'];
    $nama        = $_POST['nama'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $gambar_lama = $_POST['gambar_lama'];
    $namaBaru    = $gambar_lama;

    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != '') {
        $upload   = $_FILES['gambar'];
        $tmp      = $upload['tmp_name'];
        $namaFile = $upload['name'];

        $targetDir = "../admin/gambar/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $namaBaru = time() . "_" . $namaFile;

        if (!move_uploaded_file($tmp, $targetDir . $namaBaru)) {
            die("Gagal upload file!");
        }

        if ($gambar_lama != "" && file_exists($targetDir . $gambar_lama)) {
            unlink($targetDir . $gambar_lama);
        }
    }

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
