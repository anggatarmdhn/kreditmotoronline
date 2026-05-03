@php
    $companyName = \App\Models\Setting::get('company_name', 'Angga Credit Motors');
@endphp
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran Angsuran – {{ $companyName }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Sora', sans-serif; background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%); min-height: 100vh; }
        .card { background: #fff; border-radius: 24px; box-shadow: 0 25px 60px rgba(0,0,0,0.3); }
        .pay-btn { background: linear-gradient(135deg, #10b981, #059669); border: none; cursor: pointer; transition: all .2s; }
        .pay-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(16,185,129,0.4); }
        .pay-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .info-row:last-child { border-bottom: none; }
        .loader { display: none; width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .toast { position: fixed; top: 24px; right: 24px; z-index: 9999; padding: 14px 20px; border-radius: 12px; font-size: 13px; font-weight: 600; display: none; animation: slideIn .3s ease; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
        .toast.success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .toast.error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    </style>
    <!-- Midtrans Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="flex items-center justify-center p-4">

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

    <div class="card max-w-md w-full p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-4xl mb-4 shadow-lg shadow-emerald-200">
                💸
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">Pembayaran Angsuran</h1>
            <p class="text-slate-500 text-sm mt-1">Selesaikan pembayaran cicilan bulanan Anda</p>
        </div>

        <!-- Info Pengajuan -->
        <div class="bg-slate-50 rounded-2xl p-5 mb-6 border border-slate-100">
            <div class="info-row">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Motor</span>
                <span class="font-bold text-slate-800 text-sm">{{ $pengajuan->motor->nama_motor }}</span>
            </div>
            <div class="info-row">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Angsuran Ke</span>
                <span class="font-bold text-slate-800 text-sm">{{ $angsuran->angsuran_ke }} dari {{ $pengajuan->tenor_bulan }}</span>
            </div>
            <div class="info-row">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Jatuh Tempo</span>
                <span class="font-bold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($angsuran->jatuh_tempo)->translatedFormat('d M Y') }}</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-200">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-slate-600">Total Tagihan</span>
                    <span class="text-2xl font-black text-emerald-600">Rp {{ number_format($angsuran->jumlah_tagihan, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Security Note -->
        <div class="flex items-start gap-3 bg-blue-50 rounded-xl p-4 mb-6 border border-blue-100">
            <span class="text-blue-500 text-xl flex-shrink-0">🔒</span>
            <p class="text-xs text-blue-700 leading-relaxed">
                Pembayaran diproses secara aman melalui <strong>Midtrans</strong>. Tersedia pilihan metode: Transfer Bank, GoPay, OVO, QRIS, Kartu Kredit, dan lainnya.
            </p>
        </div>

        <!-- Pay Button -->
        <button id="pay-button" class="pay-btn w-full py-4 rounded-2xl text-white font-extrabold text-lg flex items-center justify-center gap-3">
            <span id="btn-text">Bayar Sekarang</span>
            <div id="btn-loader" class="loader"></div>
        </button>

        <a href="{{ route('client.tagihan') }}" class="block text-center text-sm text-slate-400 hover:text-slate-600 font-semibold mt-4 transition">
            ← Kembali ke Tagihan Saya
        </a>
    </div>

<script>
const KONFIRMASI_URL = "{{ route('client.angsuran.konfirmasi', $angsuran) }}";
const SELESAI_URL    = "{{ route('client.angsuran.selesai', $angsuran) }}";
const SNAP_TOKEN     = "{{ $snapToken }}";
const CSRF_TOKEN     = document.querySelector('meta[name="csrf-token"]').content;

const payBtn  = document.getElementById('pay-button');
const btnText = document.getElementById('btn-text');
const loader  = document.getElementById('btn-loader');
const toast   = document.getElementById('toast');

function showToast(msg, type = 'success') {
    toast.textContent = msg;
    toast.className = 'toast ' + type;
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 4000);
}

function setLoading(loading) {
    payBtn.disabled = loading;
    btnText.textContent = loading ? 'Memproses...' : 'Bayar Sekarang';
    loader.style.display = loading ? 'block' : 'none';
}

function kirimKonfirmasi(transactionStatus, orderId) {
    setLoading(true);
    showToast('⏳ Memproses konfirmasi pembayaran...', 'success');

    fetch(KONFIRMASI_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
            transaction_status: transactionStatus,
            order_id: orderId,
        }),
    })
    .then(res => {
        if (!res.ok) throw new Error("HTTP error " + res.status);
        return res.json();
    })
    .then(data => {
        if (data.ok) {
            showToast(data.pending
                ? (data.message || '⏳ Menunggu konfirmasi bank...')
                : '✅ Pembayaran berhasil dikonfirmasi!',
                'success');
            setTimeout(() => { window.location.href = data.redirect_url; }, 1200);
        } else {
            showToast(data.message || 'Pembayaran gagal.', 'error');
            setLoading(false);
        }
    })
    .catch((err) => {
        console.error(err);
        showToast('⚠️ Gagal konfirmasi otomatis, mengalihkan untuk verifikasi...', 'error');
        setTimeout(() => { 
            let redirectUrl = SELESAI_URL;
            if (orderId) {
                redirectUrl += '?order_id=' + orderId;
            }
            window.location.href = redirectUrl; 
        }, 1500);
    });
}

payBtn.addEventListener('click', function () {
    setLoading(true);

    window.snap.pay(SNAP_TOKEN, {
        onSuccess: function (result) {
            kirimKonfirmasi(result.transaction_status || 'settlement', result.order_id || '');
        },
        onPending: function (result) {
            kirimKonfirmasi(result.transaction_status || 'pending', result.order_id || '');
        },
        onError: function (result) {
            setLoading(false);
            showToast('❌ Pembayaran gagal. Silakan coba metode lain.', 'error');
        },
        onClose: function () {
            setLoading(false);
        },
    });
});
</script>
</body>
</html>
