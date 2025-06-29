@extends('layouts.main')

@section('content')

@if (session('success-avatar'))
<div id="custom-notification" class="position-fixed top-0 start-50 translate-middle-x mt-3 z-3"
    style="min-width: 300px;">
    <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
        <strong>Sukses!</strong> {{ session('success-avatar') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<div class="container my-3">

    <!-- Profile Header -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <div class="position-relative d-inline-block">

                {{-- Avatar Image --}}
                @if (auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="rounded-circle"
                    style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;"
                    onclick="document.getElementById('avatarInput').click()" id="avatarImage">
                @else
                <img src="https://avatar.iran.liara.run/public/boy" alt="Avatar" class="rounded-circle"
                    style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;"
                    onclick="document.getElementById('avatarInput').click()" id="avatarImage">
                @endif

                {{-- Loading Spinner --}}
                <div id="avatarLoading"
                    class="position-absolute top-0 start-0 w-100 h-100 d-none d-flex align-items-center justify-content-center"
                    style="background-color: rgba(255, 255, 255, 0.75); z-index: 10; border-radius: 50%;">

                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                {{-- Hidden File Input --}}
                <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST"
                    enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    @method('PUT')
                    <input type="file" name="avatar" id="avatarInput" class="d-none"
                        accept="image/png, image/jpeg, image/jpg" onchange="submitWithLoading()">
                </form>
            </div>
            <h5 class="mt-3">{{ $profile->nama }}</h5>
            <p class="text-muted">{{ '@' . auth()->user()->username }}</p>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs justify-content-center" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
                    role="tab">
                    Info
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button"
                    role="tab">
                    Settings
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="profileTabContent">
        <!-- Info Tab -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Profile Info</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $profile->nama }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ auth()->user()->email }}">
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Settings Tab -->
        <div class="tab-pane fade" id="settings" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Pengaturan Akun</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.settings') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control"
                                value="{{ auth()->user()->username }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function submitWithLoading() {
        document.getElementById('avatarLoading').classList.remove('d-none');
        document.getElementById('avatarForm').submit();
    }
</script>
@endsection