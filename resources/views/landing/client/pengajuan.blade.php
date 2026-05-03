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
    $roleSlug = auth()->user()?->role?->slug;
    $isInternalUser = in_array($roleSlug, ['admin', 'marketing', 'surveyor', 'kolektor', 'manager', 'owner'], true);
@endphp
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan Saya – {{ $company['name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Sora', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="text-slate-800">

    <div class="bg-slate-900 text-white text-xs">
        <div class="max-w-7xl mx-auto px-4 md:px-5 py-2 flex flex-wrap items-center justify-between gap-2">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                <span>Hubungi Kami: {{ $company['phone'] }}</span>
                <span>Cabang: {{ $company['branch'] }}</span>
            </div>
            <span class="font-semibold text-red-300">{{ $company['tagline'] }}</span>
        </div>
    </div>

    <header class="sticky top-0 z-30 border-b border-slate-200/90 bg-white/95 backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 md:px-5 py-4 flex items-center gap-4 md:gap-5">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 min-w-fit">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-red-500 to-red-700 text-white flex items-center justify-center font-extrabold overflow-hidden">
                    @if($company['logo_path'])
                        <img src="{{ asset('storage/'.$company['logo_path']) }}" class="w-full h-full object-cover">
                    @else
                        {{ $company['logo_text'] }}
                    @endif
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 uppercase tracking-[0.2em]">{{ $company['name_short'] }}</p>
                    <h1 class="font-extrabold text-slate-900 leading-tight">{{ $company['name_suffix'] }}</h1>
                </div>
            </a>

            <nav class="hidden xl:flex items-center gap-4 text-sm font-semibold text-slate-700 min-w-fit">
                <a href="{{ route('landing') }}" class="hover:text-red-600">Beranda</a>
                <a href="{{ route('landing') }}#katalog" class="hover:text-red-600">Katalog</a>
                <a href="{{ route('client.pengajuan') }}" class="text-red-600">Pengajuan Kredit</a>
                <a href="{{ route('client.tagihan') }}" class="hover:text-red-600">Tagihan & Cicilan</a>
            </nav>

            <form method="GET" action="{{ route('landing') }}" class="flex-1">
                <div class="relative">
                    <input type="text" name="q" placeholder="Cari motor, merk, tipe, atau kode unit" class="w-full rounded-full border border-slate-300 bg-slate-50 pl-5 pr-24 py-3 text-sm focus:outline-none focus:border-slate-500 focus:bg-white">
                    <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 px-4 py-2 rounded-full bg-slate-900 text-white text-xs font-semibold">Cari</button>
                </div>
            </form>

            <div class="hidden md:flex items-center gap-2 min-w-fit">
                @auth
                    @if($isInternalUser)
                        <a href="{{ route('dashboard') }}" class="h-11 px-5 flex items-center justify-center rounded-xl border border-slate-300 text-slate-700 text-sm font-bold hover:bg-slate-50 transition whitespace-nowrap">Panel</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="h-11 px-5 flex items-center justify-center rounded-xl border border-transparent bg-slate-900 text-white font-bold text-sm hover:bg-slate-800 transition whitespace-nowrap shadow-sm">Akun Saya</a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                        @csrf
                        <button type="submit" class="h-11 px-5 flex items-center justify-center rounded-xl border border-slate-300 text-slate-700 text-sm font-bold hover:bg-slate-50 transition whitespace-nowrap">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="h-11 px-5 flex items-center justify-center rounded-xl border border-slate-300 text-slate-700 text-sm font-bold hover:bg-slate-50 transition whitespace-nowrap">Masuk</a>
                    <a href="{{ route('register') }}" class="h-11 px-5 flex items-center justify-center rounded-xl bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition whitespace-nowrap">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-5 py-12">
        <div class="max-w-4xl">
            <div class="mb-10 text-left">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4 text-3xl">📋</div>
                <h2 class="text-3xl font-extrabold text-slate-900">Pengajuan Saya</h2>
                <p class="text-slate-500 mt-2">Pantau status aplikasi kredit motor Anda secara real-time.</p>
            </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl p-4 mb-8 font-semibold text-sm text-center shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-xl p-4 mb-8 font-semibold text-sm text-center">
                ❌ {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6">
            @forelse($pengajuans as $p)
                <div class="bg-white border border-slate-200 rounded-3xl p-5 md:p-7 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-shadow duration-300">
                    
                    <div class="flex flex-row gap-4 sm:gap-6 items-start">
                        @if($p->motor->foto1)
                            <img src="{{ asset('storage/'.$p->motor->foto1) }}" style="width: 120px; height: 120px; min-width: 120px;" class="object-cover rounded-2xl bg-slate-50 flex-shrink-0 border border-slate-100">
                        @else
                            <div style="width: 120px; height: 120px; min-width: 120px;" class="rounded-2xl bg-slate-50 flex items-center justify-center text-xs text-slate-400 font-bold flex-shrink-0 border border-slate-100 text-center">NO IMAGE</div>
                        @endif

                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md tracking-wider uppercase">{{ $p->kode_pengajuan }}</span>
                                    <span class="text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->translatedFormat('d M Y') }}</span>
                                </div>
                                <h3 class="text-xl font-extrabold text-slate-900 mb-1">{{ $p->motor->nama_motor }}</h3>
                                <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm text-slate-500 mb-4">
                                    <span>Tenor: <strong class="text-slate-700">{{ $p->tenor_bulan }} Bln</strong></span>
                                    <span>Angsuran: <strong class="text-slate-700">Rp {{ number_format($p->angsuran_per_bulan, 0, ',', '.') }}/bln</strong></span>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div>
                                    <span class="block text-xs text-slate-500 mb-0.5">Uang Muka (DP)</span>
                                    <strong class="text-slate-900 font-black">Rp {{ number_format($p->dp, 0, ',', '.') }}</strong>
                                </div>

                                <div class="flex items-center gap-3">
                                    {{-- STATUS: Diterima (Disetujui) --}}
                                    @if($p->status === 'Diterima')
                                        @if($p->dp_paid)
                                            {{-- DP already paid - show success badge, NO pay button --}}
                                            <div class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-200">
                                                ✅ DP Sudah Dibayar
                                            </div>
                                            <div class="px-5 py-2.5 rounded-xl bg-slate-300 text-slate-500 font-extrabold text-sm cursor-not-allowed" title="Pembayaran sudah dilakukan">
                                                Sudah Lunas
                                            </div>
                                        @else
                                            {{-- DP not yet paid - show approve badge + pay button --}}
                                            <div class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 font-bold text-xs">
                                                Disetujui
                                            </div>
                                            <a href="{{ route('client.bayar', $p) }}" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-sm transition shadow-lg shadow-slate-900/20">
                                                Bayar DP
                                            </a>
                                        @endif

                                    {{-- STATUS: Diproses (could be after DP payment or admin processing) --}}
                                    @elseif($p->status === 'Diproses')
                                        @if($p->dp_paid)
                                            <div class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-200">
                                                ✅ DP Sudah Dibayar
                                            </div>
                                            <div class="px-4 py-2 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 font-bold text-sm">
                                                Sedang Diproses
                                            </div>
                                        @else
                                            <div class="px-4 py-2 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 font-bold text-sm">
                                                {{ $p->status }}
                                            </div>
                                        @endif

                                    {{-- STATUS: Menunggu Konfirmasi --}}
                                    @elseif($p->status === 'Menunggu Konfirmasi')
                                        <div class="px-4 py-2 rounded-xl bg-orange-50 text-orange-700 border border-orange-100 font-bold text-sm">
                                            {{ $p->status }}
                                        </div>

                                    {{-- STATUS: Dibatalkan / Ditolak --}}
                                    @else
                                        <div class="px-4 py-2 rounded-xl bg-red-50 text-red-700 border border-red-100 font-bold text-sm">
                                            {{ $p->status }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Show DP payment info if paid --}}
                            @if($p->dp_paid && $p->dp_paid_at)
                                <div class="mt-3 p-3 rounded-xl bg-emerald-50 border border-emerald-100 text-xs text-emerald-700">
                                    <strong>📝 Info Pembayaran:</strong> DP dibayar pada {{ $p->dp_paid_at->format('d M Y H:i') }}
                                    @if($p->midtrans_order_id)
                                        · Order ID: <span class="font-mono">{{ $p->midtrans_order_id }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-slate-200 rounded-2xl p-10 text-center shadow-sm">
                    <div class="text-5xl mb-4">📋</div>
                    <h3 class="text-lg font-bold text-slate-900">Belum ada pengajuan</h3>
                    <p class="text-slate-500 mt-2 text-sm">Anda belum memiliki riwayat pengajuan kredit. Silakan cek katalog dan mulai ajukan kredit pertama Anda.</p>
                    <a href="{{ route('landing') }}#katalog" class="inline-block mt-5 px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm transition">Lihat Katalog Motor</a>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
