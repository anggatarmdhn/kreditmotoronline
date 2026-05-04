@extends('layouts.admin')

@section('title', 'Katalog Motor')
@section('page-title', 'Data Motor')
@section('page-subtitle', 'Kelola daftar produk motor yang tersedia di katalog')

@section('content')

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center">
        <div>
            <h3 class="font-extrabold text-slate-800 text-lg">Daftar Motor</h3>
            <p class="text-xs text-slate-500 mt-1">Total {{ $motors->total() }} produk motor terdaftar.</p>
        </div>
        <a href="{{ route('motor.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition">
            + Tambah Motor Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Kode/Unit</th>
                    <th class="px-6 py-4">Harga OTR</th>
                    <th class="px-6 py-4">Stok</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($motors as $motor)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $motor->nama_motor }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ $motor->kode_motor }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">Rp {{ number_format($motor->harga_cash, 0, ',', '.') }}</div>
                        <div class="text-xs text-slate-500 mt-1">DP Min: Rp {{ number_format($motor->dp_minimum, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold {{ $motor->stok > 0 ? 'text-emerald-600' : 'text-red-500' }}">{{ $motor->stok }} Unit</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($motor->is_active)
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold border border-emerald-200">Aktif</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('motor.edit', $motor) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs bg-blue-50 px-3 py-1.5 rounded-lg">Edit</a>
                            <form action="{{ route('motor.destroy', $motor) }}" method="POST" class="inline" onsubmit="return confirm('Hapus motor ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs bg-red-50 px-3 py-1.5 rounded-lg">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        Belum ada data motor di sistem.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($motors->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $motors->links() }}
    </div>
    @endif
</div>

@endsection
