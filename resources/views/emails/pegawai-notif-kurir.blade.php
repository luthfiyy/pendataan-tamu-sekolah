<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Paket untuk Bapak/Ibu Guru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; padding: 20px;">
    <h2 style="color: #2c5282;">Pemberitahuan Paket untuk Bapak/Ibu Guru</h2>

    <p>Yang terhormat Bapak/Ibu {{ ucwords(strtolower($kedatanganEkspedisi->user->name)) }},</p>

    <p>Dengan hormat kami informasikan bahwa ada kiriman paket yang baru saja tiba di sekolah untuk Bapak/Ibu.</p>

    <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin: 15px 0;">
        <p>Detail kiriman:</p>
        <p>Nama Kurir: {{ $kedatanganEkspedisi->ekspedisi->nama_kurir }}</p>
        <p>No Telepon Kurir: {{ $kedatanganEkspedisi->ekspedisi->no_telp }}</p>
        <p>Tanggal dan waktu kedatangan: {{ \Carbon\Carbon::parse($kedatanganEkspedisi->tanggal_waktu)->locale('id')->translatedFormat('l, d/m/Y, H:i') }}</p>
    </div>

    <p>Dokumentasi kedatangan paket:</p>
    <img src="{{ $message->embed(storage_path('app/public/img-kurir/' . $kedatanganEkspedisi->foto)) }}" alt="Foto Dokumentasi Kurir" style="max-width: 100%; height: auto; border-radius: 5px;">

    <p>Paket dapat diambil di ruang Front Office pada jam kerja.</p>

    <p>Terima kasih atas perhatiannya.</p>
</body>
</html>
