<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azura Buket — Toko Buket Bunga Cantik & Spesial</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant Garamond:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* ── RESET & VARIABLES ─────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --brand:        #c0395e;
            --brand-dark:   #8e1f3d;
            --brand-light:  #e8729a;
            --accent:       #f5c0cc;
            --accent2:      #fde8ec;
            --bg:           #fdf6f0;
            --card:         #FFFFFF;
            --text:         #3a2030;
            --muted:        #9b6b7e;
            --border:       #f0d0da;
            --shadow:       0 2px 12px rgba(107,63,31,.10);
            --shadow-hover: 0 8px 28px rgba(107,63,31,.18);
            --radius:       14px;
            --radius-sm:    8px;
            --font-head:    'Cormorant Garamond', sans-serif;
            --font-body:    'Jost', sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }
        img { display: block; max-width: 100%; }

        /* ── NAVBAR ───────────────────────────────────── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--brand);
            padding: 0 16px;
            height: 56px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.25);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-family: var(--font-head);
            font-weight: 800;
            font-size: 1.15rem;
            white-space: nowrap;
        }

        .navbar-brand .logo-icon {
            width: 32px; height: 32px;
            background: var(--accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .search-bar {
            flex: 1;
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            height: 36px;
        }

        .search-bar input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0 12px;
            font-size: .9rem;
            font-family: var(--font-body);
            color: var(--text);
        }

        .search-bar button {
            background: var(--accent);
            border: none;
            cursor: pointer;
            padding: 0 12px;
            height: 100%;
            font-size: 16px;
            transition: background .2s;
        }

        .search-bar button:hover { background: var(--accent2); }

        .nav-icons {
            display: flex;
            gap: 4px;
        }

        .nav-icon-btn {
            background: rgba(255,255,255,.15);
            border: none;
            cursor: pointer;
            width: 36px; height: 36px;
            border-radius: 8px;
            color: #fff;
            font-size: 18px;
            display: flex; align-items: center; justify-content: center;
            transition: background .2s;
            position: relative;
        }

        .nav-icon-btn:hover { background: rgba(255,255,255,.25); }

        .cart-badge {
            position: absolute;
            top: -2px; right: -2px;
            background: #ff3b30;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            width: 16px; height: 16px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-head);
        }

        /* ── SEARCH SUGGESTIONS ───────────────────────── */
        .search-wrap {
            flex: 1;
            position: relative;
        }

        .suggestions {
            position: absolute;
            top: 38px; left: 0; right: 0;
            background: #fff;
            border-radius: 0 0 var(--radius-sm) var(--radius-sm);
            box-shadow: var(--shadow-hover);
            overflow: hidden;
            display: none;
            z-index: 200;
        }

        .suggestion-item {
            padding: 10px 14px;
            font-size: .85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background .15s;
        }

        .suggestion-item:hover { background: var(--bg); }

        /* ── PROMO BANNER ─────────────────────────────── */
        .banner-section {
            padding: 12px 12px 0;
        }

        .banner-slider {
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-light) 60%, var(--accent) 100%);
            height: 160px;
        }

        @media (min-width: 640px)  { .banner-slider { height: 200px; } }
        @media (min-width: 1024px) { .banner-slider { height: 260px; } }

        .banner-slide {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            opacity: 0;
            transition: opacity .5s;
        }

        .banner-slide.active { opacity: 1; }

        .banner-text { color: #fff; }

        .banner-tag {
            font-family: var(--font-head);
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            background: rgba(255,255,255,.2);
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .banner-title {
            font-family: var(--font-head);
            font-weight: 800;
            font-size: clamp(1.2rem, 4vw, 2rem);
            line-height: 1.15;
            margin-bottom: 6px;
        }

        .banner-title span { color: var(--accent2); }

        .banner-sub {
            font-size: .8rem;
            opacity: .85;
            margin-bottom: 14px;
        }

        .banner-btn {
            background: #fff;
            color: var(--brand);
            font-family: var(--font-head);
            font-weight: 700;
            font-size: .8rem;
            padding: 8px 18px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .banner-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(0,0,0,.2);
        }

        .banner-deco {
            font-size: clamp(3rem, 10vw, 5rem);
            opacity: .25;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .banner-dots {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 5px;
        }

        .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,.4);
            cursor: pointer;
            transition: all .3s;
        }

        .dot.active {
            background: #fff;
            width: 18px;
            border-radius: 3px;
        }

        /* ── KATEGORI IKON ────────────────────────────── */
        .section { padding: 16px 12px 0; }

        .section-title {
            font-family: var(--font-head);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 12px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }

        @media (min-width: 640px)  { .category-grid { grid-template-columns: repeat(7, 1fr); } }
        @media (min-width: 1024px) { .category-grid { grid-template-columns: repeat(10, 1fr); } }

        .cat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .cat-icon {
            width: 64px; height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .cat-icon img {
            width: 100%; height: 100%;
            object-fit: cover;
            border-radius: 16px;
            transition: transform .3s;
        }

        .cat-item:hover .cat-icon {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .cat-item:hover .cat-icon img {
            transform: scale(1.08);
        }

        .cat-label {
            font-size: .65rem;
            font-weight: 600;
            color: var(--text);
            text-align: center;
            line-height: 1.3;
        }

        /* ── FLASH SALE STRIP ─────────────────────────── */
        .flash-strip {
            margin: 16px 12px 0;
            background: linear-gradient(90deg, var(--brand) 0%, var(--brand-light) 100%);
            border-radius: var(--radius);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
        }

        .flash-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .flash-icon { font-size: 1.4rem; }

        .flash-label {
            font-family: var(--font-head);
            font-weight: 800;
            font-size: 1rem;
        }

        .flash-sub { font-size: .72rem; opacity: .8; }

        .flash-timer {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .timer-box {
            background: rgba(0,0,0,.3);
            color: #fff;
            font-family: var(--font-head);
            font-weight: 700;
            font-size: .85rem;
            width: 30px; height: 28px;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
        }

        .timer-sep { font-weight: 700; font-size: .85rem; }

        /* ── PRODUK GRID ──────────────────────────────── */
        .produk-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 0 12px;
        }

        @media (min-width: 480px)  { .produk-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 768px)  { .produk-grid { grid-template-columns: repeat(4, 1fr); } }
        @media (min-width: 1024px) { .produk-grid { grid-template-columns: repeat(5, 1fr); } }
        @media (min-width: 1280px) { .produk-grid { grid-template-columns: repeat(6, 1fr); } }

        .produk-card {
            background: var(--card);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform .25s, box-shadow .25s;
            cursor: pointer;
            position: relative;
        }

        .produk-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .produk-img-wrap {
            position: relative;
            padding-top: 100%;
            background: #F0E8DE;
            overflow: hidden;
        }

        .produk-img-wrap img {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .4s;
        }

        .produk-card:hover .produk-img-wrap img {
            transform: scale(1.06);
        }

        .produk-badge {
            position: absolute;
            top: 8px; left: 8px;
            background: #ff3b30;
            color: #fff;
            font-family: var(--font-head);
            font-size: .6rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .badge-new  { background: var(--brand); }
        .badge-sale { background: #ff3b30; }
        .badge-low  { background: #FF9500; }

        .produk-wish {
            position: absolute;
            top: 8px; right: 8px;
            background: rgba(255,255,255,.9);
            border: none;
            cursor: pointer;
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            transition: transform .2s;
        }

        .produk-wish:hover { transform: scale(1.2); }
        .produk-wish.active { color: #ff3b30; }

        .produk-info {
            padding: 10px 10px 12px;
        }

        .produk-name {
            font-size: .8rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1.35;
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .produk-price {
            font-family: var(--font-head);
            font-weight: 700;
            font-size: .9rem;
            color: var(--brand);
        }

        .produk-stok {
            font-size: .68rem;
            color: var(--muted);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stok-bar {
            flex: 1;
            height: 3px;
            background: #f0d0da;
            border-radius: 2px;
            overflow: hidden;
        }

        .stok-fill {
            height: 100%;
            background: var(--accent);
            border-radius: 2px;
        }

        .produk-add-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--brand);
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 7px;
            font-size: 16px;
            border-top: 1px solid var(--border);
            width: 100%;
            transition: background .2s;
            font-family: var(--font-head);
            font-weight: 600;
            font-size: .75rem;
            gap: 5px;
        }

        .produk-add-btn:hover { background: var(--brand-dark); }

        /* ── SHIMMER SKELETON ─────────────────────────── */
        .skeleton { animation: shimmer 1.4s infinite; }

        @keyframes shimmer {
            0%   { background-position: -400px 0; }
            100% { background-position: 400px 0; }
        }

        .skeleton .skel-box {
            background: linear-gradient(90deg, #f0d0da 25%, #F5EDE3 50%, #f0d0da 75%);
            background-size: 800px 100%;
            animation: shimmer 1.4s infinite;
            border-radius: 8px;
        }

        /* ── LOAD MORE ────────────────────────────────── */
        .load-more-wrap {
            padding: 20px 12px 30px;
            text-align: center;
        }

        .load-more-btn {
            background: transparent;
            border: 2px solid var(--brand);
            color: var(--brand);
            font-family: var(--font-head);
            font-weight: 700;
            font-size: .85rem;
            padding: 10px 36px;
            border-radius: 24px;
            cursor: pointer;
            transition: all .2s;
        }

        .load-more-btn:hover {
            background: var(--brand);
            color: #fff;
        }

        /* ── BOTTOM NAV (mobile) ──────────────────────── */
        .bottom-nav {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #fff;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-around;
            padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
            z-index: 90;
            box-shadow: 0 -2px 12px rgba(0,0,0,.08);
        }

        @media (min-width: 768px) { .bottom-nav { display: none; } }

        .bn-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            cursor: pointer;
            color: var(--muted);
            font-size: .6rem;
            font-weight: 600;
            transition: color .2s;
        }

        .bn-item.active { color: var(--brand); }

        .bn-icon { font-size: 20px; }

        /* ── SPACER for bottom nav ────────────────────── */
        .bottom-spacer { height: 70px; }
        @media (min-width: 768px) { .bottom-spacer { height: 24px; } }

        /* ── TOAST ────────────────────────────────────── */
        .toast-wrap {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            z-index: 999;
            opacity: 0;
            transition: all .3s;
            pointer-events: none;
        }

        .toast-wrap.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .toast-msg {
            background: var(--brand-dark);
            color: #fff;
            font-family: var(--font-head);
            font-size: .8rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 24px;
            white-space: nowrap;
            box-shadow: var(--shadow-hover);
        }

        /* ── SEARCH ACTIVE ────────────────────────────── */
        .search-bar input:focus + .suggestions,
        .search-bar:focus-within .suggestions { display: block; }

        /* ── EMPTY STATE ──────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
            grid-column: 1 / -1;
        }

        .empty-state .icon { font-size: 3rem; margin-bottom: 12px; }
        .empty-state p { font-size: .9rem; }

        /* ── HEADER PRODUK ────────────────────────────── */
        .produk-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 12px 10px;
        }

        .produk-header-title {
            font-family: var(--font-head);
            font-weight: 800;
            font-size: 1rem;
        }

        .filter-chips {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding: 0 12px 12px;
            scrollbar-width: none;
        }
        .filter-chips::-webkit-scrollbar { display: none; }

        .chip {
            background: var(--card);
            border: 1.5px solid var(--border);
            color: var(--muted);
            font-size: .72rem;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 20px;
            white-space: nowrap;
            cursor: pointer;
            transition: all .2s;
        }

        .chip.active, .chip:hover {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        /* ── CONTAINER WIDE ───────────────────────────── */
        .page-wrap {
            max-width: 1400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<?php
$host = "localhost"; $user = "root"; $pass = ""; $db = "azura_buket";
$conn = mysqli_connect($host, $user, $pass, $db);
$search = trim($_GET['q'] ?? '');
$where  = $search ? "WHERE nama_produk LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'" : '';
$qProduk = mysqli_query($conn, "SELECT * FROM produk $where ORDER BY id DESC LIMIT 60");
$allProduk = [];
while ($r = mysqli_fetch_assoc($qProduk)) $allProduk[] = $r;
$totalProduk = count($allProduk);

// Untuk suggestions
$qSuggest = mysqli_query($conn, "SELECT nama_produk FROM produk ORDER BY RAND() LIMIT 5");
$suggestions = [];
while ($s = mysqli_fetch_assoc($qSuggest)) $suggestions[] = $s['nama_produk'];
?>

<div class="page-wrap">

<!-- ── NAVBAR ─────────────────────────────────────────── -->
<nav class="navbar">
    <a href="index.php" class="navbar-brand">
        <div class="logo-icon">🌸</div>
        <span>Azura<span style="color:var(--accent2)"> Buket</span></span>
    </a>

    <div class="search-wrap">
        <div class="search-bar">
            <input type="text" id="searchInput"
                   placeholder="Cari buket impianmu..."
                   value="<?= htmlspecialchars($search) ?>"
                   autocomplete="off"
                   onkeydown="if(event.key==='Enter')doSearch()">
            <button onclick="doSearch()">🔍</button>
        </div>
        <div class="suggestions" id="suggBox">
            <?php foreach ($suggestions as $sg): ?>
            <div class="suggestion-item" onclick="setSearch('<?= htmlspecialchars($sg) ?>')">
                🔍 <?= htmlspecialchars($sg) ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="nav-icons">
        <button class="nav-icon-btn" title="Keranjang" onclick="toggleCart()">
            🛒
            <span class="cart-badge" id="cartCount">0</span>
        </button>
    </div>
</nav>

<!-- ── BANNER SLIDER ──────────────────────────────────── -->
<div class="banner-section">
    <div class="banner-slider" id="bannerSlider">

        <div class="banner-slide active">
            <div class="banner-text">
                <span class="banner-tag">Koleksi Spesial</span>
                <div class="banner-title">Buket Mawar<br><span>Penuh Cinta</span></div>
                <div class="banner-sub">Temukan buket cantik terbaik<br>dari momen spesialmu</div>
                <button class="banner-btn" onclick="document.getElementById('produkSection').scrollIntoView({behavior:'smooth'})">
                    Pesan Sekarang →
                </button>
            </div>
            <div class="banner-deco">🌸</div>
        </div>

        <div class="banner-slide">
            <div class="banner-text">
                <span class="banner-tag">Flash Deal</span>
                <div class="banner-title">Diskon<br><span>Spesial</span></div>
                <div class="banner-sub">Stok terbatas!<br>Jangan sampai kehabisan</div>
                <button class="banner-btn" onclick="document.getElementById('produkSection').scrollIntoView({behavior:'smooth'})">
                    Lihat Produk →
                </button>
            </div>
            <div class="banner-deco">🎁</div>
        </div>

        <div class="banner-slide">
            <div class="banner-text">
                <span class="banner-tag">Koleksi Baru</span>
                <div class="banner-title">Koleksi<br><span>Terbaru</span></div>
                <div class="banner-sub">Produk baru hadir setiap minggu<br>Jangan ketinggalan!</div>
                <button class="banner-btn" onclick="document.getElementById('produkSection').scrollIntoView({behavior:'smooth'})">
                    Cek Sekarang →
                </button>
            </div>
            <div class="banner-deco">✨</div>
        </div>

        <div class="banner-dots" id="bannerDots">
            <div class="dot active" onclick="goSlide(0)"></div>
            <div class="dot" onclick="goSlide(1)"></div>
            <div class="dot" onclick="goSlide(2)"></div>
        </div>
    </div>
</div>

<!-- ── KATEGORI ───────────────────────────────────────── -->
<div class="section">
    <div class="section-title">Kategori</div>
    <div class="category-grid">
        <?php
        // nama file gambar disimpan di folder azura_buket/gambar/kategori/
        $cats = [
            ['Mawar',        'gambar/kategori/mawar.jpg'],
            ['Wisuda',         'gambar/kategori/wisuda.jpg'],
	    ['Anniversary',     'gambar/kategori/anniversary.jpg'],
            ['Money Buket',     'gambar/kategori/money.jpg'],
            ['Sunflower',     'gambar/kategori/sunflower.jpg'],
            ['Baby Shower', 'gambar/kategori/babyshower.jpg'],
            ['Snack Buket',     'gambar/kategori/snack.jpg'],
            ['Tulip',      'gambar/kategori/tulip.jpg'],
            ['Valentine',     'gambar/kategori/valentine.jpg'],
            ['Custom',       'gambar/kategori/custom.jpg'],
        ];
        foreach ($cats as $c):
        ?>
        <div class="cat-item" onclick="filterKategori('<?= $c[0] ?>')">
            <div class="cat-icon" style="background:<?= $c[2] ?>">
                <img src="<?= $c[1] ?>"
                     alt="<?= $c[0] ?>"
                     onerror="this.parentElement.innerHTML='<span style=font-size:28px><?= urlencode($c[0][0]) ?></span>'">
            </div>
            <span class="cat-label"><?= $c[0] ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ── FLASH SALE STRIP ───────────────────────────────── -->
<div class="flash-strip">
    <div class="flash-left">
        <span class="flash-icon">⚡</span>
        <div>
            <div class="flash-label">Promo Spesial</div>
            <div class="flash-sub">Berakhir dalam</div>
        </div>
    </div>
    <div class="flash-timer">
        <div class="timer-box" id="th">00</div>
        <span class="timer-sep">:</span>
        <div class="timer-box" id="tm">00</div>
        <span class="timer-sep">:</span>
        <div class="timer-box" id="ts">00</div>
    </div>
</div>

<!-- ── PRODUK ─────────────────────────────────────────── -->
<div id="produkSection">
    <div class="produk-header">
        <span class="produk-header-title">
            <?= $search ? '🔍 Hasil: "' . htmlspecialchars($search) . '"' : '🛒 Semua Produk' ?>
            <span style="font-size:.75rem;font-weight:400;color:var(--muted);margin-left:6px">(<?= $totalProduk ?>)</span>
        </span>
        <?php if ($search): ?>
            <a href="index.php" style="font-size:.75rem;color:var(--brand);font-weight:600">Lihat semua</a>
        <?php endif; ?>
    </div>

    <!-- Filter chips -->
    <div class="filter-chips">
        <div class="chip active" onclick="setChip(this,'')">Semua</div>
        <div class="chip" onclick="setChip(this,'termurah')">Termurah</div>
        <div class="chip" onclick="setChip(this,'termahal')">Termahal</div>
        <div class="chip" onclick="setChip(this,'stok')">Stok Terbanyak</div>
        <div class="chip" onclick="setChip(this,'terbaru')">Terbaru</div>
    </div>

    <div class="produk-grid" id="produkGrid">
        <?php if (empty($allProduk)): ?>
            <div class="empty-state">
                <div class="icon">🔍</div>
                <p>Produk tidak ditemukan.<br>Coba kata kunci lain.</p>
            </div>
        <?php else: ?>
            <?php foreach ($allProduk as $i => $p):
                $stokPersen = min(100, max(5, ($p['stok'] / 50) * 100));
                $isLow = $p['stok'] > 0 && $p['stok'] <= 5;
                $isNew = $i < 4;
            ?>
            <div class="produk-card"
                 data-harga="<?= $p['harga'] ?>"
                 data-stok="<?= $p['stok'] ?>"
                 data-nama="<?= htmlspecialchars($p['nama_produk']) ?>"
                 data-id="<?= $p['id'] ?>">

                <div class="produk-img-wrap">
                    <img src="admin/gambar/<?= htmlspecialchars($p['gambar']) ?>"
                         alt="<?= htmlspecialchars($p['nama_produk']) ?>"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/300x300/f0d0da/c0395e?text=🌸'">

                    <?php if ($p['stok'] == 0): ?>
                        <span class="produk-badge badge-sale">Habis</span>
                    <?php elseif ($isLow): ?>
                        <span class="produk-badge badge-low">Sisa <?= $p['stok'] ?></span>
                    <?php elseif ($isNew): ?>
                        <span class="produk-badge badge-new">Baru</span>
                    <?php endif; ?>

                    <button class="produk-wish" onclick="toggleWish(event, this)">🤍</button>
                </div>

                <div class="produk-info">
                    <div class="produk-name"><?= htmlspecialchars($p['nama_produk']) ?></div>
                    <div class="produk-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                    <div class="produk-stok">
                        <span><?= $p['stok'] ?> stok</span>
                        <div class="stok-bar">
                            <div class="stok-fill" style="width:<?= $stokPersen ?>%"></div>
                        </div>
                    </div>
                </div>

                <a href="checkout.php?produk=<?= $p['id'] ?>" class="produk-add-btn" style="display:block;text-align:center;text-decoration:none">
                    🛒 Pesan Sekarang
                </a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php if ($totalProduk >= 20): ?>
<div class="load-more-wrap">
    <button class="load-more-btn">Lihat Lebih Banyak</button>
</div>
<?php endif; ?>

<div class="bottom-spacer"></div>

</div><!-- /page-wrap -->

<!-- ── BOTTOM NAV ────────────────────────────────────── -->
<nav class="bottom-nav">
    <div class="bn-item active">
        <span class="bn-icon">🏠</span>
        <span>Beranda</span>
    </div>
    <div class="bn-item" onclick="document.getElementById('searchInput').focus()">
        <span class="bn-icon">🔍</span>
        <span>Cari</span>
    </div>
    <div class="bn-item" onclick="showToast('Fitur segera hadir!')">
        <span class="bn-icon">🛒</span>
        <span>Keranjang</span>
    </div>
    <div class="bn-item" onclick="showToast('Silakan login terlebih dahulu')">
        <span class="bn-icon">👤</span>
        <span>Akun</span>
    </div>
</nav>

<!-- ── TOAST ─────────────────────────────────────────── -->
<div class="toast-wrap" id="toast">
    <div class="toast-msg" id="toastMsg"></div>
</div>

<!-- ── CART PANEL ─────────────────────────────────────── -->
<div id="cartOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:998;" onclick="toggleCart()"></div>
<div id="cartPanel" style="position:fixed;top:0;right:0;bottom:0;width:min(360px,100vw);background:#fff;z-index:999;transform:translateX(100%);transition:transform .3s;display:flex;flex-direction:column;box-shadow:-4px 0 24px rgba(0,0,0,.15);">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;background:var(--brand);color:#fff;">
        <span style="font-family:var(--font-head);font-weight:700;font-size:1rem;">🛒 Keranjang Belanja</span>
        <button onclick="toggleCart()" style="background:none;border:none;color:#fff;font-size:20px;cursor:pointer;">✕</button>
    </div>
    <div id="cartItems" style="flex:1;overflow-y:auto;padding:12px 16px;">
        <p style="text-align:center;color:var(--muted);padding:40px 0;font-size:.9rem;">Keranjang masih kosong 🌸</p>
    </div>
    <div style="padding:14px 16px;border-top:1px solid var(--border);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <span style="font-family:var(--font-head);font-weight:700;">Total</span>
            <span id="cartTotal" style="font-family:var(--font-head);font-weight:800;color:var(--brand);font-size:1.1rem;">Rp 0</span>
        </div>
        <button onclick="showToast('Segera hubungi kami via WhatsApp! 🌸');toggleCart();" style="width:100%;background:var(--brand);color:#fff;border:none;border-radius:10px;padding:12px;font-family:var(--font-head);font-weight:700;font-size:.9rem;cursor:pointer;">
            Checkout →
        </button>
    </div>
</div>

<script>
// ── DATA PRODUK dari PHP ──────────────────────────────────
const semuaProduk = <?= json_encode($allProduk) ?>;
let cartCount = 0;
let cart = {}; // { id: { nama, harga, qty } }

// ── BANNER SLIDER ─────────────────────────────────────────
let slideIdx = 0;
const slides = document.querySelectorAll('.banner-slide');
const dots   = document.querySelectorAll('.dot');

function goSlide(n) {
    slides[slideIdx].classList.remove('active');
    dots[slideIdx].classList.remove('active');
    slideIdx = n;
    slides[slideIdx].classList.add('active');
    dots[slideIdx].classList.add('active');
}

setInterval(() => goSlide((slideIdx + 1) % slides.length), 4000);

// ── FLASH TIMER ───────────────────────────────────────────
function updateTimer() {
    const end = new Date();
    end.setHours(23, 59, 59, 0);
    const diff = end - new Date();
    if (diff <= 0) return;
    const h = Math.floor(diff / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    document.getElementById('th').textContent = String(h).padStart(2,'0');
    document.getElementById('tm').textContent = String(m).padStart(2,'0');
    document.getElementById('ts').textContent = String(s).padStart(2,'0');
}
updateTimer();
setInterval(updateTimer, 1000);

// ── SEARCH ────────────────────────────────────────────────
function doSearch() {
    const q = document.getElementById('searchInput').value.trim();
    window.location.href = 'index.php' + (q ? '?q=' + encodeURIComponent(q) : '');
}

function setSearch(val) {
    document.getElementById('searchInput').value = val;
    doSearch();
}

// ── KERANJANG ─────────────────────────────────────────────
function addToCart(e, id, nama) {
    e.stopPropagation();
    const produk = semuaProduk.find(p => p.id == id);
    const harga = produk ? Number(produk.harga) : 0;
    if (cart[id]) {
        cart[id].qty++;
    } else {
        cart[id] = { nama, harga, qty: 1 };
    }
    cartCount++;
    document.getElementById('cartCount').textContent = cartCount;
    renderCartPanel();
    showToast('✅ ' + nama + ' ditambahkan!');
}

function removeFromCart(id) {
    if (!cart[id]) return;
    cartCount -= cart[id].qty;
    delete cart[id];
    document.getElementById('cartCount').textContent = cartCount;
    renderCartPanel();
}

function changeQty(id, delta) {
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) { removeFromCart(id); return; }
    cartCount += delta;
    document.getElementById('cartCount').textContent = cartCount;
    renderCartPanel();
}

function renderCartPanel() {
    const container = document.getElementById('cartItems');
    const keys = Object.keys(cart);
    if (!keys.length) {
        container.innerHTML = '<p style="text-align:center;color:var(--muted);padding:40px 0;font-size:.9rem;">Keranjang masih kosong 🌸</p>';
        document.getElementById('cartTotal').textContent = 'Rp 0';
        return;
    }
    let total = 0;
    container.innerHTML = keys.map(id => {
        const item = cart[id];
        total += item.harga * item.qty;
        return `<div style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid var(--border);">
            <div style="flex:1;">
                <div style="font-size:.82rem;font-weight:600;color:var(--text);line-height:1.3;">${item.nama}</div>
                <div style="font-size:.78rem;color:var(--brand);font-weight:700;">Rp ${item.harga.toLocaleString('id-ID')}</div>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <button onclick="changeQty(${id},-1)" style="width:26px;height:26px;border:1px solid var(--border);background:#fff;border-radius:6px;cursor:pointer;font-size:14px;">−</button>
                <span style="font-weight:700;min-width:18px;text-align:center;">${item.qty}</span>
                <button onclick="changeQty(${id},1)" style="width:26px;height:26px;border:1px solid var(--border);background:#fff;border-radius:6px;cursor:pointer;font-size:14px;">+</button>
            </div>
            <button onclick="removeFromCart(${id})" style="background:none;border:none;cursor:pointer;font-size:16px;color:#ff3b30;">🗑</button>
        </div>`;
    }).join('');
    document.getElementById('cartTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

function toggleCart() {
    const panel = document.getElementById('cartPanel');
    const overlay = document.getElementById('cartOverlay');
    const isOpen = panel.style.transform === 'translateX(0%)';
    panel.style.transform = isOpen ? 'translateX(100%)' : 'translateX(0%)';
    overlay.style.display = isOpen ? 'none' : 'block';
}

// ── WISHLIST ──────────────────────────────────────────────
function toggleWish(e, btn) {
    e.stopPropagation();
    const active = btn.classList.toggle('active');
    btn.textContent = active ? '❤️' : '🤍';
    showToast(active ? '❤️ Ditambahkan ke wishlist!' : 'Dihapus dari wishlist');
}

// ── TOAST ─────────────────────────────────────────────────
let toastTimer;
function showToast(msg) {
    clearTimeout(toastTimer);
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    t.classList.add('show');
    toastTimer = setTimeout(() => t.classList.remove('show'), 2500);
}

// ── FILTER CHIPS ──────────────────────────────────────────
function setChip(el, type) {
    document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');

    let sorted = [...semuaProduk];
    if (type === 'termurah')  sorted.sort((a,b) => a.harga - b.harga);
    if (type === 'termahal')  sorted.sort((a,b) => b.harga - a.harga);
    if (type === 'stok')      sorted.sort((a,b) => b.stok - a.stok);
    if (type === 'terbaru')   sorted.sort((a,b) => b.id - a.id);

    renderGrid(sorted);
}

function renderGrid(list) {
    const grid = document.getElementById('produkGrid');
    if (!list.length) {
        grid.innerHTML = `<div class="empty-state"><div class="icon">📦</div><p>Tidak ada produk.</p></div>`;
        return;
    }
    grid.innerHTML = list.map((p, i) => {
        const pct  = Math.min(100, Math.max(5, (p.stok / 50) * 100));
        const isNew = i < 4;
        const badge = p.stok == 0
            ? `<span class="produk-badge badge-sale">Habis</span>`
            : (p.stok <= 5 ? `<span class="produk-badge badge-low">Sisa ${p.stok}</span>`
                           : (isNew ? `<span class="produk-badge badge-new">Baru</span>` : ''));
        return `
        <div class="produk-card">
            <div class="produk-img-wrap">
                <img src="admin/gambar/${p.gambar}" alt="${p.nama_produk}" loading="lazy"
                     onerror="this.src='https://placehold.co/300x300/f0d0da/c0395e?text=🌸'">
                ${badge}
                <button class="produk-wish" onclick="toggleWish(event,this)">🤍</button>
            </div>
            <div class="produk-info">
                <div class="produk-name">${p.nama_produk}</div>
                <div class="produk-price">Rp ${Number(p.harga).toLocaleString('id-ID')}</div>
                <div class="produk-stok">
                    <span>${p.stok} stok</span>
                    <div class="stok-bar"><div class="stok-fill" style="width:${pct}%"></div></div>
                </div>
            </div>
            <a href="checkout.php?produk=${p.id}" class="produk-add-btn" style="display:block;text-align:center;text-decoration:none">
                🛒 Pesan Sekarang
            </a>
        </div>`;
    }).join('');
}

// ── KATEGORI FILTER ───────────────────────────────────────
function filterKategori(kat) {
    document.getElementById('searchInput').value = kat;
    doSearch();
}

// ── SEARCH SUGGESTIONS live ───────────────────────────────
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    const box = document.getElementById('suggBox');
    if (!q) { box.innerHTML = ''; return; }
    const matches = semuaProduk
        .filter(p => p.nama_produk.toLowerCase().includes(q))
        .slice(0, 5);
    box.innerHTML = matches.map(p =>
        `<div class="suggestion-item" onclick="setSearch('${p.nama_produk.replace(/'/g,"\\'")}')">
            🔍 ${p.nama_produk}
         </div>`
    ).join('');
});
</script>
</body>
</html>
