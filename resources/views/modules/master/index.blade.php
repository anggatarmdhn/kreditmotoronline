@extends('layouts.admin')

@section('title', 'Master Data')
@section('page-title', 'Setting Master Data')
@section('page-subtitle', 'Kelola data referensi sistem kredit motor')

@section('content')

<div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:32px;text-align:center;">
    <div style="font-size:48px;margin-bottom:12px;">⚙️</div>
    <h2 style="font-size:20px;font-weight:800;color:#0f172a;margin:0 0 8px;">Modul Master Data</h2>
    <p style="font-size:13px;color:#64748b;margin:0;">
        Halaman ini siap dikembangkan untuk mengelola data referensi:<br>
        Jenis Motor, Jenis Cicilan, Metode Bayar, Asuransi, dan Data Pengguna.
    </p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-top:28px;text-align:left;">
        @php
            $modules = [
                ['icon'=>'🏍️', 'label'=>'Jenis Motor',    'desc'=>'Kelola merk & jenis'],
                ['icon'=>'📅', 'label'=>'Jenis Cicilan',  'desc'=>'Tenor & bunga'],
                ['icon'=>'💳', 'label'=>'Metode Bayar',   'desc'=>'Transfer, Cash, VA'],
                ['icon'=>'🛡️', 'label'=>'Asuransi',       'desc'=>'Produk & margin'],
                ['icon'=>'👥', 'label'=>'Data Pengguna',  'desc'=>'Staff internal'],
            ];
        @endphp
        @foreach($modules as $mod)
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:11px;padding:16px;">
            <div style="font-size:22px;margin-bottom:8px;">{{ $mod['icon'] }}</div>
            <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ $mod['label'] }}</div>
            <div style="font-size:11px;color:#94a3b8;margin-top:3px;">{{ $mod['desc'] }}</div>
        </div>
        @endforeach
    </div>
</div>

@endsection
