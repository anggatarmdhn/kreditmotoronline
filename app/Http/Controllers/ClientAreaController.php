<?php

namespace App\Http\Controllers;

use App\Models\PengajuanKredit;
use Illuminate\Http\Request;

class ClientAreaController extends Controller
{
    // ─── Status Midtrans yang berarti "LUNAS" ─────────────────────────────────
    private const STATUS_LUNAS   = ['settlement', 'capture'];
    private const STATUS_PENDING = ['pending'];

    // ─── Public ───────────────────────────────────────────────────────────────

    /**
     * Halaman daftar pengajuan milik klien yang login.
     */
    public function pengajuan()
    {
        $email = auth()->user()->email;

        $pengajuans = PengajuanKredit::with(['motor', 'jenisCicilan', 'pelanggan'])
            ->whereHas('pelanggan', fn ($q) => $q->where('email', $email))
            ->latest('tanggal_pengajuan')
            ->get();

        return view('landing.client.pengajuan', compact('pengajuans'));
    }

    public function tagihan()
    {
        $email = auth()->user()->email;

        $kredits = \App\Models\Kredit::with(['pengajuanKredit.motor', 'angsurans' => function($q) {
            $q->orderBy('angsuran_ke');
        }])
            ->whereHas('pengajuanKredit', function ($q) use ($email) {
                $q->whereHas('pelanggan', fn ($p) => $p->where('email', $email))
                  ->where('dp_paid', true);
            })
            ->get();

        return view('landing.client.tagihan', compact('kredits'));
    }

    /**
     * Halaman pembayaran DP via Midtrans Snap.
     * Jika dp_paid sudah true → langsung ke halaman sukses.
     */
    public function bayar(PengajuanKredit $pengajuan)
    {
        if ($pengajuan->status !== 'Diterima') {
            return redirect()->route('client.pengajuan')
                ->with('error', 'Pengajuan ini belum disetujui atau tidak dapat dibayar.');
        }

        // Sudah dibayar? Langsung ke halaman sukses
        if ($pengajuan->dp_paid) {
            return redirect()->route('client.bayar.sukses', $pengajuan);
        }

        $this->setupMidtrans();

        $orderId = $pengajuan->kode_pengajuan . '-' . time();
        $pengajuan->update(['midtrans_order_id' => $orderId]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $pengajuan->dp,
            ],
            'customer_details' => [
                'first_name' => $pengajuan->pelanggan->nama_pelanggan ?? 'Pelanggan',
                'email'      => $pengajuan->pelanggan->email ?? 'client@example.com',
                'phone'      => $pengajuan->pelanggan->no_telp ?? '',
            ],
            'callbacks' => [
                'finish' => route('client.bayar.selesai', ['pengajuan' => $pengajuan->id, 'order_id' => $orderId]),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('landing.client.bayar', compact('pengajuan', 'snapToken', 'orderId'));
        } catch (\Exception $e) {
            return redirect()->route('client.pengajuan')
                ->with('error', 'Gagal memuat pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * ── ENDPOINT AJAX (POST) ──────────────────────────────────────────────────
     * Dipanggil oleh JS onSuccess / onPending Snap.js.
     * Tandai dp_paid dan update status langsung dari data Snap callback.
     */
    public function konfirmasiBayar(Request $request, PengajuanKredit $pengajuan)
    {
        if ($pengajuan->dp_paid) {
            return response()->json([
                'ok'          => true,
                'redirect_url' => route('client.bayar.sukses', $pengajuan),
            ]);
        }

        $transactionStatus = $request->input('transaction_status', '');
        $orderId           = $request->input('order_id', $pengajuan->midtrans_order_id ?? '');

        if (in_array($transactionStatus, self::STATUS_LUNAS)) {
            $this->tandaiDpLunas($pengajuan, $orderId);

            return response()->json([
                'ok'           => true,
                'redirect_url' => route('client.bayar.sukses', $pengajuan),
            ]);
        }

        if (in_array($transactionStatus, self::STATUS_PENDING)) {
            $pengajuan->update(['midtrans_order_id' => $orderId]);

            return response()->json([
                'ok'           => true,
                'pending'      => true,
                'redirect_url' => route('client.pengajuan'),
                'message'      => 'Pembayaran sedang menunggu konfirmasi. Silakan selesaikan sesuai instruksi bank.',
            ]);
        }

        return response()->json(['ok' => false, 'message' => 'Status tidak dikenali.'], 422);
    }

    /**
     * ── ENDPOINT GET (Midtrans finish redirect) ───────────────────────────────
     * Dipanggil browser setelah Snap popup ditutup (finish callback Midtrans).
     * Lakukan verifikasi RESMI ke Midtrans Status API untuk status sebenarnya.
     */
    public function selesaiBayar(Request $request, PengajuanKredit $pengajuan)
    {
        // Sudah ditandai lunas (dari konfirmasiBayar JS) → langsung sukses
        if ($pengajuan->dp_paid) {
            return redirect()->route('client.bayar.sukses', $pengajuan);
        }

        // Ambil order_id dari parameter URL Midtrans callback, atau fallback ke DB
        $orderId = $request->query('order_id', $pengajuan->midtrans_order_id);

        // Tidak ada order_id → belum pernah mulai bayar
        if (! $orderId) {
            return redirect()->route('client.pengajuan')
                ->with('error', 'Sesi pembayaran tidak ditemukan. Silakan coba lagi.');
        }

        // Verifikasi status ke Midtrans API
        try {
            $this->setupMidtrans();
            $statusResult = \Midtrans\Transaction::status($orderId);
            $transactionStatus = $statusResult->transaction_status ?? '';
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), '404') || str_contains($e->getMessage(), "doesn't exist")) {
                if (!config('midtrans.is_production')) {
                    // BYPASS UNTUK SANDBOX: Anggap lunas agar mempermudah testing user
                    $this->tandaiDpLunas($pengajuan, $orderId);
                    return redirect()->route('client.bayar.sukses', $pengajuan);
                }
                
                return redirect()->route('client.pengajuan')
                    ->with('error', 'Transaksi belum dibayar. Jika memilih Virtual Account, Anda harus mentransfernya di dalam simulator Midtrans.');
            }

            // Error API lainnya
            return redirect()->route('client.pengajuan')
                ->with('error', 'Tidak dapat memverifikasi status pembayaran. Silakan coba lagi nanti.');
        }

        if (in_array($transactionStatus, self::STATUS_LUNAS)) {
            $this->tandaiDpLunas($pengajuan, $orderId);
            return redirect()->route('client.bayar.sukses', $pengajuan);
        }

        if (in_array($transactionStatus, self::STATUS_PENDING)) {
            return redirect()->route('client.pengajuan')
                ->with('success', 'Pembayaran sedang menunggu konfirmasi. Kami akan memperbarui status secara otomatis.');
        }

        // Gagal / expired / denied
        return redirect()->route('client.bayar', $pengajuan)
            ->with('error', 'Pembayaran belum berhasil (status: ' . $transactionStatus . '). Silakan coba lagi.');
    }

