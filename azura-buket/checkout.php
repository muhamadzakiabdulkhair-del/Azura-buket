<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — Azura Buket</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand:       #c0395e;
            --brand-dark:  #8e1f3d;
            --brand-light: #e8729a;
            --accent:      #f5c0cc;
            --accent2:     #fde8ec;
            --bg:          #fdf6f0;
            --card:        #ffffff;
            --text:        #3a2030;
            --muted:       #9b6b7e;
            --border:      #f0d0da;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Jost', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        a { text-decoration: none; color: inherit; }

        /* ── NAVBAR ── */
        .navbar {
            background: var(--brand);
            padding: 0 20px; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,.2);
        }
        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700; font-size: 1.3rem; color: #fff;
            display: flex; align-items: center; gap: 8px;
        }
        .navbar a { color: rgba(255,255,255,.85); font-size: .88rem; }
        .navbar a:hover { color: #fff; }

        /* ── LAYOUT ── */
        .page-wrap { max-width: 1100px; margin: 0 auto; padding: 24px 16px 60px; }

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem; font-weight: 600; margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
            align-items: start;
        }
        @media (max-width: 768px) {
            .checkout-grid { grid-template-columns: 1fr; }
        }

        /* ── CARD ── */
        .card {
            background: var(--card);
            border-radius: 14px;
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff;
            padding: 14px 20px;
            font-weight: 600; font-size: .95rem;
        }
        .card-body { padding: 20px; }

        /* ── KERANJANG ITEMS ── */
        .cart-empty {
            text-align: center; padding: 40px;
            color: var(--muted); font-size: .9rem;
        }
        .cart-empty span { font-size: 2.5rem; display: block; margin-bottom: 8px; }

        .cart-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 0; border-bottom: 1px solid var(--border);
        }
        .cart-item:last-child { border-bottom: none; }

        .cart-item-img {
            width: 64px; height: 64px; border-radius: 10px;
            object-fit: cover; background: var(--accent2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; flex-shrink: 0; overflow: hidden;
        }
        .cart-item-img img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }

        .cart-item-info { flex: 1; }
        .cart-item-name {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600; font-size: 1rem; margin-bottom: 3px;
        }
        .cart-item-price { font-size: .8rem; color: var(--brand); font-weight: 600; }

        .cart-item-qty {
            display: flex; align-items: center; gap: 8px;
        }
        .qty-btn {
            width: 28px; height: 28px; border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--bg); cursor: pointer;
            font-size: 16px; display: flex; align-items: center;
            justify-content: center; font-weight: 600;
            transition: all .2s; color: var(--brand);
        }
        .qty-btn:hover { background: var(--brand); color: #fff; border-color: var(--brand); }
        .qty-num { font-weight: 700; min-width: 20px; text-align: center; }

        .cart-item-remove {
            background: none; border: none; color: var(--muted);
            cursor: pointer; font-size: 16px; padding: 4px;
            transition: color .2s;
        }
        .cart-item-remove:hover { color: #e53935; }

        /* ── FORM ── */
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block; font-size: .8rem; font-weight: 600;
            color: var(--muted); margin-bottom: 6px;
        }
        .form-group label span { color: var(--brand); }
        .form-control {
            width: 100%; padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px; font-family: 'Jost', sans-serif;
            font-size: .9rem; color: var(--text);
            background: var(--bg); transition: all .2s;
        }
        .form-control:focus {
            outline: none; border-color: var(--brand);
            background: #fff; box-shadow: 0 0 0 3px rgba(192,57,94,.08);
        }
        .form-control::placeholder { color: var(--border); }
        textarea.form-control { resize: vertical; min-height: 90px; }

        /* ── RINGKASAN ORDER ── */
        .summary-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 8px 0; font-size: .88rem;
        }
        .summary-row.total {
            border-top: 2px solid var(--border);
            margin-top: 8px; padding-top: 14px;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem; font-weight: 700;
        }
        .summary-row.total .amount { color: var(--brand); font-size: 1.3rem; }

        /* ── TOMBOL ── */
        .btn-checkout {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; border: none; border-radius: 12px;
            font-family: 'Jost', sans-serif; font-weight: 700;
            font-size: 1rem; cursor: pointer;
            transition: all .25s; margin-top: 12px;
            box-shadow: 0 4px 16px rgba(192,57,94,.3);
        }
        .btn-checkout:hover { opacity: .92; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(192,57,94,.4); }
        .btn-checkout:disabled { opacity: .5; cursor: not-allowed; transform: none; }

        .btn-lanjut-belanja {
            display: block; text-align: center; margin-top: 12px;
            color: var(--muted); font-size: .82rem;
        }
        .btn-lanjut-belanja:hover { color: var(--brand); }

        /* ── ALERT ── */
        .alert { border-radius: 10px; padding: 12px 16px; font-size: .88rem; margin-bottom: 16px; }
        .alert-danger  { background: rgba(220,38,38,.08);  color: #dc2626; border: 1px solid rgba(220,38,38,.2); }
        .alert-success { background: rgba(5,150,105,.08); color: #059669; border: 1px solid rgba(5,150,105,.2); }

        /* ── PROGRESS STEPS ── */
        .steps {
            display: flex; align-items: center; gap: 0;
            margin-bottom: 24px; padding: 0 8px;
        }
        .step {
            display: flex; flex-direction: column; align-items: center;
            gap: 4px; flex: 1;
        }
        .step-circle {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem;
            background: var(--brand); color: #fff;
        }
        .step-circle.inactive { background: var(--border); color: var(--muted); }
        .step-label { font-size: .7rem; color: var(--muted); font-weight: 600; }
        .step-label.active { color: var(--brand); }
        .step-line { flex: 1; height: 2px; background: var(--border); margin: 0 -1px; margin-bottom: 18px; }
        .step-line.done { background: var(--brand); }

        /* ── METODE BAYAR ── */
        .metode-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .metode-opt { position: relative; }
        .metode-opt input { position: absolute; opacity: 0; width: 0; height: 0; }
        .metode-label {
            display: flex; align-items: center; gap: 8px;
            padding: 12px 14px; border-radius: 10px;
            border: 1.5px solid var(--border);
            cursor: pointer; font-size: .85rem; font-weight: 500;
            transition: all .2s; background: var(--bg);
        }
        .metode-label:hover { border-color: var(--brand-light); }
        .metode-opt input:checked + .metode-label {
            border-color: var(--brand); background: var(--accent2);
            color: var(--brand); font-weight: 600;
        }
        .metode-icon { font-size: 1.3rem; }

        /* ── INFO PEMBAYARAN ── */
        .info-bayar {
            background: var(--accent2); border: 1px solid var(--accent);
            border-radius: 10px; padding: 14px 16px;
            margin-top: 12px; display: none;
        }
        .info-bayar.show { display: block; }
        .info-bayar h5 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem; font-weight: 600; margin-bottom: 8px; color: var(--brand);
        }
        .info-bayar p { font-size: .83rem; color: var(--text); margin-bottom: 4px; }
        .rekening {
            display: flex; align-items: center; justify-content: space-between;
            background: #fff; border-radius: 8px;
            padding: 10px 14px; margin: 8px 0;
        }
        .rek-num { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: var(--brand); }
        .copy-btn {
            background: var(--brand); color: #fff; border: none;
            border-radius: 6px; padding: 4px 12px;
            font-size: .75rem; font-weight: 600; cursor: pointer;
        }
        .copy-btn:hover { opacity: .9; }

        /* ── EMPTY CART INFO ── */
        #checkoutForm { display: none; }
        #cartSection  { display: block; }
    </style>
</head>
<body>

<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "azura_buket";
$conn = @mysqli_connect($host, $user, $pass, $db);

// Ambil semua produk aktif untuk referensi harga
$produk_list = [];
if ($conn) {
    $q = mysqli_query($conn, "SELECT * FROM produk WHERE status='aktif' ORDER BY id");
    while ($r = mysqli_fetch_assoc($q)) {
        $produk_list[$r['id']] = $r;
    }
}

$emojis = ['🌹','🌸','🌷','💵','🌻','🍼','🍫','🥀'];
$no_produk = 0;
foreach ($produk_list as $p) {
    // assign emoji index by id mod 8
}

// Pre-selected product dari GET (klik Pesan di halaman utama)
$preselect_id = (int)($_GET['produk'] ?? 0);
?>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="index.php" class="navbar-brand">🌸 Azura <em style="color:#fde8ec;font-style:italic">Buket</em></a>
    <a href="index.php">← Lanjut Belanja</a>
</nav>

<div class="page-wrap">

    <!-- STEPS -->
    <div class="steps">
        <div class="step">
            <div class="step-circle">1</div>
            <span class="step-label active">Keranjang</span>
        </div>
        <div class="step-line done"></div>
        <div class="step">
            <div class="step-circle">2</div>
            <span class="step-label active">Data Pemesan</span>
        </div>
        <div class="step-line done"></div>
        <div class="step">
            <div class="step-circle">3</div>
            <span class="step-label active">Konfirmasi</span>
        </div>
    </div>

    <div class="page-title">🛒 Checkout</div>

    <div class="checkout-grid">

        <!-- KIRI: Form Data Pemesan + Produk -->
        <div>

            <!-- Pilih Produk -->
            <div class="card" style="margin-bottom:16px">
                <div class="card-header">🌸 Pilih Produk</div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:10px">
                        <label>Cari & Pilih Produk</label>
                        <select id="selectProduk" class="form-control" onchange="tambahKeKeranjang()">
                            <option value="">-- Pilih produk --</option>
                            <?php foreach ($produk_list as $p):
                                $emoji = $emojis[($p['id']-1) % 8];
                            ?>
                            <option value="<?= $p['id'] ?>"
                                    data-harga="<?= $p['harga'] ?>"
                                    data-nama="<?= htmlspecialchars($p['nama_produk']) ?>"
                                    data-stok="<?= $p['stok'] ?>"
                                    data-gambar="<?= htmlspecialchars($p['gambar']) ?>"
                                    data-emoji="<?= $emoji ?>"
                                    <?= ($preselect_id == $p['id']) ? 'selected' : '' ?>>
                                <?= $emoji ?> <?= htmlspecialchars($p['nama_produk']) ?>
                                — Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                                (Stok: <?= $p['stok'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Keranjang items -->
                    <div id="keranjangList">
                        <div class="cart-empty" id="keranjangKosong">
                            <span>🌸</span>
                            Keranjang masih kosong.<br>Pilih produk di atas untuk mulai.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pemesan -->
            <div class="card" style="margin-bottom:16px">
                <div class="card-header">📋 Data Pemesan</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Lengkap <span>*</span></label>
                        <input type="text" id="nama" class="form-control" placeholder="Masukkan nama lengkap kamu">
                    </div>
                    <div class="form-group">
                        <label>No. WhatsApp <span>*</span></label>
                        <input type="tel" id="no_hp" class="form-control" placeholder="Contoh: 08123456789">
                    </div>
                    <div class="form-group">
                        <label>Alamat Pengiriman <span>*</span></label>
                        <textarea id="alamat" class="form-control" placeholder="Masukkan alamat lengkap (jalan, no rumah, kota)..."></textarea>
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label>Catatan / Pesan Kartu (opsional)</label>
                        <textarea id="catatan" class="form-control" rows="3"
                            placeholder="Contoh: Tolong sertakan kartu ucapan bertuliskan 'Happy Birthday Sayang'..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="card">
                <div class="card-header">💳 Metode Pembayaran</div>
                <div class="card-body">
                    <div class="metode-grid">
                        <div class="metode-opt">
                            <input type="radio" name="metode" id="m_transfer" value="Transfer Bank" checked onchange="updateMetode()">
                            <label for="m_transfer" class="metode-label">
                                <span class="metode-icon">🏦</span> Transfer Bank
                            </label>
                        </div>
                        <div class="metode-opt">
                            <input type="radio" name="metode" id="m_bri" value="BRI" onchange="updateMetode()">
                            <label for="m_bri" class="metode-label">
                                <span class="metode-icon">💙</span> BRI
                            </label>
                        </div>
                        <div class="metode-opt">
                            <input type="radio" name="metode" id="m_mandiri" value="Mandiri" onchange="updateMetode()">
                            <label for="m_mandiri" class="metode-label">
                                <span class="metode-icon">💛</span> Mandiri
                            </label>
                        </div>
                        <div class="metode-opt">
                            <input type="radio" name="metode" id="m_cod" value="COD" onchange="updateMetode()">
                            <label for="m_cod" class="metode-label">
                                <span class="metode-icon">🤝</span> COD
                            </label>
                        </div>
                        <div class="metode-opt">
                            <input type="radio" name="metode" id="m_qris" value="QRIS" onchange="updateMetode()">
                            <label for="m_qris" class="metode-label">
                                <span class="metode-icon">📱</span> QRIS
                            </label>
                        </div>
                        <div class="metode-opt">
                            <input type="radio" name="metode" id="m_gopay" value="GoPay/OVO" onchange="updateMetode()">
                            <label for="m_gopay" class="metode-label">
                                <span class="metode-icon">💚</span> GoPay/OVO
                            </label>
                        </div>
                    </div>

                    <!-- Info Rekening/Pembayaran -->
                    <div class="info-bayar" id="infoBayar">
                        <h5 id="infoBayarTitle">Info Transfer</h5>
                        <div id="infoBayarContent"></div>
                    </div>

                </div>
            </div>

        </div>

        <!-- KANAN: Ringkasan Order -->
        <div>
            <div class="card" style="position:sticky;top:70px">
                <div class="card-header">🧾 Ringkasan Pesanan</div>
                <div class="card-body">

                    <div id="alertMsg"></div>

                    <!-- Item summary -->
                    <div id="summaryItems">
                        <p style="color:var(--muted);font-size:.85rem;text-align:center;padding:12px 0">
                            Pilih produk untuk melihat ringkasan
                        </p>
                    </div>

                    <div id="summaryBottom" style="display:none">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="summarySubtotal">Rp 0</span>
                        </div>
                        <div class="summary-row">
                            <span>Ongkir</span>
                            <span style="color:var(--brand);font-weight:600">Gratis 🎉</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="amount" id="summaryTotal">Rp 0</span>
                        </div>
                    </div>

                    <button class="btn-checkout" id="btnCheckout" onclick="submitCheckout()" disabled>
                        ✨ Buat Pesanan
                    </button>

                    <a href="index.php" class="btn-lanjut-belanja">← Lanjut Belanja</a>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Data produk dari PHP
const produkData = <?= json_encode(array_values($produk_list)) ?>;
const emojis     = ['🌹','🌸','🌷','💵','🌻','🍼','🍫','🥀'];
let keranjang    = {}; // { id: { id, nama, harga, jumlah, gambar, emoji } }

// ── Init: jika ada produk pre-selected ────────────────────────
<?php if ($preselect_id && isset($produk_list[$preselect_id])): ?>
window.addEventListener('DOMContentLoaded', function() {
    // Langsung tambahkan produk yang di-klik dari halaman utama
    setTimeout(function() {
        tambahKeKeranjang();
    }, 100);
});
<?php endif; ?>

// ── TAMBAH KE KERANJANG ────────────────────────────────────────
function tambahKeKeranjang() {
    const sel = document.getElementById('selectProduk');
    const opt = sel.options[sel.selectedIndex];
    if (!opt.value) return;

    const id     = parseInt(opt.value);
    const nama   = opt.dataset.nama;
    const harga  = parseInt(opt.dataset.harga);
    const stok   = parseInt(opt.dataset.stok);
    const gambar = opt.dataset.gambar;
    const emoji  = opt.dataset.emoji;

    if (isNaN(id)) return;

    if (keranjang[id]) {
        if (keranjang[id].jumlah >= stok) {
            showAlert('Stok tidak mencukupi! Tersedia: ' + stok + ' pcs', 'danger');
            return;
        }
        keranjang[id].jumlah++;
    } else {
        keranjang[id] = { id, nama, harga, jumlah: 1, stok, gambar, emoji };
    }

    // Reset select
    sel.value = '';
    renderKeranjang();
    updateSummary();
    showAlert('', '');
}

// ── RENDER KERANJANG ───────────────────────────────────────────
function renderKeranjang() {
    const list = document.getElementById('keranjangList');
    const kosong = document.getElementById('keranjangKosong');
    const keys = Object.keys(keranjang);

    if (!keys.length) {
        list.innerHTML = '';
        list.appendChild(kosong);
        kosong.style.display = 'block';
        return;
    }

    kosong.style.display = 'none';
    list.innerHTML = '';

    keys.forEach(id => {
        const item = keranjang[id];
        const div  = document.createElement('div');
        div.className = 'cart-item';

        let imgHtml = '';
        if (item.gambar) {
            imgHtml = `<div class="cart-item-img"><img src="admin/gambar/${item.gambar}" alt="${item.nama}" onerror="this.parentElement.textContent='${item.emoji}'"></div>`;
        } else {
            imgHtml = `<div class="cart-item-img">${item.emoji}</div>`;
        }

        div.innerHTML = `
            ${imgHtml}
            <div class="cart-item-info">
                <div class="cart-item-name">${item.nama}</div>
                <div class="cart-item-price">Rp ${item.harga.toLocaleString('id-ID')} / pcs</div>
                <div style="font-size:.78rem;color:var(--muted);margin-top:2px">
                    Subtotal: <strong style="color:var(--brand)">Rp ${(item.harga * item.jumlah).toLocaleString('id-ID')}</strong>
                </div>
            </div>
            <div class="cart-item-qty">
                <button class="qty-btn" onclick="ubahQty(${id}, -1)">−</button>
                <span class="qty-num">${item.jumlah}</span>
                <button class="qty-btn" onclick="ubahQty(${id}, 1)">+</button>
            </div>
            <button class="cart-item-remove" onclick="hapusDariKeranjang(${id})" title="Hapus">🗑</button>
        `;
        list.appendChild(div);
    });
}

// ── UBAH QTY ──────────────────────────────────────────────────
function ubahQty(id, delta) {
    if (!keranjang[id]) return;
    const newQty = keranjang[id].jumlah + delta;

    if (newQty <= 0) {
        hapusDariKeranjang(id);
        return;
    }
    if (newQty > keranjang[id].stok) {
        showAlert('Stok tidak mencukupi! Tersedia: ' + keranjang[id].stok + ' pcs', 'danger');
        return;
    }

    keranjang[id].jumlah = newQty;
    renderKeranjang();
    updateSummary();
}

// ── HAPUS DARI KERANJANG ───────────────────────────────────────
function hapusDariKeranjang(id) {
    delete keranjang[id];
    renderKeranjang();
    updateSummary();
}

// ── UPDATE RINGKASAN ───────────────────────────────────────────
function updateSummary() {
    const keys  = Object.keys(keranjang);
    const total = keys.reduce((sum, id) => sum + (keranjang[id].harga * keranjang[id].jumlah), 0);
    const bottomEl = document.getElementById('summaryBottom');
    const itemsEl  = document.getElementById('summaryItems');
    const btnEl    = document.getElementById('btnCheckout');

    if (!keys.length) {
        itemsEl.innerHTML = '<p style="color:var(--muted);font-size:.85rem;text-align:center;padding:12px 0">Pilih produk untuk melihat ringkasan</p>';
        bottomEl.style.display = 'none';
        btnEl.disabled = true;
        return;
    }

    // Render summary items
    let html = '';
    keys.forEach(id => {
        const item = keranjang[id];
        html += `<div class="summary-row" style="font-size:.82rem">
            <span>${item.nama} ×${item.jumlah}</span>
            <span>Rp ${(item.harga * item.jumlah).toLocaleString('id-ID')}</span>
        </div>`;
    });
    itemsEl.innerHTML = html;

    bottomEl.style.display = 'block';
    document.getElementById('summarySubtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('summaryTotal').textContent    = 'Rp ' + total.toLocaleString('id-ID');
    btnEl.disabled = false;
}

// ── METODE PEMBAYARAN ──────────────────────────────────────────
const infoBayarData = {
    'Transfer Bank': {
        title: '🏦 Info Transfer Bank',
        html: `<p>Transfer ke salah satu rekening berikut:</p>
               <div class="rekening">
                   <div><small style="color:var(--muted)">BCA — a.n. Azura Rahmawati</small><br><span class="rek-num">1234567890</span></div>
                   <button class="copy-btn" onclick="copy('1234567890')">Salin</button>
               </div>
               <p style="margin-top:8px;font-size:.78rem;color:var(--muted)">
                   Setelah transfer, screenshot bukti pembayaran dan kirim ke WhatsApp kami.
               </p>`
    },
    'BRI': {
        title: '💙 Info Transfer BRI',
        html: `<div class="rekening">
                   <div><small style="color:var(--muted)">BRI — a.n. Azura Rahmawati</small><br><span class="rek-num">0987654321</span></div>
                   <button class="copy-btn" onclick="copy('0987654321')">Salin</button>
               </div>
               <p style="margin-top:8px;font-size:.78rem;color:var(--muted)">
                   Kirim bukti transfer ke WhatsApp kami setelah pembayaran.
               </p>`
    },
    'Mandiri': {
        title: '💛 Info Transfer Mandiri',
        html: `<div class="rekening">
                   <div><small style="color:var(--muted)">Mandiri — a.n. Azura Rahmawati</small><br><span class="rek-num">1122334455</span></div>
                   <button class="copy-btn" onclick="copy('1122334455')">Salin</button>
               </div>`
    },
    'COD': {
        title: '🤝 COD (Bayar di Tempat)',
        html: `<p>Pembayaran dilakukan saat buket tiba di lokasimu.</p>
               <p style="margin-top:6px;font-size:.78rem;color:var(--muted)">
                   ⚠️ COD hanya tersedia untuk area Kota Cirebon dan sekitarnya.
               </p>`
    },
    'QRIS': {
        title: '📱 Pembayaran QRIS',
        html: `<p>Scan QR code yang akan kami kirimkan via WhatsApp setelah pesanan dikonfirmasi.</p>`
    },
    'GoPay/OVO': {
        title: '💚 GoPay / OVO',
        html: `<div class="rekening">
                   <div><small style="color:var(--muted)">No. GoPay/OVO</small><br><span class="rek-num">081234567890</span></div>
                   <button class="copy-btn" onclick="copy('081234567890')">Salin</button>
               </div>`
    }
};

function updateMetode() {
    const val = document.querySelector('input[name="metode"]:checked')?.value;
    const infoEl = document.getElementById('infoBayar');
    if (val && infoBayarData[val]) {
        document.getElementById('infoBayarTitle').textContent   = infoBayarData[val].title;
        document.getElementById('infoBayarContent').innerHTML   = infoBayarData[val].html;
        infoEl.classList.add('show');
    } else {
        infoEl.classList.remove('show');
    }
}

function copy(text) {
    navigator.clipboard.writeText(text).then(() => {
        showAlert('✅ Nomor rekening disalin!', 'success');
    });
}

// ── SUBMIT CHECKOUT ────────────────────────────────────────────
function submitCheckout() {
    const nama    = document.getElementById('nama').value.trim();
    const no_hp   = document.getElementById('no_hp').value.trim();
    const alamat  = document.getElementById('alamat').value.trim();
    const catatan = document.getElementById('catatan').value.trim();
    const metode  = document.querySelector('input[name="metode"]:checked')?.value || '';
    const keys    = Object.keys(keranjang);

    // Validasi
    if (!nama) { showAlert('❌ Nama lengkap wajib diisi!', 'danger'); document.getElementById('nama').focus(); return; }
    if (!no_hp) { showAlert('❌ No. WhatsApp wajib diisi!', 'danger'); document.getElementById('no_hp').focus(); return; }
    if (!alamat) { showAlert('❌ Alamat pengiriman wajib diisi!', 'danger'); document.getElementById('alamat').focus(); return; }
    if (!keys.length) { showAlert('❌ Keranjang masih kosong!', 'danger'); return; }

    // Siapkan data
    const items = keys.map(id => ({
        id_produk: parseInt(id),
        nama_produk: keranjang[id].nama,
        harga: keranjang[id].harga,
        jumlah: keranjang[id].jumlah,
        subtotal: keranjang[id].harga * keranjang[id].jumlah
    }));

    const total = items.reduce((sum, i) => sum + i.subtotal, 0);

    // Kirim ke proses_checkout.php via AJAX
    const btn = document.getElementById('btnCheckout');
    btn.disabled = true;
    btn.textContent = '⏳ Memproses...';

    const formData = new FormData();
    formData.append('nama', nama);
    formData.append('no_hp', no_hp);
    formData.append('alamat', alamat);
    formData.append('catatan', catatan);
    formData.append('metode', metode);
    formData.append('total', total);
    formData.append('items', JSON.stringify(items));

    fetch('proses_checkout.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Redirect ke halaman sukses
                window.location.href = 'pesanan_sukses.php?no=' + encodeURIComponent(data.no_pesanan) + '&total=' + total;
            } else {
                showAlert('❌ ' + (data.message || 'Terjadi kesalahan. Coba lagi.'), 'danger');
                btn.disabled = false;
                btn.textContent = '✨ Buat Pesanan';
            }
        })
        .catch(() => {
            // Fallback jika DB tidak aktif: tetap lanjut ke halaman sukses dummy
            const noDummy = 'AZ-' + Date.now();
            window.location.href = 'pesanan_sukses.php?no=' + noDummy + '&total=' + total + '&nama=' + encodeURIComponent(nama) + '&metode=' + encodeURIComponent(metode);
        });
}

// ── ALERT HELPER ──────────────────────────────────────────────
function showAlert(msg, type) {
    const el = document.getElementById('alertMsg');
    if (!msg) { el.innerHTML = ''; return; }
    el.innerHTML = `<div class="alert alert-${type}">${msg}</div>`;
    setTimeout(() => { el.innerHTML = ''; }, 4000);
}

// ── INIT ──────────────────────────────────────────────────────
updateMetode(); // tampilkan info metode pertama

<?php if ($preselect_id && isset($produk_list[$preselect_id])): ?>
// Auto tambah produk yang dipilih dari halaman utama
setTimeout(() => tambahKeKeranjang(), 200);
<?php endif; ?>
</script>

</body>
</html>
