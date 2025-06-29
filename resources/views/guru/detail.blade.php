@extends('layouts.main')
@section('content')

<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nama : {{ $data_guru_single->nama }}</h5>
                <p class="card-text">Email: {{ $data_guru_single->user->email}}</p>
                <p class="card-text">NIP: {{ $data_guru_single->nip }}</p>
                <p class="card-text">NUPTK: {{ $data_guru_single->nuptk }}</p>
            </div>
        </div>
    </div>
</div>

@endsection