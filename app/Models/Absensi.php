<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'kategori_absensi_id',
        'admin_id',
        'tanggal',
        'jenis_absensi',
        'jenis',
        'bukti_photo',
        'status_validasi'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kategoriAbsensi()
    {
        return $this->belongsTo(KategoriAbsensi::class);
    }

    public function admin()
    {
        return $this->belongsTo(KategoriAbsensi::class);
    }

    public function absenKelas()
    {
        return $this->hasMany(AbsenKelas::class);
    }
}
