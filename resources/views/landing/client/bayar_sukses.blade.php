@php
    $company = [
        'name'       => \App\Models\Setting::get('company_name', 'Angga Credit Motors'),
        'name_short' => \App\Models\Setting::get('company_name_short', 'Angga Motors'),
        'name_suffix'=> \App\Models\Setting::get('company_name_suffix', 'Credit'),
        'tagline'    => \App\Models\Setting::get('company_tagline', 'Sistem Informasi Kredit Motor'),
        'branch'     => \App\Models\Setting::get('company_branch', 'Rajeg'),
        'phone'      => \App\Models\Setting::get('company_phone', '0813-8704-7805'),
        'logo_text'  => \App\Models\Setting::get('company_logo_text', 'KM'),
        'logo_path'  => \App\Models\Setting::get('company_logo_path', ''),
    ];
@endphp
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Berhasil – {{ $company['name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Sora', sans-serif; background: #f0fdf4; }

        .hero-success {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);
            position: relative; overflow: hidden;
        }
        .hero-success::before {
            content: ''; position: absolute; top: -80px; right: -80px;
            width: 300px; height: 300px; border-radius: 50%;
            background: rgba(255,255,255,.06); 
        }
        .hero-success::after {
            content: ''; position: absolute; bottom: -60px; left: 10%;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,.04);
        }

        .check-circle {
            width: 96px; height: 96px; border-radius: 50%;
            background: rgba(255,255,255,.15);
            border: 3px solid rgba(255,255,255,.3);
            display: flex; align-items: center; justify-content: center;
            font-size: 48px; margin: 0 auto 20px;
            animation: popIn .5s cubic-bezier(.175,.885,.32,1.275);
        }
        @keyframes popIn {
            from { transform: scale(0); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        .card { background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; }
        .card-hd { padding: 18px 22px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .card-body { padding: 22px; }

        .info-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 11px 0; border-bottom: 1px solid #f8fafc; font-size: 13px; gap: 12px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #64748b; font-weight: 600; flex-shrink: 0; }
        .info-val { color: #0f172a; font-weight: 700; text-align: right; }

        .angsuran-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; border-radius: 10px; font-size: 12px; margin-bottom: 6px; }
        .angsuran-row:nth-child(odd) { background: #f8fafc; }
        .angsuran-row:nth-child(even) { background: #fff; }

        .badge-lunas { background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 99px; font-size: 10px; font-weight: 700; }
        .badge-pending { background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 99px; font-size: 10px; font-weight: 700; }

        .step-item { display: flex; gap: 14px; align-items: flex-start; margin-bottom: 20px; }
        .step-num { width: 32px; height: 32px; border-radius: 50%; background: #ecfdf5; color: #059669; font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #a7f3d0; }
        .step-active .step-num { background: #059669; color: #fff; border-color: #059669; }

        @media(max-width: 768px) {
            .two-col { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body class="text-slate-800">

    {{-- Header --}}
    <header class="sticky top-0 z-30 border-b border-slate-200/90 bg-white/95 backdrop-blur">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center gap-4">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-red-700 text-white flex items-center justify-center font-extrabold text-sm overflow-hidden">
                    @if($company['logo_path'])
                        <img src="{{ asset('storage/'.$company['logo_path']) }}" class="w-full h-full object-cover">
                    @else
                        {{ $company['logo_text'] }}
                    @endif
                </div>
                <div>
                    <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em]">{{ $company['name_short'] }}</p>
                    <p class="font-extrabold text-slate-900 text-sm leading-tight">{{ $company['name_suffix'] }}</p>
                </div>
            </a>
            <div class="flex-1"></div>
            <a href="{{ route('client.pengajuan') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
                ← Pengajuan Saya
            </a>
        </div>
    </header>

    {{-- Hero Sukses --}}
    <div class="hero-success text-white py-12 px-4 text-center relative z-0">
        <div class="relative z-10 max-w-xl mx-auto">
            <div class="check-circle">✅</div>
            <h1 class="text-3xl font-black mb-2">Pembayaran Berhasil!</h1>
            <p class="text-emerald-100 text-sm mb-1">Uang Muka (DP) untuk kredit motor Anda telah diterima.</p>
            <p class="text-emerald-200 text-xs">
                Order ID: <span class="font-mono font-bold">{{ $pengajuan->midtrans_order_id ?? '-' }}</span>
            </p>
            @if($pengajuan->dp_paid_at)
                <p class="text-emerald-200 text-xs mt-1">
                    Dibayar pada: {{ $pengajuan->dp_paid_at->format('d M Y, H:i') }} WIB
                </p>
            @endif
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="two-col" style="display:grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start;">

            {{-- Kiri: Ringkasan + Angsuran --}}
            <div style="display: flex; flex-direction: column; gap: 16px;">

                {{-- Ringkasan Pengajuan --}}
                <div class="card">
                    <div class="card-hd">
                        <div>
                            <h3 style="font-size:14px; font-weight:700; color:#0f172a; margin:0;">Ringkasan Pengajuan</h3>
                            <p style="font-size:11px; color:#94a3b8; margin:2px 0 0;">Detail kredit motor Anda</p>
                        </div>
                        @if($pengajuan->dp_paid)
                            <span style="font-size:11px; font-weight:700; background:#d1fae5; color:#065f46; padding:4px 12px; border-radius:999px;">✅ DP Lunas</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label">Kode Pengajuan</span>
                            <span class="info-val" style="font-family:monospace;">{{ $pengajuan->kode_pengajuan }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Motor</span>
                            <span class="info-val">{{ $pengajuan->motor->nama_motor }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Harga OTR</span>
                            <span class="info-val">Rp {{ number_format($pengajuan->harga_cash, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Uang Muka (DP)</span>
                            <span class="info-val" style="color:#059669;">Rp {{ number_format($pengajuan->dp, 0, ',', '.') }} ✅</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Pokok Hutang</span>
                            <span class="info-val">Rp {{ number_format($pengajuan->pokok_hutang, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tenor</span>
                            <span class="info-val">{{ $pengajuan->tenor_bulan }} Bulan</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Angsuran/Bulan</span>
                            <span class="info-val" style="font-size:16px; color:#0f172a;">Rp {{ number_format($pengajuan->angsuran_per_bulan, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Pembiayaan</span>
                            <span class="info-val">Rp {{ number_format($pengajuan->total_pembiayaan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Jadwal Angsuran --}}
                @if($pengajuan->kredit && $pengajuan->kredit->angsurans->count() > 0)
                <div class="card">
                    <div class="card-hd">
                        <div>
                            <h3 style="font-size:14px; font-weight:700; color:#0f172a; margin:0;">Jadwal Angsuran Kredit</h3>
                            <p style="font-size:11px; color:#94a3b8; margin:2px 0 0;">{{ $pengajuan->kredit->angsurans->count() }} kali cicilan</p>
                        </div>
                    </div>
                    <div style="padding: 14px 22px; max-height: 360px; overflow-y: auto;">
                        {{-- Header --}}
                        <div style="display:flex; justify-content:space-between; padding:8px 14px; font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.06em;">
                            <span>Cicilan ke</span>
                            <span>Jatuh Tempo</span>
                            <span>Jumlah</span>
                            <span>Status</span>
                        </div>
                        @foreach($pengajuan->kredit->angsurans->sortBy('angsuran_ke') as $ang)
                            <div class="angsuran-row">
                                <span style="font-weight:700; color:#475569; min-width:60px;">ke-{{ $ang->angsuran_ke }}</span>
                                <span style="color:#64748b;">{{ \Carbon\Carbon::parse($ang->jatuh_tempo)->format('d M Y') }}</span>
                                <span style="font-weight:700; color:#0f172a;">Rp {{ number_format($ang->jumlah_tagihan, 0, ',', '.') }}</span>
                                @if($ang->status === 'lunas')
                                    <span class="badge-lunas">Lunas</span>
                                @else
                                    <span class="badge-pending">Belum</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-body" style="text-align:center; color:#94a3b8; padding: 30px;">
                        <p style="font-size:13px;">Jadwal angsuran sedang dipersiapkan oleh tim kami.</p>
                    </div>
                </div>
                @endif

            </div>

            {{-- Kanan: Status & Langkah --}}
            <div style="display: flex; flex-direction: column; gap: 16px;">

                {{-- Status Saat Ini --}}
                <div class="card">
                    <div class="card-hd">
                        <h3 style="font-size:14px; font-weight:700; color:#0f172a; margin:0;">Status Pengajuan</h3>
                    </div>
                    <div class="card-body">
                        <div style="text-align:center; padding: 10px 0;">
                            <div style="font-size:36px; margin-bottom:10px;">🏍️</div>
                            @php
                            $statusColor = match($pengajuan->status) {
                                'Diproses'          => '#2563eb',
                                'Diterima'          => '#059669',
                                'Menunggu Konfirmasi' => '#d97706',
                                default             => '#ef4444',
                            };
                            $statusDesc = match($pengajuan->status) {
                                'Diproses' => 'DP diterima, motor sedang diproses untuk pengiriman.',
                                'Diterima' => 'Pengajuan disetujui, menunggu pembayaran DP.',
                                'Menunggu Konfirmasi' => 'Pengajuan sedang menunggu review admin.',
                                default    => 'Silakan hubungi admin untuk informasi lebih lanjut.',
                            };
                        @endphp
                        <div style="font-size:20px; font-weight:900; color:{{ $statusColor }};">{{ $pengajuan->status }}</div>
                            <div style="font-size:12px; color:#64748b; margin-top:6px;">{{ $statusDesc }}</div>
                        </div>
                        @if($pengajuan->catatan)
                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px; margin-top:14px; font-size:12px; color:#065f46;">
                            {{ $pengajuan->catatan }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Langkah Selanjutnya --}}
                <div class="card">
                    <div class="card-hd">
                        <h3 style="font-size:14px; font-weight:700; color:#0f172a; margin:0;">Langkah Selanjutnya</h3>
                    </div>
                    <div class="card-body">
                        <div class="step-item step-active">
                            <div class="step-num">1</div>
                            <div>
                                <div style="font-size:13px; font-weight:700; color:#0f172a;">DP Dibayar ✅</div>
                                <div style="font-size:11px; color:#64748b; margin-top:2px;">Pembayaran uang muka telah diterima</div>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">2</div>
                            <div>
                                <div style="font-size:13px; font-weight:700; color:#475569;">Verifikasi Dokumen</div>
                                <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Tim kami memverifikasi kelengkapan berkas</div>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">3</div>
                            <div>
                                <div style="font-size:13px; font-weight:700; color:#475569;">Survei & Persetujuan</div>
                                <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Proses survei oleh tim lapangan</div>
                            </div>
                        </div>
                        <div class="step-item" style="margin-bottom:0;">
                            <div class="step-num">4</div>
                            <div>
                                <div style="font-size:13px; font-weight:700; color:#475569;">Pengiriman Motor 🏍️</div>
                                <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Motor dikirim ke alamat Anda</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CTA --}}
                <a href="{{ route('client.pengajuan') }}"
                   style="display:block; text-align:center; background:#0f172a; color:#fff; font-weight:800; font-size:14px; padding:14px; border-radius:14px; text-decoration:none; transition: background .2s;"
                   onmouseover="this.style.background='#1e293b'" onmouseout="this.style.background='#0f172a'">
                    Lihat Semua Pengajuan
                </a>
                <a href="{{ route('landing') }}"
                   style="display:block; text-align:center; border:1px solid #e2e8f0; color:#475569; font-weight:700; font-size:13px; padding:12px; border-radius:14px; text-decoration:none;">
                    Kembali ke Beranda
                </a>

            </div>
        </div>
    </div>

</body>
</html>
