<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>☕</text></svg>">
<title>Luminaire - Kak Ara</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body>

<!-- ini ada di views/components/sidebar.blade.php ya bang -->
<x-sidebar active="ara" />

<main class="main">
  <div class="chat-header">
    <a class="back-btn" href="{{ route('chat.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
    <div class="ai-profile-pic">
      <img src="{{ asset('assets/ara-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;"/>
    </div>
    <div>
      <div class="ai-name">Kak Ara</div>
      <div class="ai-status">Siap dengerin kamu curhat.</div>
    </div>
    <button class="new-chat-btn" onclick="newChat()">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      New Chat
    </button>
  </div>

  <!-- ini ada di views/components/chat-disclaimer.blade.php ya bang -->
  <x-chat-disclaimer />

  <div class="messages" id="messages">
      @foreach($history as $msg)
        @if($msg->role === 'assistant')
        <div class="msg-row ai">
          <div class="msg-avatar"><img src="{{ asset('assets/ara-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"/></div>
          <div class="msg-group">
            <div class="bubble ai">{{ $msg->content }}</div>
          </div>
        </div>
        @else
        <div class="msg-row user">
          <div class="msg-group">
            <div class="bubble user">{{ $msg->content }}</div>
          </div>
        </div>
        @endif
      @endforeach
  </div>
  <!-- ini ada di views/components/chat-input.blade.php ya bang -->
  <x-chat-input />
</main>

<script>
  const SEND_URL  = "{{ route('chat.ara.send') }}";
  const RESET_URL = "{{ route('chat.ara.reset') }}";
  const CSRF      = document.querySelector('meta[name="csrf-token"]').content;
  let isTyping    = false;

  // Auto scroll ke bawah
  const msgs = document.getElementById('messages');
  msgs.scrollTop = msgs.scrollHeight;

  function getTime() {
    return new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
  }

  function appendMessage(text, sender) {
    const row = document.createElement('div');
    row.className = 'msg-row ' + sender;
    if (sender === 'ai') {
      row.innerHTML = `<div class="msg-avatar"><img src="{{ asset('assets/ara-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"/></div>
        <div class="msg-group">
          <div class="bubble ai">${text}</div>
        </div>`;
    } else {
      row.innerHTML = `<div class="msg-group">
          <div class="bubble user">${text}</div>
        </div>`;
    }
    msgs.appendChild(row);
    msgs.scrollTop = msgs.scrollHeight;
  }

  function showTyping() {
    const row = document.createElement('div');
    row.className = 'msg-row ai';
    row.id = 'typing-row';
    row.innerHTML = `<div class="msg-avatar"><img src="{{ asset('assets/ara-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"/></div>
      <div class="typing-dots"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>`;
    msgs.appendChild(row);
    msgs.scrollTop = msgs.scrollHeight;
  }

  function removeTyping() {
    const el = document.getElementById('typing-row');
    if (el) el.remove();
  }

  async function sendMessage() {
    const input = document.getElementById('chat-input');
    const text  = input.value.trim();
    if (!text || isTyping) return;
    input.value = '';
    isTyping = true;
    document.getElementById('send-btn').style.opacity = '0.5';

    appendMessage(text, 'user');
    showTyping();

    try {
      const res  = await fetch(SEND_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ message: text })
      });
      const data = await res.json();
      removeTyping();
      appendMessage(data.reply, 'ai');
    } catch (err) {
      removeTyping();
      appendMessage('Koneksi bermasalah nih. Coba lagi sebentar ya 🙏', 'ai');
    }

    isTyping = false;
    document.getElementById('send-btn').style.opacity = '1';
    input.focus();
  }

  async function newChat() {
    if (!confirm('Mulai percakapan baru? Riwayat chat akan dihapus.')) return;
    const res  = await fetch(RESET_URL, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': CSRF }
    });
    const data = await res.json();
    msgs.innerHTML = `<div class="msg-row ai">
        <div class="msg-avatar"><img src="{{ asset('assets/ara-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"/></div>
        <div class="msg-group">
          <div class="bubble ai">${data.greeting}</div>
        </div>
      </div>`;
  }

  document.getElementById('chat-input').addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
  });
</script>
</body>
</html>