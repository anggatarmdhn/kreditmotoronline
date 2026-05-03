<?php

namespace App\Http\Controllers;

use App\Models\Kredit;
use App\Models\PengajuanKredit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ManajemenKreditController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'all');
        $search = trim((string) $request->input('q', ''));

        $query = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor', 'angsurans'])
            ->latest();

        if (in_array($status, ['Dicicil', 'Lunas', 'Macet'], true)) {
            $query->where('status_kredit', $status);
        }

        if ($search !== '') {
            $query->whereHas('pengajuanKredit', function ($sub) use ($search) {
                $sub->where('kode_pengajuan', 'like', '%'.$search.'%')
                    ->orWhereHas('pelanggan', fn ($p) => $p->where('nama_pelanggan', 'like', '%'.$search.'%'))
                    ->orWhereHas('motor', fn ($m) => $m->where('nama_motor', 'like', '%'.$search.'%'));
            });
        }

        return view('modules.kredit.index', [
            'kredits'      => $query->paginate(10)->withQueryString(),
            'statusFilter' => $status,
            'search'       => $search,
            'stats'        => [
                'total'    => Kredit::count(),
                'dicicil'  => Kredit::where('status_kredit', 'Dicicil')->count(),
                'lunas'    => Kredit::where('status_kredit', 'Lunas')->count(),
            ],
        ]);
    }

    public function show(Kredit $kredit): View
    {
        $kredit->load(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor', 'angsurans']);
        return view('modules.kredit.show', compact('kredit'));
    }

    /**
     * Admin aktivasi kredit setelah DP terbayar — set status_kredit = 'Dicicil'
     */
    public function aktivasi(PengajuanKredit $pengajuan): RedirectResponse
    {
        if (!$pengajuan->dp_paid) {
            return back()->with('error', 'DP belum dibayar oleh pelanggan.');
        }

        $kredit = $pengajuan->kredit;

        if (!$kredit) {
            return back()->with('error', 'Data kredit belum digenerate. Pastikan status sudah "Diterima".');
        }

        $kredit->update([
            'status_kredit'            => 'Dicicil',
            'tgl_mulai_kredit'         => now()->toDateString(),
        ]);

        // Update pengajuan jadi "Aktif"
        $pengajuan->update(['status' => 'Aktif']);

        return back()->with('success', 'Kredit untuk ' . ($pengajuan->pelanggan->nama_pelanggan ?? 'pelanggan') . ' berhasil diaktifkan. Cicilan bulanan sudah berjalan.');
    }
}
