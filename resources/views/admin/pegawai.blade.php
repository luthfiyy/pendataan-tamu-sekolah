<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- CSS --}}

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}"> --}}

    {{-- Icons --}}
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


    <title>GuBook</title>
</head>

<body>

    {{-- Sidebar --}}
    @include('admin.components.sidebar')

    {{-- Section --}}
    <section class="home">
        <div class="row">
            <div class="col-12 ml-0">

                @include('admin.components.navbar')
                {{-- Breadcrumbs --}}
                <x-breadcrumb />
                {{-- Form insert --}}
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
                @include('admin.components.form')

            </div>
            {{-- Card --}}
            @include('admin.components.table-pegawai')

        </div>
    </section>
    {{-- End Section --}}

    {{-- JavaScript --}}
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/material-dashboard.js') }}"></script>

</body>

</html>