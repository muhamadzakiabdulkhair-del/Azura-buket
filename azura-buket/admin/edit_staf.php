<?php
include 'koneksi.php';
$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM staf WHERE id='$id'");
$row = mysqli_fetch_assoc($data);
?>

<h3>✏️ Edit Staf</h3>

<form action="update_staf.php" method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($row['username']) ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label>Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label>No. HP</label>
        <input type="text" name="no_hp" value="<?= htmlspecialchars($row['no_hp'] ?? '') ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin"   <?= $row['role']=='admin'   ? 'selected' : '' ?>>Admin</option>
            <option value="staf"    <?= $row['role']=='staf'    ? 'selected' : '' ?>>Staf</option>
            <option value="pemilik" <?= $row['role']=='pemilik' ? 'selected' : '' ?>>Pemilik/CEO</option>
        </select>
    </div>

    <button class="btn" style="background:#c0395e;color:#fff">💾 Update</button>
    <a href="index.php?menu=staf" class="btn btn-secondary">Kembali</a>
</form>
