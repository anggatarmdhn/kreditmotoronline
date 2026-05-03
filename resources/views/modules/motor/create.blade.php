@extends('layouts.admin')

@section('title', 'Tambah Motor Baru')
@section('page-title', 'Tambah Motor')
@section('page-subtitle', 'Tambahkan produk motor baru ke dalam katalog')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6">
        <form action="{{ route('motor.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kode Motor</label>
                    <input type="text" name="kode_motor" value="{{ old('kode_motor') }}" required class="w-full text-sm rounded-xl border border-slate-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 py-2.5 px-3">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Motor</label>
                    <input type="text" name="nama_motor" value="{{ old('nama_motor') }}" required class="w-full text-sm rounded-xl border border-slate-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 py-2.5 px-3">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori / Jenis</label>
                    <select name="id_jenis" required class="w-full text-sm rounded-xl border border-slate-300 focus:border-red-500 py-2.5 px-3">
                        @foreach($jenisMotors as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->merk }} - {{ $jenis->jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Tahun Produksi</label>
                    <input type="number" name="tahun_produksi" value="{{ old('tahun_produksi', date('Y')) }}" required class="w-full text-sm rounded-xl border border-slate-300 focus:border-red-500 py-2.5 px-3">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Harga OTR (Rp)</label>
                    <input type="number" name="harga_cash" value="{{ old('harga_cash') }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">DP Minimum (Rp)</label>
                    <input type="number" name="dp_minimum" value="{{ old('dp_minimum') }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Stok Unit</label>
                    <input type="number" name="stok" value="{{ old('stok', 1) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kapasitas Mesin (cc)</label>
                    <input type="text" name="kapasitas_mesin" value="{{ old('kapasitas_mesin') }}" required placeholder="Contoh: 150cc" class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Warna</label>
                    <input type="text" name="warna" value="{{ old('warna') }}" required placeholder="Contoh: Merah, Hitam" class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Spesifikasi</label>
                <textarea name="deskripsi_motor" rows="4" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3">{{ old('deskripsi_motor') }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-5 border-t border-slate-100 pt-5 mt-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto 1 (Utama)</label>
                    <input type="file" name="foto1" accept="image/*" class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-slate-100 file:font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto 2</label>
                    <input type="file" name="foto2" accept="image/*" class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-slate-100 file:font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto 3</label>
                    <input type="file" name="foto3" accept="image/*" class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-slate-100 file:font-bold">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-emerald-500 focus:ring-emerald-500 w-5 h-5">
                    <span class="text-sm font-bold text-slate-800">Tayangkan di Katalog</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('motor.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700">Simpan Motor</button>
            </div>
        </form>
    </div>
</div>
@endsection
