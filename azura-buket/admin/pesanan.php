<?php
include 'koneksi.php';

// Handle update status
if (isset($_GET['set_status']) && isset($_GET['no'])) {
    $no  = mysqli_real_escape_string($conn, $_GET['no']);
    $st  = in_array($_GET['set_status'], ['pending','diproses','selesai','dibatalkan'])
           ? $_GET['set_status'] : 'pending';
    mysqli_query($conn, "UPDATE pesanan SET status='$st' WHERE no_pesanan='$no'");
    header("Location: index.php?menu=pesanan&msg=$st");
    exit;
}

// Filter
$filter_status = $_GET['status'] ?? '';
$where = '';
if ($filter_status && in_array($filter_status, ['pending','diproses','selesai','dibatalkan'])) {
    $where = "WHERE p.status = '$filter_status'";
}

$data = mysqli_query($conn, "
    SELECT p.*,
           COUNT(dp.id)      AS jml_item,
           SUM(dp.subtotal)  AS total
    FROM pesanan p
    LEFT JOIN detail_pesanan dp ON dp.no_pesanan = p.no_pesanan
    $where
    GROUP BY p.no_pesanan
    ORDER BY p.created_at DESC
");

// Hitung per status
$countStatus = [];
foreach (['pending','diproses','selesai','dibatalkan'] as $st) {
    $q = mysqli_query($conn, "SELECT COUNT(*) c FROM pesanan WHERE status='$st'");
    $countStatus[$st] = mysqli_fetch_assoc($q)['c'] ?? 0;
}
?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h3>🛍️ Pesanan dari Website</h3>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">🖨 Cetak</button>
</div>

<?php if (isset($_GET['msg'])): ?>
<div class="alert alert-success alert-dismissible fade show">
    ✅ Status pesanan berhasil diubah ke <strong><?= ucfirst($_GET['msg']) ?></strong>.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Kartu ringkasan status -->
<div class="row g-3 mb-4">
    <?php
    $stColors = [
        'pending'    => ['warning','⏳'],
        'diproses'   => ['primary','⚙️'],
        'selesai'    => ['success','✅'],
        'dibatalkan' => ['danger', '❌'],
    ];
    foreach ($stColors as $st => [$color, $ico]):
    ?>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3" style="border-left:4px solid var(--bs-<?= $color ?>)">
            <div style="font-size:1.5rem"><?= $ico ?></div>
            <div style="font-family:Georgia,serif;font-size:2rem;font-weight:700;color:#c0395e">
                <?= $countStatus[$st] ?>
            </div>
            <small class="text-muted"><?= ucfirst($st) ?></small>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Filter status -->
<div class="mb-3 d-flex gap-2 flex-wrap">
    <a href="index.php?menu=pesanan" class="btn btn-sm <?= !$filter_status ? 'btn-dark' : 'btn-outline-secondary' ?>">
        Semua (<?= array_sum($countStatus) ?>)
    </a>
    <?php foreach ($stColors as $st => [$color, $ico]): ?>
    <a href="index.php?menu=pesanan&status=<?= $st ?>"
       class="btn btn-sm btn-<?= $filter_status===$st ? $color : "outline-$color" ?>">
        <?= $ico ?> <?= ucfirst($st) ?> (<?= $countStatus[$st] ?>)
    </a>
    <?php endforeach; ?>
</div>

<!-- Tabel pesanan -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0" id="tabelPesanan">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>No. Pesanan</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th class="text-center">Item</th>
                        <th class="text-end">Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $badgeClass = [
                    'pending'    => 'bg-warning text-dark',
                    'diproses'   => 'bg-primary',
                    'selesai'    => 'bg-success',
                    'dibatalkan' => 'bg-danger',
                ];
                if ($data && mysqli_num_rows($data) > 0):
                    while ($row = mysqli_fetch_assoc($data)):
                        $bc = $badgeClass[$row['status']] ?? 'bg-secondary';
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <a href="index.php?menu=detail_pesanan&no=<?= urlencode($row['no_pesanan']) ?>"
                           style="font-size:11px;background:#fde8ec;padding:2px 7px;border-radius:4px;color:#c0395e;text-decoration:none;font-weight:600">
                            <?= htmlspecialchars($row['no_pesanan']) ?>
                        </a>
                    </td>
                    <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                    <td>
                        <a href="https://wa.me/62<?= ltrim($row['no_hp'],'0') ?>"
                           target="_blank" class="text-decoration-none text-success fw-semibold">
                            📱 <?= htmlspecialchars($row['no_hp']) ?>
                        </a>
                    </td>
                    <td class="text-center"><?= $row['jml_item'] ?> item</td>
                    <td class="text-end">Rp <?= number_format($row['total'] ?? 0, 0, ',', '.') ?></td>
                    <td><span class="badge <?= $bc ?>"><?= ucfirst($row['status']) ?></span></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                    <td class="text-center" style="white-space:nowrap">
                        <?php if ($row['status'] === 'pending'): ?>
                            <a href="index.php?menu=pesanan&set_status=diproses&no=<?= urlencode($row['no_pesanan']) ?>"
                               class="btn btn-primary btn-sm"
                               onclick="return confirm('Ubah ke Diproses?')">⚙️</a>
                        <?php endif; ?>
                        <?php if (in_array($row['status'], ['pending','diproses'])): ?>
                            <a href="index.php?menu=pesanan&set_status=selesai&no=<?= urlencode($row['no_pesanan']) ?>"
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Tandai Selesai?')">✓</a>
                            <a href="index.php?menu=pesanan&set_status=dibatalkan&no=<?= urlencode($row['no_pesanan']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Batalkan pesanan ini?')">✕</a>
                        <?php endif; ?>
                        <a href="index.php?menu=detail_pesanan&no=<?= urlencode($row['no_pesanan']) ?>"
                           class="btn btn-secondary btn-sm">🔍</a>
                        <a href="https://wa.me/62<?= ltrim($row['no_hp'],'0') ?>?text=Halo%20<?= urlencode($row['nama']) ?>%2C%20pesanan%20Anda%20<?= urlencode($row['no_pesanan']) ?>%20sedang%20kami%20proses%20%F0%9F%8C%B8"
                           target="_blank" class="btn btn-success btn-sm">📱</a>
                    </td>
                </tr>
                <?php
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">
                        🌸 Belum ada pesanan masuk.<br>
                        <small>Pesanan dari website akan muncul di sini.</small>
                    </td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tabelPesanan').DataTable({
        pageLength: 10,
        order: [[7, 'desc']],
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Tidak ada data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { next: "Next", previous: "Prev" }
        }
    });
});
</script>
