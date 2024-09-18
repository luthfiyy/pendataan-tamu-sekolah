<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ada kunjungan baru</title>
</head>
<body>
    <h2>Ada tamu baru!</h2>
    <p>Nama Tamu: {{ $kedatanganTamu->tamu->nama }}</p>
    <p>No Telepon Tamu: {{ $kedatanganTamu->tamu->no_telp }}</p>
    <p>Tanggal pertemuan: {{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->locale('id')->translatedFormat('l, d/m/Y, H:i') }}</p>
    <h3>Silakan konfirmasi tamu ini:</h3>
    <p>
        <a href="{{ route('confirm.appointment', ['token' => $kedatanganTamu->confirmation_token, 'action' => 'accept']) }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; margin-right: 10px;">
            Terima
        </a>
        <a href="{{ route('confirm.appointment', ['token' => $kedatanganTamu->confirmation_token, 'action' => 'reject']) }}" class="button button-red">
            Tolak Kunjungan
        </a>
    </p>
    <p>Atau Anda dapat membuka web GuBook untuk konfirmasi lebih lanjut.</p>
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
