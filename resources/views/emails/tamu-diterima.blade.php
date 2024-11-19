<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Status Kunjungan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #2c5282;">Konfirmasi Status Kunjungan</h2>

    <p>Yang terhormat Bapak/Ibu {{ $kedatanganTamu->tamu->nama }},</p>

    <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin: 15px 0;">
        @if($kedatanganTamu->status == 'Diterima')
            <p style="color: #2f855a; font-size: 18px; font-weight: bold;">Status: Kunjungan Disetujui ✓</p>
            <p>Pertemuan Anda telah dikonfirmasi. Silakan gunakan QR Code di bawah ini saat kedatangan Anda:</p>
            <div style="text-align: center; margin: 20px 0;">
                <img src="{{ $message->embed($qrCodePath) }}"
                     alt="QR Code Kunjungan"
                     style="width: 300px; height: 300px; max-width: 100%;">
            </div>
            <p style="margin-top: 15px;">
                <strong>Penting:</strong>
                <ul style="margin-top: 5px;">
                    <li>Tunjukkan QR Code ini kepada petugas keamanan saat kedatangan</li>
                    <li>QR Code berlaku hanya 1 Jam setelah jadwal yang telah disepakati</li>
                    <li>Harap datang 5 menit sebelum waktu pertemuan</li>
                </ul>
            </p>
        @endif

        @if($kedatanganTamu->status == 'Ditolak')
            <p style="color: #c53030; font-size: 18px; font-weight: bold;">Status: Kunjungan Ditolak</p>
            <p><strong>Keterangan:</strong> {{ $kedatanganTamu->keterangan }}</p>
            <div style="margin-top: 15px;">
                <p><strong>Anda dapat:</strong></p>
                <ul style="margin-top: 5px;">
                    <li>Mengajukan jadwal kunjungan di waktu lain</li>
                    <li>Menghubungi kami untuk informasi lebih lanjut</li>
                </ul>
            </div>
        @endif
    </div>

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
        <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami melalui:</p>
        <p>Email: admin@gubook.com<br>
           Telepon: (021) xxx-xxxx</p>
    </div>

</body>
</html>
