<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';

    protected $fillable = [
        'pengajuan_kredit_id',
        'no_resi',
        'ekspedisi',
        'alamat_kirim',
        'tanggal_kirim',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kirim' => 'date',
        ];
    }

    public function pengajuanKredit(): BelongsTo
    {
        return $this->belongsTo(PengajuanKredit::class);
    }
}