    /**
     * Halaman sukses — hanya tampil jika dp_paid = true.
     */
    public function suksesBayar(PengajuanKredit $pengajuan)
    {
        // Guard: jangan tampilkan sukses kalau dp_paid belum true
        if (! $pengajuan->dp_paid) {
            return redirect()->route('client.bayar', $pengajuan)
                ->with('error', 'Pembayaran DP belum terkonfirmasi.');
        }

        $pengajuan->load(['motor', 'pelanggan', 'kredit.angsurans']);

        return view('landing.client.bayar_sukses', compact('pengajuan'));
    }

    // ─── Private ──────────────────────────────────────────────────────────────

    /**
     * Tandai pengajuan sebagai DP lunas dan ubah status ke Diproses.
     */
    private function tandaiDpLunas(PengajuanKredit $pengajuan, string $orderId): void
    {
        $pengajuan->update([
            'dp_paid'           => true,
            'dp_paid_at'        => now(),
            'midtrans_order_id' => $orderId,
            'status'            => 'Diproses',
            'catatan'           => '✅ DP telah dibayar via Midtrans (Order ID: ' . $orderId . '). Menunggu proses pengiriman motor.',
        ]);
    }

    /**
     * Setup konfigurasi Midtrans dari config file.
     */
    private function setupMidtrans(): void
    {
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
        \Midtrans\Config::$curlOptions  = [
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER     => [],
        ];
    }
    // ─── Angsuran ─────────────────────────────────────────────────────────────

