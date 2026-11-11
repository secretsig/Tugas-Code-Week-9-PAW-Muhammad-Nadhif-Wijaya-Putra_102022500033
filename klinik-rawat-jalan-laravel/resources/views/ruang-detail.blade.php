<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Ruang Poliklinik & Inventaris Alat</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

  <header class="site-header">
    <h1>Sistem Informasi Klinik Rawat Jalan</h1>
    <p class="subtitle">Modul: Manajemen Ruang Poliklinik</p>
  </header>

  <nav class="main-nav">
    <a href="{{ route('ruang.index') }}">Daftar Ruang</a>
    <a href="{{ route('ruang.show', $ruang->id) }}" class="active">Detail Ruang & Inventaris</a>
  </nav>

  <main>
    @if(session('success'))
      <div class="alert alert-ok">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-error">Data alat medis tidak valid. Periksa kembali inputan Anda.</div>
    @endif

    <section class="room-detail">
      <h2>Detail Ruang: {{ $ruang->nama_ruang }}</h2>
      <table class="info-table">
        <tr><th>Nama Ruang</th><td>{{ $ruang->nama_ruang }}</td></tr>
        <tr><th>Jenis Poli</th><td>{{ $ruang->jenis_poli }}</td></tr>
        <tr><th>Lokasi Gedung</th><td>{{ $ruang->gedung }}</td></tr>
        <tr><th>Lantai</th><td>{{ $ruang->lantai }}</td></tr>
        <tr><th>Kapasitas</th><td>{{ $ruang->kapasitas }}</td></tr>
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
          @foreach ($ruang->alatMedis as $a)
          <tr>
            <td>{{ $a->nama_alat }}</td>
            <td>{{ $a->jumlah }}</td>
            <td>{{ $a->kondisi }}</td>
            <td>{{ $a->tahun_pengadaan }}</td>
            <td>
              <form action="{{ route('alat.destroy', $a->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Hapus alat ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-hapus">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach

          @if ($ruang->alatMedis->isEmpty())
          <tr><td colspan="5">Belum ada alat medis di ruang ini.</td></tr>
          @endif
        </tbody>
      </table>
    </section>

    <section class="form-box">
      <h2>Tambah Alat Medis</h2>
      <form action="{{ route('alat.store', $ruang->id) }}" method="POST">
        @csrf

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
          <input type="number" name="tahun_pengadaan" min="1990" max="{{ date('Y') }}" required>
        </label>

        <button type="submit" class="btn-simpan">Simpan</button>
      </form>
    </section>

    <a href="{{ route('ruang.index') }}" class="btn-back">&larr; Kembali ke Daftar Ruang</a>
  </main>

  <footer class="site-footer">
    <p>Nama: Muhammad Nadhif Wijaya Putra | NIM: 102022500033</p>
    <p>Modul: Ruang Poliklinik</p>
  </footer>

</body>
</html>