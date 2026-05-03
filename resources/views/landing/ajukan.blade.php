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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Kredit - {{ $motor->nama_motor }} | {{ $company['name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Sora', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans">
    @php
        $defaultTenor = $jenisCicilans->first();
        $defaultTenorId = old('jenis_cicilan_id', $defaultTenor?->id);
        $defaultDp = old('dp', (int) $motor->dp_minimum);
        $defaultAsuransiId = old('asuransi_id', $asuransis->first()?->id);
        $roleSlug = auth()->user()?->role?->slug;
        $isInternalUser = in_array($roleSlug, ['admin', 'marketing', 'surveyor', 'kolektor', 'manager', 'owner'], true);
    @endphp

    <div class="bg-slate-900 text-white text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-wrap items-center justify-between gap-2">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                <span>Hubungi Kami: {{ $company['phone'] }}</span>
                <span>Cabang: {{ $company['branch'] }}</span>
            </div>
            <span class="font-semibold text-red-300">{{ $company['tagline'] }}</span>
        </div>
    </div>

    <header class="sticky top-0 z-30 border-b border-slate-200/90 bg-white/95 backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center gap-4 md:gap-5">
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
                @auth
                    <a href="{{ route('client.tagihan') }}" class="hover:text-red-600">Tagihan & Cicilan</a>
                @endauth
            </nav>

            <div class="flex-1"></div>

            <div class="hidden md:flex items-center gap-2 min-w-fit h-11">
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">
            
            <!-- Left Column: Motor Details -->
            <div class="w-full lg:w-7/12 space-y-6">
                <!-- Image Gallery -->
                <div class="bg-white rounded-3xl border border-slate-200 p-4 shadow-sm overflow-hidden">
                    <div style="aspect-ratio: 16/10;" class="w-full bg-slate-100 rounded-2xl overflow-hidden">
                        <img src="{{ $motor->foto1 ? asset('storage/'.$motor->foto1) : asset('images/placeholders/card-1200x700.svg') }}" alt="{{ $motor->nama_motor }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex gap-3 mt-3">
                        <div style="aspect-ratio: 16/10;" class="w-1/2 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 cursor-pointer hover:border-red-500 transition">
                            <img src="{{ $motor->foto2 ? asset('storage/'.$motor->foto2) : asset('images/placeholders/card-1200x700.svg') }}" class="w-full h-full object-cover">
                        </div>
                        <div style="aspect-ratio: 16/10;" class="w-1/2 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 cursor-pointer hover:border-red-500 transition">
                            <img src="{{ $motor->foto3 ? asset('storage/'.$motor->foto3) : asset('images/placeholders/card-1200x700.svg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Info Block -->
                <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                    <div class="uppercase tracking-[0.15em] text-[11px] font-bold text-red-600 mb-1.5">{{ $motor->jenisMotor?->merk ?? 'Merk' }}</div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight tracking-tight mb-5">{{ $motor->nama_motor }}</h1>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-xs font-bold text-slate-600">{{ $motor->jenisMotor?->jenis ?? 'Tipe' }}</span>
                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-xs font-bold text-slate-600">{{ $motor->kapasitas_mesin ?? '150cc' }}</span>
                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-xs font-bold text-slate-600">{{ $motor->warna }}</span>
                    </div>

                    <p class="text-slate-600 leading-relaxed text-sm md:text-base">
                        {{ $motor->deskripsi_motor ?? 'Sepeda motor pilihan tepat dengan desain modern dan performa mesin yang efisien. Dapatkan segera dengan cicilan ringan dan proses yang cepat.' }}
                    </p>

                    <div class="mt-8 border-t border-slate-100 pt-6">
                        <h3 class="font-bold text-slate-900 mb-4 text-lg">Spesifikasi Singkat</h3>
                        <div class="grid grid-cols-2 gap-y-5 text-sm">
                            <div>
                                <div class="text-slate-500 text-xs font-semibold mb-1 uppercase tracking-wide">Tahun Produksi</div>
                                <div class="font-bold text-slate-900">{{ $motor->tahun_produksi }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-xs font-semibold mb-1 uppercase tracking-wide">Ketersediaan Stok</div>
                                <div class="font-bold text-emerald-600 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> {{ $motor->stok }} Unit Ready
                                </div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-xs font-semibold mb-1 uppercase tracking-wide">Kode Motor</div>
                                <div class="font-bold text-slate-900">{{ $motor->kode_motor }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Simulation & Form -->
            <div class="w-full lg:w-5/12 lg:sticky lg:top-24 space-y-6">
                <!-- Errors and Success -->
                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-semibold shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm font-semibold shadow-sm">
                        <p class="mb-2">Terdapat kesalahan pada form:</p>
                        <ul class="list-disc pl-5 space-y-1 font-normal">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Card -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
                    <div class="p-6 md:p-8 border-b border-slate-100">
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">Harga OTR</p>
                        <div class="text-3xl md:text-4xl font-black text-slate-900">Rp {{ number_format((float) $motor->harga_cash, 0, ',', '.') }}</div>
                    </div>

                    <div class="p-6 md:p-8 bg-slate-50">
                        <h3 class="font-black text-xl text-slate-900 mb-6">Pengajuan Kredit</h3>
                        
                        @guest
                            <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center shadow-sm">
                                <div class="text-4xl mb-4">🔒</div>
                                <h4 class="font-bold text-slate-900 text-lg mb-2">Masuk untuk Mengajukan</h4>
                                <p class="text-sm text-slate-500 mb-6 leading-relaxed">Anda perlu masuk ke akun Anda untuk melakukan simulasi kredit detail dan mengisi formulir pengajuan.</p>
                                <a href="{{ route('login') }}" class="block w-full py-3.5 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition shadow-lg shadow-red-600/20">Login / Daftar Akun</a>
                            </div>
                        @else
                            <form method="POST" action="{{ route('pengajuan.store', $motor) }}" id="pengajuan-form" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                
                                <!-- Simulasi Section -->
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold">1</div>
                                        <h4 class="font-bold text-sm text-slate-900 uppercase tracking-wider">Rencana Kredit</h4>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Uang Muka (DP)</label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">Rp</span>
                                            <input type="number" id="input-dp" name="dp" min="{{ (int) $motor->dp_minimum }}" max="{{ (int) $motor->harga_cash - 1 }}" step="100000" value="{{ (int) old('dp', (int) $motor->dp_minimum) }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 bg-white focus:border-red-500 focus:ring-1 focus:ring-red-500 font-semibold text-slate-900 transition" required>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-1.5">Minimal DP: Rp {{ number_format((float) $motor->dp_minimum, 0, ',', '.') }}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Tenor (Bulan)</label>
                                            <select id="input-tenor" name="jenis_cicilan_id" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white focus:border-red-500 focus:ring-1 focus:ring-red-500 font-semibold text-slate-900 transition" required>
                                                @foreach($jenisCicilans as $jenis)
                                                    <option value="{{ $jenis->id }}" data-tenor="{{ (int) $jenis->tenor_bulan }}" data-bunga="{{ (float) $jenis->bunga_persen }}" {{ (string) old('jenis_cicilan_id', $defaultTenorId) === (string) $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }} ({{ $jenis->tenor_bulan }}x)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Asuransi</label>
                                            <select id="input-asuransi" name="asuransi_id" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white focus:border-red-500 focus:ring-1 focus:ring-red-500 font-semibold text-slate-900 transition">
                                                <option value="" data-margin="0">Tanpa asuransi</option>
                                                @foreach($asuransis as $asuransi)
                                                    <option value="{{ $asuransi->id }}" data-margin="{{ (float) $asuransi->margin_persen }}" {{ (string) old('asuransi_id', $defaultAsuransiId) === (string) $asuransi->id ? 'selected' : '' }}>{{ $asuransi->nama_asuransi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Hasil Simulasi (Auto update via JS) -->
                                    <div class="bg-red-50 border border-red-100 rounded-xl p-5 mt-2 shadow-sm">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs font-bold text-red-900 uppercase tracking-wide">Cicilan per bulan</span>
                                            <span class="text-xl font-black text-red-700" id="sim-angsuran">Rp 0</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs text-red-700/70 font-semibold">
                                            <span>Asuransi per bulan</span>
                                            <span id="sim-asuransi">Rp 0</span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="border-slate-200 my-6">

                                <!-- Data Pemohon -->
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold">2</div>
                                        <h4 class="font-bold text-sm text-slate-900 uppercase tracking-wider">Data Pemohon</h4>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Domisili Kota</label>
                                            <input type="text" name="kota1" value="{{ old('kota1', 'Jakarta') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-sm transition" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">No. WhatsApp</label>
                                            <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-sm transition" required>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Pekerjaan</label>
                                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Contoh: Karyawan Swasta" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-sm transition" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Penghasilan /Bulan</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                                                <input type="number" name="penghasilan_bulanan" value="{{ old('penghasilan_bulanan') }}" placeholder="0" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-sm transition" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Alamat Lengkap</label>
                                        <textarea name="alamat1" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-sm transition" required>{{ old('alamat1') }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Sesuai KTP</label>
                                        <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan', auth()->user()->name) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 text-sm transition" required>
                                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                    </div>
                                </div>

                                <hr class="border-slate-200 my-6">

                                <!-- Upload Dokumen -->
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold">3</div>
                                        <h4 class="font-bold text-sm text-slate-900 uppercase tracking-wider">Berkas Persyaratan</h4>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Foto KTP <span class="text-red-500">*</span></label>
                                            <input type="file" name="url_ktp" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 transition" required onchange="validateFileSize(this)">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Foto KK <span class="text-red-500">*</span></label>
                                            <input type="file" name="url_kk" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 transition" required onchange="validateFileSize(this)">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Pas Foto</label>
                                            <input type="file" name="url_foto" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 transition" onchange="validateFileSize(this)">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Slip Gaji / Bukti Penghasilan</label>
                                            <input type="file" name="url_slip_gaji" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 transition" onchange="validateFileSize(this)">
                                        </div>
                                    </div>
                                </div>

                                <!-- Placeholder Midtrans Token (Hidden) -->
                                <input type="hidden" name="snap_token" id="snap_token" value="">

                                <div class="pt-6">
                                    <button type="submit" id="btn-submit-pengajuan" class="w-full py-4 rounded-xl bg-red-600 text-white font-black text-lg hover:bg-red-700 hover:-translate-y-0.5 transition duration-200 shadow-xl shadow-red-600/30">Kirim Pengajuan</button>
                                </div>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    @auth
        <script>
            function validateFileSize(input) {
                if (input.files && input.files[0]) {
                    if (input.files[0].size > 2 * 1024 * 1024) {
                        alert('Oops! Ukuran file terlalu besar. Maksimal ukuran file adalah 2MB.');
                        input.value = '';
                    }
                }
            }

            (function () {
                const hargaCash = {{ (float) $motor->harga_cash }};
                const dpInput = document.getElementById('input-dp');
                const tenorInput = document.getElementById('input-tenor');
                const asuransiInput = document.getElementById('input-asuransi');

                const outputAsuransi = document.getElementById('sim-asuransi');
                const outputAngsuran = document.getElementById('sim-angsuran');

                const formatRupiah = (value) => {
                    const number = Number(value) || 0;
                    return 'Rp ' + new Intl.NumberFormat('id-ID', {
                        maximumFractionDigits: 0,
                        minimumFractionDigits: 0
                    }).format(number);
                };

                const calculate = () => {
                    const dp = Number(dpInput.value) || 0;
                    const tenorOption = tenorInput.options[tenorInput.selectedIndex];
                    const asuransiOption = asuransiInput.options[asuransiInput.selectedIndex];

                    const tenor = Number(tenorOption?.dataset.tenor || 0);
                    const bungaPersen = Number(tenorOption?.dataset.bunga || 0);
                    const asuransiMarginPersen = Number(asuransiOption?.dataset.margin || 0);

                    const pokok = Math.max(hargaCash - dp, 0);
                    const biayaAsuransiPerBulan = pokok * (asuransiMarginPersen / 100);
                    const totalPembiayaan = (pokok * (1 + ((bungaPersen / 100) * (tenor / 12)))) + (biayaAsuransiPerBulan * tenor);
                    const angsuran = tenor > 0 ? (totalPembiayaan / tenor) : totalPembiayaan;

                    if (outputAsuransi) outputAsuransi.innerText = formatRupiah(biayaAsuransiPerBulan);
                    if (outputAngsuran) outputAngsuran.innerText = formatRupiah(angsuran);
                };

                dpInput?.addEventListener('input', calculate);
                tenorInput?.addEventListener('change', calculate);
                asuransiInput?.addEventListener('change', calculate);

                calculate();
            })();
        </script>
    @endauth

    <!-- Script Midtrans Sandbox (Disiapkan untuk integrasi nanti) -->
    <!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script> -->
</body>
</html>
