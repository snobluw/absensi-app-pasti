@extends('layouts.main')

@section('content')

@php
$month = request('month', $month ?? now()->month);
$year = request('year', $year ?? now()->year);
$kategoriId = request('kategori');

$start = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfMonth();
$end = \Carbon\Carbon::createFromDate($year, $month, 1)->endOfMonth();

$sundays = collect(Carbon\CarbonPeriod::create($start, $end))
->filter(fn ($date) => $date->isSunday())
->map(fn ($date) => $date->format('Y-m-d'));
@endphp

<!-- Filter form -->
<form method="GET" class="row g-3 mb-4">
  <div class="col-12 col-md-4">
    <label for="kategori" class="form-label">Kategori Absensi</label>
    <select id="kategori" name="kategori" class="form-select">
      @foreach(\App\Models\KategoriAbsensi::all() as $kategori)
      <option value="{{ $kategori->id }}" {{ request('kategori')==$kategori->id ? 'selected' : '' }}>
        {{ $kategori->nama }}
      </option>
      @endforeach
    </select>
  </div>


  <!-- Only show on mobile -->
  <div class="col-6 d-block d-md-none">
    <label for="day" class="form-label">Tanggal</label>
    <select id="day" name="day" class="form-select">
      @for($d = 1; $d <= $end->day; $d++)
        <option value="{{ $d }}" {{ request('day', now()->day) == $d ? 'selected' : '' }}>
          {{ str_pad($d, 2, '0', STR_PAD_LEFT) }}
        </option>
        @endfor
    </select>
  </div>

  <div class="col-6 col-md-3">
    <label for="month" class="form-label">Bulan</label>
    <select id="month" name="month" class="form-select">
      @for($m = 1; $m <= 12; $m++) <option value="{{ $m }}" {{ $m==$month ? 'selected' : '' }}>
        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
        </option>
        @endfor
    </select>
  </div>

  <div class="col-6 col-md-3">
    <label for="year" class="form-label">Tahun</label>
    <select id="year" name="year" class="form-select">
      @for($y = now()->year; $y >= 2020; $y--)
      <option value="{{ $y }}" {{ $y==$year ? 'selected' : '' }}>{{ $y }}</option>
      @endfor
    </select>
  </div>

  <div class="col-12 col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">Terapkan</button>
  </div>
</form>

<!-- photo overlay -->
<div id="photoOverlay"
  style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.8); z-index:2000; justify-content:center; align-items:center;">
  <span onclick="closeOverlay(event)"
    style="position:absolute; top:20px; right:30px; color:white; font-size:30px; cursor:pointer;">&times;</span>
  <img id="overlayImage" src="" alt="Bukti Foto" style="max-width:90%; max-height:90%; border-radius:10px;">
</div>

<!-- Modal -->
<div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="absensiModalLabel">Detail Absensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Guru</label>
          <div class="col-sm-8" id="modalGuru"></div>
        </div>

        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Jenis</label>
          <div class="col-sm-8" id="modalJenis"></div>
        </div>

        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Tanggal</label>
          <div class="col-sm-8" id="modalTanggal"></div>
        </div>

        <hr>

        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Absen Masuk</label>
        </div>

        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Waktu</label>
           <div class="col-sm-8" id="modalWaktuMasuk"></div>
        </div>

        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Bukti Foto</label>
          <div class="col-sm-8" id="modalPhotoLinkContainer"></div>
        </div>


        <hr>

        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Absen Keluar</label>
        </div>

        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Waktu</label>
        </div>

        <div class="mb-2 row">
          <label class="col-sm-4 fw-bold">Bukti Foto</label>
          <div class="col-sm-8" id="modalPhotoLinkContainer"></div>
        </div>
      </div>
      <div class="modal-footer">
        <form id="validateForm" method="POST" action="">
          @csrf
          @method('PUT')
          <button type="submit" class="btn btn-primary">Validasi</button>
        </form>
      </div>

    </div>
  </div>
</div>


