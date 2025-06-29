<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\KategoriAbsensi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Make sure this is imported


class SlipGajiController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $guru = $user->guru;

        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $allKategori = KategoriAbsensi::all();
        $absensiList = Absensi::with(['absenKelas', 'kategoriAbsensi'])
            ->where('guru_id', $guru->id)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $data = [];
        $total = 0;

        foreach ($allKategori as $kategori) {
            $gajiPerKehadiran = $kategori->gaji;

            // Filter absensi for this kategori
            $absensis = $absensiList->where('kategori_absensi_id', $kategori->id);

            $counts = ['H' => 0, 'S' => 0, 'I' => 0, 'T' => 0];

            foreach ($absensis as $absen) {



                if ($absen->jenis === 'H') {
                    $counts['H'] += $absen->absenKelas->count(); // Count kelas
                } elseif (in_array($absen->jenis, ['S', 'I', 'T'])) {
                    $counts[$absen->jenis]++;
                }
            }

            $jumlah = $counts['H'] * $gajiPerKehadiran;

            $data[] = [
                'kategori' => $kategori->nama,
                'counts' => $counts,
                'gaji_per_kehadiran' => $gajiPerKehadiran,
                'jumlah' => $jumlah,
            ];

            $total += $jumlah;
        }


        return view('slip-gaji.index', [
            'title' => 'Slip Gaji',
            'guru' => $guru,
            'data' => $data,
            'total' => $total,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function download(Request $request)
    {


        $user = auth()->user();
        $guru = $user->guru;

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // === Generate same $data and $total like index() ===
        [$data, $total] = $this->generateSlipData($guru, $month, $year);

        $pdf = Pdf::loadView('slip-gaji.pdf', compact('guru', 'data', 'total', 'month', 'year'));

        return $pdf->download("Slip-Gaji-{$guru->nama}-{$month}-{$year}.pdf");
    }

    private function generateSlipData($guru, $month, $year)
    {
        $allKategori = KategoriAbsensi::all();

        // Get all validated absensi
        $absensiList = Absensi::with(['absenKelas', 'kategoriAbsensi'])
            ->where('guru_id', $guru->id)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $data = [];
        $total = 0;

        foreach ($allKategori as $kategori) {
            $gajiPerKehadiran = $kategori->gaji;

            // Filter absensi by this kategori
            $absensis = $absensiList->where('kategori_absensi_id', $kategori->id);

            $counts = ['H' => 0, 'S' => 0, 'I' => 0, 'T' => 0];

            foreach ($absensis as $absen) {
                if ($absen->jenis === 'H') {
                    $counts['H'] += $absen->absenKelas->count(); // ✅ Hitung berdasarkan kelas
                } elseif (in_array($absen->jenis, ['S', 'I', 'T'])) {
                    $counts[$absen->jenis]++;
                }
            }

            $jumlah = $counts['H'] * $gajiPerKehadiran;

            $data[] = [
                'kategori' => $kategori->nama,
                'counts' => $counts,
                'gaji_per_kehadiran' => $gajiPerKehadiran,
                'jumlah' => $jumlah,
            ];

            $total += $jumlah;
        }

        return [$data, $total];
    }
}
