@extends('layouts.main')

@section('content')

@if (session('success-absen'))
<div id="custom-notification" class="position-fixed top-0 start-50 translate-middle-x mt-3 z-3"
    style="min-width: 300px;">
    <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
        <strong>Sukses!</strong> {{ session('success-absen') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if (session('error-absen'))
<div id="custom-notification" class="position-fixed top-0 start-50 translate-middle-x mt-3 z-3"
    style="min-width: 300px;">
    <div class="alert alert-warning alert-dismissible fade show shadow" role="alert">
        <strong>Gagal!</strong> {{ session('error-absen') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif


<div class="card shadow">

    <div class="card mb-3 border-0 bg-light">
        <div class="card-header bg-primary text-white border-bottom d-flex align-items-center">
            <h5 class="mb-0">
                @if($existingAbsensi === 0)
                <span>Absen Masuk</span>

                @else
                <span>Absen Pulang</span>

                @endif
            </h5>
        </div>
    </div>

    <div class="card-body">

        <form action="/absensi" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Ambil Foto Kehadiran</label>

                <div class="d-flex justify-content-center">
                    <!-- Camera Wrapper -->
                    <div id="cameraWrapper" class="ratio ratio-4x3" style="max-width: 400px; width: 100%;">
                        <video id="camera" class="w-100 h-100 object-fit-cover rounded" autoplay playsinline></video>
                    </div>

                    <!-- Canvas Preview Wrapper -->
                    <div id="previewWrapper" class="ratio ratio-4x3 d-none" style="max-width: 400px; width: 100%;">
                        <canvas id="snapshot" class="w-100 h-100 rounded"></canvas>
                    </div>
                </div>

                <div class="text-center mt-2">
                    <button type="button" class="btn btn-sm btn-warning" id="takePhotoBtn" onclick="takePhoto()">Ambil
                        Foto</button>
                    <button type="button" class="btn btn-sm btn-secondary d-none" id="retakePhotoBtn"
                        onclick="retakePhoto()">Ulangi Foto</button>
                </div>

                <input type="hidden" name="photo_data" id="photo_data">
            </div>

            <div class="mb-3">
                <label for="kategori_absensi_id" class="form-label">Kategori Absensi</label>
                <select class="form-select" name="kategori_absensi_id" id="kategori_absensi_id" required>
                    @foreach ($kategori as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>

            @if($existingAbsensi > 0)
            <div class="mb-3">
                <label class="form-label">Pilih Kelas yang Dihadiri</label>
                <div id="kelasContainer">
                    <div class="d-flex mb-2 kelas-select-group">
                        <select name="kelas_id[]" class="form-select me-2" required>
                            @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-danger btn-sm remove-kelas">×</button>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="addKelasBtn">+ Tambah Kelas</button>
            </div>
            @else
            <div class="mb-3">
                <label for="jenis_absen" class="form-label">Jenis Absen</label>
                <select name="jenis_absen" id="jenis_absen" class="form-select" required>
                    <option value="H">✅ Hadir</option>
                    <option value="S">🤒 Sakit</option>
                    <option value="I">📩 Izin</option>
                </select>
            </div>

            <div class="mb-3 d-none" id="keteranganContainer">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="2"
                    placeholder="Tulis keterangan..."></textarea>
            </div>


            @endif
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
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

         const jenisSelect = document.getElementById('jenis_absen');
    const keteranganContainer = document.getElementById('keteranganContainer');

    function toggleKeterangan() {
      const selected = jenisSelect.value;
      if (selected === 'H') {
        keteranganContainer.classList.add('d-none');
      } else {
        keteranganContainer.classList.remove('d-none');
      }
    }

    jenisSelect.addEventListener('change', toggleKeterangan);
    toggleKeterangan(); // Trigger on page load

        
    });

    const video = document.getElementById('camera');
    const canvas = document.getElementById('snapshot');
    const photoData = document.getElementById('photo_data');

    const cameraWrapper = document.getElementById('cameraWrapper');
    const previewWrapper = document.getElementById('previewWrapper');
    const takeBtn = document.getElementById('takePhotoBtn');
    const retakeBtn = document.getElementById('retakePhotoBtn');

    let stream = null;

    function startCamera() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((mediaStream) => {
                stream = mediaStream;
                video.srcObject = mediaStream;
                video.play();
                cameraWrapper.classList.remove('d-none');
                previewWrapper.classList.add('d-none');
                takeBtn.classList.remove('d-none');
                retakeBtn.classList.add('d-none');
            })
            .catch((err) => {
                alert('Tidak dapat mengakses kamera: ' + err.message);
            });
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    }

    function takePhoto() {
        const context = canvas.getContext('2d');

        // Optional: Resize to reduce final size (e.g., 640x480)
        canvas.width = 640;
        canvas.height = 480;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Use JPEG with compression (quality between 0 and 1)
        const imageData = canvas.toDataURL('image/jpeg', 0.7);

        photoData.value = imageData;

        cameraWrapper.classList.add('d-none');
        previewWrapper.classList.remove('d-none');
        takeBtn.classList.add('d-none');
        retakeBtn.classList.remove('d-none');

        console.log('Image size:', Math.round(imageData.length * (3 / 4) / 1024), 'KB');

        stopCamera();
    }

    function retakePhoto() {
        startCamera();
    }

    window.addEventListener('DOMContentLoaded', startCamera);

 document.getElementById('addKelasBtn').addEventListener('click', function () {
  const container = document.getElementById('kelasContainer');
  const template = container.querySelector('.kelas-select-group');
  const clone = template.cloneNode(true);

  // Clear selection
  clone.querySelector('select').selectedIndex = 0;

  // Add remove handler
  clone.querySelector('.remove-kelas').addEventListener('click', function () {
    clone.remove();
  });

  container.appendChild(clone);
});

// Initial remove button
document.querySelectorAll('.remove-kelas').forEach(button => {
  button.addEventListener('click', function () {
    this.closest('.kelas-select-group').remove();
  });
});

</script>

@endsection