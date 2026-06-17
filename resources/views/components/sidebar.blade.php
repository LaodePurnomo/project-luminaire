@props(['active' => ''])

@php
  $customChar = auth()->user()
    ? \App\Models\CustomCharacter::where('user_id', auth()->id())->first()
    : null;
@endphp

<aside class="sidebar">
  <a class="logo" href="{{ route('chat.index') }}">☕ luminaire.</a>
  <div class="sidebar-label">Teman Curhat</div>

  <a class="nav-item {{ $active === 'ara' ? 'active' : '' }}" href="{{ route('chat.ara') }}">
    <div class="nav-avatar">
      <img src="{{ asset('assets/ara-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
    </div>
    <span>Kak Ara</span>
  </a>

  <a class="nav-item {{ $active === 'reza' ? 'active' : '' }}" href="{{ route('chat.reza') }}">
    <div class="nav-avatar">
      <img src="{{ asset('assets/reza-avatar.png') }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
    </div>
    <span>Kak Reza</span>
  </a>

  <div class="sidebar-divider"></div>
  <div class="sidebar-sub">Karaktermu</div>

  @if($customChar)
    <a class="nav-item {{ $active === 'custom' ? 'active' : '' }}" href="{{ route('chat.custom') }}">
      <div class="nav-avatar">
        @if($customChar->avatar)
          <img src="{{ asset('storage/' . $customChar->avatar) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
        @else
          🤖
        @endif
      </div>
      <span>{{ $customChar->name }}</span>
    </a>
    <a class="nav-create" href="{{ route('chat.create-character') }}?edit=1">Edit Karakter</a>
  @else
    <a class="nav-create" href="{{ route('chat.create-character') }}">+ Buat Karakter</a>
  @endif

  <div class="sidebar-footer">
    <div class="sidebar-divider" style="margin:10px 12px"></div>
    <a class="user-account" href="{{ route('profile.edit') }}">
      <div class="nav-avatar" style="width:32px;height:32px;font-size:13px;font-weight:600;color:#fff;">
        {{ strtoupper(substr(auth()->user()->username ?? auth()->user()->name, 0, 1)) }}
      </div>
      <div>
        <div class="ua-name">{{ auth()->user()->username ?? auth()->user()->name }}</div>
        <div class="ua-sub">Lihat profil</div>
      </div>
    </a>
  </div>
</aside>