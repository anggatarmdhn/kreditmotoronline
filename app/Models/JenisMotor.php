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

}
