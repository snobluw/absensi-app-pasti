<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\KategoriAbsensi;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'username'       => 'snobluw',
            'email'          => 'snobluw@gmail.com',
            'password'       => bcrypt('123'),
            'gender'         => 'L',
            'role'           => 'admin',
            'avatar'         => null,
            'remember_token' => Str::random(10),
        ]);

        $user2 = User::create([
            'username'       => 'snobluwguru',
            'email'          => 'snobluw11@gmail.com',
            'password'       => bcrypt('123'),
            'gender'         => 'L',
            'role'           => 'guru',
            'avatar'         => null,
            'remember_token' => Str::random(10),
        ]);


        Admin::create([
            'user_id' => $user->id,
            'nama'    => 'Rifqi Nugraha',
            'nip'     => rand(1900000000000000, 1900009999999999),
        ]);

        Guru::create([
            'user_id' => $user2->id,
            'nama'    => 'Rifqi Nugraha',
            'nip'     => rand(1900000000000000, 1900009999999999),
            'nuptk'     => rand(1900000000000000, 1900009999999999),
        ]);

        KategoriAbsensi::create([
            'nama' => 'Pokok',
            'gaji' => 120000,
        ]);

        KategoriAbsensi::create([
            'nama' => 'Tambahan Walas',
            'gaji' => 50000,
        ]);

        KategoriAbsensi::create([
            'nama' => 'Pramuka',
            'gaji' => 830000,
        ]);

        KategoriAbsensi::create([
            'nama' => 'Lain-lain',
            'gaji' => 50000,
        ]);

        KategoriAbsensi::create([
            'nama' => 'Eskul',
            'gaji' => 30000,
        ]);




        Guru::factory(10)->create();
        Admin::factory(10)->create();

        $this->call([
            KelasSeeder::class,
        ]);
    }
}
