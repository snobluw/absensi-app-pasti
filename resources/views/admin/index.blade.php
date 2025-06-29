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
  <a href="admin/create" class="btn btn-primary">+ Tambah</a>

  {{-- Search input --}}
  <form action="/admin">
    <div class="input-group" style="max-width: 300px;">
      <button class="btn btn-primary" type="submit">
        <i class="bi bi-search"></i>
      </button>
      <input type="text" name="search" class="form-control" placeholder="Cari...">
    </div>
  </form>

</div>

@if ($data_admin->isEmpty())
<div class="alert alert-warning" role="alert">
  Data admin tidak ditemukan.
</div>

@else

<table class="table table-bordered table-striped" id="admin-table">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Nama</th>
      <th>L/P</th>
      <th>NIP</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data_admin as $index => $admin)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $admin->nama }}</td>
        <td>{{ $admin->user->gender }}</td>
        <td>{{ $admin->nip }}</td>
        <td>
          <div class="d-flex gap-1">
            <a href="/admin/{{ $admin->id }}" class="btn btn-success btn-sm" title="View">
              <i class="bi bi-eye"></i>
            </a>
            <a href="/admin/{{ $admin->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
              <i class="bi bi-pencil"></i>
            </a>
            <form action="/admin/{{ $admin->id }}" method="POST">
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

@endif

<div class="d-flex justify-content-center mt-3">
  {{ $data_admin->links() }}
</div>

@endsection
