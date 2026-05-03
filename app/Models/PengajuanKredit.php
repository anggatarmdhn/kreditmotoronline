<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PengajuanKredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pengajuan',
        'pelanggan_id',
        'motor_id',
        'jenis_cicilan_id',
        'asuransi_id',
        'marketing_id',
        'approved_by',
        'harga_cash',
        'dp',
        'pokok_hutang',
        'bunga_persen',
        'biaya_asuransi_per_bulan',
        'total_pembiayaan',
        'angsuran_per_bulan',
        'tenor_bulan',
        'tanggal_pengajuan',
        'url_kk',
        'url_ktp',
        'url_npwp',
        'url_slip_gaji',
        'url_foto',
        'status',
        'catatan',
        'approved_at',
        'dp_paid',
        'midtrans_order_id',
        'dp_paid_at',
    ];

    protected function casts(): array
    {
        return [
            'harga_cash' => 'decimal:2',
            'dp' => 'decimal:2',
            'pokok_hutang' => 'decimal:2',
            'bunga_persen' => 'decimal:2',
            'biaya_asuransi_per_bulan' => 'decimal:2',
            'total_pembiayaan' => 'decimal:2',
            'angsuran_per_bulan' => 'decimal:2',
            'tanggal_pengajuan' => 'date',
            'approved_at' => 'datetime',
            'dp_paid' => 'boolean',
            'dp_paid_at' => 'datetime',
        ];
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function motor(): BelongsTo
    {
        return $this->belongsTo(Motor::class);
    }

    public function jenisCicilan(): BelongsTo
    {
        return $this->belongsTo(JenisCicilan::class);
    }

    public function asuransi(): BelongsTo
    {
        return $this->belongsTo(Asuransi::class);
    }

    public function marketing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function kredit(): HasOne
    {
        return $this->hasOne(Kredit::class, 'id_pengajuan_kredit');
    }

    public function angsurans()
    {
        // hasManyThrough: (Related, Through, firstKeyOnThrough, secondKeyOnRelated, localKey, secondLocalKey)
        return $this->hasManyThrough(Angsuran::class, Kredit::class, 'id_pengajuan_kredit', 'id_kredit', 'id', 'id');
    }

    public function pengiriman(): HasOne
    {
        return $this->hasOne(Pengiriman::class);
    }
}
