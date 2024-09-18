<!-- resources/views/emails/reject_confirmation.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Penolakan Kunjungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        textarea {
            width: 100%;
            padding: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #f44336;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Konfirmasi Penolakan Kunjungan</h1>
        <p>Anda akan menolak kunjungan dari: {{ $kedatanganTamu->tamu->nama }}</p>
        <p>Tanggal kunjungan: {{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->locale('id')->translatedFormat('l, d/m/Y, H:i') }}</p>

        <form action="{{ route('confirm.appointment', ['token' => $kedatanganTamu->confirmation_token, 'action' => 'reject']) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="keterangan">Alasan Penolakan:</label>
                <textarea name="keterangan" id="keterangan" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn">Konfirmasi Penolakan</button>
        </form>
    </div>
</body>
</html>
