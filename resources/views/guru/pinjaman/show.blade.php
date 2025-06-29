@extends('layouts.main')

@section('content')

<ul class="list-group mb-3">
    <li class="list-group-item">Tanggal Pengajuan: <strong>{{ $pinjaman->tanggal_pengajuan }}</strong></li>
    <li class="list-group-item">Jumlah Pinjaman: <strong>Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</strong>
    </li>
    <li class="list-group-item">Status:
        @if ($pinjaman->status !== 'disetujui')
        <span class="badge bg-secondary text-capitalize">{{ $pinjaman->status }}</span>
        @if ($pinjaman->pesan)
      
        <div class="small text-muted mt-1">   <span class="badge bg-info">Pesan : </span> {{ $pinjaman->pesan }}</div>
        @endif
        @else
        @php
        $sisa = $pinjaman->jumlah - $pinjaman->pengembalian->sum('jumlah');
        @endphp
        @if ($sisa <= 0) <span class="badge bg-success">Lunas</span>
            @else
            <span class="badge bg-warning text-dark">Sisa: Rp {{ number_format($sisa, 0, ',', '.') }}</span>
            @endif
            @endif
    </li>
</ul>

<h5>Riwayat Pengembalian</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pengembalians as $pay)
        <tr>
            <td>{{ $pay->tanggal }}</td>
            <td>Rp {{ number_format($pay->jumlah, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2" class="text-center">Belum ada pengembalian</td>
        </tr>
        @endforelse
    </tbody>
</table>

<a href="/pinjaman" class="btn btn-secondary mt-2">← Kembali</a>
@endsection