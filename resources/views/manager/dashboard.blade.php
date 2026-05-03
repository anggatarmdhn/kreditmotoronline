@extends('layouts.admin')

@section('title', 'Dashboard Manager')
@section('page-title', 'Dashboard Manager')
@section('page-subtitle', 'Laporan Performa Penjualan dan Kredit')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .stat-card { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; }
    .stat-card .label { font-size: 12px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 8px; }
    .stat-card .value { font-size: 24px; font-weight: 900; color: #0f172a; }
    .chart-container { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 24px; }
    .table-container { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 24px; overflow-x: auto; }
    .table-container h3 { font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 0; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th { text-align: left; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; color: #64748b; text-transform: uppercase; font-size: 11px; }
    td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; color: #334155; }
</style>
@endpush

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Kredit Aktif</div>
        <div class="value">{{ number_format($totalPenjualan) }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Total Pendapatan (Angsuran Lunas)</div>
        <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Kredit Macet (>3 Bulan)</div>
        <div class="value" style="color: #ef4444;">{{ number_format($kreditMacet->count()) }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Tunggakan (Total)</div>
        <div class="value" style="color: #f59e0b;">{{ number_format($telatBayar->count()) }}</div>
    </div>
</div>

<div class="chart-container">
    <h3 style="margin-top: 0; margin-bottom: 16px; font-size: 16px; font-weight: 800;">Performa Penjualan & Pendapatan (6 Bulan Terakhir)</h3>
    <canvas id="performanceChart" height="100"></canvas>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
    <div class="table-container" style="margin-bottom: 0;">
        <h3>Produk Motor Paling Laku</h3>
        <table>
            <thead>
                <tr>
                    <th>Motor</th>
                    <th>Jumlah Terjual (Kredit Aktif)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($motorTerlaris as $motor)
                <tr>
                    <td style="font-weight: 600;">{{ $motor->nama_motor }}</td>
                    <td>{{ $motor->pengajuan_kredits_count }} unit</td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align: center; color: #94a3b8;">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="table-container" style="margin-bottom: 0;">
        <h3>Daftar Kredit Macet (> 3 Bulan)</h3>
        <table>
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Motor</th>
                    <th>Sisa Kredit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kreditMacet as $kredit)
                <tr>
                    <td style="font-weight: 600;">{{ $kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '—' }}</td>
                    <td>{{ $kredit->pengajuanKredit->motor->nama_motor ?? '—' }}</td>
                    <td style="color: #ef4444; font-weight: 700;">Rp {{ number_format($kredit->sisa_kredit, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align: center; color: #94a3b8;">Tidak ada kredit macet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="table-container">
    <h3>Tunggakan Angsuran (Telat Bayar)</h3>
    <table>
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Angsuran Ke</th>
                <th>Jatuh Tempo</th>
                <th>Tagihan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($telatBayar as $angsuran)
            <tr>
                <td style="font-weight: 600;">{{ $angsuran->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '—' }}</td>
                <td>{{ $angsuran->angsuran_ke }}</td>
                <td style="color: #ef4444;">{{ \Carbon\Carbon::parse($angsuran->jatuh_tempo)->translatedFormat('d M Y') }}</td>
                <td style="font-weight: 700;">Rp {{ number_format($angsuran->jumlah_tagihan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align: center; color: #94a3b8;">Tidak ada angsuran telat.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Jumlah Penjualan (Kredit Baru)',
                    data: {!! json_encode($penjualanBulanan) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    yAxisID: 'y',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Pendapatan Angsuran (Rp)',
                    data: {!! json_encode($pendapatanBulanan) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    yAxisID: 'y1',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: { display: true, text: 'Jumlah Unit' }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: { display: true, text: 'Pendapatan (Rp)' },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });
</script>
@endpush
@endsection
