<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ada Paket</title>
</head>
<body>
    <h2>Ada kiriman baru!</h2>
    <p>Nama Kurir: {{ $kedatanganEkspedisi->ekspedisi->nama_kurir }}</p>
    <p>No Telepon Kurir: {{ $kedatanganEkspedisi->ekspedisi->no_telp }}</p>
    <p>Tanggal dan waktu: {{ \Carbon\Carbon::parse($kedatanganEkspedisi->tanggal_waktu)->locale('id')->translatedFormat('l, d/m/Y, H:i') }}</p>
</body>
</html>
