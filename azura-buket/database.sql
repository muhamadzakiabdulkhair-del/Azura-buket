-- ============================================================
-- AZURA BUKET — database.sql
-- Sama persis dengan kedaikopi + tabel pesanan (checkout)
-- Import: phpMyAdmin > Import > pilih file ini
-- ============================================================

CREATE DATABASE IF NOT EXISTS `azura_buket`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `azura_buket`;

-- ── Tabel produk ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `produk` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `nama_produk` VARCHAR(200) NOT NULL,
  `harga`       INT NOT NULL DEFAULT 0,
  `stok`        INT NOT NULL DEFAULT 0,
  `gambar`      VARCHAR(255) DEFAULT '',
  `status`      ENUM('aktif','nonaktif') DEFAULT 'aktif',
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Tabel staf ───────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `staf` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `nama`       VARCHAR(100) NOT NULL,
  `username`   VARCHAR(60)  NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL,
  `role`       ENUM('pemilik','admin','staf') DEFAULT 'staf',
  `no_hp`      VARCHAR(20)  DEFAULT '',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Tabel transaksi_masuk (barang masuk dari supplier) ───────
CREATE TABLE IF NOT EXISTS `transaksi_masuk` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `no_transaksi` VARCHAR(50) NOT NULL UNIQUE,
  `tanggal`      DATETIME NOT NULL,
  `keterangan`   TEXT,
  `total_item`   INT NOT NULL DEFAULT 0,
  `created_by`   VARCHAR(60) NOT NULL,
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Tabel detail_transaksi_masuk ─────────────────────────────
CREATE TABLE IF NOT EXISTS `detail_transaksi_masuk` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `no_transaksi` VARCHAR(50) NOT NULL,
  `id_produk`    INT NOT NULL,
  `jumlah`       INT NOT NULL DEFAULT 1,
  `harga_beli`   INT NOT NULL DEFAULT 0,
  FOREIGN KEY (`no_transaksi`) REFERENCES `transaksi_masuk`(`no_transaksi`) ON DELETE CASCADE,
  FOREIGN KEY (`id_produk`)    REFERENCES `produk`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Tabel pesanan (checkout dari website publik) ─────────────
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `no_pesanan`  VARCHAR(50) NOT NULL UNIQUE,
  `nama`        VARCHAR(100) NOT NULL,
  `no_hp`       VARCHAR(20)  NOT NULL,
  `alamat`      TEXT,
  `catatan`      TEXT,
  `metode_bayar` VARCHAR(50) DEFAULT '',
  `status`       ENUM('pending','diproses','selesai','dibatalkan') DEFAULT 'pending',
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Tabel detail_pesanan ─────────────────────────────────────
CREATE TABLE IF NOT EXISTS `detail_pesanan` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `no_pesanan`  VARCHAR(50) NOT NULL,
  `id_produk`   INT NOT NULL,
  `nama_produk` VARCHAR(200) NOT NULL,
  `harga`       INT NOT NULL DEFAULT 0,
  `jumlah`      INT NOT NULL DEFAULT 1,
  `subtotal`    INT NOT NULL DEFAULT 0,
  FOREIGN KEY (`no_pesanan`) REFERENCES `pesanan`(`no_pesanan`) ON DELETE CASCADE,
  FOREIGN KEY (`id_produk`)  REFERENCES `produk`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Data staf default ────────────────────────────────────────
INSERT INTO `staf` (`nama`, `username`, `password`, `role`, `no_hp`) VALUES
('Azura Rahmawati', 'admin',    MD5('azura2025'),  'pemilik', '081234567890'),
('Nisa Permata',    'florist1', MD5('florist123'), 'admin',   '081234567891'),
('Dinda Cantika',   'dinda',    MD5('staf123'),    'staf',    '081234567892');

-- ── Data produk contoh ───────────────────────────────────────
INSERT INTO `produk` (`nama_produk`, `harga`, `stok`, `gambar`, `status`) VALUES
('Buket Mawar Merah Premium',  95000,  10, '', 'aktif'),
('Buket Wisuda Pastel Cantik', 120000,  8, '', 'aktif'),
('Buket Tulip Romantic',       110000,  6, '', 'aktif'),
('Money Buket Eksklusif',      150000,  5, '', 'aktif'),
('Buket Sunflower Ceria',       85000, 12, '', 'aktif'),
('Buket Baby Shower Pink',     130000,  7, '', 'aktif'),
('Buket Snack Surprise',       100000,  9, '', 'aktif'),
('Buket Anniversary Gold',     200000,  4, '', 'aktif');

-- ── Data transaksi masuk contoh ──────────────────────────────
INSERT INTO `transaksi_masuk` (`no_transaksi`, `tanggal`, `keterangan`, `total_item`, `created_by`) VALUES
('TM-20250501-001', '2025-05-01 09:00:00', 'Beli stok mawar dari pasar bunga', 20, 'admin'),
('TM-20250503-002', '2025-05-03 10:30:00', 'Restok bunga tulip import',        10, 'florist1'),
('TM-20250504-003', '2025-05-04 08:00:00', 'Beli perlengkapan kemasan & pita', 30, 'dinda');

INSERT INTO `detail_transaksi_masuk` (`no_transaksi`, `id_produk`, `jumlah`, `harga_beli`) VALUES
('TM-20250501-001', 1, 10, 50000),
('TM-20250501-001', 5,  5, 30000),
('TM-20250501-001', 2,  5, 70000),
('TM-20250503-002', 3,  5, 65000),
('TM-20250503-002', 3,  5, 65000),
('TM-20250504-003', 4,  3, 80000),
('TM-20250504-003', 8,  2, 90000);

-- ── Contoh pesanan ───────────────────────────────────────────
INSERT INTO `pesanan` (`no_pesanan`, `nama`, `no_hp`, `alamat`, `catatan`, `status`) VALUES
('AZ-20250501-001', 'Rahel Amelia',  '081111111111', 'Jl. Mawar No.1 Cirebon', 'Tolong sertakan kartu ucapan ya', 'selesai'),
('AZ-20250502-002', 'Nisa Maharani', '082222222222', 'Jl. Tulip No.5 Bandung',  'Warna merah muda saja', 'diproses'),
('AZ-20250504-003', 'Dara Puspita',  '083333333333', 'Jl. Kenanga No.3 Jakarta','Buat hadiah wisuda sahabat',    'pending');

INSERT INTO `detail_pesanan` (`no_pesanan`, `id_produk`, `nama_produk`, `harga`, `jumlah`, `subtotal`) VALUES
('AZ-20250501-001', 1, 'Buket Mawar Merah Premium',  95000, 1,  95000),
('AZ-20250502-002', 2, 'Buket Wisuda Pastel Cantik', 120000, 1, 120000),
('AZ-20250502-002', 5, 'Buket Sunflower Ceria',       85000, 1,  85000),
('AZ-20250504-003', 8, 'Buket Anniversary Gold',     200000, 1, 200000);

-- ============================================================
-- Login Admin : admin    / azura2025
-- Login Staf  : florist1 / florist123  atau  dinda / staf123
-- ============================================================
