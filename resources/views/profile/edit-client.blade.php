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
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya – {{ $company['name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Sora', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="text-slate-800">
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
            </nav>

            <form method="GET" action="{{ route('landing') }}" class="flex-1">
                <div class="relative">
                    <input type="text" name="q" placeholder="Cari motor, merk, tipe, atau kode unit" class="w-full rounded-full border border-slate-300 bg-slate-50 pl-5 pr-24 py-3 text-sm focus:outline-none focus:border-slate-500 focus:bg-white">
                    <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 px-4 py-2 rounded-full bg-slate-900 text-white text-xs font-semibold">Cari</button>
                </div>
            </form>

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

    <main class="max-w-4xl mx-auto px-4 md:px-5 py-12">
        <div class="mb-10 text-center md:text-left">
            <h2 class="text-3xl font-extrabold text-slate-900">Pengaturan Akun</h2>
            <p class="text-slate-500 mt-2">Kelola informasi profil dan kata sandi Anda di sini.</p>
        </div>

        <div class="space-y-6">
            <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] rounded-3xl">
                <div class="max-w-xl mx-auto md:mx-0">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] rounded-3xl">
                <div class="max-w-xl mx-auto md:mx-0">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-red-50 border border-red-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] rounded-3xl">
                <div class="max-w-xl mx-auto md:mx-0">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>
</body>
</html>
