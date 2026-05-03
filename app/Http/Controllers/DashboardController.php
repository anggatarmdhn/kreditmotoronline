<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;

use App\Models\Kredit;
use App\Models\Motor;
use App\Models\Pelanggan;
use App\Models\PengajuanKredit;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Hitung angsuran yang sudah lewat jatuh tempo tapi belum bayar
        $angsuranTunggak = Angsuran::where('status', '!=', 'lunas')
            ->where('jatuh_tempo', '<', now()->toDateString())
            ->count();

        $user = auth()->user();

        // Pengajuan yang DP-nya sudah dibayar tapi kredit belum diaktifkan
        $menungguAktivasi = PengajuanKredit::with(['pelanggan', 'motor', 'kredit'])
            ->where('dp_paid', true)
            ->where('status', 'Diproses')
            ->latest('dp_paid_at')
            ->get();

        return view('dashboard', [
            'stats' => [
                'pelanggan'           => Pelanggan::count(),
                'motor_aktif'         => Motor::where('is_active', true)->count(),
                'pengajuan_menunggu'  => PengajuanKredit::where('status', 'Menunggu Konfirmasi')->count(),
                'angsuran_tunggak'    => $angsuranTunggak,
                'kredit_berjalan'     => Kredit::where('status_kredit', 'Dicicil')->count(),
                'total_pengajuan'     => PengajuanKredit::count(),
            ],
            'menungguAktivasi' => $menungguAktivasi,
            'pengajuanTerbaru' => PengajuanKredit::with(['pelanggan', 'motor'])
                ->latest()
                ->take(7)
                ->get(),
            // Angsuran terbaru untuk monitoring admin
            'angsuranMonitor' => Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor'])
                ->orderByRaw("CASE WHEN status != 'lunas' AND jatuh_tempo < ? THEN 0 ELSE 1 END", [now()->toDateString()])
                ->orderBy('jatuh_tempo')
                ->take(10)
                ->get(),
        ]);
    }

    public function monitoring(): View
    {
        // Manager dashboard logic: graphs, performance, top selling products, delayed payments (kredit macet)
        $totalPenjualan = \App\Models\Kredit::count();
        $pendapatanAngsuran = \App\Models\Angsuran::sum('jumlah_bayar');
        $pendapatanDP = PengajuanKredit::where('dp_paid', true)->sum('dp');
        $totalPendapatan = $pendapatanAngsuran + $pendapatanDP;
        
        // Produk paling laku
        $motorTerlaris = \App\Models\Motor::withCount(['pengajuanKredits' => function ($q) {
            $q->has('kredit');
        }])->orderByDesc('pengajuan_kredits_count')->take(5)->get();

        // Perform per bulan (6 bulan terakhir)
        $penjualanBulanan = [];
        $pendapatanBulanan = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');
            $penjualanBulanan[] = \App\Models\Kredit::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
            
            $angsuranBulanIni = \App\Models\Angsuran::whereMonth('tanggal_bayar', $date->month)->whereYear('tanggal_bayar', $date->year)->sum('jumlah_bayar');
            $dpBulanIni = PengajuanKredit::where('dp_paid', true)->whereMonth('dp_paid_at', $date->month)->whereYear('dp_paid_at', $date->year)->sum('dp');
            
            $pendapatanBulanan[] = $angsuranBulanIni + $dpBulanIni;
        }

        // Kredit Macet (lebih dari 3 bulan tidak bayar)
        $kreditMacet = \App\Models\Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor'])
            ->whereHas('angsurans', function ($q) {
                $q->where('status', '!=', 'lunas')->where('jatuh_tempo', '<', now()->subMonths(3)->toDateString());
            })->get();

        // Telat Bayar (tunggakan umum)
        $telatBayar = \App\Models\Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor'])
            ->where('status', '!=', 'lunas')
            ->where('jatuh_tempo', '<', now()->toDateString())
            ->orderBy('jatuh_tempo')
            ->take(10)->get();

        return view('manager.dashboard', compact(
            'totalPenjualan', 'totalPendapatan', 'motorTerlaris', 
            'penjualanBulanan', 'pendapatanBulanan', 'labels', 
            'kreditMacet', 'telatBayar'
        ));
    }
}
