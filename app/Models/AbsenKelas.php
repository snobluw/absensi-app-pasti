<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'absensi_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }
}
