@extends('layouts.admin')

@section('title', 'Detail Kredit')
@section('page-title', 'Detail Kredit')
@section('page-subtitle', 'Jadwal angsuran dan riwayat pembayaran kredit pelanggan')

@push('styles')
<style>
    .info-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:22px; }
    .info-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; }
    .info-card .ic-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.14em; color:#94a3b8; margin-bottom:5px; }
    .info-card .ic-val   { font-size:18px; font-weight:800; color:#0f172a; }
    .info-card .ic-sub   { font-size:11px; color:#64748b; margin-top:2px; }

    .profile-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:22px; margin-bottom:20px; display:flex; gap:20px; align-items:start; }
    .profile-card img { width:80px; height:80px; object-fit:cover; border-radius:12px; border:1px solid #e2e8f0; flex-shrink:0; }
    .profile-card .pc-placeholder { width:80px; height:80px; background:#f1f5f9; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:28px; flex-shrink:0; }
    .profile-card h2 { font-size:20px; font-weight:800; color:#0f172a; margin:0 0 4px; }
    .profile-card .pc-sub { font-size:13px; color:#64748b; margin-bottom:8px; }
    .pc-badge { display:inline-flex; align-items:center; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:700; }
    .pc-badge.dicicil { background:#dbeafe; color:#1e40af; }
    .pc-badge.lunas   { background:#d1fae5; color:#065f46; }

    .progress-section { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:20px; margin-bottom:20px; }
    .progress-bar-lg { background:#e2e8f0; border-radius:999px; height:12px; overflow:hidden; }
    .progress-fill-lg { height:100%; border-radius:999px; background:linear-gradient(90deg,#3b82f6,#06b6d4); transition:width .5s; }

    .tbl-wrap { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; }
    table { width:100%; border-collapse:collapse; font-size:12.5px; }
    thead th { padding:11px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
    tbody td { padding:13px 16px; color:#334155; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    tbody tr:hover { background:#f8fafc; }
    tbody tr.row-lunas td { background:#f0fdf4; }
    tbody tr.row-tunggak td { background:#fff5f5; }

    .sbadge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:600; }
    .sbadge.lunas    { background:#d1fae5; color:#065f46; }
    .sbadge.tunggak  { background:#fee2e2; color:#991b1b; }
    .sbadge.belum    { background:#fef3c7; color:#92400e; }

    @media(max-width:768px) { .info-grid { grid-template-columns:1fr 1fr; } .profile-card { flex-direction:column; } }
</style>
@endpush

@section('content')

@php
    $pengajuan  = $kredit->pengajuanKredit;
    $pelanggan  = $pengajuan?->pelanggan;
    $motor      = $pengajuan?->motor;
    $totalAng   = $kredit->angsurans->count();
    $lunasAng   = $kredit->angsurans->where('status','lunas')->count();
    $pct        = $totalAng > 0 ? round($lunasAng / $totalAng * 100) : 0;
@endphp

<div style="margin-bottom:16px;">
    <a href="{{ route('kredit.index') }}" style="font-size:13px;font-weight:600;color:#64748b;text-decoration:none;">← Kembali ke Daftar Kredit</a>
</div>

{{-- Profil Pelanggan --}}
<div class="profile-card">
    @if($motor?->foto1)
        <img src="{{ asset('storage/'.$motor->foto1) }}" alt="{{ $motor->nama_motor }}">
    @else
        <div class="pc-placeholder">🏍️</div>
    @endif
    <div style="flex:1;">
        <h2>{{ $pelanggan?->nama_pelanggan ?? '—' }}</h2>
        <div class="pc-sub">{{ $motor?->nama_motor ?? '—' }} &nbsp;·&nbsp; Tenor {{ $pengajuan?->tenor_bulan }} bulan &nbsp;·&nbsp; Kode: <strong>{{ $pengajuan?->kode_pengajuan ?? '—' }}</strong></div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;font-size:12px;color:#64748b;">
            <span>📞 {{ $pelanggan?->no_telp ?? '—' }}</span>
            <span>📧 {{ $pelanggan?->email ?? '—' }}</span>
            @if($kredit->tgl_mulai_kredit)
            <span>📅 Mulai: {{ $kredit->tgl_mulai_kredit->format('d M Y') }}</span>
            @endif
        </div>
        <div style="margin-top:10px;">
            <span class="pc-badge {{ strtolower($kredit->status_kredit ?? 'dicicil') }}">{{ $kredit->status_kredit ?? 'Dicicil' }}</span>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="info-grid">
    <div class="info-card">
        <div class="ic-label">Total Pembiayaan</div>
        <div class="ic-val">Rp {{ number_format($pengajuan?->total_pembiayaan ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="info-card">
        <div class="ic-label">Sisa Kredit</div>
        <div class="ic-val" style="color:#dc2626;">Rp {{ number_format($kredit->sisa_kredit, 0, ',', '.') }}</div>
    </div>
    <div class="info-card">
        <div class="ic-label">Cicilan / Bulan</div>
        <div class="ic-val">Rp {{ number_format($pengajuan?->angsuran_per_bulan ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="info-card">
        <div class="ic-label">DP Dibayar</div>
        <div class="ic-val" style="color:#059669;">Rp {{ number_format($pengajuan?->dp ?? 0, 0, ',', '.') }}</div>
        <div class="ic-sub">{{ $pengajuan?->dp_paid_at?->format('d M Y H:i') ?? '—' }}</div>
    </div>
    <div class="info-card">
        <div class="ic-label">Angsuran Lunas</div>
        <div class="ic-val" style="color:#1d4ed8;">{{ $lunasAng }} / {{ $totalAng }}</div>
    </div>
    <div class="info-card">
        <div class="ic-label">Progress</div>
        <div class="ic-val" style="color:#0891b2;">{{ $pct }}%</div>
    </div>
</div>

{{-- Progress Bar --}}
<div class="progress-section">
    <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
        <span style="font-size:13px;font-weight:700;color:#0f172a;">Progress Pelunasan Kredit</span>
        <span style="font-size:12px;color:#64748b;">{{ $lunasAng }} dari {{ $totalAng }} cicilan selesai</span>
    </div>
    <div class="progress-bar-lg">
        <div class="progress-fill-lg" style="width:{{ $pct }}%;"></div>
    </div>
</div>

{{-- Jadwal Angsuran --}}
<div class="tbl-wrap">
    <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h3 style="font-size:14px;font-weight:700;color:#0f172a;margin:0;">Jadwal Angsuran Lengkap</h3>
            <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">Semua cicilan bulanan dari kontrak kredit ini</p>
        </div>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Ke-</th>
                    <th>Jatuh Tempo</th>
                    <th>Tagihan</th>
                    <th>Dibayar</th>
                    <th>Tgl Bayar</th>
                    <th>Status</th>
                    <th>Order ID</th>
                </tr>
            </thead>
            <tbody>
            @forelse($kredit->angsurans->sortBy('angsuran_ke') as $ang)
                @php
                    $isPastDue = $ang->jatuh_tempo && now()->startOfDay()->gt($ang->jatuh_tempo) && $ang->status !== 'lunas';
                    $rowClass  = $ang->status === 'lunas' ? 'row-lunas' : ($isPastDue ? 'row-tunggak' : '');
                @endphp
                <tr class="{{ $rowClass }}">
                    <td style="font-weight:700;font-size:13px;">#{{ $ang->angsuran_ke }}</td>
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
                    <td style="font-size:11px;color:#64748b;">{{ $ang->tanggal_bayar?->format('d M Y') ?? '—' }}</td>
                    <td>
                        @if($ang->status === 'lunas')
                            <span class="sbadge lunas">✅ Lunas</span>
                        @elseif($isPastDue)
                            <span class="sbadge tunggak">🔴 Tunggak</span>
                        @else
                            <span class="sbadge belum">⏳ Belum Bayar</span>
                        @endif
                    </td>
                    <td style="font-size:10px;color:#94a3b8;font-family:monospace;">{{ $ang->midtrans_order_id ? Str::limit($ang->midtrans_order_id, 22) : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;padding:30px;color:#94a3b8;">Belum ada data angsuran.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
