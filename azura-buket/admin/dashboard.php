<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin — Azura Buket</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background-color: #fdf6f0;
        }
        .sidebar {
            height: 100vh;
            background: #2a0f1e;
        }
        .sidebar a {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            display: block;
            padding: 12px 16px;
            font-size: .88rem;
            transition: background .2s;
        }
        .sidebar a:hover {
            background: #3e1630;
            color: #fff;
        }
        .sidebar .menu-label {
            color: rgba(255,255,255,.35);
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 10px 16px 4px;
        }
        .navbar-brand-azura {
            font-family: Georgia, serif;
            font-weight: 700;
            color: #fff !important;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #c0395e, #e8729a);">
    <div class="container-fluid">
        <a class="navbar-brand navbar-brand-azura" href="#">🌸 Azura Buket — Admin</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">

                <!-- DROPDOWN LAPORAN -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Laporan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?menu=laporan_pembelian">Laporan Pembelian</a></li>
                        <li><a class="dropdown-item" href="index.php?menu=laporan_penjualan">Laporan Penjualan</a></li>
                        <li><a class="dropdown-item" href="index.php?menu=laporan_produk">Laporan Produk</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?menu=pesanan">🛍️ Pesanan Website</a></li>
                    </ul>
                </li>

                <!-- User info -->
                <li class="nav-item">
                    <span class="nav-link text-white-50">
                        👤 <?= htmlspecialchars($_SESSION['nama'] ?? $_SESSION['username']) ?>
                        (<?= ucfirst($_SESSION['role'] ?? '') ?>)
                    </span>
                </li>

                <!-- LOGOUT -->
                <li class="nav-item">
                    <a class="nav-link text-warning" href="logout.php">Logout</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- LAYOUT -->
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar p-0">

            <div class="text-center py-3 border-bottom" style="border-color:rgba(255,255,255,.1)!important">
                <div style="width:48px;height:48px;background:linear-gradient(135deg,#c0395e,#e8729a);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1.2rem;margin:0 auto 6px;">
                    <?= strtoupper(substr($_SESSION['nama'] ?? 'A', 0, 1)) ?>
                </div>
                <small style="color:rgba(255,255,255,.6);font-size:.75rem">
                    <?= htmlspecialchars($_SESSION['nama'] ?? '') ?>
                </small>
            </div>

            <div class="menu-label">Menu Utama</div>
            <a href="index.php">🏠 Dashboard</a>
            <a href="index.php?menu=produk">📦 Produk</a>
            <a href="index.php?menu=staf">👨‍💼 Staf</a>

            <div class="menu-label">Pesanan</div>
            <a href="index.php?menu=pesanan">🛍️ Pesanan Website</a>

            <div class="menu-label">Laporan</div>
            <a href="index.php?menu=laporan_pembelian">📊 Laporan Pembelian</a>
            <a href="index.php?menu=laporan_penjualan">💰 Laporan Penjualan</a>
            <a href="index.php?menu=laporan_produk">📋 Laporan Produk</a>

            <div class="menu-label">Akses Staf</div>
            <a href="../staf/index.php" target="_blank">🌸 Panel Staf</a>
            <a href="../index.php" target="_blank">🌐 Website</a>

            <div style="padding:16px;border-top:1px solid rgba(255,255,255,.08);margin-top:auto">
                <a href="logout.php" style="background:rgba(220,38,38,.15);color:#fca5a5;border-radius:6px;padding:8px 12px;display:block;text-align:center;font-size:.82rem">
                    Logout
                </a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-md-10 p-4">
<?php
include "menu.php";
?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<?php
include "footer.php";
?>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DATATABLE -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- AKTIFKAN DATATABLE -->
<script>
$(document).ready(function() {
    $('#tabelStaf').DataTable({
        pageLength: 5,
        lengthMenu: [
            [5, 10, 25, 50],
            [5, 10, 25, 50]
        ],
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                next: "Next",
                previous: "Prev"
            }
        }
    });
});
</script>
</body>
</html>
