@extends('layouts.admin')

@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner')
@section('page-subtitle', 'Ubah informasi atau gambar banner')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6">
        <form action="{{ route('banner.update', $banner) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul (Opsional)</label>
                <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="w-full text-sm rounded-xl border border-slate-300 px-3 py-2.5 focus:border-red-500">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat (Opsional)</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="w-full text-sm rounded-xl border border-slate-300 px-3 py-2.5 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Gambar Saat Ini</label>
                <img src="{{ asset('storage/'.$banner->image_path) }}" class="rounded-xl border border-slate-200 mb-3" style="max-height: 250px; width: auto; max-width: 100%;" alt="Banner Saat Ini">
                
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Ganti Gambar Banner (Biarkan kosong jika tidak ingin ganti, Max 5MB)</label>
                <input type="file" name="image" accept="image/*" class="w-full text-xs file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-slate-100 file:font-bold">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Urutan (Sort Order)</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" class="w-full text-sm rounded-xl border border-slate-300 px-3 py-2.5">
                </div>
                <div class="flex items-end pb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} class="rounded text-emerald-500 border-slate-300">
                        <span class="text-sm font-bold text-slate-700">Tampilkan Banner</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('banner.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
