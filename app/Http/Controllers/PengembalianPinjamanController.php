<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\PengembalianPinjaman;
use App\Http\Requests\StorePengembalianPinjamanRequest;
use App\Http\Requests\UpdatePengembalianPinjamanRequest;
use Illuminate\Http\Request;

class PengembalianPinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePengembalianPinjamanRequest  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengembalianPinjaman  $pengembalianPinjaman
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Pinjaman $pinjaman)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1000',
        ]);

        $pinjaman->pengembalian()->create($request->all());

        return redirect()->route('admin.pinjaman.show', $pinjaman)->with('success', 'Pengembalian berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengembalianPinjaman  $pengembalianPinjaman
     * @return \Illuminate\Http\Response
     */
    public function edit(PengembalianPinjaman $pengembalianPinjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePengembalianPinjamanRequest  $request
     * @param  \App\Models\PengembalianPinjaman  $pengembalianPinjaman
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePengembalianPinjamanRequest $request, PengembalianPinjaman $pengembalianPinjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengembalianPinjaman  $pengembalianPinjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy(PengembalianPinjaman $pengembalianPinjaman)
    {
        //
    }
}
