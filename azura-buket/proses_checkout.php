<?php
// ============================================================
// AZURA BUKET — proses_checkout.php
// Terima data JSON dari checkout.php via AJAX, simpan ke DB
// ============================================================
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "azura_buket";
$conn = @mysqli_connect($host, $user, $pass, $db);

// Jika DB tidak ada, return success dengan no dummy
if (!$conn) {
    echo json_encode([
        'success'    => true,
        'no_pesanan' => 'AZ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
        'message'    => 'Pesanan berhasil (offline mode)'
    ]);
    exit;
}

// Ambil data POST
$nama    = trim($_POST['nama']    ?? '');
$no_hp   = trim($_POST['no_hp']   ?? '');
$alamat  = trim($_POST['alamat']  ?? '');
$catatan = trim($_POST['catatan'] ?? '');
$metode  = trim($_POST['metode']  ?? '');
$total   = (int)($_POST['total']  ?? 0);
$items   = json_decode($_POST['items'] ?? '[]', true);

// Validasi
if (!$nama || !$no_hp || !$alamat || empty($items)) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

// Generate nomor pesanan unik
$no_pesanan = 'AZ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

// Cek stok sebelum simpan
foreach ($items as $item) {
    $id_produk = (int)$item['id_produk'];
    $jumlah    = (int)$item['jumlah'];
    $stokQ = mysqli_query($conn, "SELECT stok, nama_produk FROM produk WHERE id=$id_produk AND status='aktif'");
    $stokRow = mysqli_fetch_assoc($stokQ);
    if (!$stokRow) {
        echo json_encode(['success' => false, 'message' => "Produk tidak tersedia"]);
        exit;
    }
    if ($stokRow['stok'] < $jumlah) {
        echo json_encode(['success' => false, 'message' => "Stok {$stokRow['nama_produk']} tidak mencukupi (tersisa {$stokRow['stok']})"]);
        exit;
    }
}

// Mulai transaksi
mysqli_begin_transaction($conn);
try {

    // 1. Simpan header pesanan
    $nama_e   = mysqli_real_escape_string($conn, $nama);
    $no_hp_e  = mysqli_real_escape_string($conn, $no_hp);
    $alamat_e = mysqli_real_escape_string($conn, $alamat);
    $catatan_e= mysqli_real_escape_string($conn, $catatan);
    $metode_e = mysqli_real_escape_string($conn, $metode);
    $no_e     = mysqli_real_escape_string($conn, $no_pesanan);

    $q = "INSERT INTO pesanan (no_pesanan, nama, no_hp, alamat, catatan, metode_bayar, status)
          VALUES ('$no_e','$nama_e','$no_hp_e','$alamat_e','$catatan_e','$metode_e','pending')";

    // Cek apakah kolom metode_bayar ada (opsional)
    $check_col = mysqli_query($conn, "SHOW COLUMNS FROM pesanan LIKE 'metode_bayar'");
    if (mysqli_num_rows($check_col) === 0) {
        // Kolom belum ada, insert tanpa metode
        $q = "INSERT INTO pesanan (no_pesanan, nama, no_hp, alamat, catatan, status)
              VALUES ('$no_e','$nama_e','$no_hp_e','$alamat_e','$catatan_e','pending')";
    }

    if (!mysqli_query($conn, $q)) {
        throw new Exception("Gagal simpan pesanan: " . mysqli_error($conn));
    }

    // 2. Simpan detail & kurangi stok
    foreach ($items as $item) {
        $id_produk   = (int)$item['id_produk'];
        $nama_produk = mysqli_real_escape_string($conn, $item['nama_produk']);
        $harga       = (int)$item['harga'];
        $jumlah      = (int)$item['jumlah'];
        $subtotal    = $harga * $jumlah;

        $dq = "INSERT INTO detail_pesanan (no_pesanan, id_produk, nama_produk, harga, jumlah, subtotal)
               VALUES ('$no_e', $id_produk, '$nama_produk', $harga, $jumlah, $subtotal)";
        if (!mysqli_query($conn, $dq)) {
            throw new Exception("Gagal simpan detail: " . mysqli_error($conn));
        }

        // Kurangi stok
        if (!mysqli_query($conn, "UPDATE produk SET stok = stok - $jumlah WHERE id = $id_produk")) {
            throw new Exception("Gagal update stok: " . mysqli_error($conn));
        }
    }

    mysqli_commit($conn);

    echo json_encode([
        'success'    => true,
        'no_pesanan' => $no_pesanan,
        'message'    => 'Pesanan berhasil dibuat'
    ]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
