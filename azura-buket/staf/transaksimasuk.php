<?php

include 'koneksi.php';

// ── Inisialisasi keranjang di session ──────────────────────
if (!isset($_SESSION['keranjang_masuk'])) {
    $_SESSION['keranjang_masuk'] = [];
}

$pesan  = '';
$error  = '';

// ── Tambah produk ke keranjang ─────────────────────────────
if (isset($_POST['tambah_keranjang'])) {
    $id_produk  = (int)$_POST['id_produk'];
    $jumlah     = (int)$_POST['jumlah'];
    $harga_beli = (int)$_POST['harga_beli'];

    if ($jumlah < 1) {
        $error = "Jumlah harus minimal 1.";
    } elseif ($harga_beli < 0) {
        $error = "Harga beli tidak boleh negatif.";
    } else {
        // Ambil data produk
        $qProduk = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id_produk");
        $produk  = mysqli_fetch_assoc($qProduk);

        if ($produk) {
            // Jika sudah ada di keranjang, tambah jumlahnya
            if (isset($_SESSION['keranjang_masuk'][$id_produk])) {
                $_SESSION['keranjang_masuk'][$id_produk]['jumlah']     += $jumlah;
                $_SESSION['keranjang_masuk'][$id_produk]['harga_beli']  = $harga_beli;
            } else {
                $_SESSION['keranjang_masuk'][$id_produk] = [
                    'id_produk'    => $id_produk,
                    'nama_produk'  => $produk['nama_produk'],
                    'gambar'       => $produk['gambar'],
                    'stok_saat_ini'=> $produk['stok'],
                    'jumlah'       => $jumlah,
                    'harga_beli'   => $harga_beli,
                ];
            }
            $pesan = "✅ <strong>{$produk['nama_produk']}</strong> berhasil ditambahkan ke keranjang.";
        } else {
            $error = "Produk tidak ditemukan.";
        }
    }
}

// ── Hapus item dari keranjang ──────────────────────────────
if (isset($_GET['hapus'])) {
    $hapus_id = (int)$_GET['hapus'];
    unset($_SESSION['keranjang_masuk'][$hapus_id]);
    header("Location: " . $_SERVER['PHP_SELF'] . "?menu=transaksimasuk");
    exit;
}

// ── Kosongkan keranjang ────────────────────────────────────
if (isset($_GET['reset'])) {
    $_SESSION['keranjang_masuk'] = [];
    header("Location: " . $_SERVER['PHP_SELF'] . "?menu=transaksimasuk");
    exit;
}

