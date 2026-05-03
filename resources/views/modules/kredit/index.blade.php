@extends('layouts.admin')

@section('title', 'Manajemen Kredit')
@section('page-title', 'Manajemen Kredit')
@section('page-subtitle', 'Pantau semua kontrak kredit aktif dan jadwal angsuran pelanggan')

@push('styles')
<style>
    .mini-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:18px; }
    .mini-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px 18px; }
    .mini-card .mc-label { font-size:11px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.07em; }
    .mini-card .mc-val   { font-size:28px; font-weight:900; color:#0f172a; margin-top:5px; }
    .mini-card.blue  { border-color:#bfdbfe; background:#eff6ff; } .mini-card.blue .mc-val { color:#1d4ed8; }
    .mini-card.green { border-color:#a7f3d0; background:#f0fdf4; } .mini-card.green .mc-val { color:#047857; }

    .filter-bar { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:14px 18px; margin-bottom:18px; }
    .filter-bar form { display:grid; grid-template-columns:1fr 200px 110px; gap:10px; }
    .filter-bar input, .filter-bar select { height:38px; border:1px solid #cbd5e1; border-radius:8px; padding:0 12px; font-size:13px; font-family:inherit; background:#fff; outline:none; }
    .filter-bar button { height:38px; background:#0f172a; color:#fff; font-weight:700; font-size:13px; border:none; border-radius:8px; cursor:pointer; }

    .tbl-wrap { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; }
    table { width:100%; border-collapse:collapse; font-size:12.5px; }
    thead th { padding:11px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
    tbody td { padding:13px 16px; color:#334155; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    tbody tr:hover { background:#f8fafc; }

    .sbadge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:600; }
    .sbadge.dicicil { background:#dbeafe; color:#1e40af; }
    .sbadge.lunas   { background:#d1fae5; color:#065f46; }
    .sbadge.macet   { background:#fee2e2; color:#991b1b; }

    .progress-bar { background:#e2e8f0; border-radius:999px; height:6px; overflow:hidden; margin-top:5px; }
    .progress-fill { height:100%; background:linear-gradient(90deg,#3b82f6,#06b6d4); border-radius:999px; }

    .pagi-wrap { padding:14px 18px; border-top:1px solid #f1f5f9; }
    @media(max-width:768px) { .mini-stats { grid-template-columns:1fr 1fr; } .filter-bar form { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')

<div class="mini-stats">
    <div class="mini-card">
        <div class="mc-label">Total Kredit</div>
        <div class="mc-val">{{ $stats['total'] }}</div>
    </div>
    <div class="mini-card blue">
        <div class="mc-label">Sedang Dicicil</div>
        <div class="mc-val">{{ $stats['dicicil'] }}</div>
    </div>
    <div class="mini-card green">
        <div class="mc-label">Lunas</div>
        <div class="mc-val">{{ $stats['lunas'] }}</div>
    </div>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('kredit.index') }}">
        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama pelanggan, motor, kode pengajuan…">
        <select name="status">
            <option value="all"    {{ $statusFilter==='all'    ? 'selected':'' }}>Semua Status</option>
            <option value="Dicicil" {{ $statusFilter==='Dicicil' ? 'selected':'' }}>Sedang Dicicil</option>
            <option value="Lunas"  {{ $statusFilter==='Lunas'  ? 'selected':'' }}>Lunas</option>
            <option value="Macet"  {{ $statusFilter==='Macet'  ? 'selected':'' }}>Macet</option>
        </select>
        <button type="submit">Terapkan</button>
    </form>
</div>

<div class="tbl-wrap">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Motor</th>
                    <th>Mulai Kredit</th>
                    <th>Progress Cicilan</th>
                    <th>Sisa Kredit</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($kredits as $kredit)
                @php
                    $pengajuan  = $kredit->pengajuanKredit;
                    $totalAng   = $kredit->angsurans->count();
                    $lunasAng   = $kredit->angsurans->where('status','lunas')->count();
                    $pct        = $totalAng > 0 ? round($lunasAng / $totalAng * 100) : 0;
                @endphp
                <tr>
                    <td>
                        <div style="font-weight:600;">{{ $pengajuan?->pelanggan?->nama_pelanggan ?? '—' }}</div>
                        <div style="font-size:11px;color:#94a3b8;">{{ $pengajuan?->pelanggan?->no_telp ?? '' }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $pengajuan?->motor?->nama_motor ?? '—' }}</div>
                        <div style="font-size:11px;color:#94a3b8;">Tenor: {{ $pengajuan?->tenor_bulan }} bulan</div>
                    </td>
                    <td>
                        <div>{{ $kredit->tgl_mulai_kredit?->format('d M Y') ?? '—' }}</div>
                    </td>
                    <td style="min-width:140px;">
                        <div style="font-size:11px;color:#64748b;">{{ $lunasAng }}/{{ $totalAng }} angsuran lunas</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width:{{ $pct }}%;"></div>
                        </div>
                        <div style="font-size:10px;color:#94a3b8;margin-top:3px;">{{ $pct }}% selesai</div>
                    </td>
                    <td style="font-weight:700;color:#dc2626;">
                        Rp {{ number_format($kredit->sisa_kredit, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="sbadge {{ strtolower($kredit->status_kredit ?? 'dicicil') }}">{{ $kredit->status_kredit ?? 'Dicicil' }}</span>
                    </td>
                    <td>
                        <a href="{{ route('kredit.show', $kredit) }}" style="display:inline-block;padding:6px 14px;background:#0f172a;color:#fff;border-radius:7px;font-size:12px;font-weight:700;text-decoration:none;">Lihat Detail</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">Belum ada data kredit.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagi-wrap">{{ $kredits->links() }}</div>
</div>

@endsection
