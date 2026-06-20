<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Luminaire — Masuk</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="logo">☕ luminaire.</div>
<p class="tagline">Selamat datang kembali!</p>

<div class="card">
  <div class="card-title">Masuk</div>

  @if (session('status'))
    <div class="session-status">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" />
      @error('email') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required autocomplete="current-password" />
      @error('password') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="remember">
      <input id="remember_me" type="checkbox" name="remember" />
      <label for="remember_me">Ingat saya</label>
    </div>

    @if (Route::has('password.request'))
      <a class="forgot" href="{{ route('password.request') }}">Lupa password?</a>
    @endif

    <button type="submit" class="btn btn-primary">Masuk</button>
    <a href="{{ route('register') }}" class="btn btn-secondary">Daftar Sekarang</a>
  </form>
</div>

</body>
</html>