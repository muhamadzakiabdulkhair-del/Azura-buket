<?php
include 'koneksi.php';

$dari   = $_GET['dari']   ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');

$dari_sql   = mysqli_real_escape_string($conn, $dari);
$sampai_sql = mysqli_real_escape_string($conn, $sampai);

// Laporan penjualan dari tabel produk & transaksi
// Karena tidak ada tabel penjualan terpisah di kedaikopi,
// kita pakai data stok yang keluar (stok awal - stok sekarang dari transaksi masuk)
$data = mysqli_query($conn, "
    SELECT p.nama_produk, p.harga, p.stok,
           COALESCE(SUM(dtm.jumlah),0) AS total_masuk
    FROM produk p
    LEFT JOIN detail_transaksi_masuk dtm ON dtm.id_produk = p.id
    LEFT JOIN transaksi_masuk tm ON tm.no_transaksi = dtm.no_transaksi
        AND DATE(tm.tanggal) BETWEEN '$dari_sql' AND '$sampai_sql'
    GROUP BY p.id
    ORDER BY p.nama_produk
");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>💰 Laporan Penjualan / Produk Terjual</h3>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">🖨 Cetak</button>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-body py-2">
        <form method="GET" class="d-flex align-items-center gap-3 flex-wrap">
            <input type="hidden" name="menu" value="laporan_penjualan">
            <div class="d-flex align-items-center gap-2">
                <label class="mb-0 fw-semibold">Dari:</label>
                <input type="date" name="dari" class="form-control form-control-sm" style="width:160px" value="<?= $dari ?>">
            </div>
            <div class="d-flex align-items-center gap-2">
                <label class="mb-0 fw-semibold">Sampai:</label>
                <input type="date" name="sampai" class="form-control form-control-sm" style="width:160px" value="<?= $sampai ?>">
            </div>
            <button type="submit" class="btn btn-sm" style="background:#c0395e;color:#fff">🔍 Filter</button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered table-striped mb-0" id="tabelLapJual">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th class="text-end">Harga Jual</th>
                    <th class="text-center">Stok Masuk (Periode)</th>
                    <th class="text-center">Stok Saat Ini</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                    <td class="text-end">Rp <?= number_format($row['harga'],0,',','.') ?></td>
                    <td class="text-center fw-bold text-success">+<?= $row['total_masuk'] ?></td>
                    <td class="text-center">
                        <span class="badge bg-<?= $row['stok']<=0?'danger':($row['stok']<=5?'warning text-dark':'success') ?>">
                            <?= $row['stok'] ?>
                        </span>
                    </td>
                    <td>
                        <?php if($row['stok']<=0): ?>
                            <span class="badge bg-danger">Habis</span>
                        <?php elseif($row['stok']<=5): ?>
                            <span class="badge bg-warning text-dark">Hampir Habis</span>
                        <?php else: ?>
                            <span class="badge bg-success">Tersedia</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#tabelLapJual').DataTable({
        pageLength: 10,
        language: {
            search: "🔍 Cari:", lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { next: "Next", previous: "Prev" }
        }
    });
});
</script>
