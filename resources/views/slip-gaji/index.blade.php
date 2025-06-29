@extends('layouts.main')

@section('content')

<!-- Filter Section -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4 col-sm-6">
                <label for="month" class="form-label">Bulan</label>
                <select name="month" id="month" class="form-select">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4 col-sm-6">
                <label for="year" class="form-label">Tahun</label>
                <select name="year" id="year" class="form-select">
                    @for ($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4 col-sm-12">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Download Button -->
<div class="text-end mb-3">
    <a href="{{ route('slip-gaji.download', ['month' => $month, 'year' => $year]) }}" class="btn btn-outline-danger" target="_blank">
        <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
    </a>
</div>

<!-- Gaji Slip Card -->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div><strong>Nama Guru:</strong> {{ $guru->nama ?? '-' }}</div>
            <div><strong>Bulan:</strong> {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th rowspan="2">Honor</th>
                        <th colspan="4">Kehadiran</th>
                        <th rowspan="2">Gaji / Kehadiran</th>
                        <th rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <th>H</th>
                        <th>S</th>
                        <th>I</th>
                        <th>T</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item['kategori'] }}</td>
                            <td>{{ $item['counts']['H'] }}</td>
                            <td>{{ $item['counts']['S'] }}</td>
                            <td>{{ $item['counts']['I'] }}</td>
                            <td>{{ $item['counts']['T'] }}</td>
                            <td>Rp {{ number_format($item['gaji_per_kehadiran'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="table-info fw-bold">
                        <td colspan="6" class="text-end">Jumlah Diterima</td>
                        <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
