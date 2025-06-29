<?php

namespace App\Http\Controllers;

use App\Models\KategoriAbsensi;
use App\Http\Requests\StoreKategoriAbsensiRequest;
use App\Http\Requests\UpdateKategoriAbsensiRequest;

class KategoriAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori-absensi.index', [
            'title' => 'Kategori Absensi',
            'kategori_absensi' => KategoriAbsensi::orderBy('nama', 'asc')->paginate(10)->withQueryString()
        ]);
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
     * @param  \App\Http\Requests\StoreKategoriAbsensiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKategoriAbsensiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoriAbsensi  $kategoriAbsensi
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriAbsensi $kategoriAbsensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriAbsensi  $kategoriAbsensi
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriAbsensi $kategoriAbsensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKategoriAbsensiRequest  $request
     * @param  \App\Models\KategoriAbsensi  $kategoriAbsensi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKategoriAbsensiRequest $request, KategoriAbsensi $kategoriAbsensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriAbsensi  $kategoriAbsensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriAbsensi $kategoriAbsensi)
    {
        //
    }
}
