@extends('layouts.main')

@section('content')
<h5 class="mb-3">Tambah Pinjaman Guru</h5>

<form method="POST" action="{{ route('admin.pinjaman.store') }}">
    @csrf

    <div class="mb-3">
        <label for="guru_id">Guru</label>
        <select name="guru_id" class="form-select" required>
            <option value="">-- Pilih Guru --</option>
            @foreach($guruList as $guru)
            <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="tanggal_pengajuan">Tanggal</label>
        <input type="date" name="tanggal_pengajuan" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="jumlah">Jumlah Pinjaman</label>
        <input type="number" name="jumlah" class="form-control" required>
    </div>

    <label for="status">Status</label>
    <select name="status" class="form-select" required>
        <option value="menunggu">Menunggu</option>
        <option value="disetujui">Disetujui</option>
        <option value="ditolak">Ditolak</option>
    </select>

    <div class="mb-3">
        <label for="pesan">Pesan (opsional)</label>
        <textarea name="pesan" class="form-control" rows="2"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
</form>
@endsection