<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}">

    {{-- icon --}}
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>GuBook</title>
</head>

<body>
    {{-- ===== sidebar ===== --}}
    @include('pegawai.components.sidebar')
    {{-- ===== sidebar ===== --}}

    {{-- ===== section ===== --}}
    <section class="home">
        @include('pegawai.components.navbar')
        @include('pegawai.components.breadcrumb')

        {{-- container fluid --}}
        <div class="container" style="margin-left: 0; margin-right: 0;">
            <div class="row">
                <div class="card mb-4">
                    <h5 class="card-header text-center">Profile Details</h5>
                    <!-- Account -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <hr class="my-0"/>
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" action="{{ route('user.update') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="newNama" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="newNama" name="newNama" value="{{ $user->name }}" autofocus />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="nip" class="form-label">NIP (tidak dapat diubah)</label>
                                    <input class="form-control" type="text" id="nip" name="nip" value="{{ $pegawai->nip }}" readonly />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="newEmail" class="form-label">E-mail</label>
                                    <input class="form-control" type="email" id="newEmail" name="newEmail" value="{{ $user->email }}" placeholder="john.doe@example.com" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="newNotelp" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="newNotelp" name="newNotelp" value="{{ $pegawai->no_telp }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="newPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Password" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="newPtk" class="form-label">PTK</label>
                                    <select name="newPtk" id="newPtk" class="form-control" required>
                                        <option value="" selected disabled>PTK</option>
                                        <option value="produktif rpl" {{ $pegawai->ptk == 'produktif rpl' ? 'selected' : '' }}>Produktif RPL</option>
                                        <option value="produktif akl" {{ $pegawai->ptk == 'produktif akl' ? 'selected' : '' }}>Produktif AKL</option>
                                        <option value="pendidikan pencasila" {{ $pegawai->ptk == 'pendidikan pencasila' ? 'selected' : '' }}>Pendidikan Pancasila</option>
                                        <option value="bahasa inggris" {{ $pegawai->ptk == 'bahasa inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                        <option value="pjok" {{ $pegawai->ptk == 'pjok' ? 'selected' : '' }}>PJOK</option>
                                        <option value="produktif bdp" {{ $pegawai->ptk == 'produktif bdp' ? 'selected' : '' }}>Produktif BDP</option>
                                        <option value="produktif MP" {{ $pegawai->ptk == 'produktif MP' ? 'selected' : '' }}>Produktif MP</option>
                                        <option value="tendik" {{ $pegawai->ptk == 'tendik' ? 'selected' : '' }}>Tendik</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>



                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
        {{-- end container fluid --}}
    </section>
    {{-- ===== section ===== --}}

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/material-dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9FfN2IO49JWKNj4Xc4lTnL8E+vsgYV8h6i+n81paAnw1Pp8DAfB1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-c0vJ+c44F1c8Upct9c0V6sHFeKt9Wv9m6rKf6BqP8Iq5k5hBf9Wh9oQAK86b8G0E" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('upload');
            const uploadedAvatar = document.getElementById('uploadedAvatar');
            const resetButton = document.getElementById('resetButton');
            const defaultAvatarSrc = uploadedAvatar.src;

            uploadInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        uploadedAvatar.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            resetButton.addEventListener('click', function() {
                uploadedAvatar.src = defaultAvatarSrc;
                uploadInput.value = ''; // Clear the file input
            });
        });
    </script>


    <link rel="stylesheet" href="{{ asset('js/script.js') }}">
</body>

</html>
