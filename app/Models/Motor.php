<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_motor',
        'nama_motor',
        'harga_cash',
        'harga_jual',
        'dp_minimum',
        'deskripsi_motor',
        'warna',
        'kapasitas_mesin',
        'tahun_produksi',
        'foto1',
        'foto2',
        'foto3',
        'stok',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'harga_cash' => 'decimal:2',
            'dp_minimum' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pengajuanKredits(): HasMany
    {
        return $this->hasMany(PengajuanKredit::class);
    }
}
