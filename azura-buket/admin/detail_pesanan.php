<?php
include 'koneksi.php';

if (!isset($_GET['no'])) {
    header("Location: index.php?menu=pesanan"); exit;
}

$no_e    = mysqli_real_escape_string($conn, $_GET['no']);
$pesanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pesanan WHERE no_pesanan='$no_e'"));
if (!$pesanan) { echo '<div class="alert alert-danger">Pesanan tidak ditemukan.</div>'; exit; }

$detail  = [];
$q = mysqli_query($conn, "
    SELECT dp.*, p.gambar
    FROM detail_pesanan dp
    LEFT JOIN produk p ON p.id = dp.id_produk
    WHERE dp.no_pesanan='$no_e'
");
while ($r = mysqli_fetch_assoc($q)) $detail[] = $r;
$total = array_sum(array_column($detail, 'subtotal'));

$badgeClass = [
    'pending'    => 'bg-warning text-dark',
    'diproses'   => 'bg-primary',
    'selesai'    => 'bg-success',
    'dibatalkan' => 'bg-danger',
];
$bc = $badgeClass[$pesanan['status']] ?? 'bg-secondary';
?>

<style>
@media print { .no-print { display:none !important; } }
.brand-header { font-family: Georgia, serif; font-weight:700; color:#c0395e; }
</style>

<!-- Print header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="brand-header mb-0">🌸 Azura Buket</h4>
        <small class="text-muted">Nota Pesanan Website</small>
    </div>
    <div class="text-end">
        <span class="badge <?= $bc ?> fs-6"><?= ucfirst($pesanan['status']) ?></span><br>
        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($pesanan['created_at'])) ?></small>
    </div>
</div>

<!-- Info pesanan -->
<div class="card shadow-sm mb-4">
    <div class="card-header text-white" style="background:#c0395e">
        <strong>📋 Informasi Pesanan — <?= htmlspecialchars($pesanan['no_pesanan']) ?></strong>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted" style="width:140px">No. Pesanan</td>
                        <td><strong><?= htmlspecialchars($pesanan['no_pesanan']) ?></strong></td></tr>
                    <tr><td class="text-muted">Nama Pemesan</td>
                        <td><strong><?= htmlspecialchars($pesanan['nama']) ?></strong></td></tr>
                    <tr><td class="text-muted">No. WhatsApp</td>
                        <td>
                            <a href="https://wa.me/62<?= ltrim($pesanan['no_hp'],'0') ?>"
                               target="_blank" class="text-success text-decoration-none fw-semibold">
                               📱 <?= htmlspecialchars($pesanan['no_hp']) ?>
                            </a>
                        </td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted" style="width:140px">Tanggal</td>
                        <td><?= date('d/m/Y H:i', strtotime($pesanan['created_at'])) ?></td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td><span class="badge <?= $bc ?>"><?= ucfirst($pesanan['status']) ?></span></td></tr>
                    <?php if (!empty($pesanan['metode_bayar'])): ?>
                    <tr><td class="text-muted">Metode Bayar</td>
                        <td><?= htmlspecialchars($pesanan['metode_bayar']) ?></td></tr>
                    <?php endif; ?>
                </table>
            </div>
            <?php if (!empty($pesanan['alamat'])): ?>
            <div class="col-12">
                <div class="text-muted small mb-1">Alamat Pengiriman</div>
                <div class="p-2 rounded" style="background:#fdf6f0;font-size:.88rem">
                    <?= nl2br(htmlspecialchars($pesanan['alamat'])) ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($pesanan['catatan'])): ?>
            <div class="col-12">
                <div class="text-muted small mb-1">Catatan / Pesan Kartu</div>
                <div class="p-2 rounded" style="background:#fde8ec;border:1px solid #f5c0cc;font-size:.88rem">
                    <?= nl2br(htmlspecialchars($pesanan['catatan'])) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Detail produk -->
<div class="card shadow-sm mb-4">
    <div class="card-header" style="background:#e8729a;color:#fff">
        <strong>📦 Detail Produk Dipesan</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th><th>Gambar</th><th>Nama Produk</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; foreach ($detail as $d): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <?php if (!empty($d['gambar'])): ?>
                        <img src="gambar/<?= htmlspecialchars($d['gambar']) ?>"
                             width="50" height="50" style="object-fit:cover;border-radius:6px">
                    <?php else: ?>
                        <div style="width:50px;height:50px;background:#fde8ec;border-radius:6px;display:flex;align-items:center;justify-content:center">🌸</div>
                    <?php endif; ?>
                </td>
                <td><strong><?= htmlspecialchars($d['nama_produk']) ?></strong></td>
                <td class="text-center"><?= $d['jumlah'] ?></td>
                <td class="text-end">Rp <?= number_format($d['harga'],0,',','.') ?></td>
                <td class="text-end fw-bold" style="color:#c0395e">Rp <?= number_format($d['subtotal'],0,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot class="table-warning fw-bold">
                <tr>
                    <td colspan="5" class="text-end">Total</td>
                    <td class="text-end" style="color:#c0395e">Rp <?= number_format($total,0,',','.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Aksi -->
<div class="d-flex gap-2 flex-wrap no-print">
    <?php if ($pesanan['status'] === 'pending'): ?>
        <a href="index.php?menu=pesanan&set_status=diproses&no=<?= urlencode($pesanan['no_pesanan']) ?>"
           class="btn btn-primary" onclick="return confirm('Ubah ke Diproses?')">⚙️ Proses Pesanan</a>
    <?php endif; ?>
    <?php if (in_array($pesanan['status'], ['pending','diproses'])): ?>
        <a href="index.php?menu=pesanan&set_status=selesai&no=<?= urlencode($pesanan['no_pesanan']) ?>"
           class="btn btn-success" onclick="return confirm('Tandai Selesai?')">✅ Selesai</a>
        <a href="index.php?menu=pesanan&set_status=dibatalkan&no=<?= urlencode($pesanan['no_pesanan']) ?>"
           class="btn btn-danger" onclick="return confirm('Batalkan pesanan?')">❌ Batalkan</a>
    <?php endif; ?>
    <a href="https://wa.me/62<?= ltrim($pesanan['no_hp'],'0') ?>?text=Halo%20<?= urlencode($pesanan['nama']) ?>%2C%20pesanan%20Anda%20nomor%20<?= urlencode($pesanan['no_pesanan']) ?>%20%F0%9F%8C%B8"
       target="_blank" class="btn btn-success">📱 Hubungi via WA</a>
    <button onclick="window.print()" class="btn btn-outline-secondary">🖨 Cetak Nota</button>
    <a href="index.php?menu=pesanan" class="btn btn-secondary">← Kembali</a>
</div>
