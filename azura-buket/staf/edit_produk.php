<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan");
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
if (!$query || mysqli_num_rows($query) == 0) {
    die("Produk tidak ditemukan");
}

$row = mysqli_fetch_assoc($query);
?>

<div class="container mt-5">
    <h3>✏️ Edit Produk</h3>

    <form action="simpan_produk.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama_produk']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $row['harga'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="<?= $row['stok'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Gambar Lama</label><br>
            <?php if($row['gambar'] != ""): ?>
                <img src="../admin/gambar/<?= $row['gambar'] ?>" width="150" style="border-radius:8px;">
            <?php else: ?>
                <div style="width:80px;height:80px;background:#fde8ec;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:2rem">🌸</div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Upload Gambar Baru (optional)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        <button type="submit" name="edit" class="btn" style="background:#c0395e;color:#fff">Update Produk</button>
        <a href="index.php?menu=produk" class="btn btn-secondary">Kembali</a>
    </form>
</div>
