<h3>➕ Tambah Staf</h3>

<form action="simpan_staf.php" method="POST">
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>No. HP</label>
        <input type="text" name="no_hp" class="form-control" placeholder="0812...">
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="staf">Staf</option>
            <option value="pemilik">Pemilik/CEO</option>
        </select>
    </div>

    <button class="btn" style="background:#c0395e;color:#fff">💾 Simpan</button>
    <a href="index.php?menu=staf" class="btn btn-secondary">Kembali</a>
</form>
