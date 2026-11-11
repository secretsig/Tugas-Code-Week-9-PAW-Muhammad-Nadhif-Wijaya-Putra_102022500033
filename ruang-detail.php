<?php
require 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM ruang WHERE id = ?");
$stmt->execute([$id]);
$ruang = $stmt->fetch();

if (!$ruang) {
    http_response_code(404);
    die('Ruang tidak ditemukan. <a href="index.php">Kembali</a>');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'tambah_alat') {
        $nama    = trim($_POST['nama_alat'] ?? '');
        $jumlah  = (int)($_POST['jumlah'] ?? 0);
        $kondisi = $_POST['kondisi'] ?? '';
        $tahun   = (int)($_POST['tahun_pengadaan'] ?? 0);

        if ($nama === '' || $jumlah < 1 || $tahun < 1990 || $tahun > (int)date('Y')) {
            $error = 'Data alat tidak valid. Periksa nama, jumlah, dan tahun.';
        } elseif (!in_array($kondisi, ['Baik', 'Perlu Perawatan', 'Rusak'], true)) {
            $error = 'Kondisi tidak valid.';
        } else {
            $stmt = $pdo->prepare(
                "INSERT INTO alat_medis (ruang_id, nama_alat, jumlah, kondisi, tahun_pengadaan)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$id, $nama, $jumlah, $kondisi, $tahun]);
            header("Location: ruang-detail.php?id=$id&status=tambah");
            exit;
        }
    }

    if ($aksi === 'hapus_alat') {
        $alat_id = (int)($_POST['alat_id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM alat_medis WHERE id = ? AND ruang_id = ?");
        $stmt->execute([$alat_id, $id]);
        header("Location: ruang-detail.php?id=$id&status=hapus");
        exit;
    }
}

$stmt = $pdo->prepare("SELECT * FROM alat_medis WHERE ruang_id = ? ORDER BY id");
$stmt->execute([$id]);
$alat = $stmt->fetchAll();

$status = $_GET['status'] ?? '';
$pesan  = '';
if ($status === 'tambah') $pesan = 'Alat medis berhasil ditambahkan.';
if ($status === 'hapus')  $pesan = 'Alat medis berhasil dihapus.';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Ruang Poliklinik & Inventaris Alat</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="site-header">
    <h1>Sistem Informasi Klinik Rawat Jalan</h1>
    <p class="subtitle">Modul: Manajemen Ruang Poliklinik</p>
  </header>

  <nav class="main-nav">
    <a href="index.php">Daftar Ruang</a>
    <a href="ruang-detail.php?id=<?= (int)$ruang['id'] ?>" class="active">Detail Ruang & Inventaris</a>
  </nav>

  <main>
    <?php if ($pesan): ?><div class="alert alert-ok"><?= e($pesan) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

    <section class="room-detail">
      <h2>Detail Ruang: <?= e($ruang['nama_ruang']) ?></h2>
      <table class="info-table">
        <tr><th>Nama Ruang</th><td><?= e($ruang['nama_ruang']) ?></td></tr>
        <tr><th>Jenis Poli</th><td><?= e($ruang['jenis_poli']) ?></td></tr>
        <tr><th>Lokasi Gedung</th><td><?= e($ruang['gedung']) ?></td></tr>
        <tr><th>Lantai</th><td><?= e($ruang['lantai']) ?></td></tr>
        <tr><th>Kapasitas</th><td><?= e($ruang['kapasitas']) ?></td></tr>
      </table>
    </section>

    <section class="inventory">
      <h2>Inventaris Alat Medis</h2>
      <table class="inventory-table">
        <thead>
          <tr>
            <th>Nama Alat</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
            <th>Tahun Pengadaan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($alat as $a): ?>
          <tr>
            <td><?= e($a['nama_alat']) ?></td>
            <td><?= e($a['jumlah']) ?></td>
            <td><?= e($a['kondisi']) ?></td>
            <td><?= e($a['tahun_pengadaan']) ?></td>
            <td>
              <form method="POST" class="inline-form" onsubmit="return confirm('Hapus alat ini?')">
                <input type="hidden" name="aksi" value="hapus_alat">
                <input type="hidden" name="alat_id" value="<?= (int)$a['id'] ?>">
                <button type="submit" class="btn-hapus">Hapus</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (!$alat): ?>
          <tr><td colspan="5">Belum ada alat medis di ruang ini.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>

    <section class="form-box">
      <h2>Tambah Alat Medis</h2>
      <form method="POST">
        <input type="hidden" name="aksi" value="tambah_alat">

        <label>Nama Alat
          <input type="text" name="nama_alat" required>
        </label>

        <label>Jumlah
          <input type="number" name="jumlah" min="1" required>
        </label>

        <label>Kondisi
          <select name="kondisi" required>
            <option value="Baik">Baik</option>
            <option value="Perlu Perawatan">Perlu Perawatan</option>
            <option value="Rusak">Rusak</option>
          </select>
        </label>

        <label>Tahun Pengadaan
          <input type="number" name="tahun_pengadaan" min="1990" max="<?= date('Y') ?>" required>
        </label>

        <button type="submit" class="btn-simpan">Simpan</button>
      </form>
    </section>

    <a href="index.php" class="btn-back">&larr; Kembali ke Daftar Ruang</a>
  </main>

  <footer class="site-footer">
    <p>Nama: Muhammad Nadhif Wijaya Putra | NIM: 102022500033</p>
    <p>Modul: Ruang Poliklinik</p>
  </footer>

</body>
</html>
