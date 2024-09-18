<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Kunjungan Diperbarui</title>
</head>
<body>
    <h2>Status Kunjungan Anda Telah Diperbarui</h2>
    <p>Status kunjungan Anda sekarang: <b>{{ $kedatanganTamu->status }}</b></p>

    @if($kedatanganTamu->status == 'Diterima')
        <p>Berikut adalah QR Code untuk kunjungan Anda:</p>
        <img src="{{ $message->embed($qrCodePath) }}" alt="Logo" width="400px" height="400px">
    @endif

    @if ($kedatanganTamu->status == 'Ditolak')
        <h3>Silahkan membuat pertemuan dilain waktu!</h3>
        <h3>Keterangan: {{ $kedatanganTamu->keterangan }}</h3>
    @endif
</body>
</html>
