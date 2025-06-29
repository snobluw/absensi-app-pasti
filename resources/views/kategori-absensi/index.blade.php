@extends('layouts.main')

@section('content')

@if (session('success-tambah'))
<div id="custom-notification" class="position-fixed top-0 start-50 translate-middle-x mt-3 z-3"
  style="min-width: 300px;">
  <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
    <strong>Sukses!</strong> {{ session('success-tambah') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
@endif

@if (session('success-edit'))
<div id="custom-notification" class="position-fixed top-0 start-50 translate-middle-x mt-3 z-3"
  style="min-width: 300px;">
  <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
    <strong>Sukses!</strong> {{ session('success-edit') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
  <a href="guru/create" class="btn btn-primary">+ Tambah</a>

  {{-- Search input --}}
  <form action="/kategori-absensi">
    <div class="input-group" style="max-width: 300px;">
      <button class="btn btn-primary" type="submit">
        <i class="bi bi-search"></i>
      </button>
      <input type="text" name="search" class="form-control" placeholder="Cari...">
    </div>
  </form>
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped" id="guru-table">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Nama</th>
      <th>Gaji</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($kategori_absensi as $index => $kategori)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ $kategori->nama }}</td>
      <td>{{ $kategori->gaji }}</td>
    
      <td>
        <div class="d-flex gap-1 justify-content-center">
          <a href="/kategori-absensi/{{ $kategori->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
            <i class="bi bi-pencil"></i>
          </a>
          <form action="/kategori-absensi/{{ $kategori->id }}" method="POST">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger btn-sm" title="Delete"
              onclick="return confirm('Yakin ingin menghapus data ini?')">
              <i class="bi bi-trash"></i>
          </form>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

<div class="d-flex justify-content-center mt-3">
  {{ $kategori_absensi->links() }}
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
      const notification = document.getElementById('custom-notification');
      if (notification) {
          setTimeout(() => {
              const alert = bootstrap.Alert.getOrCreateInstance(notification.querySelector('.alert'));
              alert.close();
          }, 3000); // 3 seconds
      }
  });
</script>

@endsection