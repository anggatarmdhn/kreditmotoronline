@extends('layouts.admin')

@section('title', 'Pembayaran Angsuran – Kolektor')
@section('page-title', 'Pembayaran Angsuran')
@section('page-subtitle', 'Input pembayaran manual dari kolektor lapangan')

@push('styles')
<style>
    /* ─── Tab Bar ─── */
    .tab-bar { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:20px; }
    .tab-btn {
        padding:8px 16px; border-radius:999px; font-size:12px; font-weight:700;
        cursor:pointer; text-decoration:none; border:1.5px solid #e2e8f0;
        color:#64748b; background:#fff; display:inline-flex; align-items:center; gap:6px;
        transition:all .15s;
    }
    .tab-btn:hover { background:#f8fafc; }
    .tab-btn.active { background:#0f172a; color:#fff; border-color:#0f172a; }
    .tab-btn.active.red { background:#ef4444; border-color:#ef4444; }
    .tab-btn .badge { background:rgba(255,255,255,.25); color:inherit; padding:1px 7px; border-radius:999px; font-size:10px; }
    .tab-btn:not(.active) .badge { background:#f1f5f9; color:#475569; }
    .tab-btn.active.red .badge { background:rgba(255,255,255,.3); }

    /* ─── Search bar ─── */
    .search-bar { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:12px 16px; margin-bottom:18px; display:flex; gap:10px; }
    .search-bar input { flex:1; height:36px; border:1px solid #cbd5e1; border-radius:8px; padding:0 12px; font-size:13px; font-family:inherit; background:#fff; outline:none; }
    .search-bar button { height:36px; background:#0f172a; color:#fff; font-weight:700; font-size:13px; border:none; border-radius:8px; cursor:pointer; padding:0 20px; }

    /* ─── Card list ─── */
    .collector-list { display:grid; gap:14px; }
    .collector-card {
        background:#fff; border:1px solid #e2e8f0; border-radius:16px;
        overflow:hidden; display:grid; grid-template-columns:1fr auto;
        transition:box-shadow .15s;
    }
    .collector-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.07); }
    .collector-card.tunggak { border-left:4px solid #ef4444; }
    .collector-card.lunas   { border-left:4px solid #10b981; opacity:.75; }

    .cc-main { padding:18px 20px; }
    .cc-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:10px; }
    .cc-name { font-size:15px; font-weight:800; color:#0f172a; }
    .cc-motor { font-size:12px; color:#64748b; margin-top:2px; }
    .cc-meta { display:flex; flex-wrap:wrap; gap:12px; font-size:12px; color:#64748b; margin-top:8px; }
    .cc-meta strong { color:#334155; }

    .sbadge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:700; }
    .sbadge.lunas    { background:#d1fae5; color:#065f46; }
    .sbadge.tunggak  { background:#fee2e2; color:#991b1b; }
    .sbadge.belum    { background:#fef3c7; color:#92400e; }
    .sbadge.online   { background:#dbeafe; color:#1e40af; }

    .cc-form-panel { background:#f8fafc; border-left:1px solid #e2e8f0; padding:16px 18px; min-width:260px; display:flex; flex-direction:column; gap:8px; justify-content:center; }
    .cc-form-panel label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.14em; color:#94a3b8; display:block; margin-bottom:3px; }
    .cc-form-panel input, .cc-form-panel select, .cc-form-panel textarea {
        width:100%; height:34px; border:1px solid #e2e8f0; border-radius:7px;
        padding:0 10px; font-size:12px; font-family:inherit; background:#fff; outline:none;
        color:#1e293b;
    }
    .cc-form-panel textarea { height:54px; padding:8px 10px; resize:none; }
    .cc-form-panel input:focus, .cc-form-panel select:focus { border-color:#64748b; }
    .cc-form-panel .pay-btn {
        height:36px; background:#ef4444; color:#fff; font-weight:700; font-size:12px;
        border:none; border-radius:8px; cursor:pointer; width:100%;
        transition:background .15s;
    }
    .cc-form-panel .pay-btn:hover { background:#dc2626; }

    .lunas-info { padding:16px 18px; display:flex; flex-direction:column; justify-content:center; align-items:center; gap:6px; min-width:200px; text-align:center; }
    .lunas-info .li-icon { font-size:28px; }
    .lunas-info .li-label { font-size:12px; font-weight:700; color:#047857; }
    .lunas-info .li-meta { font-size:10px; color:#94a3b8; }

    .empty-state { text-align:center; padding:60px 20px; color:#94a3b8; }
    .empty-state .es-icon { font-size:48px; margin-bottom:12px; }
    .empty-state h3 { font-size:16px; font-weight:700; color:#64748b; margin:0 0 6px; }
    .empty-state p  { font-size:13px; }

    .pagi-wrap { padding:14px 0; }

    @media(max-width:768px) {
        .collector-card { grid-template-columns:1fr; }
        .cc-form-panel { border-left:none; border-top:1px solid #e2e8f0; min-width:auto; }
    }
</style>
@endpush

@section('content')

{{-- Context banner --}}
<div style="background:linear-gradient(120deg,#0f172a,#1e3a5f);border-radius:14px;padding:18px 22px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
    <div>
        <div style="font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Modul Kolektor</div>
        <h2 style="font-size:16px;font-weight:800;color:#fff;margin:0;">Input Pembayaran Angsuran Manual</h2>
        <p style="font-size:12px;color:#94a3b8;margin:4px 0 0;">Untuk pembayaran tunai/transfer yang diterima langsung oleh kolektor di lapangan.<br>Pembayaran online via Midtrans oleh klien tercatat otomatis.</p>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('kredit.index') }}" style="padding:8px 16px;background:rgba(255,255,255,.1);color:#e2e8f0;border:1px solid rgba(255,255,255,.15);border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">🏦 Manajemen Kredit</a>
    </div>
</div>

{{-- Tab Bar --}}
<div class="tab-bar">
    <a href="{{ route('pembayaran.index', array_merge(request()->except('tab','page'), ['tab'=>'tunggak'])) }}"
       class="tab-btn {{ $tab==='tunggak' ? 'active red' : '' }}">
        🔴 Tunggak
        <span class="badge">{{ $counts['countTunggak'] }}</span>
    </a>
    <a href="{{ route('pembayaran.index', array_merge(request()->except('tab','page'), ['tab'=>'hari_ini'])) }}"
       class="tab-btn {{ $tab==='hari_ini' ? 'active' : '' }}">
        📅 Jatuh Tempo Hari Ini
        <span class="badge">{{ $counts['countHariIni'] }}</span>
    </a>
    <a href="{{ route('pembayaran.index', array_merge(request()->except('tab','page'), ['tab'=>'minggu_ini'])) }}"
       class="tab-btn {{ $tab==='minggu_ini' ? 'active' : '' }}">
        📆 Minggu Ini
        <span class="badge">{{ $counts['countMingguIni'] }}</span>
    </a>
    <a href="{{ route('pembayaran.index', array_merge(request()->except('tab','page'), ['tab'=>'semua'])) }}"
       class="tab-btn {{ $tab==='semua' ? 'active' : '' }}">
        📋 Semua Belum Bayar
        <span class="badge">{{ $counts['countBelum'] }}</span>
    </a>
    <a href="{{ route('pembayaran.index', array_merge(request()->except('tab','page'), ['tab'=>'lunas'])) }}"
       class="tab-btn {{ $tab==='lunas' ? 'active' : '' }}">
        ✅ Sudah Lunas
        <span class="badge">{{ $counts['countLunas'] }}</span>
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('pembayaran.index') }}" class="search-bar">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama pelanggan atau kode pengajuan…">
    <button type="submit">Cari</button>
</form>

{{-- Flash --}}
@if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:13px;font-weight:600;">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="background:#fff1f2;border:1px solid #fecaca;color:#991b1b;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:13px;font-weight:600;">❌ {{ session('error') }}</div>
@endif

{{-- List --}}
<div class="collector-list">
@forelse($angsuranRows as $row)
    @php
        $pengajuan  = $row->kredit?->pengajuanKredit;
        $pelanggan  = $pengajuan?->pelanggan;
        $motor      = $pengajuan?->motor;
        $isPastDue  = $row->jatuh_tempo && now()->startOfDay()->gt($row->jatuh_tempo) && $row->status !== 'lunas';
        $sisa       = max((float)$row->jumlah_tagihan - (float)$row->jumlah_bayar, 0);
        $bayarOnline= $row->midtrans_order_id ? true : false;
        $cardClass  = $row->status === 'lunas' ? 'lunas' : ($isPastDue ? 'tunggak' : '');
    @endphp
    <div class="collector-card {{ $cardClass }}">
        {{-- Info Utama --}}
        <div class="cc-main">
            <div class="cc-header">
                <div>
                    <div class="cc-name">{{ $pelanggan?->nama_pelanggan ?? '—' }}</div>
                    <div class="cc-motor">{{ $motor?->nama_motor ?? '—' }} &nbsp;·&nbsp; Angsuran ke-<strong>{{ $row->angsuran_ke }}</strong></div>
                </div>
                <div style="display:flex;gap:5px;align-items:center;">
                    @if($row->status === 'lunas')
                        <span class="sbadge lunas">✅ Lunas</span>
                        @if($bayarOnline)
                            <span class="sbadge online">🌐 Online</span>
                        @endif
                    @elseif($isPastDue)
                        <span class="sbadge tunggak">⚠ Tunggak</span>
                    @else
                        <span class="sbadge belum">⏳ Belum Bayar</span>
                    @endif
                </div>
            </div>
            <div class="cc-meta">
                <span>📅 Jatuh Tempo: <strong>{{ \Carbon\Carbon::parse($row->jatuh_tempo)->translatedFormat('d M Y') }}</strong>
                    @if($isPastDue)
                        <span style="color:#ef4444;font-weight:700;"> ({{ \Carbon\Carbon::parse($row->jatuh_tempo)->diffForHumans() }})</span>
                    @endif
                </span>
                <span>💵 Tagihan: <strong>Rp {{ number_format($row->jumlah_tagihan, 0, ',', '.') }}</strong></span>
                @if($sisa > 0 && $sisa < (float)$row->jumlah_tagihan)
                    <span style="color:#f59e0b;">⚡ Sisa: <strong>Rp {{ number_format($sisa, 0, ',', '.') }}</strong></span>
                @endif
                @if($pelanggan?->no_telp)
                    <span>📞 <strong>{{ $pelanggan->no_telp }}</strong></span>
                @endif
                @if($pelanggan?->alamat ?? $pelanggan?->alamat_ktp ?? null)
                    <span>📍 {{ Str::limit($pelanggan->alamat ?? $pelanggan->alamat_ktp, 50) }}</span>
                @endif
            </div>
            @if($row->keterangan)
                <div style="margin-top:8px;font-size:11px;color:#64748b;background:#f8fafc;padding:6px 10px;border-radius:7px;border:1px solid #e2e8f0;">
                    📝 {{ $row->keterangan }}
                </div>
            @endif
        </div>

        {{-- Form Bayar / Info Lunas --}}
        @if($row->status === 'lunas')
            <div class="lunas-info">
                <div class="li-icon">✅</div>
                <div class="li-label">Sudah Lunas</div>
                <div class="li-meta">{{ $row->tanggal_bayar?->format('d M Y') ?? '—' }}</div>
                @if($row->metodeBayar)
                    <div class="li-meta">via {{ $row->metodeBayar->nama }}</div>
                @endif
                @if($bayarOnline)
                    <div class="li-meta" style="color:#1d4ed8;">🌐 Dibayar online</div>
                @endif
            </div>
        @else
            <form method="POST" action="{{ route('pembayaran.store', $row) }}" class="cc-form-panel">
                @csrf
                <div>
                    <label>Nominal Bayar (Sisa: Rp {{ number_format($sisa, 0, ',', '.') }})</label>
                    <input type="number" name="jumlah_bayar" min="1" max="{{ max(1,(int)$sisa) }}" value="{{ (int)$sisa }}" required>
                </div>
                <div>
                    <label>Tanggal Diterima</label>
                    <input type="date" name="tanggal_bayar" value="{{ now()->toDateString() }}" required>
                </div>
                <div>
                    <label>Metode Pembayaran</label>
                    <select name="metode_bayar_id" required>
                        <option value="">Pilih metode…</option>
                        @foreach($metodeBayars as $m)
                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Catatan Kolektor (opsional)</label>
                    <textarea name="keterangan" placeholder="Misal: dibayar di rumah, transfer BCA, dll."></textarea>
                </div>
                <button type="submit" class="pay-btn">💾 Catat Pembayaran</button>
            </form>
        @endif
    </div>
@empty
    <div class="empty-state">
        <div class="es-icon">
            @if($tab === 'tunggak') 🎉 @elseif($tab === 'hari_ini') 📅 @else ✅ @endif
        </div>
        <h3>
            @if($tab === 'tunggak') Tidak ada angsuran tunggak!
            @elseif($tab === 'hari_ini') Tidak ada angsuran jatuh tempo hari ini
            @elseif($tab === 'lunas') Belum ada angsuran lunas
            @else Tidak ada data angsuran
            @endif
        </h3>
        <p>
            @if($tab === 'tunggak') Semua angsuran dalam kondisi baik.
            @elseif($tab === 'hari_ini') Cek tab "Tunggak" untuk yang sudah terlambat.
            @else Pilih tab lain untuk melihat data angsuran.
            @endif
        </p>
    </div>
@endforelse
</div>

@if($angsuranRows->hasPages())
    <div class="pagi-wrap">{{ $angsuranRows->links() }}</div>
@endif

@endsection
