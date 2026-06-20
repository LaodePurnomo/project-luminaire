<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>☕</text></svg>">
<title>Luminaire - Profile</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<style>
  .page-header {
    width: 100%; max-width: 560px;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px;
  }
  .back-btn {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; color: var(--text-light);
    text-decoration: none; padding: 6px 10px;
    border-radius: 8px; transition: background 0.15s;
  }
  .back-btn:hover { background: var(--cream-dark); color: var(--text-mid); }
  .card { max-width: 560px; margin-bottom: 20px; }
  .card-subtitle { font-size: 13px; color: var(--text-light); margin-bottom: 20px; }
  .section-divider { height: 1px; background: var(--cream-dark); margin: 4px 0 20px; }
  .btn-danger {
    width: 100%; padding: 11px; border-radius: 999px;
    border: none; font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 500; cursor: pointer;
    background: #C0392B; color: #fff; transition: background 0.2s;
  }
  .btn-danger:hover { background: #A93226; }
  .success-msg { font-size: 13px; color: var(--sage); margin-left: 12px; }
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.4); z-index: 50;
    align-items: center; justify-content: center;
  }
  .modal-overlay.active { display: flex; }
  .modal-box {
    background: var(--warm-white); border-radius: 20px;
    padding: 32px; width: 100%; max-width: 420px;
    margin: 20px;
  }
  .modal-title { font-size: 16px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; }
  .modal-desc { font-size: 13px; color: var(--text-light); margin-bottom: 20px; line-height: 1.6; }
  .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
  .btn-sm {
    padding: 8px 20px; border-radius: 999px; border: none;
    font-family: 'DM Sans', sans-serif; font-size: 13px;
    font-weight: 500; cursor: pointer; transition: background 0.2s;
  }
  .btn-sm-secondary { background: var(--cream-dark); color: var(--text-mid); }
  .btn-sm-secondary:hover { background: var(--cream); }
  .btn-sm-danger { background: #C0392B; color: #fff; }
  .btn-sm-danger:hover { background: #A93226; }
</style>
</head>
<body>

<div class="page-header">
  <a class="logo" href="{{ route('chat.index') }}" style="margin-bottom:0;font-size:24px;text-decoration:none;">☕ luminaire.</a>
  <a class="back-btn" href="{{ route('chat.index') }}">
    ← Kembali
  </a>
</div>

{{-- Update Profile --}}
<div class="card">
  <div class="card-title">Informasi Profil</div>
  <div class="card-subtitle">Update nickname, username, email, dan gender kamu.</div>
  <div class="section-divider"></div>

  <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

  <form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="form-group">
      <label for="name">Nickname</label>
      <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
      @error('name') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required autocomplete="username" />
      @error('username') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email" />
      @error('email') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="gender">Kamu identifikasi sebagai?</label>
      <select id="gender" name="gender">
        <option value="laki-laki" {{ old('gender', $user->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
        <option value="perempuan" {{ old('gender', $user->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
      </select>
      @error('gender') <div class="error">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    @if(session('status') === 'profile-updated')
        <p style="font-size:13px;color:var(--sage);margin-top:8px;text-align:center;">Tersimpan!</p>
    @endif
  </form>
</div>

{{-- Update Password --}}
<div class="card">
  <div class="card-title">Ganti Password</div>
  <div class="card-subtitle">Gunakan password yang panjang dan acak agar akun tetap aman.</div>
  <div class="section-divider"></div>

  <form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="form-group">
      <label for="current_password">Password Saat Ini</label>
      <input id="current_password" name="current_password" type="password" autocomplete="current-password" />
      @error('current_password', 'updatePassword') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="new_password">Password Baru</label>
      <input id="new_password" name="password" type="password" autocomplete="new-password" />
      @error('password', 'updatePassword') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label for="password_confirmation">Konfirmasi Password Baru</label>
      <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
      @error('password_confirmation', 'updatePassword') <div class="error">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    @if(session('status') === 'password-updated')
        <p style="font-size:13px;color:var(--sage);margin-top:8px;text-align:center;">Password Updated!</p>
    @endif
  </form>
</div>

{{-- Delete Account --}}
<div class="card">
  <div class="card-title" style="color:#C0392B;">Hapus Akun</div>
  <div class="card-subtitle">Setelah akun dihapus, semua data akan hilang permanen.</div>
  <div class="section-divider"></div>
  <button class="btn-danger" onclick="document.getElementById('deleteModal').classList.add('active')">
    Hapus Akun
  </button>
</div>

{{-- Modal Delete --}}
<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <div class="modal-title">Yakin mau hapus akun?</div>
    <div class="modal-desc">Semua data kamu termasuk riwayat chat dan karakter akan dihapus permanen. Masukkan password untuk konfirmasi.</div>
    <form method="post" action="{{ route('profile.destroy') }}">
      @csrf
      @method('delete')
      <div class="form-group">
        <label for="delete_password">Password</label>
        <input id="delete_password" name="password" type="password" placeholder="Password kamu" />
        @error('password', 'userDeletion') <div class="error">{{ $message }}</div> @enderror
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-sm btn-sm-secondary" onclick="document.getElementById('deleteModal').classList.remove('active')">Batal</button>
        <button type="submit" class="btn-sm btn-sm-danger">Hapus Akun</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>