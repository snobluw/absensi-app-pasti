<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tingkat', // or 'kelas_name' etc., depending on your schema
    ];

    public function absenKelas()
    {
        return $this->hasMany(AbsenKelas::class);
    }
}
