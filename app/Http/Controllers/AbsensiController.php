<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Absensi;
use App\Models\AbsenKelas;
use Illuminate\Http\Request;
use App\Models\KategoriAbsensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kategoriId = $request->query('kategori');
        $month = $request->query('month', now()->month); // default: current month
        $year = $request->query('year', now()->year);    // default: current year



        $start = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $end = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();

        $absensis = Absensi::with(['guru', 'kategoriAbsensi'])
            ->where('kategori_absensi_id', $kategoriId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $selectedDay = request('day', now()->day); // default to today
        $tanggalSelected = \Carbon\Carbon::create($year, $month, $selectedDay)->toDateString();

        return view('absensi.admin.index', [
            'title' => 'Data Absensi ' . optional(KategoriAbsensi::find($kategoriId))->nama,
            'guru' => Guru::all(),
            'absensi' => $absensis,
            'selectedDay' => $selectedDay,
            'tanggalSelected' => $tanggalSelected,
            'month' => $month,
            'year' => $year,
            'kategoriId' => $kategoriId,
        ]);
    }

    public function indexKategori()
    {
        return view(
            'absensi.admin.kategori-index',
            [
                'title' => 'Kategori Absensi',
                'kategori_absensis' => KategoriAbsensi::all()
            ]
        );
    }

    public function validateAbsen(Absensi $absensi)
    {
        $absensi->status_validasi = 'Y';
        $absensi->save();

        return back()->with('success', 'Absensi berhasil divalidasi.');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tanggal = \Carbon\Carbon::now()->toDateString();

        $kelasList = \App\Models\Kelas::all(); // only needed on pulang
        $kategori = KategoriAbsensi::all();
        $title = 'Absensi Guru';

        $user = auth()->user();
        $guru = $user->guru;

        $existingAbsensi = \App\Models\Absensi::where('guru_id', $guru->id)
            ->whereDate('tanggal', $tanggal)
            ->count();

        return view('absensi.guru.create', compact('title', 'kategori', 'existingAbsensi', 'kelasList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAbsensiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_absensi_id' => 'required|exists:kategori_absensis,id',
            'photo_data' => 'required|string', // validate image string
        ]);

        $user = auth()->user();
        $guru = $user->guru;
        $tanggal = \Carbon\Carbon::now()->toDateString();

        // ✅ Cek duplikat absensi
        $existing = \App\Models\Absensi::where('guru_id', $guru->id)
            ->where('kategori_absensi_id', $request->kategori_absensi_id)
            ->whereDate('tanggal', $tanggal)
            ->count();

        if ($existing > 1) {
            return redirect()->back()->with('error-absen', 'Anda sudah absen untuk kategori ini hari ini.');
        }

        $jenisKehadiran = $request->jenis_absen;

        if ($existing === 0) {
            $jenisAbsen = 'M'; // Default to 'M' for masuk
        } else {
            $jenisAbsen = 'P'; // Default to 'P' for pulang
            $jenisKehadiran = 'H';
        }

        // ✅ Decode and store the image
        $photoData = $request->input('photo_data');
        $photoData = preg_replace('/^data:image\/\w+;base64,/', '', $photoData);
        $photoData = str_replace(' ', '+', $photoData);

        $imageName = $guru->id . '_absensi_' . time() . '.jpg';
        $path = 'absensi/' . $imageName;

        Storage::put($path, base64_decode($photoData));

        // ✅ Simpan absensi
        $absensi = Absensi::create([
            'guru_id' => $guru->id,
            'kategori_absensi_id' => $request->kategori_absensi_id,
            'tanggal' => $tanggal,
            'jenis' => $jenisKehadiran,
            'jenis_absensi' => $jenisAbsen,
            'bukti_photo' => 'absensi/' . $imageName, // Simpan path relative ke storage
            'status_validasi' => 'M'
        ]);

        foreach ($request->input('kelas_id', []) as $kelasId) {
            AbsenKelas::create([
                'absensi_id' => $absensi->id,
                'kelas_id' => $kelasId,
            ]);
        }

        return redirect()->back()->with('success-absen', 'Absensi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(Guru $guru, Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $start = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $end = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();

        $absensis = Absensi::where('guru_id', $guru->id)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        return view('absensi.admin.detail', [
            'guru' => $guru,
            'absensi' => $absensis,
            'month' => $month,
            'year' => $year,
            'end' => $end,
            'start' => $start,
            'title' => 'Detail Absensi ' . $guru->nama, // ✅ This line fixes the issue
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAbsensiRequest  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absensi $absensi) {}

    public function validateAbsensi(Request $request, Absensi $absensi)
    {

        $tanggal = $absensi->tanggal;
        $guruId = $absensi->guru_id;


        // Update all absensi for the same guru and date
        $updatedCount = Absensi::where('tanggal', $tanggal)
            ->where('guru_id', $guruId)
            ->where('status_validasi', '!=', 'Y')
            ->update([
                'status_validasi' => 'Y',
                'admin_id' => auth()->admin->id,
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', "$updatedCount absensi berhasil divalidasi untuk tanggal $tanggal.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        //
    }
}
