<?php
include 'koneksi.php';

$dari   = $_GET['dari']   ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');

$dari_sql   = mysqli_real_escape_string($conn, $dari);
$sampai_sql = mysqli_real_escape_string($conn, $sampai);

$data = mysqli_query($conn, "
    SELECT tm.no_transaksi, tm.tanggal, tm.keterangan, tm.created_by,
           p.nama_produk, dtm.jumlah, dtm.harga_beli,
           (dtm.jumlah * dtm.harga_beli) AS subtotal
    FROM transaksi_masuk tm
    JOIN detail_transaksi_masuk dtm ON tm.no_transaksi = dtm.no_transaksi
    JOIN produk p ON dtm.id_produk = p.id
    WHERE DATE(tm.tanggal) BETWEEN '$dari_sql' AND '$sampai_sql'
    ORDER BY tm.tanggal DESC
");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📊 Laporan Pembelian / Barang Masuk</h3>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">🖨 Cetak</button>
</div>

<!-- Filter -->
<div class="card mb-4 shadow-sm">
    <div class="card-body py-2">
        <form method="GET" class="d-flex align-items-center gap-3 flex-wrap">
            <input type="hidden" name="menu" value="laporan_pembelian">
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
        <table class="table table-bordered table-striped mb-0" id="tabelLapPembelian">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No. Transaksi</th>
                    <th>Produk</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-end">Harga Beli</th>
                    <th class="text-end">Subtotal</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no=1; $grandTotal=0; $totalItem=0;
            if($data && mysqli_num_rows($data)>0):
                while($row = mysqli_fetch_assoc($data)):
                    $grandTotal += $row['subtotal'];
                    $totalItem  += $row['jumlah'];
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                    <td><code style="font-size:11px"><?= $row['no_transaksi'] ?></code></td>
                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                    <td class="text-center fw-bold text-success">+<?= $row['jumlah'] ?></td>
                    <td class="text-end">Rp <?= number_format($row['harga_beli'],0,',','.') ?></td>
                    <td class="text-end">Rp <?= number_format($row['subtotal'],0,',','.') ?></td>
                    <td><?= htmlspecialchars($row['created_by']) ?></td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data pada periode ini.</td></tr>
            <?php endif; ?>
            </tbody>
            <?php if($grandTotal > 0): ?>
            <tfoot class="table-warning fw-bold">
                <tr>
                    <td colspan="4" class="text-end">TOTAL</td>
                    <td class="text-center">+<?= $totalItem ?></td>
                    <td></td>
                    <td class="text-end">Rp <?= number_format($grandTotal,0,',','.') ?></td>
                    <td></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#tabelLapPembelian').DataTable({
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
