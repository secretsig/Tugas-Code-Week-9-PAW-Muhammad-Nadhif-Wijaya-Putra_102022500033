<?php
require 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'tambah') {
        $nama      = trim($_POST['nama_ruang'] ?? '');
        $jenis     = $_POST['jenis_poli'] ?? '';
        $gedung    = trim($_POST['gedung'] ?? '');
        $lantai    = (int)($_POST['lantai'] ?? 0);
        $kapasitas = trim($_POST['kapasitas'] ?? '');

        if ($nama === '' || $gedung === '' || $kapasitas === '' || $lantai < 1) {
            $error = 'Semua field wajib diisi dengan benar.';
        } elseif (!in_array($jenis, ['Gigi', 'Umum'], true)) {
            $error = 'Jenis poli tidak valid.';
        } else {
            $stmt = $pdo->prepare(
                "INSERT INTO ruang (nama_ruang, jenis_poli, gedung, lantai, kapasitas)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$nama, $jenis, $gedung, $lantai, $kapasitas]);
            header('Location: index.php?status=tambah');
            exit;
        }
    }

    if ($aksi === 'hapus') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM ruang WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: index.php?status=hapus');
        exit;
    }
}

$daftar = $pdo->query("SELECT * FROM ruang ORDER BY id")->fetchAll();

$status = $_GET['status'] ?? '';
$pesan  = '';
if ($status === 'tambah') $pesan = 'Ruang berhasil ditambahkan.';
if ($status === 'hapus')  $pesan = 'Ruang berhasil dihapus.';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modul Ruang Poliklinik - Daftar Ruang</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="site-header">
    <h1>Sistem Informasi Klinik Rawat Jalan</h1>
    <p class="subtitle">Modul: Manajemen Ruang Poliklinik</p>
  </header>

  <nav class="main-nav">
    <a href="index.php" class="active">Daftar Ruang</a>
  </nav>

  <main>
    <?php if ($pesan): ?><div class="alert alert-ok"><?= e($pesan) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

    <section class="intro">
      <h2>Daftar Ruang Poliklinik</h2>
      <p>Berikut adalah daftar ruang poli yang tersedia di klinik. Klik salah satu ruang untuk melihat detail dan inventaris alat medisnya.</p>
    </section>

    <section class="room-list">
      <?php foreach ($daftar as $r): ?>
      <article class="room-card">
        <h3><?= e($r['nama_ruang']) ?></h3>
        <p><strong>Lokasi:</strong> <?= e($r['gedung']) ?>, Lantai <?= e($r['lantai']) ?></p>
        <p><strong>Jenis Poli:</strong> <?= e($r['jenis_poli']) ?></p>
        <a href="ruang-detail.php?id=<?= (int)$r['id'] ?>" class="btn-detail">Lihat Detail &rarr;</a>
        <form method="POST" class="inline-form" onsubmit="return confirm('Hapus ruang ini beserta inventarisnya?')">
          <input type="hidden" name="aksi" value="hapus">
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button type="submit" class="btn-hapus">Hapus</button>
        </form>
      </article>
      <?php endforeach; ?>
      <?php if (!$daftar): ?><p>Belum ada data ruang.</p><?php endif; ?>
    </section>

    <section class="form-box">
      <h2>Tambah Ruang Baru</h2>
      <form method="POST">
        <input type="hidden" name="aksi" value="tambah">

        <label>Nama Ruang
          <input type="text" name="nama_ruang" required>
        </label>

        <label>Jenis Poli
          <select name="jenis_poli" required>
            <option value="Gigi">Gigi</option>
            <option value="Umum">Umum</option>
          </select>
        </label>

        <label>Lokasi Gedung
          <input type="text" name="gedung" placeholder="contoh: Gedung A" required>
        </label>

        <label>Lantai
          <input type="number" name="lantai" min="1" required>
        </label>

        <label>Kapasitas
          <input type="text" name="kapasitas" placeholder="contoh: 2 dental chair" required>
        </label>

        <button type="submit" class="btn-simpan">Simpan</button>
      </form>
    </section>
  </main>

  <footer class="site-footer">
    <p>Nama: Muhammad Nadhif Wijaya Putra | NIM: 102022500033</p>
    <p>Kelas: SI4906 | Kelompok 2</p>
    <p>Modul: Ruang Poliklinik &mdash; Studi Kasus: Sistem Informasi Klinik Rawat Jalan</p>
  </footer>

</body>
</html>
