<?php

namespace App\Http\Controllers;

use App\Models\Asuransi;
use App\Models\JenisCicilan;
use App\Models\Motor;
use App\Models\Pelanggan;
use App\Models\PengajuanKredit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PengajuanKreditController extends Controller
{
    public function show(Motor $motor): View
    {
        abort_unless($motor->is_active, 404);

        $jenisCicilans = JenisCicilan::query()
            ->where('is_active', true)
            ->orderBy('tenor_bulan')
            ->get();

        $asuransis = Asuransi::query()
            ->where('is_active', true)
            ->orderBy('nama_asuransi')
            ->get();

        $defaultJenisCicilan = $jenisCicilans->first();
        $defaultAsuransi = $asuransis->first();

        $simulasi = $this->calculateSimulasi(
            hargaCash: (float) $motor->harga_cash,
            dp: (float) $motor->dp_minimum,
            tenorBulan: (int) ($defaultJenisCicilan?->tenor_bulan ?? 12),
            bungaPersen: (float) ($defaultJenisCicilan?->bunga_persen ?? 0),
            asuransiMarginPersen: (float) ($defaultAsuransi?->margin_persen ?? 0)
        );

        return view('landing.ajukan', [
            'motor' => $motor,
            'jenisCicilans' => $jenisCicilans,
            'asuransis' => $asuransis,
            'simulasiDefault' => $simulasi,
        ]);
    }

    public function store(Request $request, Motor $motor): RedirectResponse
    {
        abort_unless($motor->is_active, 404);

        $validated = $request->validate([
            'nama_pelanggan' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_telp' => ['required', 'string', 'max:15'],
            'kota1' => ['required', 'string', 'max:255'],
            'alamat1' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'penghasilan_bulanan' => ['required', 'numeric', 'min:0'],
            'jenis_cicilan_id' => ['required', 'exists:jenis_cicilans,id'],
            'asuransi_id' => ['nullable', 'exists:asuransis,id'],
            'dp' => ['required', 'numeric', 'min:'.$motor->dp_minimum],
            'kode_referral' => ['nullable', 'string', 'max:50'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'url_ktp' => ['required', 'image', 'max:2048'],
            'url_kk' => ['required', 'image', 'max:2048'],
            'url_slip_gaji' => ['nullable', 'image', 'max:2048'],
            'url_foto' => ['nullable', 'image', 'max:2048'],
        ], [
            'dp.min' => 'DP minimal untuk motor ini adalah Rp '.number_format((float) $motor->dp_minimum, 0, ',', '.').'.',
        ]);

        $nik = $this->generateNikFromPhone($validated['no_telp']);
        $pekerjaan = $validated['pekerjaan'];
        $penghasilanBulanan = (float) $validated['penghasilan_bulanan'];
        $statusPernikahan = 'lajang';

        $catatan = trim(collect([
            $validated['catatan'] ?? null,
            ! empty($validated['kode_referral']) ? 'Kode referral: '.$validated['kode_referral'] : null,
        ])->filter()->implode(' | '));

        $jenisCicilan = JenisCicilan::query()->findOrFail((int) $validated['jenis_cicilan_id']);

        $hargaCash = (float) $motor->harga_cash;
        $dpInput = (float) $validated['dp'];

        if ($dpInput >= $hargaCash) {
            return back()->withErrors(['dp' => 'DP harus lebih kecil dari harga OTR.'])->withInput();
        }

        $dp = $dpInput;

        $pokokHutang = $hargaCash - $dp;
        $bungaPersen = (float) $jenisCicilan->bunga_persen;
        $tenorBulan = (int) $jenisCicilan->tenor_bulan;
        $asuransi = ! empty($validated['asuransi_id'])
            ? Asuransi::query()->find((int) $validated['asuransi_id'])
            : null;
        $biayaAsuransiPerBulan = $asuransi ? ($pokokHutang * ((float) $asuransi->margin_persen / 100)) : 0;

        $totalPembiayaan = ($pokokHutang * (1 + (($bungaPersen / 100) * ($tenorBulan / 12)))) + ($biayaAsuransiPerBulan * $tenorBulan);
        $angsuranPerBulan = $tenorBulan > 0 ? ($totalPembiayaan / $tenorBulan) : $totalPembiayaan;

        $marketingId = User::query()->whereHas('role', function ($query) {
            $query->where('slug', 'marketing');
        })->value('id');

        // Handle File Uploads
        $ktpPath = $request->file('url_ktp') ? $request->file('url_ktp')->store('pengajuan/ktp', 'public') : null;
        $kkPath = $request->file('url_kk') ? $request->file('url_kk')->store('pengajuan/kk', 'public') : null;
        $slipGajiPath = $request->file('url_slip_gaji') ? $request->file('url_slip_gaji')->store('pengajuan/slip_gaji', 'public') : null;
        $fotoPath = $request->file('url_foto') ? $request->file('url_foto')->store('pengajuan/foto', 'public') : null;

        DB::transaction(function () use ($validated, $motor, $jenisCicilan, $asuransi, $hargaCash, $dp, $pokokHutang, $bungaPersen, $biayaAsuransiPerBulan, $totalPembiayaan, $angsuranPerBulan, $tenorBulan, $marketingId, $nik, $pekerjaan, $penghasilanBulanan, $statusPernikahan, $catatan, $ktpPath, $kkPath, $slipGajiPath, $fotoPath): void {
            $pelanggan = Pelanggan::query()->updateOrCreate(
            ['nik' => $nik],
                [
                    'nama_pelanggan' => $validated['nama_pelanggan'],
                    'email' => $validated['email'] ?? null,
                    'no_telp' => $validated['no_telp'],
                    'alamat1' => $validated['alamat1'],
                    'kota1' => $validated['kota1'],
                    'pekerjaan' => $pekerjaan,
                    'penghasilan_bulanan' => $penghasilanBulanan,
                    'status_pernikahan' => $statusPernikahan,
                ]
            );

            PengajuanKredit::query()->create([
                'kode_pengajuan' => $this->generateKodePengajuan(),
                'pelanggan_id' => $pelanggan->id,
                'motor_id' => $motor->id,
                'jenis_cicilan_id' => $jenisCicilan->id,
                'asuransi_id' => $asuransi?->id,
                'marketing_id' => $marketingId,
                'approved_by' => null,
                'harga_cash' => $hargaCash,
                'dp' => $dp,
                'pokok_hutang' => $pokokHutang,
                'bunga_persen' => $bungaPersen,
                'biaya_asuransi_per_bulan' => $biayaAsuransiPerBulan,
                'total_pembiayaan' => $totalPembiayaan,
                'angsuran_per_bulan' => $angsuranPerBulan,
                'tenor_bulan' => $tenorBulan,
                'tanggal_pengajuan' => now()->toDateString(),
                'url_ktp' => $ktpPath,
                'url_kk' => $kkPath,
                'url_slip_gaji' => $slipGajiPath,
                'url_foto' => $fotoPath,
                'status' => 'Menunggu Konfirmasi',
                'catatan' => $catatan !== '' ? $catatan : null,
                'approved_at' => null,
            ]);
        });

        return redirect()->route('pengajuan.form', $motor)
            ->with('success', 'Pengajuan kredit berhasil dikirim. Tim kami akan menghubungi Anda.');
    }

    private function calculateSimulasi(float $hargaCash, float $dp, int $tenorBulan, float $bungaPersen, float $asuransiMarginPersen): array
    {
        $pokokHutang = max($hargaCash - $dp, 0);
        $biayaAsuransiPerBulan = $pokokHutang * ($asuransiMarginPersen / 100);
        $totalPembiayaan = ($pokokHutang * (1 + (($bungaPersen / 100) * ($tenorBulan / 12)))) + ($biayaAsuransiPerBulan * $tenorBulan);
        $angsuranPerBulan = $tenorBulan > 0 ? ($totalPembiayaan / $tenorBulan) : $totalPembiayaan;

        return [
            'pokok_hutang' => $pokokHutang,
            'biaya_asuransi_per_bulan' => $biayaAsuransiPerBulan,
            'total_pembiayaan' => $totalPembiayaan,
            'angsuran_per_bulan' => $angsuranPerBulan,
        ];
    }

    private function generateKodePengajuan(): string
    {
        do {
            $kode = 'PGJ-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (PengajuanKredit::query()->where('kode_pengajuan', $kode)->exists());

        return $kode;
    }

    private function generateNikFromPhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?: '';
        $base = substr(str_pad($digits, 12, '0'), 0, 12).now()->format('Hi');

        do {
            $nik = substr($base, 0, 14).str_pad((string) random_int(0, 99), 2, '0', STR_PAD_LEFT);
        } while (Pelanggan::query()->where('nik', $nik)->exists());

        return $nik;
    }
}
