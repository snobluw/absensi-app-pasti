<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $data_sekolah = [
            [
                'data-name' => 'Data Guru',
                'name' => 'guru',
                'jumlah' => 10,
                'colors' => 'primary'
            ],
            [
                'data-name' => 'Data Admin',
                'name' => 'admin',
                'jumlah' => 5,
                'colors' => 'success'
            ],
            [
                'data-name' => 'Data Kelas',
                'name' => 'kelas',
                'jumlah' => 5,
                'colors' => 'warning'
            ],
            [
                'data-name' => 'Data Mapel',
                'name' => 'mapel',
                'jumlah' => 8,
                'colors' => 'danger'
            ]
        ];

        if (auth()->user()->role == 'admin') {
            return view('dashboard.admin.index', [
                'title' => 'Dashboard',
                'data_sekolah' => $data_sekolah
            ]);
        } elseif (auth()->user()->role == 'guru') {

            $guru = auth()->user()->guru;

            $today = now()->toDateString();
            $absensiHariIni = $guru->absensi()->whereDate('tanggal', $today)->first();

            $summary = $guru->absensi()
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->selectRaw('jenis, count(*) as total')
                ->groupBy('jenis')
                ->pluck('total', 'jenis');

            return view('dashboard.index', [
                'title' => 'Dashboard',
                'sudahAbsen' => $absensiHariIni !== null,
                'statusAbsen' => $absensiHariIni->jenis ?? '',
                'summary' => $summary,
            ]);
        }
    }
}