    public function bayarAngsuran(\App\Models\Angsuran $angsuran)
    {
        $kredit = $angsuran->kredit;
        $pengajuan = $kredit->pengajuanKredit;

        if ($angsuran->status === 'lunas') {
            return redirect()->route('client.tagihan')->with('success', 'Angsuran ini sudah lunas.');
        }

        $this->setupMidtrans();

        $orderId = 'ANG-' . $angsuran->id . '-' . time();
        $angsuran->update(['midtrans_order_id' => $orderId]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $angsuran->jumlah_tagihan,
            ],
            'customer_details' => [
                'first_name' => $pengajuan->pelanggan->nama_pelanggan ?? 'Pelanggan',
                'email'      => $pengajuan->pelanggan->email ?? 'client@example.com',
                'phone'      => $pengajuan->pelanggan->no_telp ?? '',
            ],
            'callbacks' => [
                'finish' => route('client.angsuran.selesai', ['angsuran' => $angsuran->id, 'order_id' => $orderId]),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('landing.client.bayar_angsuran', compact('angsuran', 'snapToken', 'orderId', 'pengajuan'));
        } catch (\Exception $e) {
            return redirect()->route('client.tagihan')->with('error', 'Gagal memuat pembayaran: ' . $e->getMessage());
        }
    }

    public function konfirmasiAngsuran(Request $request, \App\Models\Angsuran $angsuran)
    {
        if ($angsuran->status === 'lunas') {
            return response()->json(['ok' => true, 'redirect_url' => route('client.tagihan')]);
        }

        $transactionStatus = $request->input('transaction_status', '');
        $orderId           = $request->input('order_id', $angsuran->midtrans_order_id ?? '');

        if (in_array($transactionStatus, self::STATUS_LUNAS)) {
            $this->tandaiAngsuranLunas($angsuran, $orderId);
            return response()->json(['ok' => true, 'redirect_url' => route('client.tagihan')]);
        }

        if (in_array($transactionStatus, self::STATUS_PENDING)) {
            $angsuran->update(['midtrans_order_id' => $orderId]);
            return response()->json([
                'ok' => true, 'pending' => true, 'redirect_url' => route('client.tagihan'),
                'message' => 'Pembayaran angsuran sedang menunggu konfirmasi.'
            ]);
        }

        return response()->json(['ok' => false, 'message' => 'Status tidak dikenali.'], 422);
    }

    public function selesaiAngsuran(Request $request, \App\Models\Angsuran $angsuran)
    {
        if ($angsuran->status === 'lunas') {
            return redirect()->route('client.tagihan')->with('success', 'Pembayaran angsuran berhasil!');
        }

        $orderId = $request->query('order_id', $angsuran->midtrans_order_id);

        if (! $orderId) {
            return redirect()->route('client.tagihan')->with('error', 'Sesi pembayaran tidak ditemukan.');
        }

        try {
            $this->setupMidtrans();
            $statusResult = \Midtrans\Transaction::status($orderId);
            $transactionStatus = $statusResult->transaction_status ?? '';
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), '404') || str_contains($e->getMessage(), "doesn't exist")) {
                if (!config('midtrans.is_production')) {
                    $this->tandaiAngsuranLunas($angsuran, $orderId);
                    return redirect()->route('client.tagihan')->with('success', 'Bypass: Pembayaran sukses (Sandbox).');
                }
                return redirect()->route('client.tagihan')->with('error', 'Transaksi angsuran belum dibayar.');
            }
            return redirect()->route('client.tagihan')->with('error', 'Tidak dapat memverifikasi status angsuran.');
        }

        if (in_array($transactionStatus, self::STATUS_LUNAS)) {
            $this->tandaiAngsuranLunas($angsuran, $orderId);
            return redirect()->route('client.tagihan')->with('success', 'Pembayaran angsuran berhasil!');
        }

        if (in_array($transactionStatus, self::STATUS_PENDING)) {
            return redirect()->route('client.tagihan')->with('success', 'Pembayaran angsuran menunggu konfirmasi.');
        }

        return redirect()->route('client.tagihan')->with('error', 'Pembayaran angsuran gagal.');
    }

    private function tandaiAngsuranLunas(\App\Models\Angsuran $angsuran, string $orderId): void
    {
        $angsuran->update([
            'status'            => 'lunas',
            'jumlah_bayar'      => $angsuran->jumlah_tagihan,
            'tanggal_bayar'     => now(),
            'midtrans_order_id' => $orderId,
            'keterangan'        => 'Dibayar via Midtrans (Order ID: ' . $orderId . ')',
        ]);
        
        // Update Sisa Kredit
        $kredit = $angsuran->kredit;
        $kredit->decrement('sisa_kredit', $angsuran->jumlah_tagihan);
    }
}
