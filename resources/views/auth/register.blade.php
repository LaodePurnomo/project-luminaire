<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>☕</text></svg>">
<title>Luminaire - Register</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="logo">☕ luminaire.</div>
<p class="tagline">Buat akun Luminaire kamu.</p>

<div class="card">
  <div class="card-title">Daftar</div>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
      <label for="name">Nickname</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
      @error('name') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" />
      @error('username') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="gender">Kamu identifikasi sebagai?</label>
      <select id="gender" name="gender">
        <option value="" disabled selected>- Pilih -</option>
        <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
        <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
      </select>
      @error('gender') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
      @error('email') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required autocomplete="new-password" />
      @error('password') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="password_confirmation">Konfirmasi Password</label>
      <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
      @error('password_confirmation') <div class="error">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Daftar</button>
    <a href="{{ route('login') }}" class="btn btn-secondary">Sudah punya akun? Masuk</a>
  </form>
</div>

</body>
</html>