<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAbsensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'gaji',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
