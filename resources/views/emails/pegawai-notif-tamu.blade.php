<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pemberitahuan Kunjungan Tamu</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; padding: 20px;">
    <h2 style="color: #2c5282;">Permintaan Kunjungan Tamu</h2>

    <p>Yang terhormat Bapak/Ibu {{ ucwords(strtolower($kedatanganTamu->user->name)) }}</,</p>

    <p>Kami ingin menginformasikan bahwa ada tamu yang ingin mengajukan pertemuan dengan Bapak/Ibu.<p>

    <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin: 15px 0;">
        <p><strong>Detail Kunjungan:</strong></p>
        <p>Nama Tamu: {{ ucwords(strtolower($kedatanganTamu->tamu->nama)) }}</p>
        <p>No Telepon Tamu: {{ $kedatanganTamu->tamu->no_telp }}</p>
        <p>Waktu Pertemuan yang Diajukan: {{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->locale('id')->translatedFormat('l, d/m/Y, H:i') }}</p>
    </div>

    <p><strong>Mohon konfirmasi ketersediaan Bapak/Ibu untuk pertemuan ini dengan menekan salah satu tombol di bawah:</strong></p>

    <div style="margin: 20px 0;">
        <a href="{{ route('confirm.appointment', ['token' => $kedatanganTamu->confirmation_token, 'action' => 'accept']) }}"
            style="background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; margin-right: 10px; border-radius: 4px;">
            Terima Kunjungan
        </a>
        <a href="{{ route('confirm.appointment', ['token' => $kedatanganTamu->confirmation_token, 'action' => 'reject']) }}"
            style="background-color: #d01616; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; margin-right: 10px; border-radius: 4px;">
            Tolak Kunjungan
        </a>
    </div>

    <p style="color: #666;">Bapak/Ibu juga dapat mengakses web GuBook untuk melihat detail lebih lanjut dan melakukan konfirmasi melalui platform tersebut.</p>
</body>
</html>


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ada kunjungan baru</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            color: #ffffff;
            background-color: #4CAF50;
            border-radius: 6px;
            outline: none;
            transition: 0.3s;
        }
        .button-red {
            background-color: #f44336;
        }
        .button-red:hover {
            background-color: #d32f2f;
        }
        .rejection-form {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 6px;
        }
        .rejection-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Ada tamu baru!</h2>
    <p>Nama Tamu: {{ $kedatanganTamu->tamu->nama }}</p>
    <p>No Telepon Tamu: {{ $kedatanganTamu->tamu->no_telp }}</p>
    <p>Tanggal pertemuan: {{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->locale('id')->translatedFormat('l, d/m/Y, H:i') }}</p>
    <h3>Silakan konfirmasi tamu ini:</h3>
    <p>
        <a href="{{ route('confirm.appointment', ['token' => $kedatanganTamu->confirmation_token, 'action' => 'accept']) }}" class="button">
            Terima
        </a>
    </p>

    <div class="rejection-form">
        <h4>Jika Anda ingin menolak kunjungan ini, silakan isi alasan penolakan:</h4>
        <a href="{{ route('confirm.appointment', ['token' => $kedatanganTamu->confirmation_token, 'action' => 'reject']) }}" class="button button-red">
            Tolak Kunjungan
        </a>
    </div>

    <p>Atau Anda dapat membuka web GuBook untuk konfirmasi lebih lanjut.</p>
</body>
</html> --}}
