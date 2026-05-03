@extends('layouts.admin')

@section('title', 'Pengajuan Kredit')
@section('page-title', 'Pengajuan Kredit')
@section('page-subtitle', 'Kelola dan review semua pengajuan kredit masuk')

@push('styles')
<style>
    .filter-bar { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:14px 18px; margin-bottom:18px; }
    .filter-bar form { display:grid; grid-template-columns:1fr 200px 110px; gap:10px; }
    .filter-bar input, .filter-bar select {
        height:38px; border:1px solid #cbd5e1; border-radius:8px; padding:0 12px;
        font-size:13px; font-family:inherit; background:#fff; color:#1e293b; outline:none;
    }
    .filter-bar input:focus, .filter-bar select:focus { border-color:#64748b; }
    .filter-bar button {
        height:38px; background:#0f172a; color:#fff; font-weight:700; font-size:13px;
        border:none; border-radius:8px; cursor:pointer;
    }

    .tbl-wrap { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; }
    table { width:100%; border-collapse:collapse; font-size:12.5px; }
    thead th { padding:11px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
    tbody td { padding:13px 16px; color:#334155; border-bottom:1px solid #f1f5f9; vertical-align:top; }
    tbody tr:hover { background:#f8fafc; }

    .sbadge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:600; }
    .sbadge.menunggu { background:#fef3c7; color:#92400e; }
    .sbadge.diterima { background:#d1fae5; color:#065f46; }
    .sbadge.ditolak  { background:#fee2e2; color:#991b1b; }
    .sbadge.diproses { background:#dbeafe; color:#1e40af; }
    .sbadge.default  { background:#f1f5f9; color:#475569; }

    .act-form { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:10px; display:grid; gap:7px; }
    .act-form select, .act-form input[type=text] {
        width:100%; height:34px; border:1px solid #cbd5e1; border-radius:7px;
        padding:0 10px; font-size:12px; font-family:inherit; background:#fff;
    }
    .act-form button { height:34px; background:#ef4444; color:#fff; font-weight:700; font-size:12px; border:none; border-radius:7px; cursor:pointer; width:100%; }

    .pagi-wrap { padding:14px 18px; border-top:1px solid #f1f5f9; }

    @media(max-width:768px) {
        .filter-bar form { grid-template-columns:1fr; }
    }
</style>
@endpush

@section('content')
@if(session('error'))
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:15px; font-size:13px; font-weight:600;">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:15px; font-size:13px; font-weight:600;">
        <ul style="margin:0; padding-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
    <div style="background:#d1fae5; color:#065f46; padding:12px; border-radius:8px; margin-bottom:15px; font-size:13px; font-weight:600;">{{ session('success') }}</div>
@endif

<div class="filter-bar">
    <form method="GET" action="{{ route('pengajuan.index') }}">
        <input type="text" name="q" value="{{ $search }}" placeholder="Cari kode, pelanggan, NIK, telepon, motor…">
        <select name="status">
            <option value="all"               {{ $statusFilter === 'all'                ? 'selected' : '' }}>Semua Status</option>
            <option value="Menunggu Konfirmasi" {{ $statusFilter === 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="Diproses"           {{ $statusFilter === 'Diproses'           ? 'selected' : '' }}>Diproses</option>
            <option value="Diterima"           {{ $statusFilter === 'Diterima'           ? 'selected' : '' }}>Diterima</option>
            <option value="Dibatalkan Penjual" {{ $statusFilter === 'Dibatalkan Penjual' ? 'selected' : '' }}>Ditolak</option>
            <option value="Dibatalkan Pembeli" {{ $statusFilter === 'Dibatalkan Pembeli' ? 'selected' : '' }}>Dibatalkan Pembeli</option>
        </select>
        <button type="submit">Terapkan</button>
    </form>
</div>

<div class="tbl-wrap">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Motor</th>
                    <th>Asuransi</th>
                    <th>Cicilan/bln</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($rows as $row)
                <tr>
                    <td style="font-weight:700;color:#0f172a;font-family:monospace;font-size:12px;">{{ $row->kode_pengajuan }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $row->pelanggan?->nama_pelanggan ?? $row->pelanggan?->nama ?? '—' }}</div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:2px;">
                            {{ $row->pelanggan?->no_telp ?? $row->pelanggan?->telepon ?? '' }}
                            @if($row->pelanggan?->kota1 ?? $row->pelanggan?->kota ?? null)
                                | {{ $row->pelanggan?->kota1 ?? $row->pelanggan?->kota }}
                            @endif
                        </div>
                    </td>
                    <td>{{ $row->motor?->nama_motor ?? '—' }}</td>
                    <td>
                        <div>{{ $row->asuransi?->nama_asuransi ?? 'Tanpa Asuransi' }}</div>
                        <div style="font-size:11px;color:#94a3b8;">Rp {{ number_format((float)$row->biaya_asuransi_per_bulan, 0, ',', '.') }}/bln</div>
                    </td>
                    <td style="font-weight:700;">Rp {{ number_format((float)$row->angsuran_per_bulan, 0, ',', '.') }}</td>
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
                    <td>
                        <div style="display:flex; flex-direction:column; gap:6px;">
                            <a href="{{ route('pengajuan.show', $row) }}" style="display:flex; align-items:center; justify-content:center; gap:6px; width:100%; height:34px; background:#f1f5f9; color:#475569; font-weight:700; font-size:12px; border:1px solid #e2e8f0; border-radius:7px; text-decoration:none; transition:all .15s; cursor:pointer;">
                                🔍 Detail
                            </a>

                            @if(in_array($row->status, ['Menunggu Konfirmasi', 'Diproses']) && in_array(auth()->user()?->role?->slug, ['marketing','owner','surveyor','kolektor'], true))
                                <form method="POST" action="{{ route('pengajuan.update-status', $row) }}" class="act-form" style="margin-top:2px;">
                                    @csrf
                                    <select name="status" required>
                                        <option value="">Pilih aksi…</option>
                                        <option value="Diproses">Proses</option>
                                        <option value="Diterima">Setujui</option>
                                        <option value="Dibatalkan Penjual">Tolak</option>
                                        <option value="Dibatalkan Pembeli">Batalkan Pembeli</option>
                                    </select>
                                    <input type="text" name="catatan" placeholder="Catatan (opsional)">
                                    <button type="submit">Simpan</button>
                                </form>
                            @else
                                <div style="font-size:11px;color:#94a3b8;padding:4px 0;">
                                    Oleh: {{ $row->approver?->name ?? '—' }}<br>
                                    {{ $row->approved_at?->format('d M Y H:i') ?? '' }}
                                </div>
                            @endif
                        </div>

                        {{-- Tombol Hapus --}}
                        @if(in_array(auth()->user()?->role?->slug, ['marketing','owner'], true))
                            <form method="POST" action="{{ route('pengajuan.destroy', $row) }}" onsubmit="return confirm('Yakin ingin menghapus pengajuan {{ $row->kode_pengajuan }}? Data kredit & angsuran terkait juga akan dihapus.')" style="margin-top:6px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width:100%;height:30px;background:#fee2e2;color:#991b1b;font-weight:700;font-size:11px;border:1px solid #fecaca;border-radius:7px;cursor:pointer;transition:background .15s;">🗑 Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">Belum ada pengajuan kredit.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagi-wrap">{{ $rows->links() }}</div>
</div>

@endsection
