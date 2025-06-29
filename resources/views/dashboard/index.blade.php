@extends('layouts.main')

@section('content')

<div class="mb-4">
    <h4 class="fw-semibold">Selamat datang, <strong>{{ auth()->user()->name }}</strong> 👋</h4>
    <p class="text-muted">Berikut adalah status kehadiran Anda hari ini dan ringkasan bulan ini.</p>
</div>

<div class="row g-4">

    <!-- STATUS ABSEN HARI INI -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="mb-3 text-uppercase text-muted">Status Absen Hari Ini</h6>
                @if(!$sudahAbsen)
                    <div class="mb-2 fs-5 fw-semibold">Belum Absen</div>
                    <a href="{{ route('absensi.create') }}" class="btn btn-outline-primary btn-sm">
                        Absen Sekarang
                    </a>
                @else
                    <div class="mb-2 fs-5 text-success fw-semibold">
                        Sudah Absen ({{ ucfirst($statusAbsen) }})
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- RINGKASAN BULAN INI -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="mb-3 text-uppercase text-muted">Ringkasan Bulan Ini</h6>
                <div class="d-flex justify-content-around text-center">
                    <div>
                        <div class="fs-5 fw-bold">{{ $summary['H'] ?? 0 }}</div>
                        <small class="text-muted">Hadir</small>
                    </div>
                    <div>
                        <div class="fs-5 fw-bold">{{ $summary['S'] ?? 0 }}</div>
                        <small class="text-muted">Sakit</small>
                    </div>
                    <div>
                        <div class="fs-5 fw-bold">{{ $summary['I'] ?? 0 }}</div>
                        <small class="text-muted">Izin</small>
                    </div>
                    <div>
                        <div class="fs-5 fw-bold">{{ $summary['T'] ?? 0 }}</div>
                        <small class="text-muted">Tanpa Keterangan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
