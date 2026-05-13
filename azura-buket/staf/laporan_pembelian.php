<?php
include 'koneksi.php';

$tahun = $_GET['tahun'] ?? date('Y');
$tahun_sql = (int)$tahun;

// Data per bulan untuk chart
$dataBulan = [];
for ($b = 1; $b <= 12; $b++) {
    $q = mysqli_query($conn, "
        SELECT COALESCE(SUM(dtm.jumlah * dtm.harga_beli), 0) as total
        FROM transaksi_masuk tm
        JOIN detail_transaksi_masuk dtm ON tm.no_transaksi = dtm.no_transaksi
        WHERE YEAR(tm.tanggal) = $tahun_sql AND MONTH(tm.tanggal) = $b
    ");
    $row = mysqli_fetch_assoc($q);
    $dataBulan[$b] = (int)$row['total'];
}

// Filter tanggal untuk tabel
$dari   = $_GET['dari']   ?? "$tahun-01-01";
$sampai = $_GET['sampai'] ?? "$tahun-12-31";
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

// Grand total
$grandQ = mysqli_query($conn, "
    SELECT COALESCE(SUM(dtm.jumlah * dtm.harga_beli), 0) as total,
           COALESCE(SUM(dtm.jumlah), 0) as qty
    FROM transaksi_masuk tm
    JOIN detail_transaksi_masuk dtm ON tm.no_transaksi = dtm.no_transaksi
    WHERE DATE(tm.tanggal) BETWEEN '$dari_sql' AND '$sampai_sql'
");
$grandRow   = mysqli_fetch_assoc($grandQ);
$grandTotal = $grandRow['total'];
$grandQty   = $grandRow['qty'];
?>

<div class="container-fluid mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📊 Laporan Pembelian / Barang Masuk</h4>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm no-print">🖨 Cetak</button>
    </div>

    <!-- Chart Tahunan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header text-white" style="background:#c0395e">
            <div class="d-flex justify-content-between align-items-center">
                <strong>📈 Grafik Pembelian Tahun <?= $tahun ?></strong>
                <form method="GET" class="d-flex gap-2 no-print">
                    <input type="hidden" name="menu" value="laporan_pembelian">
                    <select name="tahun" class="form-select form-select-sm" style="width:100px" onchange="this.form.submit()">
                        <?php for ($y = date('Y'); $y >= date('Y') - 4; $y--): ?>
                            <option value="<?= $y ?>" <?= $y == $tahun ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body">
            <canvas id="chartPembelian" height="80"></canvas>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4 shadow-sm no-print">
        <div class="card-body py-2">
            <form method="GET" class="d-flex align-items-center gap-3 flex-wrap">
                <input type="hidden" name="menu" value="laporan_pembelian">
                <input type="hidden" name="tahun" value="<?= $tahun ?>">
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

    <!-- Ringkasan -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3" style="border-left:4px solid #c0395e">
                <div style="font-family:Georgia,serif;font-size:2rem;font-weight:700;color:#c0395e"><?= $grandQty ?></div>
                <small class="text-muted">Total Item Masuk</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3" style="border-left:4px solid #e8729a">
                <div style="font-family:Georgia,serif;font-size:1.5rem;font-weight:700;color:#c0395e">
                    Rp <?= number_format($grandTotal, 0, ',', '.') ?>
                </div>
                <small class="text-muted">Total Nilai Pembelian</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3" style="border-left:4px solid #f5c0cc">
                <?php
                $jmlTransaksi = mysqli_fetch_assoc(mysqli_query($conn,
                    "SELECT COUNT(DISTINCT no_transaksi) as total FROM transaksi_masuk
                     WHERE DATE(tanggal) BETWEEN '$dari_sql' AND '$sampai_sql'"
                ));
                ?>
                <div style="font-family:Georgia,serif;font-size:2rem;font-weight:700;color:#c0395e">
                    <?= $jmlTransaksi['total'] ?>
                </div>
                <small class="text-muted">Jumlah Transaksi</small>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0" id="tabelLaporan">
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
                    $no = 1;
                    $totalRows = 0;
                    if ($data && mysqli_num_rows($data) > 0):
                        while ($row = mysqli_fetch_assoc($data)):
                            $totalRows++;
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                            <td>
                                <a href="?menu=detail_transaksimasuk&no=<?= urlencode($row['no_transaksi']) ?>"
                                   class="text-decoration-none">
                                    <code style="font-size:11px;background:#fde8ec;padding:2px 6px;border-radius:4px">
                                        <?= htmlspecialchars($row['no_transaksi']) ?>
                                    </code>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td class="text-center fw-bold text-success">+<?= $row['jumlah'] ?></td>
                            <td class="text-end">Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                            <td class="text-end">Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['created_by']) ?></td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Tidak ada data pada periode ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                    <?php if ($grandTotal > 0): ?>
                    <tfoot class="table-warning fw-bold">
                        <tr>
                            <td colspan="4" class="text-end">TOTAL</td>
                            <td class="text-center text-success">+<?= $grandQty ?></td>
                            <td></td>
                            <td class="text-end">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    $('#tabelLaporan').DataTable({
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

// CHART
const ctx = document.getElementById('chartPembelian').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{
            label: 'Total Pembelian (Rp)',
            data: [<?= implode(',', $dataBulan) ?>],
            backgroundColor: 'rgba(192, 57, 94, 0.3)',
            borderColor: '#c0395e',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        return 'Rp ' + ctx.raw.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(v) {
                        return 'Rp ' + (v >= 1000000
                            ? (v/1000000).toFixed(1) + 'jt'
                            : v.toLocaleString('id-ID'));
                    }
                }
            }
        }
    }
});
</script>
