@extends('layouts.main')

@section('content')
<p><strong>Nama Guru:</strong> {{ $pinjaman->guru->nama }}</p>
<p><strong>Tanggal:</strong> {{ $pinjaman->tanggal_pengajuan }}</p>
<p><strong>Jumlah Pinjaman:</strong> Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</p>
<p><strong>Keterangan:</strong> {{ $pinjaman->pesan ?? '-' }}</p>

<hr>
<h6>Data Pengembalian</h6>

<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pinjaman->pengembalian as $peng)
        <tr>
            <td>{{ $peng->tanggal }}</td>
            <td>Rp {{ number_format($peng->jumlah, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2" class="text-center text-muted">Belum ada pengembalian</td>
        </tr>
        @endforelse
    </tbody>
</table>

@php
$totalBayar = $pinjaman->pengembalian->sum('jumlah');
$sisa = $pinjaman->jumlah - $totalBayar;
@endphp

@if ($pinjaman->status === 'disetujui')
@if ($sisa <= 0) <div class="alert alert-success mt-3">Pinjaman sudah lunas.</div>
    @else
    <hr>
    <h6>Tambah Pengembalian</h6>
    <form method="POST" action="{{ route('admin.pinjaman.pengembalian.store', $pinjaman) }}">
        @csrf
        <div class="mb-2">
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-2">
            <input type="number" name="jumlah" class="form-control" placeholder="Jumlah pengembalian" required>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
    </form>
    @endif

    @elseif ($pinjaman->status === 'menunggu')
    <div class="alert alert-warning mt-3">Pinjaman masih menunggu persetujuan.</div>
    <div class="d-flex gap-2 mt-3">
        <form method="POST"
            action="{{ route('admin.pinjaman.update.status', ['pinjaman' => $pinjaman->id, 'status' => 'disetujui']) }}">
            @csrf
            @method('PUT')
            <button class="btn btn-success">Setujui</button>
        </form>
        <form method="POST"
            action="{{ route('admin.pinjaman.update.status', ['pinjaman' => $pinjaman->id, 'status' => 'ditolak']) }}">
            @csrf
            @method('PUT')
            <button class="btn btn-danger">Tolak</button>
        </form>
    </div>

    @elseif ($pinjaman->status === 'ditolak')
    <div class="alert alert-danger mt-3">Pinjaman telah ditolak.</div>
    @endif

    @endsection