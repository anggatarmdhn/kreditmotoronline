<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisCicilan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tenor_bulan',
        'bunga_persen',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'bunga_persen' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pengajuanKredits(): HasMany
    {
        return $this->hasMany(PengajuanKredit::class);
    }
}
