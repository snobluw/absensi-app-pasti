@extends('layouts.main')

@section('content')

<div class="position-relative">
    <div class="card shadow-sm d-flex col-12 col-md-12 col-lg-8 mx-auto mt-4">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
            style="background-color: #495057">
            <h5 class="mb-0">Edit Data</h5>
        </div>
        <div class="card-body">
            <form action="/guru/{{ $guru->id }}" method="POST" id="guru-form">
                @method('PUT')
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required
                        value="{{ old ('nama',$guru->nama) }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required
                        value="{{ old ('email',$guru->user->email) }}">
                </div>

                <div class="mb-3 col-6">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" name="gender" id="gender" required>
                        <option value="L" {{ $guru->user->gender === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $guru->user->gender === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- NIP --}}
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nip" name="nip"
                            value="{{ old ('nip',$guru->nip) }}">
                    </div>
                </div>

                {{-- NUPTK --}}
                <div class="mb-3">
                    <label for="nuptk" class="form-label">NUPTK</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nuptk" name="nuptk"
                            value="{{ old ('nuptk',$guru->nuptk) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" maxlength="20" value="{{ old ('username',$guru->user->username) }}">
                    <div id="username-feedback" class="form-text pt-0"></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        value="{{ old ('password') }}">
                </div>

                <div class="d-flex gap-2 justify-content-between mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" id="submitButton" class="btn btn-primary" disabled>
                        <span id="submitText">Simpan</span>
                        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>

            </form>
        </div>
        <!-- Loading overlay -->
        <div id="loadingOverlay"
            class="position-absolute d-flex w-100 h-100 d-none align-items-center justify-content-center bg-white bg-opacity-75 rounded">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>


{{-- Script to disable inputs if checkbox is checked --}}
<script>

    document.getElementById('username').addEventListener('input', function () {
    const username = this.value;
    let oldUsername = "{{ $guru->user->username }}";
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
            if (username === oldUsername) {
                feedback.textContent = '';
                return;
            }
            if (data.available) {
                feedback.textContent = '✅ Username tersedia';
                feedback.style.color = 'green';
            } else {
                feedback.textContent = '❌ Username sudah dipakai';
                feedback.style.color = 'red';
            }
        });
});

let form = document.getElementById('guru-form');
let submitButton = document.getElementById('submitButton');

// Store the initial values of the form fields
let initialValues = new FormData(form);

// Listen for changes in the form fields
form.addEventListener('input', function () {
    // Compare current form data with the initial values
    let formChanged = false;
    let currentValues = new FormData(form);

    // Check if any field value has changed
    for (let [key, value] of currentValues) {
        if (initialValues.get(key) !== value) {
            formChanged = true;
            break;
        }
    }

    // Enable/Disable the button based on form changes
    if (formChanged) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
});

    document.getElementById('guru-form').addEventListener('submit', function () {
        const submitButton = document.getElementById('submitButton');
        const submitText = document.getElementById('submitText');

        submitButton.disabled = true;            // Disable the button
        submitText.textContent = 'Menyimpan...'; // Change text (optional)
    });

    document.getElementById('guru-form').addEventListener('submit', function () {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    });

</script>

@endsection