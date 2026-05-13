<?php
include 'koneksi.php';

if (!isset($_GET['no'])) {
    die("No. transaksi tidak ditemukan.");
}

$no_transaksi = mysqli_real_escape_string($conn, $_GET['no']);

// Header transaksi
$header = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM transaksi_masuk WHERE no_transaksi = '$no_transaksi'"
));

if (!$header) {
    die("Transaksi tidak ditemukan.");
}

// Detail transaksi
$detail = mysqli_query($conn, "
    SELECT dtm.*, p.nama_produk, p.gambar, p.stok AS stok_sekarang
    FROM detail_transaksi_masuk dtm
    JOIN produk p ON dtm.id_produk = p.id
    WHERE dtm.no_transaksi = '$no_transaksi'
");
?>

<div class="container mt-4 mb-5">

    <!-- Header detail print -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="header-brand">🌸 Azura Buket</h4>
                    <p class="text-muted mb-0">Nota Penerimaan Barang</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Detail Transaksi Masuk</h5>
                    <code><?= htmlspecialchars($header['no_transaksi']) ?></code>
                </div>
            </div>
        </div>
    </div>

    <!-- Info transaksi -->
    <div class="card shadow mb-4">
        <div class="card-header text-white" style="background:#c0395e">
            <h6 class="mb-0">📋 Informasi Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <small class="text-muted d-block">No. Transaksi</small>
                    <strong><code><?= htmlspecialchars($header['no_transaksi']) ?></code></strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Tanggal & Waktu</small>
                    <strong><?= date('d/m/Y H:i', strtotime($header['tanggal'])) ?></strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Total Item</small>
                    <strong><?= $header['total_item'] ?> pcs</strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Dicatat oleh</small>
                    <strong><?= htmlspecialchars($header['created_by']) ?></strong>
                </div>
            </div>
            <?php if (!empty($header['keterangan'])): ?>
            <div class="mt-2">
                <small class="text-muted d-block">Keterangan</small>
                <strong><?= htmlspecialchars($header['keterangan']) ?></strong>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabel detail produk -->
    <div class="card shadow mb-4">
        <div class="card-header" style="background:#e8729a;color:#fff">
            <h6 class="mb-0">📦 Detail Produk Masuk</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Jumlah Masuk</th>
                            <th class="text-end">Harga Beli / pcs</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Stok Sekarang</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    $totalNilai = 0;
                    $totalQty   = 0;

                    while ($row = mysqli_fetch_assoc($detail)):
                        $subtotal    = $row['jumlah'] * $row['harga_beli'];
                        $totalNilai += $subtotal;
                        $totalQty   += $row['jumlah'];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if($row['gambar'] != ''): ?>
                                    <img src="../admin/gambar/<?= htmlspecialchars($row['gambar']) ?>"
                                         width="50" height="50"
                                         style="object-fit:cover;border-radius:6px;"
                                         onerror="this.style.display='none'">
                                <?php else: ?>
                                    <div style="width:50px;height:50px;background:#fde8ec;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:1.3rem">🌸</div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= htmlspecialchars($row['nama_produk']) ?></strong></td>
                            <td class="text-center">
                                <span class="badge bg-success fs-6">+<?= $row['jumlah'] ?></span>
                            </td>
                            <td class="text-end">
                                <?= $row['harga_beli'] > 0 ? 'Rp ' . number_format($row['harga_beli'], 0, ',', '.') : '-' ?>
                            </td>
                            <td class="text-end">
                                <?= $row['harga_beli'] > 0 ? 'Rp ' . number_format($subtotal, 0, ',', '.') : '-' ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?= $row['stok_sekarang'] > 5 ? 'success' : ($row['stok_sekarang'] > 0 ? 'warning text-dark' : 'danger') ?>">
                                    <?= $row['stok_sekarang'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                    <tfoot class="table-warning fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">TOTAL</td>
                            <td class="text-center">+<?= $totalQty ?></td>
                            <td></td>
                            <td class="text-end">
                                <?= $totalNilai > 0 ? 'Rp ' . number_format($totalNilai, 0, ',', '.') : '-' ?>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol aksi -->
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="btn btn-outline-secondary">
            🖨 Cetak / Print
        </button>
        <a href="?menu=riwayat_transaksimasuk" class="btn btn-secondary">
            ← Kembali ke Riwayat
        </a>
        <a href="?menu=transaksimasuk" class="btn" style="background:#c0395e;color:#fff">
            + Transaksi Baru
        </a>
    </div>

</div>
