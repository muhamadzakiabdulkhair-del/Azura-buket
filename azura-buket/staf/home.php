<?php include "koneksi.php"; ?>

<h3>Selamat datang, <?= $_SESSION['username']; ?> 👋</h3>
<p class="text-muted">Ini adalah halaman dashboard staf Azura Buket 🌸</p>

<!-- CARD INFO -->
<div class="row mt-4">

    <div class="col-md-4">
        <div class="card text-white mb-3 shadow" style="background:linear-gradient(135deg,#c0395e,#e8729a)">
            <div class="card-body">
                <h5 class="card-title">Total Produk</h5>
                <p class="card-text fs-3">
                <?php
                include "totalproduk.php";
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
                include "totalstaf.php";
                ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3 shadow">
            <div class="card-body">
                <h5 class="card-title">Transaksi Hari Ini</h5>
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
