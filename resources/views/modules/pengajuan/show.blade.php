@extends('layouts.admin')

@section('title', 'Detail Pengajuan - ' . $pengajuan->kode_pengajuan)
@section('page-title', 'Detail Pengajuan')
@section('page-subtitle', 'Informasi lengkap pelanggan dan dokumen persyaratan')

@push('styles')
<style>
    .grid-detail { display: grid; grid-template-columns: 1fr 350px; gap: 24px; }
    .card-dt { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; margin-bottom: 24px; }
    .card-dt-hd { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; align-items: center; justify-content: space-between; }
    .card-dt-hd h3 { font-size: 15px; font-weight: 800; color: #0f172a; margin: 0; }
    .card-dt-bd { padding: 24px; }

    .info-row { display: grid; grid-template-columns: 180px 1fr; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f8fafc; }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .05em; }
    .info-value { font-size: 14px; font-weight: 700; color: #1e293b; }

    .doc-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .doc-item { border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #f8fafc; }
    .doc-label { padding: 10px 14px; font-size: 11px; font-weight: 700; background: #fff; border-bottom: 1px solid #e2e8f0; color: #475569; display: flex; justify-content: space-between; align-items: center; }
    .doc-img-wrap { aspect-ratio: 4/3; display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer; background: #f1f5f9; }
    .doc-img-wrap img { width: 100%; height: 100%; object-fit: contain; transition: transform .3s; }
    .doc-img-wrap:hover img { transform: scale(1.05); }
    .doc-empty { font-size: 12px; color: #94a3b8; font-style: italic; }

    .status-banner { padding: 16px 24px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px; }
    .status-banner.menunggu { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
    .status-banner.diproses { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
    .status-banner.diterima { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .status-banner.ditolak { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

    .btn-action { padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all .2s; }
    .btn-approve { background: #166534; color: #fff; }
    .btn-approve:hover { background: #14532d; transform: translateY(-1px); }
    .btn-reject { background: #991b1b; color: #fff; }
    .btn-reject:hover { background: #7f1d1d; transform: translateY(-1px); }

    @media(max-width: 1024px) { .grid-detail { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('pengajuan.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-slate-900 transition">
        <span>←</span> Kembali ke Daftar
    </a>
    <div class="flex items-center gap-3">
        <span class="text-xs text-slate-500">Kode Pengajuan:</span>
        <span class="px-3 py-1 bg-slate-900 text-white rounded-lg font-mono font-bold text-sm">{{ $pengajuan->kode_pengajuan }}</span>
    </div>
</div>

<div class="grid-detail">
    <div class="main-content">
        
        {{-- Status Banner --}}
        @php
            $s = $pengajuan->status;
            $cls = match(true) {
                str_contains($s,'Menunggu') => 'menunggu',
                str_contains($s,'Diterima') => 'diterima',
                str_contains($s,'Ditolak')||str_contains($s,'Dibatalkan') => 'ditolak',
                str_contains($s,'Diproses') => 'diproses',
                default => 'menunggu',
            };
        @endphp
        <div class="status-banner {{ $cls }}">
            <div style="font-size: 24px;">
                @if($cls === 'menunggu') ⏳ @elseif($cls === 'diterima') ✅ @elseif($cls === 'ditolak') ❌ @else ⚙️ @endif
            </div>
            <div>
                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .1em;">Status Saat Ini</div>
                <div style="font-size: 18px; font-weight: 900;">{{ $s }}</div>
            </div>
        </div>

        {{-- Profil Pelanggan --}}
        <div class="card-dt">
            <div class="card-dt-hd">
                <h3>👤 Profil & Biodata Pelanggan</h3>
                <span class="cnt-badge">Data Pribadi</span>
            </div>
            <div class="card-dt-bd">
                <div class="info-row">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $pengajuan->pelanggan?->nama_pelanggan ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">NIK (KTP)</div>
                    <div class="info-value">{{ $pengajuan->pelanggan?->nik ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $pengajuan->pelanggan?->no_telp ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $pengajuan->pelanggan?->email ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Alamat KTP</div>
                    <div class="info-value">
                        {{ $pengajuan->pelanggan?->alamat1 ?? '—' }}<br>
                        {{ $pengajuan->pelanggan?->kota1 }}, {{ $pengajuan->pelanggan?->propinsi1 }} {{ $pengajuan->pelanggan?->kodepos1 }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Pekerjaan</div>
                    <div class="info-value">{{ $pengajuan->pelanggan?->pekerjaan ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Penghasilan</div>
                    <div class="info-value">Rp {{ number_format($pengajuan->pelanggan?->penghasilan_bulanan, 0, ',', '.') }} /bulan</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value" style="text-transform: capitalize;">{{ $pengajuan->pelanggan?->status_pernikahan ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- Dokumen Persyaratan --}}
        <div class="card-dt">
            <div class="card-dt-hd">
                <h3>📄 Dokumen & Foto Persyaratan</h3>
                <span class="cnt-badge">Verifikasi Keaslian</span>
            </div>
            <div class="card-dt-bd">
                <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Klik gambar untuk memperbesar. Pastikan data di dokumen sesuai dengan biodata di atas.</p>
                <div class="doc-grid">
                    {{-- KTP --}}
                    <div class="doc-item">
                        <div class="doc-label">FOTO KTP @if($pengajuan->url_ktp) <a href="{{ asset('storage/' . $pengajuan->url_ktp) }}" target="_blank" style="color:#3b82f6;text-decoration:none;">Buka Full ↗</a> @endif</div>
                        <div class="doc-img-wrap" onclick="window.open('{{ $pengajuan->url_ktp ? asset('storage/' . $pengajuan->url_ktp) : '#' }}', '_blank')">
                            @if($pengajuan->url_ktp)
                                <img src="{{ asset('storage/' . $pengajuan->url_ktp) }}" alt="KTP">
                            @else
                                <div class="doc-empty">Dokumen tidak diunggah</div>
                            @endif
                        </div>
                    </div>
                    {{-- Pas Foto --}}
                    <div class="doc-item">
                        <div class="doc-label">PAS FOTO @if($pengajuan->url_foto) <a href="{{ asset('storage/' . $pengajuan->url_foto) }}" target="_blank" style="color:#3b82f6;text-decoration:none;">Buka Full ↗</a> @endif</div>
                        <div class="doc-img-wrap" onclick="window.open('{{ $pengajuan->url_foto ? asset('storage/' . $pengajuan->url_foto) : '#' }}', '_blank')">
                            @if($pengajuan->url_foto)
                                <img src="{{ asset('storage/' . $pengajuan->url_foto) }}" alt="Foto">
                            @else
                                <div class="doc-empty">Dokumen tidak diunggah</div>
                            @endif
                        </div>
                    </div>
                    {{-- KK --}}
                    <div class="doc-item">
                        <div class="doc-label">KARTU KELUARGA (KK) @if($pengajuan->url_kk) <a href="{{ asset('storage/' . $pengajuan->url_kk) }}" target="_blank" style="color:#3b82f6;text-decoration:none;">Buka Full ↗</a> @endif</div>
                        <div class="doc-img-wrap" onclick="window.open('{{ $pengajuan->url_kk ? asset('storage/' . $pengajuan->url_kk) : '#' }}', '_blank')">
                            @if($pengajuan->url_kk)
                                <img src="{{ asset('storage/' . $pengajuan->url_kk) }}" alt="KK">
                            @else
                                <div class="doc-empty">Dokumen tidak diunggah</div>
                            @endif
                        </div>
                    </div>
                    {{-- Slip Gaji --}}
                    <div class="doc-item">
                        <div class="doc-label">SLIP GAJI / BUKTI PENGHASILAN @if($pengajuan->url_slip_gaji) <a href="{{ asset('storage/' . $pengajuan->url_slip_gaji) }}" target="_blank" style="color:#3b82f6;text-decoration:none;">Buka Full ↗</a> @endif</div>
                        <div class="doc-img-wrap" onclick="window.open('{{ $pengajuan->url_slip_gaji ? asset('storage/' . $pengajuan->url_slip_gaji) : '#' }}', '_blank')">
                            @if($pengajuan->url_slip_gaji)
                                <img src="{{ asset('storage/' . $pengajuan->url_slip_gaji) }}" alt="Slip Gaji">
                            @else
                                <div class="doc-empty">Dokumen tidak diunggah</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Sidebar Detail --}}
    <div class="sidebar-detail">
        
        {{-- Rincian Kredit --}}
        <div class="card-dt">
            <div class="card-dt-hd">
                <h3>💰 Rincian Kredit</h3>
            </div>
            <div class="card-dt-bd">
                <div style="text-align: center; margin-bottom: 20px;">
                    @if($pengajuan->motor?->foto1)
                        <img src="{{ asset('storage/' . $pengajuan->motor->foto1) }}" style="width: 100%; border-radius: 12px; margin-bottom: 12px;">
                    @endif
                    <div style="font-weight: 800; font-size: 16px; color: #0f172a;">{{ $pengajuan->motor?->nama_motor }}</div>
                    <div style="font-size: 12px; color: #64748b;">{{ $pengajuan->motor?->kode_motor }}</div>
                </div>

                <div class="info-row" style="grid-template-columns: 120px 1fr;">
                    <div class="info-label">Harga OTR</div>
                    <div class="info-value">Rp {{ number_format($pengajuan->harga_cash, 0, ',', '.') }}</div>
                </div>
                <div class="info-row" style="grid-template-columns: 120px 1fr;">
                    <div class="info-label">Uang Muka (DP)</div>
                    <div class="info-value" style="color: #166534;">Rp {{ number_format($pengajuan->dp, 0, ',', '.') }}</div>
                </div>
                <div class="info-row" style="grid-template-columns: 120px 1fr;">
                    <div class="info-label">Tenor</div>
                    <div class="info-value">{{ $pengajuan->tenor_bulan }} Bulan</div>
                </div>
                <div class="info-row" style="grid-template-columns: 120px 1fr;">
                    <div class="info-label">Angsuran</div>
                    <div class="info-value" style="font-size: 16px; color: #ef4444;">Rp {{ number_format($pengajuan->angsuran_per_bulan, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- Panel Aksi --}}
        @if(in_array($pengajuan->status, ['Menunggu Konfirmasi', 'Diproses']) && in_array(auth()->user()?->role?->slug, ['marketing','owner','surveyor','kolektor'], true))
        <div class="card-dt" style="border: 2px solid #e2e8f0;">
            <div class="card-dt-hd" style="background: #f1f5f9;">
                <h3>⚡ Panel Keputusan</h3>
            </div>
            <div class="card-dt-bd">
                <form method="POST" action="{{ route('pengajuan.update-status', $pengajuan) }}">
                    @csrf
                    <div style="margin-bottom: 15px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px;">HASIL VERIFIKASI</label>
                        <select name="status" required style="width:100%; height:42px; border:1px solid #cbd5e1; border-radius:10px; padding:0 12px; font-weight:600;">
                            <option value="">Pilih Keputusan...</option>
                            <option value="Diproses" {{ $pengajuan->status === 'Diproses' ? 'selected' : '' }}>Proses (Survey)</option>
                            <option value="Diterima">Terima & Aktifkan Kredit</option>
                            <option value="Dibatalkan Penjual">Tolak Pengajuan</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px;">CATATAN (ALASAN)</label>
                        <textarea name="catatan" rows="3" placeholder="Contoh: Dokumen lengkap dan valid, lanjut survey..." style="width:100%; border:1px solid #cbd5e1; border-radius:10px; padding:12px; font-size:13px; font-family:inherit;"></textarea>
                    </div>
                    <button type="submit" style="width:100%; height:46px; background:#0f172a; color:#fff; border:none; border-radius:11px; font-weight:700; font-size:14px; cursor:pointer; transition:all .2s;">
                        Simpan Keputusan
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Approver Info --}}
        @if($pengajuan->approved_by)
        <div class="card-dt">
            <div class="card-dt-bd" style="padding: 16px;">
                <div style="font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-bottom: 8px;">Diverifikasi Oleh</div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; color: #475569;">
                        {{ strtoupper(substr($pengajuan->approver->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: #1e293b;">{{ $pengajuan->approver->name }}</div>
                        <div style="font-size: 11px; color: #94a3b8;">{{ $pengajuan->approved_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
                @if($pengajuan->catatan)
                    <div style="margin-top: 12px; padding: 10px; background: #f8fafc; border-radius: 8px; font-size: 12px; color: #475569; line-height: 1.5; border: 1px solid #f1f5f9;">
                        <strong>Catatan:</strong><br>{{ $pengajuan->catatan }}
                    </div>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
