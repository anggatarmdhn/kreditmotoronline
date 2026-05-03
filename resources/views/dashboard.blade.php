@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Ringkasan operasional sistem kredit motor')

@push('styles')
<style>
    .hero-banner {
        background: linear-gradient(120deg, #0f172a 0%, #1e3a5f 60%, #1e293b 100%);
        border-radius: 18px; padding: 30px 34px; margin-bottom: 22px;
        position: relative; overflow: hidden;
    }
    .hero-banner::before {
        content:''; position:absolute; top:-60px; right:-60px;
        width:200px; height:200px; border-radius:50%;
        background:rgba(239,68,68,.12); filter:blur(38px);
    }
    .hero-banner::after {
        content:''; position:absolute; bottom:-40px; left:32%;
        width:160px; height:160px; border-radius:50%;
        background:rgba(59,130,246,.10); filter:blur(32px);
    }
    .hero-inner { position:relative; z-index:1; }
    .hero-banner .h-eyebrow { font-size:10px; letter-spacing:.2em; text-transform:uppercase; color:#94a3b8; margin-bottom:6px; }
    .hero-banner h2 { font-size:24px; font-weight:900; color:#fff; line-height:1.25; margin:0 0 8px; }
    .hero-banner .h-sub { font-size:13px; color:#94a3b8; margin-bottom:18px; }
    .hero-actions { display:flex; gap:10px; flex-wrap:wrap; }
    .btn-hero-w { background:#fff; color:#0f172a; font-weight:700; font-size:12px; padding:8px 18px; border-radius:999px; text-decoration:none; }
    .btn-hero-g { background:rgba(255,255,255,.1); color:#e2e8f0; font-weight:600; font-size:12px; padding:8px 18px; border-radius:999px; text-decoration:none; border:1px solid rgba(255,255,255,.15); }

    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:22px; }
    .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; }
    .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--ac,#64748b); border-radius:14px 14px 0 0; }
    .stat-card.c-red    { --ac:#ef4444; }
    .stat-card.c-blue   { --ac:#3b82f6; }
    .stat-card.c-amber  { --ac:#f59e0b; }
    .stat-card.c-rose   { --ac:#f43f5e; }
    .stat-card.c-green  { --ac:#10b981; }
    .stat-card.c-purple { --ac:#8b5cf6; }
    .stat-label { font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.07em; }
    .stat-val   { font-size:34px; font-weight:900; color:#0f172a; margin:5px 0 3px; line-height:1; }
    .stat-sub   { font-size:11px; color:#94a3b8; }

    .two-col { display:grid; grid-template-columns:1fr 300px; gap:18px; align-items:start; }
    .adm-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; }
    .adm-card-hd { display:flex; align-items:center; justify-content:space-between; padding:16px 22px; border-bottom:1px solid #f1f5f9; }
    .adm-card-hd h3 { font-size:14px; font-weight:700; color:#0f172a; margin:0; }
    .adm-card-hd p  { font-size:11px; color:#94a3b8; margin:2px 0 0; }
    .cnt-badge { font-size:11px; font-weight:600; background:#f1f5f9; color:#475569; border-radius:999px; padding:3px 10px; }

    table { width:100%; border-collapse:collapse; font-size:12.5px; }
    thead th { padding:11px 18px; text-align:left; font-size:10.5px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
    tbody td { padding:12px 18px; color:#334155; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    tbody tr:hover { background:#f8fafc; }
    .td-code { font-weight:700; color:#0f172a; font-family:monospace; font-size:12px; }
    .td-name { font-weight:600; }
    .td-muted { color:#94a3b8; font-size:11px; }

    .sbadge { display:inline-flex; align-items:center; padding:3px 9px; border-radius:999px; font-size:11px; font-weight:600; }
    .sbadge.menunggu { background:#fef3c7; color:#92400e; }
    .sbadge.diterima { background:#d1fae5; color:#065f46; }
    .sbadge.ditolak  { background:#fee2e2; color:#991b1b; }
    .sbadge.diproses { background:#dbeafe; color:#1e40af; }
    .sbadge.default  { background:#f1f5f9; color:#475569; }

    .quick-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:18px; margin-bottom:14px; }
    .quick-card h4 { font-size:9.5px; font-weight:700; letter-spacing:.2em; text-transform:uppercase; color:#94a3b8; margin:0 0 12px; }
    .ql { display:flex; align-items:center; gap:8px; padding:9px 12px; border-radius:9px; border:1px solid #f1f5f9; text-decoration:none; color:#1e293b; font-size:12.5px; font-weight:500; transition:all .15s; margin-bottom:5px; }
    .ql:hover { background:#f8fafc; border-color:#e2e8f0; transform:translateX(3px); }
    .ql .qi { width:28px; height:28px; border-radius:7px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0; }

    .info-grad { background:linear-gradient(135deg,#fef3c7 0%,#fff 50%,#d1fae5 100%); border:1px solid #e2e8f0; border-radius:14px; padding:18px; }
    .info-grad .ig-label { font-size:9.5px; letter-spacing:.18em; font-weight:700; text-transform:uppercase; color:#d97706; margin-bottom:5px; }
    .info-grad h3 { font-size:15px; font-weight:800; color:#0f172a; margin:0 0 7px; }
    .info-grad p  { font-size:12px; color:#64748b; line-height:1.7; margin:0; }

    @media(max-width:1024px) {
        .stats-grid { grid-template-columns:repeat(2,1fr); }
        .two-col { grid-template-columns:1fr; }
    }
    @media(max-width:640px) { .stats-grid { grid-template-columns:1fr 1fr; } }
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="hero-banner">
    <div class="hero-inner">
        <div class="h-eyebrow">Selamat datang kembali, {{ Auth::user()->name }}</div>
        <h2>Pantau Seluruh Operasional<br>Kredit Motor Online</h2>
        <div class="h-sub">Kelola pengajuan, pembayaran, dan data master dari satu panel terintegrasi.</div>
        <div class="hero-actions">
            @if(in_array(Auth::user()?->role?->slug, ['marketing','surveyor','kolektor','owner'], true))
                <a href="{{ route('pengajuan.index') }}" class="btn-hero-w">📋 Kelola Pengajuan</a>
            @endif
            @if(in_array(Auth::user()?->role?->slug, ['marketing','kolektor','owner'], true))
                <a href="{{ route('pembayaran.index') }}" class="btn-hero-g">💳 Input Pembayaran</a>
            @endif
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card c-red">
        <div class="stat-label">Total Pelanggan</div>
        <div class="stat-val">{{ $stats['pelanggan'] }}</div>
        <div class="stat-sub">Terdaftar di sistem</div>
    </div>
    <div class="stat-card c-blue">
        <div class="stat-label">Motor Aktif</div>
        <div class="stat-val">{{ $stats['motor_aktif'] }}</div>
        <div class="stat-sub">Tersedia di katalog</div>
    </div>
    <div class="stat-card c-amber">
        <div class="stat-label">Menunggu Review</div>
        <div class="stat-val">{{ $stats['pengajuan_menunggu'] }}</div>
        <div class="stat-sub">Perlu segera ditindak</div>
    </div>
    <div class="stat-card c-rose">
        <div class="stat-label">Angsuran Tunggak</div>
        <div class="stat-val">{{ $stats['angsuran_tunggak'] }}</div>
        <div class="stat-sub">Perlu follow-up</div>
    </div>
    <div class="stat-card c-green">
        <div class="stat-label">Kredit Berjalan</div>
        <div class="stat-val">{{ $stats['kredit_berjalan'] }}</div>
        <div class="stat-sub">Kontrak aktif dicicil</div>
    </div>
    <div class="stat-card c-purple">
        <div class="stat-label">Total Pengajuan</div>
        <div class="stat-val">{{ $stats['total_pengajuan'] }}</div>
        <div class="stat-sub">Sejak sistem berjalan</div>
    </div>
</div>

{{-- DP Terbayar - Menunggu Aktivasi --}}
@if($menungguAktivasi->count() > 0 && in_array(Auth::user()?->role?->slug, ['marketing','owner'], true))
<div style="background:linear-gradient(135deg,#fff7ed 0%,#ffffff 60%,#fef3c7 100%);border:2px solid #fed7aa;border-radius:18px;padding:22px 26px;margin-bottom:22px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
        <div>
            <div style="font-size:10px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:#c2410c;margin-bottom:4px;">🔔 Perlu Tindakan</div>
            <h3 style="font-size:16px;font-weight:800;color:#0f172a;margin:0;">DP Terbayar — Menunggu Aktivasi Kredit</h3>
            <p style="font-size:12px;color:#64748b;margin:4px 0 0;">Pelanggan berikut sudah membayar DP. Klik "Aktifkan Kredit" untuk memulai cicilan bulanan.</p>
        </div>
        <span style="background:#fed7aa;color:#c2410c;font-size:12px;font-weight:700;padding:4px 14px;border-radius:999px;">{{ $menungguAktivasi->count() }} menunggu</span>
    </div>
    <div style="display:grid;gap:12px;">
        @foreach($menungguAktivasi as $p)
        <div style="background:#fff;border:1px solid #fed7aa;border-radius:12px;padding:16px 18px;display:flex;flex-wrap:wrap;gap:14px;align-items:center;justify-content:space-between;">
            <div style="display:flex;gap:14px;align-items:center;">
                @if($p->motor->foto1)
                    <img src="{{ asset('storage/'.$p->motor->foto1) }}" style="width:56px;height:56px;object-fit:cover;border-radius:10px;border:1px solid #e2e8f0;flex-shrink:0;">
                @else
                    <div style="width:56px;height:56px;background:#f1f5f9;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:10px;color:#94a3b8;flex-shrink:0;">🏍️</div>
                @endif
                <div>
                    <div style="font-weight:700;font-size:14px;color:#0f172a;">{{ $p->pelanggan?->nama_pelanggan ?? '—' }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;">{{ $p->motor?->nama_motor ?? '—' }}</div>
                    <div style="font-size:11px;color:#94a3b8;margin-top:3px;">
                        DP dibayar: <strong>Rp {{ number_format($p->dp, 0, ',', '.') }}</strong>
                        · {{ $p->dp_paid_at?->format('d M Y H:i') ?? '' }}
                        · Tenor {{ $p->tenor_bulan }} bulan
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('kredit.show', $p->kredit) }}" style="padding:8px 16px;border:1px solid #cbd5e1;border-radius:8px;font-size:12px;font-weight:600;color:#334155;text-decoration:none;">📋 Detail</a>
                <form method="POST" action="{{ route('kredit.aktivasi', $p) }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="padding:8px 18px;background:#f97316;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;">✅ Aktifkan Kredit</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Two-col --}}
<div class="two-col">

    {{-- Table --}}
    <div class="adm-card">
        <div class="adm-card-hd">
            <div>
                <h3>Pengajuan Kredit Terbaru</h3>
                <p>Data pengajuan paling baru</p>
            </div>
            <span class="cnt-badge">{{ $pengajuanTerbaru->count() }} data</span>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Motor</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pengajuanTerbaru as $row)
                    <tr>
                        <td class="td-code">{{ $row->kode_pengajuan }}</td>
                        <td class="td-name">{{ $row->pelanggan?->nama_pelanggan ?? $row->pelanggan?->nama ?? '—' }}</td>
                        <td>{{ $row->motor?->nama_motor ?? '—' }}</td>
                        <td class="td-muted">{{ $row->tanggal_pengajuan?->format('d M Y') ?? '—' }}</td>
                        <td>
                            @php
                                $s = $row->status ?? '';
                                $cls = match(true) {
                                    str_contains($s,'Menunggu')||str_contains($s,'menunggu') => 'menunggu',
                                    str_contains($s,'Diterima')||str_contains($s,'disetujui') => 'diterima',
                                    str_contains($s,'Ditolak')||str_contains($s,'ditolak')||str_contains($s,'Dibatalkan') => 'ditolak',
                                    str_contains($s,'Diproses') => 'diproses',
                                    default => 'default',
                                };
                            @endphp
                            <span class="sbadge {{ $cls }}">{{ $s }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:36px;color:#94a3b8;">Belum ada data pengajuan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Right --}}
    <div>
        <div class="quick-card">
            <h4>Akses Cepat</h4>
            <a href="{{ route('landing') }}" class="ql" target="_blank"><span class="qi">🌐</span> Landing Page</a>
            
            @if(in_array(Auth::user()?->role?->slug, ['marketing','surveyor','kolektor','owner'], true))
                <a href="{{ route('pengajuan.index') }}" class="ql"><span class="qi">📋</span> Data Pengajuan</a>
            @endif

            @if(in_array(Auth::user()?->role?->slug, ['marketing','kolektor','owner'], true))
                <a href="{{ route('pembayaran.index') }}" class="ql"><span class="qi">💳</span> Input Pembayaran</a>
            @endif

            @if(in_array(Auth::user()?->role?->slug, ['admin','owner'], true))
                <a href="{{ route('motor.index') }}" class="ql"><span class="qi">🏍️</span> Katalog Motor</a>
            @endif
            
            <a href="{{ route('profile.edit') }}" class="ql"><span class="qi">👤</span> Profil Akun</a>
        </div>
        <div class="info-grad">
            <div class="ig-label">Status Sistem</div>
            <h3>Panel Admin Aktif</h3>
            <p>Semua modul terkoneksi dengan database. Gunakan menu di samping untuk mengelola data secara real-time.</p>
        </div>
    </div>

</div>

{{-- Monitoring Angsuran Klien --}}
<div class="adm-card" style="margin-top:22px;">
    <div class="adm-card-hd">
        <div>
            <h3>📊 Monitoring Angsuran Klien</h3>
            <p>Status cicilan terbaru dari seluruh kredit aktif — tunggakan ditampilkan paling atas</p>
        </div>
        <a href="{{ route('pembayaran.index') }}" style="font-size:12px;font-weight:700;color:#ef4444;text-decoration:none;">Lihat Semua →</a>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Motor</th>
                    <th>Ke-</th>
                    <th>Jatuh Tempo</th>
                    <th>Tagihan</th>
                    <th>Dibayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($angsuranMonitor as $ang)
                @php
                    $pengajuan = $ang->kredit?->pengajuanKredit;
                    $isPastDue = $ang->jatuh_tempo && now()->startOfDay()->gt($ang->jatuh_tempo) && $ang->status !== 'lunas';
                @endphp
                <tr style="{{ $isPastDue ? 'background:#fff5f5;' : '' }}">
                    <td class="td-name">{{ $pengajuan?->pelanggan?->nama_pelanggan ?? '—' }}</td>
                    <td>{{ $pengajuan?->motor?->nama_motor ?? '—' }}</td>
                    <td style="font-weight:700;text-align:center;">{{ $ang->angsuran_ke }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($ang->jatuh_tempo)->format('d M Y') }}
                        @if($isPastDue)
                            <span style="display:block;font-size:10px;color:#dc2626;font-weight:700;">⚠ Terlambat</span>
                        @endif
                    </td>
                    <td style="font-weight:700;">Rp {{ number_format($ang->jumlah_tagihan, 0, ',', '.') }}</td>
                    <td>
                        @if($ang->jumlah_bayar > 0)
                            Rp {{ number_format($ang->jumlah_bayar, 0, ',', '.') }}
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($ang->status === 'lunas')
                            <span class="sbadge diterima">✅ Lunas</span>
                        @elseif($isPastDue)
                            <span class="sbadge ditolak">🔴 Tunggak</span>
                        @else
                            <span class="sbadge menunggu">⏳ Belum Bayar</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;padding:36px;color:#94a3b8;">Belum ada data angsuran.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
