<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Pinjaman</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            line-height: 1.6;
            margin: 50px;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .mt-2 {
            margin-top: 1rem;
        }

        .indent {
            text-indent: 3em;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <img src="{{ public_path('img/logo-sekolah.png') }}" width="80" style="margin-bottom: 10px;">
        <h4>MTS CAHAYA HARAPAN</h4>
        <p>Jl. Pendidikan No. 123, Kota Edukasi</p>
    </div>
    <hr>
    <div class="text-center">
        <h3><u>SURAT PERMOHONAN PINJAMAN</u></h3>
        <p>Nomor: ....../...../.......</p>
    </div>

    <p>Yang bertanda tangan di bawah ini:</p>
    <table style="margin-left: 20px;">
        <tr>
            <td>Nama</td>
            <td>: {{ $guru->nama }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>: {{ $guru->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td>NUPTK</td>
            <td>: {{ $guru->nuptk ?? '-' }}</td>
        </tr>
    </table>

    <p>Untuk keperluan:</p>
    <div style="width: 100%;">
        <div style="border-bottom: 1px dotted #000; margin-bottom: 8px;">&nbsp;</div>
        <div style="border-bottom: 1px dotted #000; margin-bottom: 8px;">&nbsp;</div>
        <div style="border-bottom: 1px dotted #000;">&nbsp;</div>
    </div>

    <p class="indent">
        Saya bersedia untuk mengembalikan pinjaman tersebut sesuai dengan ketentuan dan kesepakatan yang berlaku di
        sekolah. Besaran dan jangka waktu pengembalian akan saya patuhi sesuai keputusan pihak sekolah.
    </p>

    <p>Demikian surat permohonan ini saya buat dengan sebenar-benarnya. Atas perhatian dan kebijaksanaan Bapak/Ibu, saya
        ucapkan terima kasih.</p>

    <div class="signature">
        <p>{{ now()->translatedFormat('d F Y') }}</p>
        <p>Hormat saya,</p>
        <br><br>
        <p><strong><u>{{ $guru->nama }}</u></strong></p>
    </div>

</body>

</html>