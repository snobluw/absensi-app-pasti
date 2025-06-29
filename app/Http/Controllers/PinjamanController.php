<?php

namespace App\Http\Controllers;

use App\Models\Guru;

use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PinjamanController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $title = 'Pinjaman Admin';
            $pinjamanList = Pinjaman::with('guru')->latest()->get();
            return view('admin.pinjaman.index', compact('title', 'pinjamanList'));
        } else {

            $guru = auth()->user()->guru;

            // Get last pinjaman
            $lastPinjaman = $guru->pinjaman()->latest('created_at')->first();

            $canApply = true;
            $nextAllowedDate = null;

            if ($lastPinjaman) {
                $nextAllowedDate = $lastPinjaman->created_at->addMonths(6);
                $canApply = now()->gte($nextAllowedDate);
            }

            $riwayat = $guru->pinjaman()->orderBy('created_at', 'desc')->get();
            $title = 'Pinjaman Guru';
            return view('pinjaman.index', compact('title', 'guru', 'canApply', 'nextAllowedDate', 'riwayat'));
        }
    }
    public function updateStatus(Pinjaman $pinjaman, $status)
    {
        if (!in_array($status, ['disetujui', 'ditolak'])) {
            abort(400, 'Status tidak valid.');
        }

        $pinjaman->status = $status;
        $pinjaman->save();

        return redirect()->route('admin.pinjaman.show', $pinjaman)->with('success', 'Status pinjaman berhasil diperbarui.');
    }


    public function downloadSurat()
    {

        $guru = auth()->user()->guru;

        $pdf = Pdf::loadView('pinjaman.surat', compact('guru'));
        return $pdf->download('surat-permohonan-pinjaman.pdf');
    }

    public function create()
    {
        $title = 'Tambah Pinjaman';
        $guruList = Guru::all();
        return view('admin.pinjaman.create', compact('title', 'guruList'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tanggal_pengajuan' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'status' => 'required|in:menunggu,disetujui,ditolak',
        ]);

        Pinjaman::create([
            'guru_id' => $validated['guru_id'],
            'tanggal_pengajuan' => $validated['tanggal_pengajuan'],
            'jumlah' => $validated['jumlah'],
            'status' => $validated['status'],
            'pesan' => $request->input('pesan', null),
        ]);

        return redirect()->route('pinjaman.index')->with('success', 'Pinjaman berhasil disimpan.');
    }

    public function show(Pinjaman $pinjaman)
    {
        $title = 'Detail Pinjaman';
        $pinjaman->load('guru', 'pengembalian');
        return view('admin.pinjaman.show', compact('title', 'pinjaman'));
    }

    public function destroy(Pinjaman $pinjaman)
{
    $pinjaman->pengembalian()->delete(); // Optional: remove associated pengembalian
    $pinjaman->delete();

    return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil dihapus.');
}

}
