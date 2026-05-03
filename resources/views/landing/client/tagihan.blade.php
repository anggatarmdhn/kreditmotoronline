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
    <title>Tagihan & Angsuran Saya – {{ $company['name'] }}</title>
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
                <a href="{{ route('client.pengajuan') }}" class="hover:text-red-600">Pengajuan Kredit</a>
                <a href="{{ route('client.tagihan') }}" class="text-red-600">Tagihan & Cicilan</a>
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
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4 text-3xl">💸</div>
                <h2 class="text-3xl font-extrabold text-slate-900">Tagihan & Cicilan</h2>
                <p class="text-slate-500 mt-2">Bayar cicilan bulanan motor Anda dengan mudah secara online.</p>
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

        <div class="grid gap-8">
            @forelse($kredits as $kredit)
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row gap-6 items-start mb-6 pb-6 border-b border-slate-100">
                        @if($kredit->pengajuanKredit->motor->foto1)
                            <img src="{{ asset('storage/'.$kredit->pengajuanKredit->motor->foto1) }}" style="width: 140px; height: 140px; min-width: 140px;" class="object-cover rounded-2xl bg-slate-50 flex-shrink-0 border border-slate-100">
                        @else
                            <div style="width: 140px; height: 140px; min-width: 140px;" class="rounded-2xl bg-slate-50 flex items-center justify-center text-xs text-slate-400 font-bold flex-shrink-0 border border-slate-100 text-center">NO IMAGE</div>
                        @endif

                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md uppercase">KREDIT AKTIF</span>
                                <span class="text-xs font-bold text-slate-500">Mulai: {{ \Carbon\Carbon::parse($kredit->tgl_mulai_kredit)->translatedFormat('d M Y') }}</span>
                            </div>
                            <h3 class="text-2xl font-extrabold text-slate-900 mb-2">{{ $kredit->pengajuanKredit->motor->nama_motor }}</h3>
                            <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-600 mb-4">
                                <div><span class="text-slate-400">Total Kredit:</span> <strong class="text-slate-900">Rp {{ number_format($kredit->pengajuanKredit->total_pembiayaan, 0, ',', '.') }}</strong></div>
                                <div><span class="text-slate-400">Sisa Kredit:</span> <strong class="text-red-600">Rp {{ number_format($kredit->sisa_kredit, 0, ',', '.') }}</strong></div>
                                <div><span class="text-slate-400">Tenor:</span> <strong class="text-slate-900">{{ $kredit->pengajuanKredit->tenor_bulan }} Bln</strong></div>
                            </div>
                        </div>
                    </div>

                    <h4 class="text-lg font-bold text-slate-800 mb-4">Jadwal Angsuran</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-y border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">Bulan Ke</th>
                                    <th class="px-4 py-3">Jatuh Tempo</th>
                                    <th class="px-4 py-3">Tagihan</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kredit->angsurans as $angsuran)
                                    @php
                                        $isPastDue = $angsuran->jatuh_tempo && now()->startOfDay()->gt($angsuran->jatuh_tempo);
                                        $rowClass = $angsuran->status === 'lunas' ? 'bg-emerald-50/30' : ($isPastDue && $angsuran->status !== 'lunas' ? 'bg-red-50/50' : 'hover:bg-slate-50');
                                    @endphp
                                    <tr class="border-b border-slate-100 {{ $rowClass }}">
                                        <td class="px-4 py-4 font-bold text-slate-700">#{{ $angsuran->angsuran_ke }}</td>
                                        <td class="px-4 py-4">
                                            {{ \Carbon\Carbon::parse($angsuran->jatuh_tempo)->translatedFormat('d M Y') }}
                                            @if($isPastDue && $angsuran->status !== 'lunas')
                                                <span class="text-[10px] text-red-600 font-bold block">Terlambat</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 font-bold text-slate-900">
                                            Rp {{ number_format($angsuran->jumlah_tagihan, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($angsuran->status === 'lunas')
                                                <span class="inline-flex items-center px-2 py-1 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase tracking-wider">Lunas</span>
                                            @elseif($angsuran->status === 'tunggak' || $isPastDue)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md bg-red-100 text-red-800 text-[10px] font-bold uppercase tracking-wider">Tunggakan</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider">Belum Bayar</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            @if($angsuran->status === 'lunas')
                                                <span class="text-xs text-slate-400 font-medium">Dibayar: {{ \Carbon\Carbon::parse($angsuran->tanggal_bayar)->translatedFormat('d M Y') }}</span>
                                            @else
                                                <a href="{{ route('client.angsuran.bayar', $angsuran) }}" class="inline-block px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-lg text-xs transition">Bayar Cicilan</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-slate-200 rounded-2xl p-10 text-center shadow-sm">
                    <div class="text-5xl mb-4">💸</div>
                    <h3 class="text-lg font-bold text-slate-900">Belum ada kredit aktif</h3>
                    <p class="text-slate-500 mt-2 text-sm">Anda belum memiliki kredit motor yang sedang berjalan.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
