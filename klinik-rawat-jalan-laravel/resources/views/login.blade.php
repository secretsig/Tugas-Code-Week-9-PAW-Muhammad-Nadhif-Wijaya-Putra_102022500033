<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Klinik Rawat Jalan</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
  <header class="site-header">
    <h1>Sistem Informasi Klinik Rawat Jalan</h1>
    <p class="subtitle">Silakan login untuk melanjutkan</p>
  </header>

  <main>
    <section class="form-box">
      <h2>Login</h2>

      @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
      @endif

      <form action="{{ route('login.process') }}" method="POST">
        @csrf
        <label>Email
          <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        <label>Password
          <input type="password" name="password" required>
        </label>
        <button type="submit" class="btn-simpan">Masuk</button>
      </form>
    </section>
  </main>
</body>
</html>