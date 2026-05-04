<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company['name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg-soft: #f4f6f9;
            --surface: #ffffff;
            --line: #e5e7eb;
            --text: #0f172a;
            --muted: #64748b;
            --accent: #dc2626;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: radial-gradient(1100px 380px at 8% -10%, #e2e8f0 0%, transparent 52%),
                radial-gradient(900px 320px at 95% 0%, #fee2e2 0%, transparent 48%),
                var(--bg-soft);
            color: var(--text);
        }

        .lift-card {
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .lift-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 36px -24px rgba(15, 23, 42, 0.65);
        }

        .fade-up {
            animation: fadeUp 380ms ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="text-slate-800">
    @php
        $hero = $sections->firstWhere('section_key', 'hero');
        $benefit = $sections->firstWhere('section_key', 'benefit');
        $roleSlug = auth()->user()?->role?->slug;
        $isInternalUser = in_array($roleSlug, ['admin', 'marketing', 'surveyor', 'kolektor', 'manager', 'owner'], true);
    @endphp

    <div class="min-h-screen">
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
                    <a href="#katalog" class="hover:text-red-600">Katalog</a>
                    <a href="{{ route('client.pengajuan') }}" class="hover:text-red-600">Pengajuan Kredit</a>
                    @auth
                        <a href="{{ route('client.tagihan') }}" class="hover:text-red-600">Tagihan & Cicilan</a>
                    @endauth
                </nav>

                <form method="GET" action="{{ route('landing') }}" class="flex-1">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Cari motor, merk, tipe, atau kode unit" class="w-full rounded-full border border-slate-300 bg-slate-50 pl-5 pr-24 py-3 text-sm focus:outline-none focus:border-slate-500 focus:bg-white">
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
                        <a href="{{ route('login') }}" class="h-10 px-4 inline-flex items-center justify-center rounded-xl border border-slate-300 text-slate-700 text-sm font-bold hover:bg-slate-50 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="h-10 px-4 inline-flex items-center justify-center rounded-xl bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition">Daftar</a>
                    @endauth
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 md:px-5 pb-4 overflow-x-auto">
                <div class="flex items-center gap-2 min-w-max text-sm">
                    <a href="{{ route('landing') }}" class="px-3 py-1.5 rounded-full border border-slate-300 bg-white text-slate-700">Semua Kategori</a>

                    <span class="px-3 py-1.5 rounded-full bg-red-50 text-red-700 border border-red-100 font-semibold">Jenis Cicilan & Metode Bayar</span>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 md:px-5 py-6 md:py-7">
            <section id="beranda" class="grid lg:grid-cols-[1.3fr_0.7fr] gap-4 mb-5 fade-up">
                <div class="rounded-3xl overflow-hidden border border-slate-200 bg-white relative h-full w-full min-h-[300px]">
                    @if(isset($banners) && count($banners) > 0)
                        <div class="flex transition-transform duration-700 ease-in-out h-full w-full" id="slider-track" style="transform: translateX(0%);">
                            @foreach($banners as $banner)
                            <div class="h-full relative" style="flex: 0 0 100%;">
                                <img src="{{ asset('storage/'.$banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/20 to-transparent"></div>
                                <div class="absolute left-5 md:left-8 bottom-5 md:bottom-8 right-5 text-white max-w-xl">
                                    <p class="text-xs uppercase tracking-[0.18em] text-red-400 font-bold mb-1">Pilihan Terbaik</p>
                                    <h2 class="text-2xl md:text-3xl font-extrabold leading-tight">{{ $banner->title ?? 'Kredit Motor Online Cepat dan Aman' }}</h2>
                                    <p class="mt-2 text-sm text-slate-200">{{ $banner->subtitle ?? 'Ajukan kredit motor secara online dengan simulasi cicilan yang jelas dan status pengajuan real-time.' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2">
                            @foreach($banners as $index => $banner)
                            <button class="w-2 h-2 rounded-full transition-all {{ $index === 0 ? 'bg-red-500 w-6' : 'bg-white/50' }}" onclick="goToSlide({{ $index }})"></button>
                            @endforeach
                        </div>
                        <script>
                            let currentSlide = 0;
                            const totalSlides = {{ count($banners) }};
                            const track = document.getElementById('slider-track');
                            const dots = track.nextElementSibling.querySelectorAll('button');

                            function goToSlide(index) {
                                currentSlide = index;
                                track.style.transform = `translateX(-${currentSlide * 100}%)`;
                                dots.forEach((dot, i) => {
                                    dot.className = `h-2 rounded-full transition-all ${i === currentSlide ? 'bg-red-500 w-6' : 'bg-white/50 w-2'}`;
                                });
                            }

                            setInterval(() => {
                                currentSlide = (currentSlide + 1) % totalSlides;
                                goToSlide(currentSlide);
                            }, 4000);
                        </script>
                    @else
                        <img src="https://images.unsplash.com/photo-1558981403-c5f9899a28bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" alt="Banner promo 1600x600" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 via-slate-900/10 to-transparent"></div>
                        <div class="absolute left-5 bottom-5 right-5 text-white">
                            <p class="text-xs uppercase tracking-[0.18em] text-slate-200">Data Motor</p>
                            <h2 class="mt-1 text-2xl md:text-3xl font-extrabold leading-tight">{{ $hero?->title ?? 'Katalog Motor Baru' }}</h2>
                            <p class="mt-2 text-sm text-slate-100 max-w-xl">{{ $hero?->content ?? 'Pilih motor favorit, bandingkan harga, lalu ajukan kredit online tanpa proses ribet.' }}</p>
                        </div>
                    @endif
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-1 gap-4">
                    <div class="bg-white border border-slate-200 rounded-3xl p-5 lift-card">
                        <p class="text-xs text-slate-500 uppercase tracking-[0.16em]">Unit Tersedia</p>
                        <p class="text-4xl font-extrabold text-slate-900 mt-2">{{ $featuredMotors->total() }}</p>
                        <p class="text-sm text-slate-600 mt-2">Tersinkron dari database katalog.</p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-3xl p-5 lift-card">
                        <p class="text-xs text-slate-500 uppercase tracking-[0.16em]">Keunggulan</p>
                        <p class="text-lg font-bold text-slate-900 mt-2">{{ $benefit?->title ?? 'Proses cepat dan transparan' }}</p>
                        <p class="text-sm text-slate-600 mt-2">Approval lebih jelas, cicilan mudah dipantau.</p>
                    </div>
                </div>
            </section>

            <div class="grid lg:grid-cols-[280px_1fr] gap-5">
                <aside class="bg-white border border-slate-200 rounded-3xl p-5 h-fit sticky top-[144px] fade-up">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="text-lg font-extrabold text-slate-900">Filter Motor</h3>
                        <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-600">Live</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">Sesuaikan tipe, rentang harga, dan urutan data.</p>

                    <form method="GET" action="{{ route('landing') }}" class="mt-5 space-y-6">
                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3">Harga OTR</h4>
                            <div class="space-y-2 text-sm">
                                <label class="flex items-center gap-2 text-slate-700"><input type="radio" name="harga" value="" {{ $filters['harga'] === null || $filters['harga'] === '' ? 'checked' : '' }} class="border-slate-300 text-red-600 focus:ring-red-500"> Semua Harga</label>
                                <label class="flex items-center gap-2 text-slate-700"><input type="radio" name="harga" value="1" {{ $filters['harga'] === '1' ? 'checked' : '' }} class="border-slate-300 text-red-600 focus:ring-red-500"> Di bawah 20 jt</label>
                                <label class="flex items-center gap-2 text-slate-700"><input type="radio" name="harga" value="2" {{ $filters['harga'] === '2' ? 'checked' : '' }} class="border-slate-300 text-red-600 focus:ring-red-500"> 20 jt - 30 jt</label>
                                <label class="flex items-center gap-2 text-slate-700"><input type="radio" name="harga" value="3" {{ $filters['harga'] === '3' ? 'checked' : '' }} class="border-slate-300 text-red-600 focus:ring-red-500"> 30 jt - 40 jt</label>
                                <label class="flex items-center gap-2 text-slate-700"><input type="radio" name="harga" value="4" {{ $filters['harga'] === '4' ? 'checked' : '' }} class="border-slate-300 text-red-600 focus:ring-red-500"> Di atas 40 jt</label>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3">Urutkan</h4>
                            <select name="sort" class="w-full rounded-xl border border-slate-300 text-sm focus:border-slate-500 focus:ring-0">
                                <option value="terbaru" {{ $filters['sort'] === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="nama_asc" {{ $filters['sort'] === 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="harga_asc" {{ $filters['sort'] === 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="harga_desc" {{ $filters['sort'] === 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </div>

                        <input type="hidden" name="q" value="{{ $filters['q'] }}">

                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white font-semibold">Terapkan</button>
                            <a href="{{ route('landing') }}" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-center text-slate-700 font-semibold">Reset</a>
                        </div>
                    </form>

                </aside>

                <section id="katalog" class="fade-up" style="animation-delay: 80ms;">
                    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-3 mb-4">
                        @foreach($priceInsights as $insight)
                            <a href="{{ route('landing', array_merge(request()->except('page'), ['harga' => $insight['key']])) }}" class="bg-white border border-slate-200 rounded-2xl p-3 hover:border-slate-300 transition">
                                <p class="text-xs text-slate-500 uppercase tracking-[0.15em]">Range Harga</p>
                                <p class="text-sm font-bold text-slate-900 mt-1">{{ $insight['label'] }}</p>
                                <p class="text-xs text-slate-600 mt-1">{{ $insight['count'] }} motor</p>
                                <p class="text-xs text-slate-500 mt-2 line-clamp-2">{{ !empty($insight['names']) ? implode(', ', $insight['names']) : 'Belum ada motor pada range ini.' }}</p>
                            </a>
                        @endforeach
                    </div>

                    <div class="bg-white border border-slate-200 rounded-3xl p-4 md:p-5 mb-4 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900">Daftar Motor</h3>
                            <p class="text-sm text-slate-500 mt-1">{{ $featuredMotors->total() }} unit ditemukan dengan tampilan katalog modern.</p>
                            @if($selectedPriceLabel)
                                <p class="text-sm text-slate-700 mt-2">Motor {{ strtolower($selectedPriceLabel) }}: {{ !empty($filteredMotorNames) ? implode(', ', $filteredMotorNames) : 'tidak ada data.' }}</p>
                            @endif
                        </div>
                        <div class="text-sm text-slate-600 bg-slate-50 border border-slate-200 px-3 py-2 rounded-xl">{{ $benefit?->title ?? 'Data dinamis dari database' }}</div>
                    </div>

                    <div id="simulasi" class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        @forelse($featuredMotors as $motor)
                            <article class="bg-white border border-slate-200 rounded-3xl overflow-hidden lift-card">
                                <div class="relative border-b border-slate-200">
                                    <img src="{{ $motor->foto1 ? asset('storage/'.$motor->foto1) : asset('images/placeholders/card-1200x700.svg') }}" alt="{{ $motor->nama_motor }}" class="w-full h-48 object-cover">
                                    <div class="absolute top-3 left-3 flex gap-2 text-[11px] font-semibold">
                                        <span class="px-2 py-1 rounded-full bg-white/95 text-slate-700 border border-slate-200">Ready Stock</span>
                                        <span class="px-2 py-1 rounded-full bg-red-600 text-white">DP Ringan</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="text-2xl font-extrabold text-slate-900 mt-1 leading-tight">{{ $motor->nama_motor }}</h4>
                                    <p class="text-sm text-slate-500 mt-1">{{ $motor->kode_motor }} | {{ $motor->warna }}</p>

                                    <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                                        <p class="text-xs text-slate-500">OTR mulai dari</p>
                                        <p class="text-3xl font-black text-slate-900 mt-1">Rp {{ number_format((float) $motor->harga_cash, 0, ',', '.') }}</p>
                                        <p class="text-sm text-slate-600 mt-1">DP mulai Rp {{ number_format((float) $motor->dp_minimum, 0, ',', '.') }}</p>
                                    </div>

                                    <div class="mt-4 w-full">
                                        <a href="{{ route('pengajuan.form', $motor) }}" class="flex w-full items-center justify-center text-center py-4 rounded-2xl bg-red-600 text-white text-base font-extrabold shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all duration-300">
                                            Ajukan Kredit
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-full bg-white border border-slate-200 rounded-3xl p-10 text-center">
                                <p class="text-slate-700 font-semibold">Data motor tidak ditemukan sesuai filter.</p>
                                <p class="text-slate-500 text-sm mt-1">Coba ubah kata kunci atau rentang harga yang dipilih.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($featuredMotors->hasPages())
                        <div class="mt-6 bg-white border border-slate-200 rounded-3xl p-4">
                            {{ $featuredMotors->links() }}
                        </div>
                    @endif

                </section>
            </div>
        </main>

        <footer class="border-t border-slate-200 bg-white mt-8">
            <div class="max-w-7xl mx-auto px-4 md:px-5 py-8 text-sm text-slate-500 flex flex-col md:flex-row gap-3 items-center justify-between">
                <p>Copyright {{ date('Y') }} {{ $company['name'] }}</p>
                <p>Tampilan katalog dinamis gaya marketplace</p>
            </div>
        </footer>
    </div>
</body>
</html>
