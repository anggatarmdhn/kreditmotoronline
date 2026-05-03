<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kredit extends Model
{
    protected $fillable = [
        'id_pengajuan_kredit',
        'id_metode_bayar',
        'tgl_mulai_kredit',
        'tgl_selesai_kredit',
        'sisa_kredit',
        'status_kredit',
        'keterangan_status_kredit',
    ];

    protected function casts(): array
    {
        return [
            'tgl_mulai_kredit' => 'date',
            'tgl_selesai_kredit' => 'date',
            'sisa_kredit' => 'decimal:2',
        ];
    }

    public function pengajuanKredit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PengajuanKredit::class, 'id_pengajuan_kredit');
    }

    public function metodeBayar(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MetodeBayar::class, 'id_metode_bayar');
    }

    public function angsurans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Angsuran::class, 'id_kredit');
    }
}
