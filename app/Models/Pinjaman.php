<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'tanggal_pengajuan',
        'jumlah',
        'status',
        'pesan',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function pengembalian()
    {
        return $this->hasMany(PengembalianPinjaman::class);
    }

    public function getTotalDibayarAttribute()
    {
        return $this->pengembalian->sum('jumlah');
    }

    public function getSisaBayarAttribute()
    {
        return $this->jumlah - $this->total_dibayar;
    }
}
