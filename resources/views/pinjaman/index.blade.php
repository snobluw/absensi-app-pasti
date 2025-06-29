@extends('layouts.main')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-3">Status Pengajuan Pinjaman</h5>
        @if($canApply)
        <div class="alert alert-success">
            Anda dapat mengajukan pinjaman.
            <a href="{{ route('pinjaman.downloadSurat') }}" class="btn btn-sm btn-outline-primary ms-2">📄 Download
                Surat Permohonan</a>
        </div>
        @else
        <div class="alert alert-warning">
            Anda telah mengajukan pinjaman sebelumnya. Anda dapat mengajukan kembali pada <strong>{{
                $nextAllowedDate->translatedFormat('d F Y') }}</strong>.
        </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header fw-bold">Riwayat Pengajuan Pinjaman</div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0 text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Pesan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $pinjaman)
                <tr>
                    <td>{{ $pinjaman->created_at->format('d-m-Y') }}</td>
                    <td>Rp. {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</td>
                    <td>
                        @if ($pinjaman->status !== 'disetujui')
                        <span class="badge bg-secondary text-capitalize">{{ $pinjaman->status }}</span>
                        @else
                        @php
                        $sisa = $pinjaman->jumlah - $pinjaman->pengembalian->sum('jumlah');
                        @endphp
                        @if ($sisa <= 0) <span class="badge bg-success">Lunas</span>
                            @else
                            <span class="badge bg-success text-light">Disetujui</span>
                            @endif
                            @endif
                    </td>
                    <td>
                        <a href="{{ route('guru.pinjaman.show', $pinjaman->id) }}"
                            class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">Belum ada pengajuan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection