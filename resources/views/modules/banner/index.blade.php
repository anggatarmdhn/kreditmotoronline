@extends('layouts.admin')

@section('title', 'Banner Landing Page')
@section('page-title', 'Banner Landing Page')
@section('page-subtitle', 'Kelola gambar slideshow di halaman depan')

@section('content')
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="font-extrabold text-slate-800 text-lg">Daftar Banner</h3>
            <p class="text-xs text-slate-500 mt-1">Banner yang aktif akan tampil bergantian di halaman depan.</p>
        </div>
        <a href="{{ route('banner.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition">
            + Tambah Banner Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($banners as $banner)
        <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm relative group">
            <img src="{{ asset('storage/'.$banner->image_path) }}" class="w-full h-40 object-cover" alt="Banner">
            <div class="p-4">
                <div class="font-bold text-sm text-slate-800 mb-1">{{ $banner->title ?? 'Tanpa Judul' }}</div>
                <div class="text-xs text-slate-500 line-clamp-2 mb-3">{{ $banner->subtitle ?? 'Tidak ada deskripsi' }}</div>
                
                <div class="flex justify-between items-center border-t border-slate-100 pt-3">
                    <span class="text-xs font-bold {{ $banner->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                        {{ $banner->is_active ? '✅ Tayang' : 'Draft' }}
                    </span>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('banner.edit', $banner) }}" class="text-xs text-blue-600 font-bold hover:text-blue-800">Edit</a>
                        <form action="{{ route('banner.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 font-bold hover:text-red-800">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-10 text-slate-500 text-sm">
            Belum ada banner yang diunggah.
        </div>
        @endforelse
    </div>
</div>
@endsection
