<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil — Azura Buket</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&family=Dancing+Script:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand:      #c0395e;
            --brand-dark: #8e1f3d;
            --brand-light:#e8729a;
            --accent:     #f5c0cc;
            --accent2:    #fde8ec;
            --bg:         #fdf6f0;
            --text:       #3a2030;
            --muted:      #9b6b7e;
            --border:     #f0d0da;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Jost', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        a { text-decoration: none; color: inherit; }

        /* NAVBAR */
        .navbar {
            background: var(--brand);
            padding: 0 20px; height: 56px;
            display: flex; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,.2);
        }
        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700; font-size: 1.3rem; color: #fff;
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .sukses-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: clamp(2rem,5vw,3rem);
            width: 100%;
            max-width: 560px;
            text-align: center;
            box-shadow: 0 8px 40px rgba(192,57,94,.1);
        }

        /* Animasi centang */
        .check-wrap {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            animation: popIn .5s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes popIn {
            0%   { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .check-icon {
            color: #fff;
            font-size: 2.5rem;
            animation: fadeIn .3s ease .3s both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(.5); }
            to   { opacity: 1; transform: scale(1); }
        }

        .sukses-title {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            color: var(--brand);
            margin-bottom: 8px;
        }

        .sukses-sub {
            font-size: .9rem;
            color: var(--muted);
            margin-bottom: 24px;
        }

        /* No pesanan */
        .no-pesanan-box {
            background: var(--accent2);
            border: 1.5px dashed var(--accent);
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 20px;
        }
        .no-pesanan-label { font-size: .78rem; color: var(--muted); margin-bottom: 4px; }
        .no-pesanan-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--brand);
            letter-spacing: .05em;
        }

        /* Total */
        .total-box {
            background: var(--bg);
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-label { font-size: .85rem; color: var(--muted); }
        .total-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--brand);
        }

        /* Steps next */
        .next-steps {
            text-align: left;
            background: var(--accent2);
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 24px;
        }
        .next-steps h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--brand);
            margin-bottom: 10px;
        }
        .next-step-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 8px;
            font-size: .84rem;
            color: var(--text);
        }
        .next-step-item:last-child { margin-bottom: 0; }
        .step-dot {
            width: 22px; height: 22px;
            background: var(--brand);
            border-radius: 50%;
            color: #fff;
            font-size: .7rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }

        /* Buttons */
        .btn-wa {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%;
            background: #25d366;
            color: #fff;
            border: none; border-radius: 12px;
            padding: 13px;
            font-family: 'Jost', sans-serif;
            font-weight: 700; font-size: .95rem;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 10px;
            transition: all .25s;
            box-shadow: 0 4px 16px rgba(37,211,102,.3);
        }
        .btn-wa:hover { opacity: .92; transform: translateY(-1px); }

        .btn-home {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%;
            background: transparent;
            color: var(--muted);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 12px;
            font-family: 'Jost', sans-serif;
            font-weight: 600; font-size: .9rem;
            cursor: pointer;
            text-decoration: none;
            transition: all .25s;
        }
        .btn-home:hover { border-color: var(--brand); color: var(--brand); }

        /* Petals animation */
        .petal {
            position: fixed;
            pointer-events: none;
            font-size: 1.2rem;
            animation: petalFall linear forwards;
            z-index: 999;
        }
        @keyframes petalFall {
            0%   { transform: translateY(-10vh) rotate(0deg); opacity: 1; }
            100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 16px;
            font-size: .78rem;
            color: var(--muted);
        }
    </style>
</head>
<body>

<?php
// Ambil parameter dari URL
$no_pesanan = htmlspecialchars($_GET['no']     ?? 'AZ-XXXXXX');
$total      = (int)($_GET['total']             ?? 0);
$nama       = htmlspecialchars($_GET['nama']   ?? '');
$metode     = htmlspecialchars($_GET['metode'] ?? '');

// Ambil detail dari DB jika ada
$host = "localhost"; $user = "root"; $pass = ""; $db = "azura_buket";
$conn = @mysqli_connect($host, $user, $pass, $db);

$pesanan    = null;
$detail     = [];

if ($conn) {
    $no_e = mysqli_real_escape_string($conn, $no_pesanan);

    $q = mysqli_query($conn, "SELECT * FROM pesanan WHERE no_pesanan='$no_e'");
    if ($q) $pesanan = mysqli_fetch_assoc($q);

    $d = mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE no_pesanan='$no_e'");
    if ($d) while ($row = mysqli_fetch_assoc($d)) $detail[] = $row;

    // Hitung total dari detail jika belum ada
    if (!$total && !empty($detail)) {
        $total = array_sum(array_column($detail, 'subtotal'));
    }
}

