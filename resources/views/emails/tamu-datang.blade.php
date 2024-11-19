<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Kedatangan Tamu</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #2c5282;">Pemberitahuan Kedatangan Tamu</h2>

    <p>Yang terhormat Bapak/Ibu {{ ucwords(strtolower($kedatanganTamu->user->name)) }},</
    <p>Dengan hormat kami informasikan bahwa tamu Bapak/Ibu sudah tiba di sekolah sesuai dengan jadwal pertemuan yang telah disepakati.</p>

    <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin: 15px 0;">
        <p><strong>Detail Tamu:</strong></p>
        <p>Nama Tamu: {{ $tamuData->tamu->nama }}</p>
        <p>No Telepon Tamu: {{ $tamuData->tamu->no_telp }}</p>
        <p>Waktu Perjanjian: {{ \Carbon\Carbon::parse($tamuData->tanggal_perjanjian)->locale('id')->translatedFormat('l, d/m/Y, H:i') }}</p>
    </div>

    <p><strong>Dokumentasi Kedatangan:</strong></p>
    <img src="{{ $message->embed(storage_path('app/public/img-tamu/' . $tamuData->foto)) }}"
         alt="Foto Dokumentasi Tamu"
         style="max-width: 100%; height: auto; border-radius: 5px; margin: 10px 0;">

    <p>Tamu sedang menunggu di ruang Front Office. Mohon kehadiran Bapak/Ibu untuk menemui tamu tersebut.</p>

</body>
</html>
