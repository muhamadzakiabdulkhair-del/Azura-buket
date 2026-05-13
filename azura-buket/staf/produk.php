<?php
include 'koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM produk");
?>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📦 Data Produk</h3>
        <button onclick="history.back()" class="btn btn-secondary">← Kembali</button>
    </div>

    <a href="?menu=tambah_produk" class="btn mb-3" style="background:#c0395e;color:#fff">+ Tambah Produk</a>

    <table class="table table-bordered table-striped" id="tabelProduk">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php $no=1; while($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <?php if($row['gambar'] != ''): ?>
                        <img src="../admin/gambar/<?= $row['gambar'] ?>" width="80" style="border-radius:6px;">
                    <?php else: ?>
                        <div style="width:60px;height:60px;background:#fde8ec;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:1.5rem">🌸</div>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                <td>Rp <?= number_format($row['harga']) ?></td>
                <td><?= $row['stok'] ?></td>
                <td>
                    <a href="?menu=edit_produk&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_produk.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>

</div>

<script>
$(document).ready(function() {
    $('#tabelProduk').DataTable({
        "pageLength": 5,
        "lengthMenu": [[5, 10, 25, 50],[5, 10, 25, 50]],
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "paginate": { "next": "Next", "previous": "Prev" }
        }
    });
});
</script>
