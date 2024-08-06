<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">


</head>

<body style="background-color: #f4f4f4; ">
    @include('user.components.background')
    @include('user.components.navbar')
    <!-- Content of the landing page -->
    <div class="container-fluid">
        <div class="row">
            <div class="button-container" style="padding: 20px;">
                <a href="{{ route('guru') }}" class="a-pegawai"
                    style="{{ Request::routeIs('guru') ? 'background-color: transparent; color: #4461F2; border: 1px solid #007bff;' : '' }}">Guru</a>
                <a href="{{ route('tendik') }}" class="a-pegawai"
                    style="{{ Request::routeIs('tendik') ? 'background-color: transparent; color: #4461F2; border: 1px solid #007bff;' : '' }}">Tenaga
                    Pendidik</a>
            </div>
            <div class="col-12">
                @include('user.components.table-pegawai')
            </div>
        </div>
    </div>


    @include('user.components.footer')

    <!-- Bootstrap JavaScript and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-yFjHf3V/PBw1fVfXfX5wuKkpP+yYHT8QAEwb8k2+XJ3FdZyhax2o1b+qkEVsFGoC" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
