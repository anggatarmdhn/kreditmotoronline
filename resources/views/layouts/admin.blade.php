<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') – Angga Motors</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { margin: 0; background: #f1f5f9; color: #1e293b; }

        /* ══ Sidebar ══ */
        .adm-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; z-index: 40;
            width: 256px;
            background: linear-gradient(170deg, #0f172a 0%, #1e293b 100%);
            display: flex; flex-direction: column;
            box-shadow: 4px 0 28px rgba(0,0,0,.3);
            transition: transform .28s cubic-bezier(.4,0,.2,1);
        }
        .adm-sidebar-logo {
            display: flex; align-items: center; gap: 11px;
            padding: 22px 18px 18px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            text-decoration: none;
        }
        .adm-logo-icon {
            width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
            background: linear-gradient(135deg,#ef4444,#b91c1c);
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: 14px; color: #fff;
        }
        .adm-logo-text .t1 { font-size: 9px; letter-spacing: .2em; color: #94a3b8; text-transform: uppercase; }
        .adm-logo-text .t2 { font-size: 15px; font-weight: 800; color: #fff; line-height: 1.2; margin-top: 1px; }

        .adm-nav { flex: 1; overflow-y: auto; padding: 18px 10px 0; }
        .adm-nav-label {
            font-size: 9.5px; font-weight: 700; letter-spacing: .22em; text-transform: uppercase;
            color: #475569; padding: 0 10px; margin: 0 0 5px;
        }
        .adm-nav-group { margin-bottom: 20px; }
        .adm-nav-link {
            display: flex; align-items: center; gap: 9px; padding: 9px 11px;
            border-radius: 9px; margin-bottom: 1px; font-size: 13px; font-weight: 500;
            color: #94a3b8; text-decoration: none; cursor: pointer;
            transition: background .15s, color .15s; background: none; border: none; width: 100%; text-align: left;
        }
        .adm-nav-link:hover { background: rgba(255,255,255,.07); color: #e2e8f0; }
        .adm-nav-link.active { background: rgba(239,68,68,.14); color: #fca5a5; font-weight: 600; }
        .adm-nav-link .ico {
            width: 30px; height: 30px; border-radius: 7px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,.06); font-size: 14px;
        }
        .adm-nav-link.active .ico { background: rgba(239,68,68,.22); }

        .adm-sidebar-footer {
            border-top: 1px solid rgba(255,255,255,.07); padding: 12px 10px;
        }
        .adm-user-card {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 11px; border-radius: 9px; background: rgba(255,255,255,.05);
        }
        .adm-user-avatar {
            width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg,#ef4444,#b91c1c);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 13px; color: #fff;
        }
        .adm-user-name { font-size: 13px; font-weight: 600; color: #e2e8f0; }
        .adm-user-role { font-size: 11px; color: #64748b; margin-top: 1px; }

        /* ══ Overlay mobile ══ */
        .adm-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.45); z-index: 39;
        }
        .adm-overlay.show { display: block; }

        /* ══ Main wrap ══ */
        .adm-main { margin-left: 256px; min-height: 100vh; }

        /* ══ Topbar ══ */
        .adm-topbar {
            position: sticky; top: 0; z-index: 30;
            background: rgba(241,245,249,.93); backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 13px 28px; gap: 12px;
        }
        .adm-topbar-left { display: flex; align-items: center; gap: 10px; }
        .adm-hamburger {
            display: none; width: 36px; height: 36px; border-radius: 9px;
            border: 1px solid #e2e8f0; background: #fff; cursor: pointer;
            align-items: center; justify-content: center; flex-shrink: 0;
        }
        .adm-page-title h1 { font-size: 18px; font-weight: 800; color: #0f172a; line-height: 1.2; }
        .adm-page-title p  { font-size: 11px; color: #64748b; margin-top: 1px; }
        .adm-topbar-right { display: flex; align-items: center; gap: 8px; }
        .adm-badge {
            display: flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 600; border-radius: 999px;
            padding: 5px 12px; border: 1px solid;
        }
        .adm-badge.green { color: #047857; background: #d1fae5; border-color: #a7f3d0; }
        .adm-badge.date  { color: #475569; background: #fff; border-color: #e2e8f0; }
        .adm-logout-btn {
            font-size: 12px; font-weight: 700; color: #fff; background: #ef4444;
            border: none; border-radius: 999px; padding: 6px 15px; cursor: pointer; transition: background .16s;
        }
        .adm-logout-btn:hover { background: #dc2626; }

        /* ══ Page content ══ */
        .adm-content { padding: 26px 28px; }

        /* ══ Responsive ══ */
        @media (max-width: 1024px) {
            .adm-sidebar { transform: translateX(-100%); }
            .adm-sidebar.open { transform: translateX(0); }
            .adm-main { margin-left: 0; }
            .adm-hamburger { display: flex; }
            .adm-topbar { padding: 12px 16px; }
            .adm-content { padding: 18px 16px; }
        }
        @media (max-width: 640px) {
            .adm-badge.green, .adm-badge.date { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

@php
    $roleSlug          = Auth::user()?->role?->slug;
    $canSeeTransaction = in_array($roleSlug, ['marketing','surveyor','kolektor','owner'], true);
    $canManageMaster   = in_array($roleSlug, ['admin','owner'], true);
    $canManagePay      = in_array($roleSlug, ['marketing','kolektor','owner'], true);
    $initial           = strtoupper(substr(Auth::user()->name ?? 'A', 0, 1));
    $currentRoute      = request()->route()?->getName() ?? '';
    // Company settings
    $co_name      = \App\Models\Setting::get('company_name_short', 'Angga Motors');
    $co_logo_text = \App\Models\Setting::get('company_logo_text', 'KM');
    $co_logo_path = \App\Models\Setting::get('company_logo_path', '');
@endphp

<!-- Overlay mobile -->
<div class="adm-overlay" id="admOverlay" onclick="admCloseSidebar()"></div>

<!-- ══════════ SIDEBAR ══════════ -->
<aside class="adm-sidebar" id="admSidebar">

    <a href="{{ route('dashboard') }}" class="adm-sidebar-logo">
        <div class="adm-logo-icon">
            @if($co_logo_path)
                <img src="{{ asset('storage/'.$co_logo_path) }}" style="width:100%;height:100%;object-fit:cover;border-radius:11px;">
            @else
                {{ $co_logo_text }}
            @endif
        </div>
        <div class="adm-logo-text">
            <div class="t1">Staff CMS</div>
            <div class="t2">{{ $co_name }}</div>
        </div>
    </a>

    <nav class="adm-nav">

        {{-- Menu Utama --}}
        <div class="adm-nav-group">
            <div class="adm-nav-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="adm-nav-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}">
                <span class="ico">🏠</span> Dashboard
            </a>
            @if(in_array($roleSlug, ['manager', 'owner'], true))
            <a href="{{ route('monitoring') }}" class="adm-nav-link {{ $currentRoute === 'monitoring' ? 'active' : '' }}">
                <span class="ico">📊</span> Monitoring Penjualan
            </a>
            @endif
            <a href="{{ route('landing') }}" class="adm-nav-link" target="_blank">
                <span class="ico">🌐</span> Lihat Landing Page
            </a>
        </div>

        {{-- Transaksi --}}
        @if($canSeeTransaction)
        <div class="adm-nav-group">
            <div class="adm-nav-label">Transaksi</div>
            <a href="{{ route('pengajuan.index') }}" class="adm-nav-link {{ str_starts_with($currentRoute, 'pengajuan') ? 'active' : '' }}">
                <span class="ico">📋</span> Pengajuan Kredit
            </a>
            @if($canManagePay)
            <a href="{{ route('pembayaran.index') }}" class="adm-nav-link {{ str_starts_with($currentRoute, 'pembayaran') ? 'active' : '' }}">
                <span class="ico">💳</span> Pembayaran Angsuran
            </a>
            <a href="{{ route('kredit.index') }}" class="adm-nav-link {{ str_starts_with($currentRoute, 'kredit') ? 'active' : '' }}">
                <span class="ico">🏦</span> Manajemen Kredit
            </a>
            @endif
        </div>
        @endif

        {{-- Data Master --}}
        @if($canManageMaster)
        <div class="adm-nav-group">
            <div class="adm-nav-label">Data Master</div>
            <a href="{{ route('motor.index') }}" class="adm-nav-link {{ str_starts_with($currentRoute, 'motor') ? 'active' : '' }}">
                <span class="ico">🏍️</span> Katalog Motor
            </a>
            <a href="{{ route('banner.index') }}" class="adm-nav-link {{ str_starts_with($currentRoute, 'banner') ? 'active' : '' }}">
                <span class="ico">🖼️</span> Banner Landing
            </a>
            <a href="{{ route('company.edit') }}" class="adm-nav-link {{ $currentRoute === 'company.edit' ? 'active' : '' }}">
                <span class="ico">🏢</span> Profil Perusahaan
            </a>
        </div>
        @endif

        {{-- Akun --}}
        <div class="adm-nav-group">
            <div class="adm-nav-label">Akun</div>
            <a href="{{ route('profile.edit') }}" class="adm-nav-link {{ str_starts_with($currentRoute, 'profile') ? 'active' : '' }}">
                <span class="ico">👤</span> Profil Saya
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="adm-nav-link">
                    <span class="ico">🚪</span> Logout
                </button>
            </form>
        </div>

    </nav>

    <div class="adm-sidebar-footer">
        <div class="adm-user-card">
            <div class="adm-user-avatar">{{ $initial }}</div>
            <div>
                <div class="adm-user-name">{{ Auth::user()->name }}</div>
                <div class="adm-user-role">{{ ucfirst($roleSlug ?? 'User') }}</div>
            </div>
        </div>
    </div>

</aside>

<!-- ══════════ MAIN ══════════ -->
<div class="adm-main">

    <!-- Topbar -->
    <header class="adm-topbar">
        <div class="adm-topbar-left">
            <button class="adm-hamburger" onclick="admOpenSidebar()" aria-label="Buka menu">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#334155" stroke-width="2.5" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <div class="adm-page-title">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'Sistem Informasi Kredit Motor')</p>
            </div>
        </div>
        <div class="adm-topbar-right">
            <div class="adm-badge green">
                <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>
                Sistem Online
            </div>
            <div class="adm-badge date">{{ now()->translatedFormat('d M Y') }}</div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="adm-logout-btn">Logout</button>
            </form>
        </div>
    </header>

    <!-- Page content -->
    <main class="adm-content">

        {{-- Flash messages --}}
        @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:10px;padding:10px 16px;margin-bottom:18px;font-size:13px;">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background:#fff1f2;border:1px solid #fecaca;color:#991b1b;border-radius:10px;padding:10px 16px;margin-bottom:18px;font-size:13px;">
            ❌ {{ session('error') }}
        </div>
        @endif
        @if($errors->any())
        <div style="background:#fffbeb;border:1px solid #fde68a;color:#92400e;border-radius:10px;padding:10px 16px;margin-bottom:18px;font-size:13px;">
            <strong>Validasi gagal:</strong>
            <ul style="margin:6px 0 0 18px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        @yield('content')

    </main>
</div>

<script>
    function admOpenSidebar()  { document.getElementById('admSidebar').classList.add('open'); document.getElementById('admOverlay').classList.add('show'); }
    function admCloseSidebar() { document.getElementById('admSidebar').classList.remove('open'); document.getElementById('admOverlay').classList.remove('show'); }
</script>
@stack('scripts')
</body>
</html>
