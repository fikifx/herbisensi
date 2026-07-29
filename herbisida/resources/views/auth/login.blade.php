<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - HERBI Sense</title>
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#183F30">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    <link href="/css/herbi.css" rel="stylesheet">
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--paper), #E7F2DA);
            padding: 20px;
        }
        .login-card {
            background: #fff;
            width: 100%;
            max-width: 400px;
            border-radius: 24px;
            padding: 40px 32px;
            box-shadow: 0 20px 60px rgba(24, 63, 48, 0.08);
            border: 1px solid var(--line);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-logo .app-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--leaf), #5da320);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(124, 185, 59, 0.3);
            color: #fff;
        }
        .login-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--forest);
            margin: 0 0 6px;
        }
        .login-sub {
            font-size: 13px;
            color: var(--ink-soft);
            margin: 0;
            line-height: 1.5;
        }
        .install-pwa-btn {
            display: none;
            width: 100%;
            margin-top: 16px;
            background: var(--amber-light);
            color: #8A5A16;
            border: 1px dashed var(--amber);
            border-radius: 12px;
            padding: 14px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        .install-pwa-btn:hover {
            background: #f7e6c6;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-logo">
            <div class="app-icon">🌿</div>
            <h1 class="login-title">HERBI Sense</h1>
            <p class="login-sub">Sistem Manajemen Herbisida Presisi<br>Masuk untuk memulai pekerjaan</p>
        </div>

        @if($errors->any())
            <div class="flash-error" style="margin-bottom: 20px;">
                @foreach($errors->all() as $err)
                    {{ $err }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display:block; font-size:12px; font-weight:700; color:var(--ink-soft); margin-bottom:6px; text-transform:uppercase; letter-spacing:0.05em;">Email Akun</label>
                <input type="email" name="email" class="f-input" placeholder="admin@herbi.com" value="{{ old('email') }}" required style="padding:14px;">
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display:block; font-size:12px; font-weight:700; color:var(--ink-soft); margin-bottom:6px; text-transform:uppercase; letter-spacing:0.05em;">Kata Sandi</label>
                <input type="password" name="password" class="f-input" placeholder="••••••••" required style="padding:14px;">
            </div>

            <button type="submit" class="btn leaf" style="padding: 16px; font-size: 15px; margin-top:0;">
                Masuk ke Aplikasi
            </button>
        </form>

        <!-- Tombol Install PWA -->
        <button id="pwa-install-btn-login" class="install-pwa-btn" onclick="installPWA()">
            📲 Install Aplikasi HERBI ke Homescreen
        </button>
        
        <div style="text-align:center; margin-top:24px; font-size:11px; color:var(--ink-soft);">
            Versi 1.1.0 &copy; {{ date('Y') }} Agronomi Div 1
        </div>
    </div>
</div>

<script>
let deferredPrompt = null;
window.addEventListener('beforeinstallprompt', e => {
  e.preventDefault();
  deferredPrompt = e;
  // Tampilkan tombol instal di halaman login
  const btn = document.getElementById('pwa-install-btn-login');
  if (btn) btn.style.display = 'block';
});

function installPWA() {
  if (deferredPrompt) {
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then(() => { 
        deferredPrompt = null; 
        document.getElementById('pwa-install-btn-login').style.display = 'none';
    });
  }
}

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js').catch(() => {});
}
</script>

</body>
</html>