// WhatsApp message
$wa_no = '6281234567890';
$items_text = '';
foreach ($detail as $d) {
    $items_text .= "%0A• {$d['nama_produk']} x{$d['jumlah']} = Rp " . number_format($d['subtotal'],0,',','.');
}
if (!$items_text) $items_text = '%0A(Detail produk ada di sistem kami)';

$wa_msg = "Halo Azura Buket 🌸%0A%0A"
        . "Saya baru saja melakukan pesanan:%0A"
        . "No. Pesanan: *{$no_pesanan}*%0A"
        . "Nama: " . ($pesanan['nama'] ?? $nama) . "%0A"
        . "Total: Rp " . number_format($total,0,',','.')
        . "%0AProduk:{$items_text}%0A%0A"
        . "Mohon konfirmasi pesanan saya. Terima kasih! 💕";
?>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="index.php" class="navbar-brand">🌸 Azura <em style="color:#fde8ec;font-style:italic">Buket</em></a>
</nav>

<!-- MAIN -->
<div class="main">
    <div class="sukses-card">

        <!-- Centang animasi -->
        <div class="check-wrap">
            <span class="check-icon">✓</span>
        </div>

        <h2 class="sukses-title">Pesanan Berhasil!</h2>
        <p class="sukses-sub">Terima kasih sudah memesan di Azura Buket 🌸<br>Kami akan segera memproses pesananmu.</p>

        <!-- No Pesanan -->
        <div class="no-pesanan-box">
            <div class="no-pesanan-label">Nomor Pesanan Kamu</div>
            <div class="no-pesanan-val"><?= $no_pesanan ?></div>
            <div style="font-size:.72rem;color:var(--muted);margin-top:4px">Simpan nomor ini untuk cek status pesanan</div>
        </div>

        <!-- Detail dari DB -->
        <?php if (!empty($detail)): ?>
        <div style="text-align:left;margin-bottom:16px">
            <?php foreach ($detail as $d): ?>
            <div style="display:flex;justify-content:space-between;font-size:.85rem;padding:5px 0;border-bottom:1px solid var(--border)">
                <span><?= htmlspecialchars($d['nama_produk']) ?> ×<?= $d['jumlah'] ?></span>
                <span style="font-weight:600;color:var(--brand)">Rp <?= number_format($d['subtotal'],0,',','.') ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Total -->
        <?php if ($total): ?>
        <div class="total-box">
            <span class="total-label">Total Pembayaran</span>
            <span class="total-val">Rp <?= number_format($total, 0, ',', '.') ?></span>
        </div>
        <?php endif; ?>

        <!-- Langkah selanjutnya -->
        <div class="next-steps">
            <h4>📋 Langkah Selanjutnya</h4>
            <div class="next-step-item">
                <div class="step-dot">1</div>
                <span>Screenshot halaman ini sebagai bukti pesanan.</span>
            </div>
            <div class="next-step-item">
                <div class="step-dot">2</div>
                <span>Klik tombol WhatsApp di bawah untuk konfirmasi pesanan ke kami.</span>
            </div>
            <div class="next-step-item">
                <div class="step-dot">3</div>
                <span>Lakukan pembayaran sesuai metode yang dipilih <?= $metode ? "(<strong>$metode</strong>)" : '' ?>.</span>
            </div>
            <div class="next-step-item">
                <div class="step-dot">4</div>
                <span>Buketmu akan segera kami rangkai dan kirimkan! 🌸</span>
            </div>
        </div>

        <!-- Tombol WA Konfirmasi -->
        <a href="https://wa.me/<?= $wa_no ?>?text=<?= $wa_msg ?>" target="_blank" class="btn-wa">
            📱 Konfirmasi Pesanan via WhatsApp
        </a>

        <!-- Kembali ke toko -->
        <a href="index.php" class="btn-home">
            🌸 Kembali Belanja
        </a>

    </div>
</div>

<footer>
    &copy; <?= date('Y') ?> Azura Buket 🌸 — Semua pesanan dengan penuh cinta 💕
</footer>

<!-- Animasi kelopak bunga jatuh -->
<script>
(function() {
    const emojis = ['🌸','🌷','✿','🌺','💮'];
    let count = 0;
    function spawn() {
        if (count > 20) return;
        count++;
        const el = document.createElement('div');
        el.className = 'petal';
        el.textContent = emojis[Math.floor(Math.random() * emojis.length)];
        el.style.left = Math.random() * 100 + 'vw';
        el.style.animationDuration = (3 + Math.random() * 4) + 's';
        el.style.animationDelay    = Math.random() * 2 + 's';
        el.style.fontSize          = (10 + Math.random() * 14) + 'px';
        document.body.appendChild(el);
        setTimeout(() => { el.remove(); count--; }, 8000);
    }
    for (let i = 0; i < 15; i++) setTimeout(spawn, i * 200);
})();
</script>

</body>
</html>
