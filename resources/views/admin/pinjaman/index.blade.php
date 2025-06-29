@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Daftar Pinjaman</h5>
    <a href="{{ route('admin.pinjaman.create') }}" class="btn btn-primary">+ Tambah Pinjaman</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Guru</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pinjamanList as $item)
        <tr>
            <td>{{ $item->guru->nama }}</td>
            <td>{{ $item->tanggal_pengajuan }}</td>
            <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
            <td>
                @if ($item->status !== 'disetujui')
                <span class="badge bg-secondary text-capitalize">{{ $item->status }}</span>
                @else
                @php
                $sisa = $item->jumlah - $item->pengembalian->sum('jumlah');
                @endphp
                @if ($sisa <= 0) <span class="badge bg-success">Lunas</span>
                    @else
                    <span class="badge bg-warning text-dark">Sisa: Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                    @endif
                    @endif
            </td>
            <td class="d-flex gap-1">
                <a href="{{ route('admin.pinjaman.show', $item) }}" class="btn btn-sm btn-info">Detail</a>

                <form action="{{ route('admin.pinjaman.destroy', $item) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pinjaman ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endsection