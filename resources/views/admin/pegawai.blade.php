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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <title>GuBook</title>
</head>

<body>

    {{-- Sidebar --}}
    @include('admin.components.sidebar')

    {{-- Section --}}
    <section class="home">
        <div class="container mt-4 ps-3">
            @include('admin.components.navbar')
            <x-breadcrumb />
        </div>
        <div class="row">
            <div class="col-12 ms-3">
                {{-- Tombol untuk Menampilkan Form --}}
                <div class="mb-3">
                    <button class="btn-tambah d-flex justify-content-center align-items-center" id="showFormBtn">
                        <i class='bx bx-user-plus me-2'></i>Tambah Pegawai</button>
                </div>

                {{-- Form insert --}}
                <div id="formContainer" style="display: none;">
                    @include('admin.components.form')
                </div>

                @include('admin.components.table-pegawai')

            </div>
        </div>
    </section>
    {{-- End Section --}}



    {{-- JavaScript --}}
    <script>
        document.getElementById('showFormBtn').addEventListener('click', function() {
            var formContainer = document.getElementById('formContainer');
            if (formContainer.style.display === 'none' || formContainer.style.display === '') {
                formContainer.style.display = 'block';
                this.textContent = 'Sembunyikan Form';
            } else {
                formContainer.style.display = 'none';
                this.textContent = 'Tambah Pegawai';
            }
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/material-dashboard.js') }}"></script>

</body>

</html>
