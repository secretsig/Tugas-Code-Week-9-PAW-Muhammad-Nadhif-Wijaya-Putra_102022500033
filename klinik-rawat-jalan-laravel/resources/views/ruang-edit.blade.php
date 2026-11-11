<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Ruang Poliklinik</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

  <header class="site-header">
    <h1>Sistem Informasi Klinik Rawat Jalan</h1>
    <p class="subtitle">Modul: Manajemen Ruang Poliklinik</p>
  </header>

  <nav class="main-nav">
    <a href="{{ route('ruang.index') }}">Daftar Ruang</a>
    <a href="{{ route('ruang.edit', $ruang->id) }}" class="active">Edit Ruang</a>
  </nav>

  <main>
    @if($errors->any())
      <div class="alert alert-error">Terjadi kesalahan input. Periksa kembali form Anda.</div>
    @endif

    <section class="form-box">
      <h2>Edit Ruang: {{ $ruang->nama_ruang }}</h2>
      <form action="{{ route('ruang.update', $ruang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Ruang
          <input type="text" name="nama_ruang" value="{{ old('nama_ruang', $ruang->nama_ruang) }}" required>
        </label>

        <label>Jenis Poli
          <select name="jenis_poli" required>
            <option value="Gigi" @selected(old('jenis_poli', $ruang->jenis_poli) == 'Gigi')>Gigi</option>
            <option value="Umum" @selected(old('jenis_poli', $ruang->jenis_poli) == 'Umum')>Umum</option>
          </select>
        </label>

        <label>Lokasi Gedung
          <input type="text" name="gedung" value="{{ old('gedung', $ruang->gedung) }}" required>
        </label>

        <label>Lantai
          <input type="number" name="lantai" min="1" value="{{ old('lantai', $ruang->lantai) }}" required>
        </label>

        <label>Kapasitas
          <input type="text" name="kapasitas" value="{{ old('kapasitas', $ruang->kapasitas) }}" required>
        </label>

        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
      </form>
    </section>

    <a href="{{ route('ruang.index') }}" class="btn-back">&larr; Kembali ke Daftar Ruang</a>
  </main>

  <footer class="site-footer">
    <p>Modul: Ruang Poliklinik</p>
  </footer>

</body>
</html>