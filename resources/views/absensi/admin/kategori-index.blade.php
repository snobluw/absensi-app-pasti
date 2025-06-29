@extends('layouts.main')
@section('content')
<div class="container p-3">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($kategori_absensis as $kategori)
            <div class="col">
                <a href="{{ route('absensi.index', ['kategori' => $kategori->id]) }}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $kategori->nama }}</h5>
                    </div>
                </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection