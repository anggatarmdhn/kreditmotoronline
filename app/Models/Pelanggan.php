<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'email',
        'katakunci',
        'no_telp',
        'alamat1', 'kota1', 'propinsi1', 'kodepos1',
        'alamat2', 'kota2', 'propinsi2', 'kodepos2',
        'alamat3', 'kota3', 'propinsi3', 'kodepos3',
        'foto',
        'nik',
        'pekerjaan',
        'penghasilan_bulanan',
        'status_pernikahan',
    ];

    protected function casts(): array
    {
        return [
            'penghasilan_bulanan' => 'decimal:2',
        ];
    }

    public function pengajuanKredits(): HasMany
    {
        return $this->hasMany(PengajuanKredit::class);
    }
}
