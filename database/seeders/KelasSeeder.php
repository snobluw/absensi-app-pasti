<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelasList = [
            ['nama' => 'Kelas 1A', 'tingkat' => 1],
            ['nama' => 'Kelas 1B', 'tingkat' => 1],
            ['nama' => 'Kelas 2A', 'tingkat' => 2],
            ['nama' => 'Kelas 2B', 'tingkat' => 2],
            ['nama' => 'Kelas 3A', 'tingkat' => 3],
            ['nama' => 'Kelas 3B', 'tingkat' => 3],
        ];

        foreach ($kelasList as $kelas) {
            Kelas::create($kelas);
        }
    }
}
    