// ── Simpan transaksi ───────────────────────────────────────
if (isset($_POST['simpan_transaksi'])) {
    $keranjang  = $_SESSION['keranjang_masuk'];
    $keterangan = trim($_POST['keterangan'] ?? '');

    if (empty($keranjang)) {
        $error = "Keranjang masih kosong, tambahkan produk terlebih dahulu.";
    } else {
        // Generate nomor transaksi
        $no_transaksi = 'TM-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        $tanggal      = date('Y-m-d H:i:s');
        $created_by   = $_SESSION['username'] ?? 'sistem';
        $total_item   = array_sum(array_column($keranjang, 'jumlah'));

        mysqli_begin_transaction($conn);
        try {
            // 1. Simpan header transaksi
            $stmt = mysqli_prepare($conn,
                "INSERT INTO transaksi_masuk (no_transaksi, tanggal, keterangan, total_item, created_by)
                 VALUES (?, ?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmt, 'sssss', $no_transaksi, $tanggal, $keterangan, $total_item, $created_by);
            mysqli_stmt_execute($stmt);

            // 2. Simpan detail & update stok
            foreach ($keranjang as $item) {
                $id_produk  = (int)$item['id_produk'];
                $jumlah     = (int)$item['jumlah'];
                $harga_beli = (int)$item['harga_beli'];

                // Detail transaksi
                $stmtD = mysqli_prepare($conn,
                    "INSERT INTO detail_transaksi_masuk (no_transaksi, id_produk, jumlah, harga_beli)
                     VALUES (?, ?, ?, ?)"
                );
                mysqli_stmt_bind_param($stmtD, 'ssii', $no_transaksi, $id_produk, $jumlah, $harga_beli);
                mysqli_stmt_execute($stmtD);

                // Update stok produk
                $stmtS = mysqli_prepare($conn, "UPDATE produk SET stok = stok + ? WHERE id = ?");
                mysqli_stmt_bind_param($stmtS, 'ii', $jumlah, $id_produk);
                mysqli_stmt_execute($stmtS);
            }

            mysqli_commit($conn);
            $_SESSION['keranjang_masuk'] = [];
            $pesan = "✅ Transaksi <strong>$no_transaksi</strong> berhasil disimpan! Stok produk telah diperbarui.";

        } catch (Exception $e) {
            mysqli_rollback($conn);
            $error = "❌ Gagal menyimpan transaksi: " . $e->getMessage();
        }
    }
}

// ── Ambil semua produk untuk dropdown ─────────────────────
$qAllProduk = mysqli_query($conn, "SELECT id, nama_produk, stok, harga FROM produk ORDER BY nama_produk");
$keranjang  = $_SESSION['keranjang_masuk'];
?>

<div class="container-fluid mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">📦 Transaksi Barang Masuk</h4>
        <div>
            <a href="?menu=riwayat_transaksimasuk" class="btn btn-outline-secondary btn-sm me-2">📋 Riwayat</a>
            <button onclick="history.back()" class="btn btn-secondary btn-sm">← Kembali</button>
        </div>
    </div>

    <?php if ($pesan): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $pesan ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- ── KOLOM KIRI: Form tambah ke keranjang ────────── -->
        <div class="col-md-5">
            <div class="card shadow-sm card-form">
                <div class="card-header text-white" style="background:#e8729a">
                    <h6 class="mb-0">➕ Tambah Produk ke Keranjang</h6>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Produk</label>
                            <select name="id_produk" id="selectProduk" class="form-select" required onchange="isiHarga(this)">
                                <option value="">-- Pilih Produk --</option>
                                <?php while ($p = mysqli_fetch_assoc($qAllProduk)): ?>
                                    <option value="<?= $p['id'] ?>"
                                            data-harga="<?= $p['harga'] ?>"
                                            data-stok="<?= $p['stok'] ?>">
                                        <?= htmlspecialchars($p['nama_produk']) ?>
                                        (Stok: <?= $p['stok'] ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-2" id="infoStok" style="display:none;">
                            <span class="badge bg-info text-dark badge-stok">
                                Stok saat ini: <strong id="nilaiStok">0</strong>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah Masuk</label>
                            <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Harga Beli / Satuan (Rp)</label>
                            <input type="number" name="harga_beli" id="hargaBeli" class="form-control" min="0" value="0" required>
                            <small class="text-muted">Isi 0 jika tidak ingin mencatat harga beli.</small>
                        </div>

                        <button type="submit" name="tambah_keranjang" class="btn w-100" style="background:#c0395e;color:#fff">
                            🛒 Masukkan ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ── KOLOM KANAN: Keranjang ──────────────────────── -->
        <div class="col-md-7">
            <div class="card shadow-sm card-keranjang">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background:#c0395e">
                    <h6 class="mb-0">🧺 Keranjang Barang Masuk
                        <span class="badge bg-white text-danger ms-2"><?= count($keranjang) ?> item</span>
                    </h6>
                    <?php if (!empty($keranjang)): ?>
                        <a href="?menu=transaksimasuk&reset=1" class="btn btn-sm btn-outline-light"
                           onclick="return confirm('Kosongkan semua keranjang?')">🗑 Kosongkan</a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($keranjang)): ?>
                        <div class="text-center text-muted py-5">
                            <p class="mb-0">Keranjang masih kosong.</p>
                            <small>Tambahkan produk dari form di sebelah kiri.</small>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="keranjang-table">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Stok Saat Ini</th>
                                        <th class="text-center">Jumlah Masuk</th>
                                        <th class="text-end">Harga Beli</th>
                                        <th class="text-end">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($keranjang as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php if($item['gambar'] != ''): ?>
                                                    <img src="../admin/gambar/<?= htmlspecialchars($item['gambar']) ?>"
                                                         width="40" height="40"
                                                         style="object-fit:cover;border-radius:4px;"
                                                         onerror="this.src='https://via.placeholder.com/40'">
                                                    <?php else: ?>
                                                    <div style="width:40px;height:40px;background:#fde8ec;border-radius:4px;display:flex;align-items:center;justify-content:center">🌸</div>
                                                    <?php endif; ?>
                                                    <span><?= htmlspecialchars($item['nama_produk']) ?></span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary"><?= $item['stok_saat_ini'] ?></span>
                                            </td>
                                            <td class="text-center fw-bold text-success">
                                                +<?= $item['jumlah'] ?>
                                            </td>
                                            <td class="text-end">
                                                Rp <?= number_format($item['harga_beli'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                Rp <?= number_format($item['harga_beli'] * $item['jumlah'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="?menu=transaksimasuk&hapus=<?= $item['id_produk'] ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Hapus dari keranjang?')">✕</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="2"><strong>Total</strong></td>
                                        <td class="text-center fw-bold text-success">
                                            +<?= array_sum(array_column($keranjang, 'jumlah')) ?>
                                        </td>
                                        <td></td>
                                        <td class="text-end fw-bold">
                                            <?php
                                            $totalBeli = 0;
                                            foreach ($keranjang as $i) {
                                                $totalBeli += $i['harga_beli'] * $i['jumlah'];
                                            }
                                            echo 'Rp ' . number_format($totalBeli, 0, ',', '.');
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Form Simpan Transaksi -->
                        <div class="p-3 border-top bg-white">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Keterangan (opsional)</label>
                                    <input type="text" name="keterangan" class="form-control"
                                           placeholder="Contoh: Pembelian dari Supplier Bunga">
                                </div>
                                <button type="submit" name="simpan_transaksi"
                                        class="btn w-100" style="background:#c0395e;color:#fff"
                                        onclick="return confirm('Simpan transaksi dan perbarui stok?')">
                                    💾 Simpan Transaksi & Perbarui Stok
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div><!-- /row -->
</div>

<script>
function isiHarga(sel) {
    const opt = sel.options[sel.selectedIndex];
    const stok = opt.getAttribute('data-stok');
    const harga = opt.getAttribute('data-harga');

    if (stok !== null) {
        document.getElementById('nilaiStok').textContent = stok;
        document.getElementById('infoStok').style.display = 'block';
    } else {
        document.getElementById('infoStok').style.display = 'none';
    }
    if (harga) {
        document.getElementById('hargaBeli').value = harga;
    }
}
</script>
