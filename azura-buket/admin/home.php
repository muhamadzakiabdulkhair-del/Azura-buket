<?php include 'koneksi.php'; ?>

<h3>Selamat datang, <?= $_SESSION['username']; ?> 👋</h3>
<p class="text-muted">Ini adalah halaman dashboard admin Azura Buket 🌸</p>

<!-- CARD INFO -->
<div class="row mt-4">

    <div class="col-md-4">
        <div class="card text-white mb-3 shadow" style="background:linear-gradient(135deg,#c0395e,#e8729a)">
            <div class="card-body">
                <h5 class="card-title">Total Produk</h5>
                <p class="card-text fs-3">
                    <?php
                    $q = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk WHERE status='aktif'");
                    $d = mysqli_fetch_assoc($q);
                    echo $d['total'];
                    ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-success mb-3 shadow">
            <div class="card-body">
                <h5 class="card-title">Total Staf</h5>
                <p class="card-text fs-3">
                    <?php
                    $q = mysqli_query($conn, "SELECT COUNT(*) as total FROM staf");
                    $d = mysqli_fetch_assoc($q);
                    echo $d['total'];
                    ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3 shadow">
            <div class="card-body">
                <h5 class="card-title">Transaksi Barang Masuk</h5>
                <p class="card-text fs-3">
                    <?php
                    $q = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi_masuk WHERE DATE(tanggal) = CURDATE()");
                    $d = mysqli_fetch_assoc($q);
                    echo $d['total'];
                    ?>
                </p>
            </div>
        </div>
    </div>

</div>

<!-- Quick actions -->
<div class="row mt-2">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header" style="background:linear-gradient(135deg,#c0395e,#e8729a);color:#fff">
                <strong>⚡ Aksi Cepat</strong>
            </div>
            <div class="card-body d-flex gap-2 flex-wrap">
                <a href="index.php?menu=produk" class="btn btn-sm" style="background:#c0395e;color:#fff">📦 Kelola Produk</a>
                <a href="index.php?menu=tambah_produk" class="btn btn-sm btn-outline-danger">+ Tambah Produk</a>
                <a href="index.php?menu=staf" class="btn btn-sm btn-outline-secondary">👨‍💼 Kelola Staf</a>
                <a href="index.php?menu=laporan_pembelian" class="btn btn-sm btn-outline-success">📊 Laporan Pembelian</a>
                <a href="../staf/index.php" target="_blank" class="btn btn-sm btn-outline-primary">🌸 Panel Staf</a>
            </div>
        </div>
    </div>
</div>
