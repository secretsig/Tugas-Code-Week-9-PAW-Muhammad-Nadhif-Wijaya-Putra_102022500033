-- Import file ini lewat phpMyAdmin (tab Import) atau paste di tab SQL
CREATE DATABASE IF NOT EXISTS klinik_rawat_jalan
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE klinik_rawat_jalan;

CREATE TABLE IF NOT EXISTS ruang (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nama_ruang  VARCHAR(50)  NOT NULL,
  jenis_poli  ENUM('Gigi','Umum') NOT NULL,
  gedung      VARCHAR(20)  NOT NULL,
  lantai      TINYINT      NOT NULL,
  kapasitas   VARCHAR(50)  NOT NULL
);

CREATE TABLE IF NOT EXISTS alat_medis (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  ruang_id         INT NOT NULL,
  nama_alat        VARCHAR(100) NOT NULL,
  jumlah           INT NOT NULL,
  kondisi          ENUM('Baik','Perlu Perawatan','Rusak') NOT NULL,
  tahun_pengadaan  SMALLINT NOT NULL,
  FOREIGN KEY (ruang_id) REFERENCES ruang(id) ON DELETE CASCADE
);

-- Data awal (dari halaman HTML sebelumnya)
INSERT INTO ruang (nama_ruang, jenis_poli, gedung, lantai, kapasitas) VALUES
('Poli Gigi 1', 'Gigi', 'Gedung A', 1, '2 dental chair'),
('Poli Umum 1', 'Umum', 'Gedung A', 1, '1 tempat periksa'),
('Poli Umum 2', 'Umum', 'Gedung A', 2, '1 tempat periksa');

INSERT INTO alat_medis (ruang_id, nama_alat, jumlah, kondisi, tahun_pengadaan) VALUES
(1, 'Dental Chair', 2, 'Baik', 2023),
(1, 'Dental X-Ray Unit', 1, 'Baik', 2022),
(1, 'Sterilisator', 1, 'Perlu Perawatan', 2020),
(1, 'Dental Instrument Set', 3, 'Baik', 2023);
