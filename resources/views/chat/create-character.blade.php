<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Luminaire — {{ $character ? 'Edit' : 'Buat' }} Karakter</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --sage: #6B7C6E; --sage-dark: #4E5E51; --sage-light: #8A9E8D;
    --cream: #F2EDE6; --cream-dark: #E4DDD5; --warm-white: #FAF8F5;
    --text-dark: #2C2C2A; --text-mid: #5A5A56; --text-light: #9A9A94;
  }
  body { font-family: 'DM Sans', sans-serif; background: var(--cream); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
  .card { background: var(--warm-white); border-radius: 24px; padding: 40px; width: 100%; max-width: 520px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
  .back-btn { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-light); text-decoration: none; margin-bottom: 28px; transition: color 0.15s; }
  .back-btn:hover { color: var(--text-mid); }
  .back-btn svg { width: 16px; height: 16px; }
  .title { font-family: 'DM Serif Display', serif; font-size: 26px; color: var(--text-dark); margin-bottom: 6px; }
  .subtitle { font-size: 14px; color: var(--text-light); margin-bottom: 32px; }
  .form-group { margin-bottom: 22px; }
  label { display: block; font-size: 13px; font-weight: 600; color: var(--text-mid); margin-bottom: 8px; }
  input[type="text"], textarea {
    width: 100%; padding: 12px 16px;
    border: 1.5px solid var(--cream-dark); border-radius: 12px;
    font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--text-dark);
    background: var(--warm-white); outline: none; transition: border-color 0.2s;
  }
  input[type="text"]:focus, textarea:focus { border-color: var(--sage-light); }
  textarea { resize: vertical; min-height: 140px; line-height: 1.6; }
  .hint { font-size: 12px; color: var(--text-light); margin-top: 6px; line-height: 1.5; }

  /* Avatar upload */
  .avatar-upload { display: flex; align-items: center; gap: 16px; }
  .avatar-preview {
    width: 72px; height: 72px; border-radius: 50%;
    background: var(--cream-dark); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; overflow: hidden; border: 2px solid var(--cream-dark);
  }
  .avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
  .upload-btn {
    display: flex; flex-direction: column; gap: 4px;
  }
  .upload-label {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 16px; border-radius: 99px;
    border: 1.5px solid var(--cream-dark); background: var(--warm-white);
    font-size: 13px; font-weight: 500; color: var(--text-mid);
    cursor: pointer; transition: background 0.15s;
  }
  .upload-label:hover { background: var(--cream-dark); }
  input[type="file"] { display: none; }

  /* Buttons */
  .btn-row { display: flex; gap: 12px; margin-top: 32px; }
  .btn-confirm {
    flex: 1; padding: 13px; border-radius: 12px;
    background: var(--sage); color: #fff; border: none;
    font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 500;
    cursor: pointer; transition: background 0.2s;
  }
  .btn-confirm:hover { background: var(--sage-dark); }
  .btn-delete {
    padding: 13px 20px; border-radius: 12px;
    background: #fff; color: #C0392B;
    border: 1.5px solid #F5C6C2;
    font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500;
    cursor: pointer; transition: background 0.2s;
  }
  .btn-delete:hover { background: #FDF0EF; }

  .error { font-size: 12px; color: #C0392B; margin-top: 5px; }
</style>
</head>
<body>

<div class="card">
  <a class="back-btn" href="{{ $character ? route('chat.custom') : route('chat.index') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali
  </a>

  <div class="title">{{ $character ? 'Edit Karakter' : 'Buat Karakter' }}</div>
  <div class="subtitle">{{ $character ? 'Ubah detail karakter AI kamu' : 'Buat teman curhat AI versi kamu sendiri' }}</div>

  <form
    action="{{ $character ? route('chat.update-character') : route('chat.store-character') }}"
    method="POST"
    enctype="multipart/form-data"
  >
    @csrf
    @if($character)
      @method('PUT')
    @endif

    {{-- Avatar --}}
    <div class="form-group">
      <label>Foto Profil</label>
      <div class="avatar-upload">
        <div class="avatar-preview" id="avatar-preview">
          @if($character && $character->avatar)
            <img src="{{ asset('storage/' . $character->avatar) }}" id="preview-img" />
          @else
            <span id="preview-emoji">🤖</span>
          @endif
        </div>
        <div class="upload-btn">
          <label class="upload-label" for="avatar-input">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Upload Foto
          </label>
          <input type="file" id="avatar-input" name="avatar" accept="image/*" onchange="previewAvatar(this)" />
          <span class="hint">JPG, PNG. Maks 2MB.</span>
        </div>
      </div>
      @error('avatar') <div class="error">{{ $message }}</div> @enderror
    </div>

    {{-- Nama --}}
    <div class="form-group">
      <label for="name">Nama Karakter</label>
      <input type="text" id="name" name="name"
        placeholder="contoh: Kak Luna, Mas Budi..."
        value="{{ old('name', $character->name ?? '') }}" required />
      @error('name') <div class="error">{{ $message }}</div> @enderror
    </div>

    {{-- Personality --}}
    <div class="form-group">
      <label for="personality">Kepribadian</label>
      <textarea id="personality" name="personality"
        placeholder="Deskripsikan kepribadian AI kamu. Contoh: Kamu adalah seorang perempuan yang ceria dan penuh semangat. Kamu suka memberikan motivasi dan selalu positif dalam melihat setiap situasi..."
        required>{{ old('personality', $character->personality ?? '') }}</textarea>
      <div class="hint">Jangan menggunakan prompt yang terlalu kompleks.</div>
      @error('personality') <div class="error">{{ $message }}</div> @enderror
    </div>

    {{-- First Chat Message --}}
    <div class="form-group">
    <label for="first_message">Pesan Pertama <span style="color:var(--text-light);font-weight:400;">(opsional)</span></label>
    <textarea id="first_message" name="first_message"
        placeholder="Contoh: Hei! Andi, senang bertemu kamu. Ada yang mau diceritain?"
        style="min-height: 80px;">{{ old('first_message', $character->first_message ?? '') }}</textarea>
    <div class="hint">Jika kosong, template message default akan digunakan.</div>
    </div>

    @if($character)
    <div style="
        background: #FDF6EC; border: 1px solid #F0DDB8;
        border-radius: 12px; padding: 12px 16px;
        font-size: 13px; color: #7A6040;
        display: flex; align-items: flex-start; gap: 8px;
        margin-bottom: 16px; line-height: 1.6;
    ">
        <span style="flex-shrink:0;">💡</span>
        <span>Setelah edit, klik <strong>New Chat</strong> di halaman chat agar AI menggunakan kepribadian yang baru.</span>
    </div>
    @endif

    <div class="btn-row">
      <button type="submit" class="btn-confirm">Confirm</button>
      @if($character)
        <button type="button" class="btn-delete" onclick="deleteCharacter()">Hapus Karakter</button>
      @endif
    </div>
  </form>

  {{-- Form hapus terpisah --}}
  @if($character)
  <form id="delete-form" action="{{ route('chat.delete-character') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
  </form>
  @endif
</div>

<script>
  function previewAvatar(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        const preview = document.getElementById('avatar-preview');
        preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;" />`;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  function deleteCharacter() {
    if (confirm('Hapus karakter ini? Semua riwayat chat juga akan dihapus.')) {
      document.getElementById('delete-form').submit();
    }
  }
</script>
</body>
</html>