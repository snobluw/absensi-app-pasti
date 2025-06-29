<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Support\Facades\Auth;

class GuruPinjamanController extends Controller
{

    public function show(Pinjaman $pinjaman)
    {
        $guru = Auth::user()->guru;
        $title = 'Detail Pinjaman';
        // Prevent access to other's data
        if ($pinjaman->guru_id !== $guru->id) {
            abort(403, 'Unauthorized access to pinjaman.');
        }

        $pengembalians = $pinjaman->pengembalian()->latest()->get();

        return view('guru.pinjaman.show', compact('title', 'pinjaman', 'pengembalians'));
    }
}
