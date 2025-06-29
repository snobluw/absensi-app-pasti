<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Slip Gaji - {{ $guru->nama }}</title>
  <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #333;
    }

    .header {
        text-align: center;
        border-bottom: 2px solid #0d6efd;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .header img {
        width: 60px;
        height: auto;
        float: left;
    }

    .header h1 {
        font-size: 20px;
        margin: 0;
        color: #0d6efd;
    }

    .header p {
        margin: 0;
        font-size: 12px;
        color: #555;
    }

    .info-table {
        width: 100%;
        margin-bottom: 20px;
    }

    .info-table td {
        padding: 4px 0;
    }

    table.main-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.main-table th,
    table.main-table td {
        border: 1px solid #ccc;
        padding: 6px;
        text-align: center;
    }

    table.main-table th {
        background-color: #e0f0ff;
        color: #0d6efd;
    }

    table.main-table tfoot td {
        background-color: #e6ffee;
        font-weight: bold;
        text-align: right;
    }

    .right {
        text-align: right;
    }

    .signature {
        margin-top: 60px;
        text-align: right;
        font-size: 12px;
    }

    .footer {
        margin-top: 30px;
        text-align: center;
        font-size: 10px;
        color: #888;
    }

    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }
  </style>
</head>
<body>

  <div class="header clearfix">
    <img src="{{ public_path('img/logo-sekolah.png') }}" alt="Logo Sekolah">
    <div style="margin-left: 70px;">
      <h1>MTS CAHAYA HARAPAN</h1>
      <p>Jl. Pendidikan No. 123, Kota Edukasi</p>
    </div>
  </div>

  <table class="info-table">
    <tr>
      <td><strong>Nama Guru</strong></td>
      <td>: {{ $guru->nama }}</td>
    </tr>
    @if($guru->nip)
    <tr>
      <td><strong>NIP</strong></td>
      <td>: {{ $guru->nip }}</td>
    </tr>
    @endif
    <tr>
      <td><strong>Periode</strong></td>
      <td>: {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</td>
    </tr>
  </table>

  <table class="main-table">
    <thead>
      <tr>
        <th rowspan="2">Honor</th>
        <th colspan="4">Kehadiran</th>
        <th rowspan="2">Gaji / Kehadiran</th>
        <th rowspan="2">Jumlah</th>
      </tr>
      <tr>
        <th>H</th>
        <th>S</th>
        <th>I</th>
        <th>T</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $item)
      <tr>
        <td>{{ $item['kategori'] }}</td>
        <td>{{ $item['counts']['H'] }}</td>
        <td>{{ $item['counts']['S'] }}</td>
        <td>{{ $item['counts']['I'] }}</td>
        <td>{{ $item['counts']['T'] }}</td>
        <td class="right">Rp. {{ number_format($item['gaji_per_kehadiran'], 0, ',', '.') }}</td>
        <td class="right">Rp. {{ number_format($item['jumlah'], 0, ',', '.') }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="6">Jumlah Diterima</td>
        <td class="right">Rp. {{ number_format($total, 0, ',', '.') }}</td>
      </tr>
    </tfoot>
  </table>

  <div class="signature">
    <p>Mengetahui,</p>
    <br><br><br>
    <p><strong>Bendahara Yayasan</strong></p>
  </div>

  <div class="footer">
    Slip ini dihasilkan oleh sistem pada {{ now()->translatedFormat('d F Y') }}.
  </div>

</body>
</html>
