@extends('layouts.main')

@section('content')


<div class="card shadow">
    <div class="card-header text-white d-flex justify-content-between align-items-center"
        style="background-color: #495057">
        <h5 class="mb-0">Tambah Data Admin</h5>
    </div>
    <div class="card-body">
        <form action="/admin" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="gender" id="gender" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            {{-- NIP --}}
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="nip" name="nip">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" type="checkbox" id="no_nip_checkbox">
                        <label for="no_nip_checkbox" class="ms-2 mb-0">Tidak punya</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" maxlength="20">
                <div id="username-feedback" class="form-text pt-2"></div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>


{{-- Script to disable inputs if checkbox is checked --}}
<script>
    document.getElementById('no_nip_checkbox').addEventListener('change', function () {
        const input = document.getElementById('nip');
        input.disabled = this.checked;
        if (this.checked) input.value = '';
    });

    document.getElementById('no_nuptk_checkbox').addEventListener('change', function () {
        const input = document.getElementById('nuptk');
        input.disabled = this.checked;
        if (this.checked) input.value = '';
    });

    document.getElementById('username').addEventListener('input', function () {
    const username = this.value;
    const feedback = document.getElementById('username-feedback');

    // Check for space
    if (/\s/.test(username)) {
        feedback.textContent = '❌ Username tidak boleh mengandung spasi';
        feedback.style.color = 'red';
        return;
    }

    // Check length
    if (username.length < 3) {
        feedback.textContent = '❌ Username minimal 3 karakter';
        feedback.style.color = 'red';
        return;
    }else if (username.length < 1) {
        feedback.textContent = '❌ Username tidak boleh kosong';
        feedback.style.color = 'red';
        return;
    }



    // AJAX to check if username is available
    fetch(`/check-username?username=${encodeURIComponent(username)}`)
        .then(res => res.json())
        .then(data => {
            if (data.available) {
                feedback.textContent = '✅ Username tersedia';
                feedback.style.color = 'green';
            } else {
                feedback.textContent = '❌ Username sudah dipakai';
                feedback.style.color = 'red';
            }
        });

        
});

</script>

@endsection