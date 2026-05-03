<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisMotor extends Model
{
    protected $fillable = [
        'merk',
        'jenis',
        'deskripsi_jenis',
        'image_url',
    ];

    public function motors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Motor::class, 'id_jenis');
    }
}
