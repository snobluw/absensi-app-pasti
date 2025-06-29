@extends('layouts.main')
@section('content')
<div class="row g-3">

    <?php foreach ($data_sekolah as $index => $data): ?>
    <div class="col-6">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <h2 class="card-title fw-bold">
                    <?= $data['jumlah'] ?>
                </h2>
                <p class="card-text">
                    <?= $data['data-name'] ?>
                </p>
            </div>
            <div class="card-footer bg-success ?> border-0">
                <a href={{ $data['name'] }} class="text-white text-decoration-none">
                    Lihat detail ➔
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</div>
@endsection