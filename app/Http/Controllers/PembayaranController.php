<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\MetodeBayar;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    public function index(Request $request): View
    {
        $tab    = $request->input('tab', 'hari_ini');
        $search = trim((string) $request->input('q', ''));

        $today    = Carbon::today();
        $baseQuery = Angsuran::with([
            'kredit.pengajuanKredit.pelanggan',
            'kredit.pengajuanKredit.motor',
            'metodeBayar',
        ])->whereHas('kredit');

        if ($search !== '') {
            $baseQuery->whereHas('kredit.pengajuanKredit', function ($sub) use ($search) {
                $sub->where('kode_pengajuan', 'like', '%'.$search.'%')
                    ->orWhereHas('pelanggan', fn ($p) => $p->where('nama_pelanggan', 'like', '%'.$search.'%'));
            });
        }

        $query = clone $baseQuery;

        match ($tab) {
            'tunggak'   => $query->whereNotIn('status', ['lunas'])->where('jatuh_tempo', '<', $today),
            'hari_ini'  => $query->whereNotIn('status', ['lunas'])->whereDate('jatuh_tempo', $today),
            'minggu_ini'=> $query->whereNotIn('status', ['lunas'])
                                  ->whereBetween('jatuh_tempo', [$today, $today->copy()->addDays(7)]),
            'lunas'     => $query->where('status', 'lunas'),
            default     => $query->whereNotIn('status', ['lunas']),
        };

        // Stats untuk counter tab
        $countTunggak  = (clone $baseQuery)->whereNotIn('status',['lunas'])->where('jatuh_tempo', '<', $today)->count();
        $countHariIni  = (clone $baseQuery)->whereNotIn('status',['lunas'])->whereDate('jatuh_tempo', $today)->count();
        $countMingguIni= (clone $baseQuery)->whereNotIn('status',['lunas'])->whereBetween('jatuh_tempo', [$today, $today->copy()->addDays(7)])->count();
        $countBelum    = (clone $baseQuery)->whereNotIn('status',['lunas'])->count();
        $countLunas    = (clone $baseQuery)->where('status','lunas')->count();

        return view('modules.pembayaran.index', [
            'angsuranRows' => $query->orderBy('jatuh_tempo')->paginate(15)->withQueryString(),
            'metodeBayars' => MetodeBayar::where('is_active', true)->orderBy('nama')->get(),
            'tab'          => $tab,
            'search'       => $search,
            'counts'       => compact('countTunggak','countHariIni','countMingguIni','countBelum','countLunas'),
        ]);
    }

    public function store(Request $request, Angsuran $angsuran): RedirectResponse
    {
        if ($angsuran->status === 'lunas') {
            return back()->with('error', 'Angsuran ini sudah lunas.');
        }

        $sisaTagihan = max((float) $angsuran->jumlah_tagihan - (float) $angsuran->jumlah_bayar, 0);

        $validated = $request->validate([
            'metode_bayar_id' => ['required', 'exists:metode_bayars,id'],
            'tanggal_bayar'   => ['required', 'date'],
            'jumlah_bayar'    => ['required', 'numeric', 'min:1', 'max:'.$sisaTagihan],
            'keterangan'      => ['nullable', 'string', 'max:300'],
        ]);

        $totalBayar = (float) $angsuran->jumlah_bayar + (float) $validated['jumlah_bayar'];
        $isPastDue  = $angsuran->jatuh_tempo && now()->startOfDay()->gt($angsuran->jatuh_tempo);

        $angsuran->update([
            'jumlah_bayar'    => $totalBayar,
            'tanggal_bayar'   => $validated['tanggal_bayar'],
            'metode_bayar_id' => (int) $validated['metode_bayar_id'],
            'status'          => round($totalBayar) >= round((float)$angsuran->jumlah_tagihan) ? 'lunas' : ($isPastDue ? 'tunggak' : 'belum_bayar'),
            'keterangan'      => $validated['keterangan'] ?? null,
        ]);

        // Kurangi sisa kredit jika lunas
        if (round($totalBayar) >= round((float)$angsuran->jumlah_tagihan)) {
            $angsuran->kredit?->decrement('sisa_kredit', $angsuran->jumlah_tagihan);
        }

        return back()->with('success', 'Pembayaran angsuran ke-'.$angsuran->angsuran_ke.' berhasil dicatat.');
    }
}
