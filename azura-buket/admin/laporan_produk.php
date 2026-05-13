<?php include 'koneksi.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📋 Laporan Produk</h3>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">🖨 Cetak</button>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered table-striped mb-0" id="tabelLapProduk">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center">Stok</th>
                    <th>Status Stok</th>
                    <th>Status Produk</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no=1;
            $q=mysqli_query($conn,"SELECT * FROM produk ORDER BY status DESC, nama_produk ASC");
            while($row=mysqli_fetch_assoc($q)):
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <?php if($row['gambar']!=''): ?>
                            <img src="gambar/<?= $row['gambar'] ?>" width="60" style="border-radius:6px;">
                        <?php else: ?>
                            <div style="width:50px;height:50px;background:#fde8ec;border-radius:6px;display:flex;align-items:center;justify-content:center">🌸</div>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                    <td class="text-end">Rp <?= number_format($row['harga'],0,',','.') ?></td>
                    <td class="text-center"><strong><?= $row['stok'] ?></strong> pcs</td>
                    <td>
                        <?php if($row['stok']<=0): ?>
                            <span class="badge bg-danger">Habis</span>
                        <?php elseif($row['stok']<=5): ?>
                            <span class="badge bg-warning text-dark">⚠ Hampir Habis</span>
                        <?php else: ?>
                            <span class="badge bg-success">✓ Aman</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row['status']=='aktif'): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#tabelLapProduk').DataTable({
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
