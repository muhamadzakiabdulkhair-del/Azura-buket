-- ============================================================
-- AZURA BUKET — update_database.sql
-- Jalankan file ini HANYA jika kamu sudah import database lama
-- Cara: phpMyAdmin → pilih database azura_buket → tab SQL → paste & jalankan
-- ============================================================

USE `azura_buket`;

-- ── Tambah kolom status ke produk (jika belum ada) ──────────
ALTER TABLE `produk`
    ADD COLUMN IF NOT EXISTS `status` ENUM('aktif','nonaktif') DEFAULT 'aktif';

-- ── Tambah kolom role & no_hp ke staf (jika belum ada) ─────
ALTER TABLE `staf`
    ADD COLUMN IF NOT EXISTS `role`  ENUM('pemilik','admin','staf') DEFAULT 'staf',
    ADD COLUMN IF NOT EXISTS `no_hp` VARCHAR(20) DEFAULT '';

-- ── Buat tabel pesanan (baru) ────────────────────────────────
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `no_pesanan`   VARCHAR(50)  NOT NULL UNIQUE,
  `nama`         VARCHAR(100) NOT NULL,
  `no_hp`        VARCHAR(20)  NOT NULL,
  `alamat`       TEXT,
  `catatan`      TEXT,
  `metode_bayar` VARCHAR(50)  DEFAULT '',
  `status`       ENUM('pending','diproses','selesai','dibatalkan') DEFAULT 'pending',
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Buat tabel detail_pesanan (baru) ─────────────────────────
CREATE TABLE IF NOT EXISTS `detail_pesanan` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `no_pesanan`  VARCHAR(50)  NOT NULL,
  `id_produk`   INT          NOT NULL,
  `nama_produk` VARCHAR(200) NOT NULL,
  `harga`       INT          NOT NULL DEFAULT 0,
  `jumlah`      INT          NOT NULL DEFAULT 1,
  `subtotal`    INT          NOT NULL DEFAULT 0,
  FOREIGN KEY (`no_pesanan`) REFERENCES `pesanan`(`no_pesanan`) ON DELETE CASCADE,
  FOREIGN KEY (`id_produk`)  REFERENCES `produk`(`id`)          ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Selesai! Tidak ada data yang terhapus ───────────────────
SELECT 'Update database berhasil! Tabel pesanan & detail_pesanan sudah dibuat.' AS info;
