<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>☕</text></svg>">
<title>Luminaire - Pilih Teman Curhat</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --sage: #6B7C6E; --sage-dark: #4E5E51; --sage-light: #8A9E8D;
    --cream: #F2EDE6; --cream-dark: #E4DDD5;
    --warm-white: #FAF8F5; --text-dark: #2C2C2A;
    --text-mid: #5A5A56; --text-light: #9A9A94;
  }
  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
  }
  .logo {
    font-family: 'DM Serif Display', serif;
    font-size: 32px; color: var(--text-dark);
    margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
  }
  .tagline { font-size: 14px; color: var(--text-light); margin-bottom: 52px; text-align: center; }
  .cards { display: flex; gap: 24px; flex-wrap: wrap; justify-content: center; margin-bottom: 40px; }
  .card {
    background: var(--warm-white); border: 1.5px solid var(--cream-dark);
    border-radius: 24px; padding: 36px 32px; width: 260px;
    display: flex; flex-direction: column; align-items: center; gap: 16px;
    cursor: pointer; text-decoration: none;
    transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
  }
  .card:hover { border-color: var(--sage-light); transform: translateY(-4px); box-shadow: 0 12px 32px rgba(107,124,110,0.12); }
  .card-avatar {
    width: 80px; height: 80px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 36px; margin-bottom: 4px; position: relative;
  }
  .card-avatar.ara { background: #F7EEF5; }
  .card-avatar.reza { background: #EBF2EC; }
  .card-name { 
    font-size: 20px; font-weight: 600; color: var(--text-dark); 
  }
  .card-role {
    font-size: 12px; font-weight: 500; letter-spacing: 0.06em;
    text-transform: uppercase; color: var(--sage);
    background: #EEF2EE; padding: 4px 12px; border-radius: 99px;
  }
  .card-desc { font-size: 13.5px; color: var(--text-mid); text-align: center; line-height: 1.65; }
  .card-cta {
    margin-top: 8px; background: var(--sage); color: #fff;
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500;
    padding: 10px 28px; border-radius: 999px; border: none;
    cursor: pointer; width: 100%;
  }
  .card:hover .card-cta { background: var(--sage-dark); }
  .card.placeholder { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
  .coming-soon {
    font-size: 11px; font-weight: 600; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--text-light);
    background: var(--cream-dark); padding: 4px 12px; border-radius: 99px;
  }
  .ph-line { height: 10px; border-radius: 5px; background: var(--cream-dark); }
  .footer-note { font-size: 12px; color: var(--text-light); text-align: center; max-width: 420px; line-height: 1.7; }
  .footer-note strong { color: var(--text-mid); }
  .nav-bar {
    position: fixed; top: 0; right: 0; padding: 16px 24px;
    display: flex; gap: 12px; align-items: center;
  }
  .nav-link {
    font-size: 13px; color: var(--text-mid); text-decoration: none;
    padding: 7px 16px; border-radius: 99px;
    border: 1px solid var(--cream-dark); background: var(--warm-white);
    transition: background 0.15s;
  }
  .nav-link:hover { background: var(--cream-dark); }
  .nav-link.primary { background: var(--sage); color: #fff; border-color: var(--sage); }
  .nav-link.primary:hover { background: var(--sage-dark); }
  .greeting { font-size: 13px; color: var(--text-light); }
</style>
</head>
<body>

<nav class="nav-bar">
  <span class="greeting">Hei, {{ auth()->user()->username ?? auth()->user()->name }}! 👋</span>
    @if(auth()->user()->is_admin)
      <a href="/admin" class="nav-link primary">Admin Dashboard</a>
  @endif
  <a href="{{ route('profile.edit') }}" class="nav-link">Profil</a>
  <form method="POST" action="{{ route('logout') }}" style="display:inline;">
    @csrf
    <button type="submit" class="nav-link">Logout</button>
  </form>
</nav>

<div class="logo">☕ luminaire.</div>
<p class="tagline">Pilih teman curhat kamu hari ini</p>

<div class="cards">
  <a class="card" href="{{ route('chat.ara') }}">
    <div class="card-avatar ara">
      <img src="{{ asset('assets/ara-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
    </div>
    <div class="card-name">Kak Ara</div>
    <div class="card-role">Teman Curhat</div>
    <div class="card-desc">Mau mendengarkan, sabar dan penuh dengan empati, tanpa menghakimi.</div>
    <button class="card-cta">Mulai Ngobrol</button>
  </a>

  <a class="card" href="{{ route('chat.reza') }}">
    <div class="card-avatar reza">
      <img src="{{ asset('assets/reza-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
    </div>
    <div class="card-name">Kak Reza</div>
    <div class="card-role">Mentor</div>
    <div class="card-desc">Membantu kamu melihat masalah dari sudut pandang yang lain.</div>
    <button class="card-cta">Mulai Ngobrol</button>
  </a>

  <a class="card" href="{{ route('chat.create-character') }}">
  <div class="card-avatar" style="background: #F0EDF7;">
    @php $customChar = \App\Models\CustomCharacter::where('user_id', auth()->id())->first(); @endphp
    @if($customChar && $customChar->avatar)
      <img src="{{ asset('storage/' . $customChar->avatar) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
    @else
      🤖
    @endif
  </div>
  @if($customChar)
    <div class="card-name">{{ $customChar->name }}</div>
    <div class="card-role">Karaktermu</div>
    <div class="card-desc">Karakter AI yang kamu buat kamu sendiri dengan kepribadian unik.</div>
    <button class="card-cta" style="background:#7C6E9E;">Chat Sekarang</button>
  @else
    <div class="card-name">Karaktermu</div>
    <div class="card-role">Custom</div>
    <div class="card-desc">Buat karakter AI versi kamu sendiri dengan kepribadian unik.</div>
    <button class="card-cta" style="background:#7C6E9E;">Buat Karakter</button>
  @endif
</a>

  <div class="card placeholder">
    <div class="card-avatar" style="font-size:28px;color:var(--text-light);">?</div>
    <div class="card-name" style="color:var(--text-light);">Karakter Baru</div>
    <div class="coming-soon">Segera Hadir</div>
    <div class="ph-line" style="width:75%"></div>
    <div class="ph-line" style="width:55%"></div>
  </div>
</div>

<p class="footer-note">💛 Luminaire bukan pengganti profesional. Jika kamu dalam kondisi darurat, hubungi <strong>Into The Light Indonesia 119 ext 8</strong>.</p>

</body>
</html>