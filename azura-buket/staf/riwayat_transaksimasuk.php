<?php
include 'koneksi.php';

// Filter tanggal
$dari   = $_GET['dari']   ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');

$dari_sql   = mysqli_real_escape_string($conn, $dari);
$sampai_sql = mysqli_real_escape_string($conn, $sampai);

$data = mysqli_query($conn, "
    SELECT tm.*,
           COUNT(dtm.id) as jumlah_item,
           SUM(dtm.jumlah) as total_qty,
           SUM(dtm.jumlah * dtm.harga_beli) as total_nilai
    FROM transaksi_masuk tm
    LEFT JOIN detail_transaksi_masuk dtm ON tm.no_transaksi = dtm.no_transaksi
    WHERE DATE(tm.tanggal) BETWEEN '$dari_sql' AND '$sampai_sql'
    GROUP BY tm.no_transaksi
    ORDER BY tm.tanggal DESC
");
?>

<div class="container-fluid mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📋 Riwayat Transaksi Barang Masuk</h4>
        <div>
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm me-2">🖨 Cetak</button>
            <a href="?menu=transaksimasuk" class="btn btn-sm" style="background:#c0395e;color:#fff">+ Transaksi Baru</a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body py-2">
            <form method="GET" class="d-flex align-items-center gap-3 flex-wrap">
                <input type="hidden" name="menu" value="riwayat_transaksimasuk">
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 fw-semibold">Dari:</label>
                    <input type="date" name="dari" class="form-control form-control-sm" style="width:160px" value="<?= $dari ?>">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 fw-semibold">Sampai:</label>
                    <input type="date" name="sampai" class="form-control form-control-sm" style="width:160px" value="<?= $sampai ?>">
                </div>
                <button type="submit" class="btn btn-sm" style="background:#c0395e;color:#fff">🔍 Filter</button>
                <a href="?menu=riwayat_transaksimasuk" class="btn btn-outline-secondary btn-sm">Reset</a>
            </form>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0" id="tabelRiwayat">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No. Transaksi</th>
                            <th class="text-center">Jenis Produk</th>
                            <th class="text-center">Total Qty Masuk</th>
                            <th class="text-end">Total Nilai</th>
                            <th>Keterangan</th>
                            <th>Petugas</th>
                            <th class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    $grandTotal = 0;
                    $grandQty   = 0;

                    if ($data && mysqli_num_rows($data) > 0):
                        while ($row = mysqli_fetch_assoc($data)):
                            $grandTotal += $row['total_nilai'];
                            $grandQty   += $row['total_qty'];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['tanggal'])) ?></td>
                            <td>
                                <code style="font-size:11px;background:#fde8ec;padding:2px 6px;border-radius:4px">
                                    <?= htmlspecialchars($row['no_transaksi']) ?>
                                </code>
                            </td>
                            <td class="text-center"><?= $row['jumlah_item'] ?> jenis</td>
                            <td class="text-center">
                                <span class="badge bg-success">+<?= $row['total_qty'] ?></span>
                            </td>
                            <td class="text-end">Rp <?= number_format($row['total_nilai'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars(substr($row['keterangan'] ?? '-', 0, 40)) ?></td>
                            <td><?= htmlspecialchars($row['created_by']) ?></td>
                            <td class="text-center">
                                <a href="?menu=detail_transaksimasuk&no=<?= urlencode($row['no_transaksi']) ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    🔍 Detail
                                </a>
                            </td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Tidak ada transaksi pada periode ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                    <?php if ($grandTotal > 0): ?>
                    <tfoot class="table-warning fw-bold">
                        <tr>
                            <td colspan="4" class="text-end">TOTAL</td>
                            <td class="text-center">+<?= $grandQty ?></td>
                            <td class="text-end">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {
    $('#tabelRiwayat').DataTable({
        pageLength: 10,
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { next: "Next", previous: "Prev" }
        }
    });
});
</script>
