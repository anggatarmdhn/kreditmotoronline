<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Angsuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kredit',
        'angsuran_ke',
        'jatuh_tempo',
        'jumlah_tagihan',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_bayar_id',
        'status',
        'bukti_bayar',
        'keterangan',
        'midtrans_order_id',
    ];

    protected function casts(): array
    {
        return [
            'jatuh_tempo' => 'date',
            'jumlah_tagihan' => 'decimal:2',
            'jumlah_bayar' => 'decimal:2',
            'tanggal_bayar' => 'date',
        ];
    }

    public function kredit(): BelongsTo
    {
        return $this->belongsTo(Kredit::class, 'id_kredit');
    }

    public function metodeBayar(): BelongsTo
    {
        return $this->belongsTo(MetodeBayar::class);
    }
}
