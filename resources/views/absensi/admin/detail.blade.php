@extends('layouts.main')

@section('content')

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Aksi</th> {{-- for validation --}}
        </tr>
    </thead>
    <tbody>
        @for($day = 1; $day <= $end->day; $day++)
            @php
                $tanggal = \Carbon\Carbon::create($year, $month, $day)->toDateString();
                $absen = $absensi->firstWhere('tanggal', $tanggal);

                $jenis = optional($absen)->jenis;
                $status = optional($absen)->status_validasi;

                switch ($jenis) {
                    case 'H': $label = '✅ Hadir'; break;
                    case 'I': $label = '📩 Izin'; break;
                    case 'S': $label = '🤒 Sakit'; break;
                    case 'T': $label = '❌ Tanpa Keterangan'; break;
                    default: $label = '❓ Tidak Ada Data'; break;
                }
            @endphp

            <tr>
                <td>{{ $tanggal }}</td>
                <td>{{ $label }}</td>
                <td>
                    @if($absen && $status !== 'V')
                    <form method="POST" action="{{ route('absensi.validate', $absen->id) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary">Validasi</button>
                    </form>
                    @elseif($status === 'V')
                    <span class="badge bg-success">Tervalidasi</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
        @endfor
    </tbody>
</table>


@endsection