<div class="card mb-4">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-4"><strong>Tahun Pelajaran</strong> : 2024/2025</div>
      <div class="col-md-4"><strong>Semester</strong> : Ganjil</div>
      <div class="col-md-4"><strong>Bulan</strong> : {{ $month }} 2025</div>
    </div>
    <div class="d-none d-md-block">
      <!-- your existing table layout here -->

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="table-primary" style="top:0; z-index:2;">
            <tr>
              <th>#</th>
              <th>Nama Guru</th>
              <th>NIP</th>
              {{-- loop dates --}}
              @for($day = 1; $day <= $end->day; $day++)
                @php
                $date = $start->copy()->day($day);
                $isSunday = $sundays->contains($date->format('Y-m-d'));
                @endphp
                <th class="text-center {{ $isSunday ? 'bg-danger' : '' }} ">{{ str_pad($day,2,'0',STR_PAD_LEFT) }}
                </th>
                @endfor
            </tr>
          </thead>
          <tbody>
            @foreach($guru as $i => $guruItem)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $guruItem->nama }}</td>

              @if($guruItem->nip == null)
              <td class="text-center">-</td>
              @else
              <td>{{ $guruItem->nip }}</td>
              @endif

              {{-- for each day, output two cells --}}
              @for($day = 1; $day <= $end->day; $day++)
                @php
                $tanggal = \Carbon\Carbon::create($year, $month, $day)->toDateString();

                $matched = collect($absensi)->first(function ($item) use ($guruItem, $tanggal) {
                return $item->guru_id == $guruItem->id && $item->tanggal === $tanggal;
                });


                $date = $start->copy()->day($day);
                $isSunday = $sundays->contains($date->format('Y-m-d'));


                $jenis = $matched ? $matched->jenis : null;
                $status = $matched ? $matched->status_validasi : null;
                $absensi_data = $matched ? $matched: null;

                $jenisLabels = [
                'H' => 'Hadir',
                'I' => 'Izin',
                'S' => 'Sakit',
                'T' => 'Tanpa Keterangan',
                ];

                @endphp
                <td class="{{ $isSunday ? 'bg-danger' : '' }} p-0 text-center"
                  style="width:2rem; height:2rem; cursor: pointer;" @if($absensi_data) data-bs-toggle="modal"
                  data-bs-target="#absensiModal" data-id="{{ $absensi_data->id }}"
                  data-guru="{{ $absensi_data->guru->nama }}" data-tanggal="{{ $absensi_data->tanggal }}"
                  data-jenis="{{ $jenisLabels[$jenis] }}" data-photo="{{ $absensi_data->bukti_photo }}" data-waktu-masuk="{{ \Carbon\Carbon::parse($absensi_data->created_at)->format('H:i') }}" @endif>   

                  @if($status === 'M')
                  <span class="badge bg-light text-dark">M</span>
                  @else
                  @if($jenis === 'H')
                  <span class="badge bg-success text-dark">H</span>
                  @elseif($jenis === 'I')
                  <span class="badge bg-warning text-dark">I</span>
                  @elseif($jenis === 'T')
                  <span class="badge bg-danger text-dark">T</span>
                  @elseif($jenis === 'S')
                  <span class="badge bg-secondary text-dark">S</span>
                  @endif
                  @endif

                </td>
                @endfor
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-block d-md-none">
      @foreach($guru as $guruItem)
      @php
      $matched = collect($absensi)->first(fn($item) =>
      $item->guru_id == $guruItem->id && $item->tanggal === $tanggalSelected
      );

      $counts = ['H' => 0, 'I' => 0, 'S' => 0, 'T' => 0];
      if ($matched && isset($counts[$matched->jenis])) {
      $counts[$matched->jenis] = $matched->count();
      }
      @endphp

      <a href="{{ route('absensi.guru.show', ['guru' => $guruItem->id, 'month' => $month, 'year' => $year]) }}"
        class="text-decoration-none text-dark">
        <div class="card mb-3 shadow-sm">
          <div class="card-body p-3">
            <h5 class="card-title mb-1">{{ $guruItem->nama }}</h5>
            <p class="mb-2 text-muted small"><strong>NIP:</strong> {{ $guruItem->nip ?? '-' }}</p>

            <div class="d-flex flex-wrap gap-2 small">
              <span class="badge bg-success flex-grow-1 text-center">✅ Hadir: {{ $counts['H'] }}</span>
              <span class="badge bg-warning text-dark flex-grow-1 text-center">📩 Izin: {{ $counts['I'] }}</span>
              <span class="badge bg-secondary flex-grow-1 text-center">🤒 Sakit: {{ $counts['S'] }}</span>
              <span class="badge bg-danger flex-grow-1 text-center">❌ Tanpa: {{ $counts['T'] }}</span>
            </div>
          </div>
        </div>
      </a>
      @endforeach
    </div>

  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const modal = document.getElementById('absensiModal');

      modal.addEventListener('show.bs.modal', function (event) {
          const td = event.relatedTarget;
          const id = td.getAttribute('data-id');
          const guru = td.getAttribute('data-guru');
          const tanggal = td.getAttribute('data-tanggal');
          const jenis = td.getAttribute('data-jenis');
          const waktuMasuk = td.getAttribute('data-waktu-masuk') || 'Tidak ada data';
          const photo = td.getAttribute('data-photo');

          document.getElementById('modalGuru').innerText = guru;
          document.getElementById('modalTanggal').innerText = tanggal;
          document.getElementById('modalJenis').innerText = jenis;
          document.getElementById('modalWaktuMasuk').innerText = waktuMasuk;

          const container = document.getElementById('modalPhotoLinkContainer');
          if (photo) {
              container.innerHTML = `<a href="javascript:void(0)" onclick="showPhotoOverlay('/storage/${photo}')">Lihat Foto</a>`;
          } else {
              container.innerText = 'Tidak ada foto';
          }

          // Example: dynamically set form action (adjust route as needed)
          const form = document.getElementById('validateForm');
          form.action = `/absensi/${id}/validate`;
      });
  });

  function showPhotoOverlay(photoUrl) {
      const overlay = document.getElementById('photoOverlay');
      const img = document.getElementById('overlayImage');
      img.src = photoUrl;
      overlay.style.display = 'flex';
  }

  function closeOverlay() {
      document.getElementById('photoOverlay').style.display = 'none';
  }
</script>

@endsection