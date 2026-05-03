<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\PengajuanKredit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ManajemenPengajuanController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'all');
        $search = trim((string) $request->input('q', ''));

        $query = PengajuanKredit::query()
            ->with(['pelanggan', 'motor', 'jenisCicilan', 'asuransi', 'marketing', 'approver'])
            ->latest();

        if (in_array($status, ['Menunggu Konfirmasi', 'Diproses', 'Diterima', 'Dibatalkan Penjual', 'Dibatalkan Pembeli'], true)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('kode_pengajuan', 'like', '%'.$search.'%')
                    ->orWhereHas('pelanggan', function ($sub) use ($search) {
                        $sub->where('nama', 'like', '%'.$search.'%')
                            ->orWhere('nik', 'like', '%'.$search.'%')
                            ->orWhere('telepon', 'like', '%'.$search.'%');
                    })
                    ->orWhereHas('motor', function ($sub) use ($search) {
                        $sub->where('nama_motor', 'like', '%'.$search.'%')
                            ->orWhere('kode_motor', 'like', '%'.$search.'%');
                    });
            });
        }

        return view('modules.pengajuan.index', [
            'rows' => $query->paginate(10)->withQueryString(),
            'statusFilter' => $status,
            'search' => $search,
        ]);
    }

    public function show(PengajuanKredit $pengajuan): View
    {
        $pengajuan->load(['pelanggan', 'motor', 'jenisCicilan', 'asuransi', 'marketing', 'approver', 'kredit.angsurans']);
        return view('modules.pengajuan.show', compact('pengajuan'));
    }

    public function updateStatus(Request $request, PengajuanKredit $pengajuan): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Diproses,Diterima,Dibatalkan Penjual,Dibatalkan Pembeli'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($pengajuan->status !== 'Menunggu Konfirmasi' && $pengajuan->status !== 'Diproses') {
            return back()->with('error', 'Pengajuan ini sudah diproses atau tidak dapat diubah statusnya lagi.');
        }

        DB::transaction(function () use ($validated, $pengajuan): void {
            $catatanBaru = trim((string) ($validated['catatan'] ?? ''));
            $catatanFinal = trim(collect([
                $pengajuan->catatan,
                $catatanBaru !== '' ? 'Catatan verifikasi: '.$catatanBaru : null,
            ])->filter()->implode(' | '));

            $pengajuan->update([
                'status' => $validated['status'],
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'catatan' => $catatanFinal !== '' ? $catatanFinal : null,
            ]);

            if ($validated['status'] === 'Diterima') {
                $this->generateInstallments($pengajuan);
            }
        });

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    private function generateInstallments(PengajuanKredit $pengajuan): void
    {
        $kredit = \App\Models\Kredit::firstOrCreate(
            ['id_pengajuan_kredit' => $pengajuan->id],
            [
                'tgl_mulai_kredit' => now()->toDateString(),
                'sisa_kredit' => $pengajuan->total_pembiayaan,
                'status_kredit' => 'Dicicil'
            ]
        );

        $kredit->loadMissing('angsurans');

        if ($kredit->angsurans()->exists()) {
            return;
        }

        $tanggalPengajuan = $pengajuan->tanggal_pengajuan ?? now()->toDateString();
        $tanggalJatuhTempoAwal = Carbon::parse($tanggalPengajuan)->addMonthNoOverflow();

        $rows = [];
        for ($i = 1; $i <= (int) $pengajuan->tenor_bulan; $i++) {
            $rows[] = [
                'id_kredit' => $kredit->id,
                'angsuran_ke' => $i,
                'jatuh_tempo' => $tanggalJatuhTempoAwal->copy()->addMonthsNoOverflow($i - 1)->toDateString(),
                'jumlah_tagihan' => $pengajuan->angsuran_per_bulan,
                'jumlah_bayar' => 0,
                'tanggal_bayar' => null,
                'metode_bayar_id' => null,
                'status' => 'belum_bayar',
                'bukti_bayar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Angsuran::query()->insert($rows);
    }

    public function destroy(PengajuanKredit $pengajuan): RedirectResponse
    {
        // Hapus kredit dan angsurannya terlebih dahulu jika ada
        if ($pengajuan->kredit) {
            $pengajuan->kredit->angsurans()->delete();
            $pengajuan->kredit->delete();
        }

        $pengajuan->delete();

        return back()->with('success', 'Pengajuan "' . $pengajuan->kode_pengajuan . '" berhasil dihapus.');
    }
}
