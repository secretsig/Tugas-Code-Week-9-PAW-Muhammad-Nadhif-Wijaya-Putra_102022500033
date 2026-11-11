<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modul Ruang Poliklinik - Daftar Ruang</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

  <header class="site-header">
    <h1>Sistem Informasi Klinik Rawat Jalan</h1>
    <p class="subtitle">Modul: Manajemen Ruang Poliklinik</p>
  </header>

<nav class="main-nav">
    <a href="{{ route('ruang.index') }}" class="active">Daftar Ruang</a>
    <span style="margin-left:auto; color:#fff;">
        {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
    </span>
    <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:10px;">
        @csrf
        <button type="submit">Logout</button>
    </form>
</nav>

  <main>
    @if(session('success'))
      <div class="alert alert-ok">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-error">Terjadi kesalahan input. Periksa kembali form Anda.</div>
    @endif

    <section class="intro">
      <h2>Daftar Ruang Poliklinik</h2>
      <p>Berikut adalah daftar ruang poli yang tersedia di klinik. Klik salah satu ruang untuk melihat detail dan inventaris alat medisnya.</p>
    </section>

    <section class="room-list">
      @foreach ($daftar as $r)
      <article class="room-card">
        <h3>{{ $r->nama_ruang }}</h3>
        <p><strong>Lokasi:</strong> {{ $r->gedung }}, Lantai {{ $r->lantai }}</p>
        <p><strong>Jenis Poli:</strong> {{ $r->jenis_poli }}</p>
        <a href="{{ route('ruang.show', $r->id) }}" class="btn-detail">Lihat Detail &rarr;</a>
        <a href="{{ route('ruang.edit', $r->id) }}" class="btn-detail">Edit</a>

        @can('hapus-data')
        <form action="{{ route('ruang.destroy', $r->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Hapus ruang ini beserta inventarisnya?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-hapus">Hapus</button>
        </form>
        @endcan
      </article>
      @endforeach

      @if ($daftar->isEmpty())
        <p>Belum ada data ruang.</p>
      @endif
    </section>

    <section class="form-box">
      <h2>Tambah Ruang Baru</h2>
      <form action="{{ route('ruang.store') }}" method="POST">
        @csrf

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