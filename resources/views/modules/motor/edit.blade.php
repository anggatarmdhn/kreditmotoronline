@extends('layouts.admin')

@section('title', 'Edit Motor')
@section('page-title', 'Edit Motor')
@section('page-subtitle', 'Perbarui data spesifikasi dan foto motor')

@section('content')
<div>
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6">
        <form action="{{ route('motor.update', $motor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Kode Motor</label>
                    <input type="text" name="kode_motor" value="{{ old('kode_motor', $motor->kode_motor) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Nama Motor</label>
                    <input type="text" name="nama_motor" value="{{ old('nama_motor', $motor->nama_motor) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Kategori / Jenis</label>
                    <select name="id_jenis" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                        @foreach($jenisMotors as $jenis)
                            <option value="{{ $jenis->id }}" {{ $motor->id_jenis == $jenis->id ? 'selected' : '' }}>{{ $jenis->merk }} - {{ $jenis->jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Tahun Produksi</label>
                    <input type="number" name="tahun_produksi" value="{{ old('tahun_produksi', $motor->tahun_produksi) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Harga OTR (Rp)</label>
                    <input type="number" name="harga_cash" value="{{ old('harga_cash', (int)$motor->harga_cash) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">DP Minimum (Rp)</label>
                    <input type="number" name="dp_minimum" value="{{ old('dp_minimum', (int)$motor->dp_minimum) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Stok Unit</label>
                    <input type="number" name="stok" value="{{ old('stok', $motor->stok) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Kapasitas Mesin (cc)</label>
                    <input type="text" name="kapasitas_mesin" value="{{ old('kapasitas_mesin', $motor->kapasitas_mesin) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Warna</label>
                    <input type="text" name="warna" value="{{ old('warna', $motor->warna) }}" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Deskripsi / Spesifikasi</label>
                <textarea name="deskripsi_motor" rows="4" required class="w-full text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all">{{ old('deskripsi_motor', $motor->deskripsi_motor) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 border-t border-slate-100 pt-5 mt-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Foto 1</label>
                    @if($motor->foto1) <img src="{{ asset('storage/'.$motor->foto1) }}" class="h-16 rounded mb-2 object-cover"> @endif
                    <input type="file" name="foto1" accept="image/*" class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-slate-100 file:font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Foto 2</label>
                    @if($motor->foto2) <img src="{{ asset('storage/'.$motor->foto2) }}" class="h-16 rounded mb-2 object-cover"> @endif
                    <input type="file" name="foto2" accept="image/*" class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-slate-100 file:font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Foto 3</label>
                    @if($motor->foto3) <img src="{{ asset('storage/'.$motor->foto3) }}" class="h-16 rounded mb-2 object-cover"> @endif
                    <input type="file" name="foto3" accept="image/*" class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-slate-100 file:font-bold">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $motor->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-500 focus:ring-emerald-500 w-5 h-5">
                    <span class="text-sm font-bold text-slate-800">Tayangkan di Katalog</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('motor.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-8 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 shadow-lg shadow-red-200 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
