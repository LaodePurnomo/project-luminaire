<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Luminaire</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --sage: #6B7C6E; --sage-dark: #4E5E51;
    --cream: #F2EDE6; --cream-dark: #E4DDD5;
    --warm-white: #FAF8F5;
    --text-dark: #2C2C2A; --text-mid: #5A5A56; --text-light: #9A9A94;
  }
  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0;
  }

  .logo {
    font-family: 'DM Serif Display', serif;
    font-size: 52px;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 12px;
    opacity: 0;
    transform: translateY(16px);
    animation: fadeUp 0.7s ease forwards;
    animation-delay: 0.1s;
  }

  .tagline {
    font-size: 15px;
    color: var(--text-light);
    margin-top: 12px;
    opacity: 0;
    transform: translateY(12px);
    animation: fadeUp 0.7s ease forwards;
    animation-delay: 0.3s;
  }

  .buttons {
    display: flex;
    gap: 12px;
    margin-top: 40px;
    opacity: 0;
    transform: translateY(12px);
    animation: fadeUp 0.7s ease forwards;
    animation-delay: 0.5s;
  }

  .btn {
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 500;
    padding: 11px 32px;
    border-radius: 999px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
  }
  .btn:active { transform: scale(0.97); }

  .btn-primary {
    background: var(--sage);
    color: #fff;
  }
  .btn-primary:hover { background: var(--sage-dark); }

  .btn-secondary {
    background: var(--warm-white);
    color: var(--text-mid);
    border: 1.5px solid var(--cream-dark);
  }
  .btn-secondary:hover { background: var(--cream-dark); }

  .footer {
    position: fixed;
    bottom: 24px;
    font-size: 12px;
    color: var(--text-light);
    opacity: 0;
    animation: fadeUp 0.7s ease forwards;
    animation-delay: 0.7s;
  }

  @keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
  }
</style>
</head>
<body>

  <div class="logo">☕ luminaire.</div>
  <p class="tagline">Tempat kamu cerita, tanpa takut dihakimi.</p>

  <div class="buttons">
    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
  </div>

  <p class="footer">💛 Ruang aman untuk cerita. 🤍</p>

</body>
</html>