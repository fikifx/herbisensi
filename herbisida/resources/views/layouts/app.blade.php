<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HERBI Sense') }}</title>
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#183F30">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    <link href="/css/herbi.css" rel="stylesheet">
    @stack('css')
</head>
<body>

<!-- DESKTOP SHELL -->
<div class="desktop-shell">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="app-icon">🌿</div>
            <div class="app-name">HERBI Sense</div>
            <div class="app-sub">Sistem Manajemen<br>Herbisida Presisi</div>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Main Menu</div>
            <a href="{{ route('beranda') }}" class="sidebar-item {{ request()->routeIs('beranda') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Beranda
            </a>
            <a href="{{ route('pekerjaan.index') }}" class="sidebar-item {{ request()->routeIs('pekerjaan.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                Pekerjaan
            </a>
            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                Dashboard
            </a>
            <div class="sidebar-section-label" style="margin-top:10px">Pengaturan</div>
            <a href="{{ route('akun') }}" class="sidebar-item {{ request()->routeIs('akun') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Akun Saya
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="avatar-row">
                <div class="mini-avatar">AN</div>
                <div>
                    <div class="role-badge">Supervisi</div>
                    <div class="role-name">Andi (Agronomi)</div>
                </div>
            </div>
        </div>
    </aside>

    <main class="desktop-main">
        <div class="desktop-topbar">
            @hasSection('back')
                <a href="@yield('back')" class="deskback">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                </a>
            @endif
            <h1>@yield('title', 'HERBI Sense')</h1>
            <div class="topbar-date">{{ now()->locale('id')->isoFormat('D MMM YYYY') }}</div>
        </div>
        <div class="desktop-content">
            @yield('content_desktop')
        </div>
    </main>
    <div id="desktop-toast" class="desktop-toast">Notifikasi</div>
</div>

<!-- MOBILE SHELL -->
<div class="mobile-shell">
    <div class="statusbar">
        <div class="time" id="status-time">09:41</div>
        <div class="dots">
            <div class="bar" style="height:4px"></div>
            <div class="bar" style="height:6px"></div>
            <div class="bar" style="height:8px"></div>
            <div class="bar" style="height:10px"></div>
        </div>
    </div>
    
    <div class="content" id="mobile-content">
        <div class="topbar">
            @hasSection('back')
            <a href="@yield('back')" class="backbtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            @endif
            <h2>@yield('title', 'HERBI Sense')</h2>
        </div>

        @if(session('success'))
            <div class="flash-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash-error">❌ {{ session('error') }}</div>
        @endif

        @yield('content_mobile')
    </div>

    <!-- BOTTOM NAV -->
    <div class="bottomnav">
        <a href="{{ route('beranda') }}" class="navitem {{ request()->routeIs('beranda') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Beranda
        </a>
        <a href="{{ route('pekerjaan.index') }}" class="navitem {{ request()->routeIs('pekerjaan.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Pekerjaan
        </a>
        <a href="{{ route('dashboard') }}" class="navitem {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            Dashboard
        </a>
        <a href="{{ route('akun') }}" class="navitem {{ request()->routeIs('akun') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            Akun
        </a>
    </div>

    <!-- PWA Install Button (Hidden by default) -->
    <div id="pwa-install-btn" style="display:none; position:fixed; bottom:80px; right:16px; background:var(--amber); color:#fff; padding:12px 18px; border-radius:100px; font-weight:700; font-size:13px; box-shadow:0 4px 12px rgba(232,162,58,0.4); cursor:pointer; align-items:center; gap:8px;" onclick="installPWA()">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        Install App
    </div>

    <div id="toast" class="toast">Notifikasi</div>
</div>

<!-- GLOBAL MODAL OVERLAY -->
<div class="modal-overlay" id="modal-overlay" onclick="closeModalOutside(event)">
    <div class="modal-box" id="modal-box">
        <div class="modal-header">
            <div class="modal-title" id="modal-title">Judul Modal</div>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body" id="modal-body">
            @yield('modal_content')
        </div>
    </div>
</div>

<!-- GLOBAL CONFIRM OVERLAY -->
<div class="confirm-overlay" id="confirm-overlay">
    <div class="confirm-box">
        <div class="confirm-icon">⚠️</div>
        <div class="confirm-title" id="confirm-title">Hapus Data?</div>
        <div class="confirm-sub" id="confirm-sub">Data yang dihapus tidak dapat dikembalikan.</div>
        <form id="delete-form" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
        <div class="confirm-btns">
            <button class="confirm-cancel" onclick="closeConfirm()">Batal</button>
            <button class="confirm-delete" onclick="execDelete()">Hapus</button>
        </div>
    </div>
</div>

<script src="/js/herbi.js"></script>
<script>
    // Update jam
    setInterval(()=>{
        const d = new Date();
        const m = d.getMinutes().toString().padStart(2,'0');
        const h = d.getHours().toString().padStart(2,'0');
        const t = document.getElementById('status-time');
        if(t) t.textContent = `${h}:${m}`;
    }, 1000);
</script>
@stack('js')
</body>
</html>
