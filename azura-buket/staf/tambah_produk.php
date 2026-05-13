<div class="container mt-5">
    <h3>🌸 Tambah Produk</h3>

    <form action="simpan_produk.php" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" required placeholder="Buket Mawar Merah Premium">
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required min="0">
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required min="0">
        </div>

        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control" required accept="image/*">
        </div>

        <button type="submit" name="tambah" class="btn" style="background:#c0395e;color:#fff">💾 Simpan</button>
        <a href="index.php?menu=produk" class="btn btn-secondary">Batal</a>

    </form>
</div>
