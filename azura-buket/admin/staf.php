<?php
include 'koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM staf");
?>

<h3>👨‍💼 Data Staf</h3>

<a href="index.php" class="btn btn-secondary mb-3">Dashboard</a>

<a href="?menu=tambah_staf" class="btn mb-3" style="background:#c0395e;color:#fff">+ Tambah Staf</a>

<table class="table table-bordered table-striped" id="tabelStaf">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
    <?php $no=1; while($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#c0395e,#e8729a);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem">
                        <?= strtoupper(substr($row['nama'],0,1)) ?>
                    </div>
                    <?= htmlspecialchars($row['nama']) ?>
                </div>
            </td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td>
                <?php
                $badges = ['pemilik'=>'bg-warning text-dark','admin'=>'bg-danger','staf'=>'bg-success'];
                $badge  = $badges[$row['role']] ?? 'bg-secondary';
                ?>
                <span class="badge <?= $badge ?>"><?= ucfirst($row['role']) ?></span>
            </td>
            <td><?= htmlspecialchars($row['no_hp'] ?? '-') ?></td>
            <td>
                <a href="?menu=edit_staf&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus_staf.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus staf ini?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>
