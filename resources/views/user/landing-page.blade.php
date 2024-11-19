<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GuBook SMKN 11 Bandung - Landing Page</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            /* overflow: hidden; */
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>

</head>

<body>
    @include('user.components.background')
    @include('user.components.navbar')
    <div class="container-fluid">
        <div class="text-center">
            <div class="content-wrapper align-items-center">
                <h1 style="font-weight: 700" class="mb-3">
                    Datanglah dengan senang hati!<br>
                    Kami layani sepenuh hati
                </h1>
                <p class="mb-5 p1" style="font-size: 1.1rem">Mari kita membuat pengalaman kunjungan anda lebih
                    mudah dan aman.</p>

                    <div class="container-card">
                        <a href="{{ route('tamu') }}" class="card-link">
                            <div class="card-tamu">
                                <i class='bx bx-user'></i>
                                <h5>Tamu</h5>
                                <p>Klik disini jika anda adalah tamu</p>
                            </div>
                        </a>
                        <a href="{{ route('kurir') }}" class="card-link">
                            <div class="card-kurir">
                                <i class='bx bxs-package'></i>
                                <h5>Kurir</h5>
                                <p>Klik disini jika anda adalah kurir</p>
                            </div>
                        </a>
                    </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-yFjHf3V/PBw1fVfXfX5wuKkpP+yYHT8QAEwb8k2+XJ3FdZyhax2o1b+qkEVsFGoC" crossorigin="anonymous">
    </script>
</body>

</html>
