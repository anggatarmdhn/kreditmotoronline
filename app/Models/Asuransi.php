<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asuransi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'nama_asuransi',
        'margin_persen',
        'no_rekening',
        'url_logo',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'margin_persen' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pengajuanKredits(): HasMany
    {
        return $this->hasMany(PengajuanKredit::class);
    }
}
