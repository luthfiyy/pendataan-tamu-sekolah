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
        {{-- <div class="text">Beranda</div> --}}
        @include('pegawai.components.navbar')

        {{-- <x-breadcrumb /> --}}
        {{-- @include('pegawai.components.breadcrumb') --}}


        {{-- container fluid --}}
        <div class="container">
            <div class="ms-1 mt-5 mb-2 me-1 d-flex align-items-center justify-content-between">
                <x-breadcrumb />
                @include('pegawai.components.breadcrumb')
            </div>
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-custom gradient-success border-radius-xl mt-n4 gradient-shadow-success">
                                <i class='bx bx-user'></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 ">Total Tamu Hari Ini</p>
                                <h4 class="mb-0">{{ $totalTamuHariIni }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p> --}}
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-custom gradient-info border-radius-xl mt-n4 gradient-shadow-info">
                                <i class="fa-solid fa-person-circle-check"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 "> Tamu yang Diterima</p>
                                <h4 class="mb-0">{{ $totalTamuDiterima }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-custom gradient-danger border-radius-xl mt-n4 gradient-shadow-danger">
                                <i class="fa-solid fa-person-circle-xmark"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0"> Tamu yang Ditolak</p>
                                <h4 class="mb-0">{{ $totalTamuDitolak }}</h4>
                            </div>
                        </div>

                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-custom gradient-dark border-radius-xl mt-n4 gradient-shadow-dark">
                                <i class="fa-solid fa-person-circle-exclamation"></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 "> Tamu Belum Dikonfirmasi</p>
                                <h4 class="mb-0">{{ $totalTamuDiproses }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than lask month</p> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6 mt-4 container-detail">
                    <div class="detail-kunjungan p-4 ">
                        @if (isset($selectedTamu))
                            {{-- <div id="detail-content" class="tamu-detail-card">
                                <div class="tamu-header">
                                    <img src="{{ $selectedTamu['foto'] ? asset('storage/img-tamu/' . $selectedTamu['foto']) : asset('img/logo-hitam.png') }}"
                                        alt="Foto Tamu" class="tamu-avatar">
                                    <h2 class="tamu-name">{{ $selectedTamu['nama_tamu'] }}</h2>
                                    <span class="font-weight-bold text-white">{{ $selectedTamu['email'] }}</span>
                                    <span class="tamu-status status-{{ strtolower($selectedTamu['status']) }}">
                                        {{ $selectedTamu['status'] }}
                                    </span>
                                </div>
                                <div class="tamu-info">
                                    <div class="info-group">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p>{{ $selectedTamu['alamat_tamu'] }}</p>
                                    </div>
                                    <div class="info-group">
                                        <i class="fas fa-phone"></i>
                                        <p>{{ $selectedTamu['no_telp_tamu'] }}</p>
                                    </div>
                                    <div class="info-group">
                                        <i class="fas fa-building"></i>
                                        <p>{{ $selectedTamu['instansi'] }}</p>
                                    </div>
                                    <div class="info-group">
                                        <i class="fas fa-comments"></i>
                                        <p>{{ $selectedTamu['tujuan'] }}</p>
                                    </div>
                                    <div class="info-group">
                                        <i class="fas fa-user-tie"></i>
                                        <p>{{ $selectedTamu['nama_user'] }}</p>
                                    </div>
                                    <div class="info-group">
                                        <i class="fas fa-calendar-alt"></i>
                                        <p>{{ $selectedTamu['waktu_perjanjian'] }}</p>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div id="detail-content" class="tamu-card">
                                <div class="tamu-header">
                                    <img src="{{ $selectedTamu['foto'] ? asset('storage/img-tamu/' . $selectedTamu['foto']) : asset('img/logo-hitam.png') }}"
                                         alt="Foto Tamu" class="tamu-avatar">
                                    <h2 class="tamu-name">{{ $selectedTamu['nama_tamu'] }}</h2>
                                    <span class="tamu-status status-{{ strtolower($selectedTamu['status']) }}">
                                        {{ $selectedTamu['status'] }}
                                    </span>
                                </div>
                                <div class="tamu-info">
                                    <div class="info-item">
                                        <span class="info-label">Instansi</span>
                                        <span class="info-value">{{ $selectedTamu['instansi'] }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Tujuan</span>
                                        <span class="info-value">{{ $selectedTamu['tujuan'] }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Bertemu</span>
                                        <span class="info-value">{{ $selectedTamu['nama_user'] }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Waktu</span>
                                        <span class="info-value">{{ $selectedTamu['waktu_perjanjian'] }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Kontak</span>
                                        <span class="info-value">{{ $selectedTamu['no_telp_tamu'] }}</span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="guest-card-compact">
                                <div class="tamu-header align-items-center"
                                    style="display: flex; flex-direction: column;">
                                    <img src="{{ $selectedTamu['foto'] ? asset('storage/img-tamu/' . $selectedTamu['foto']) : asset('img/logo-hitam.png') }}"
                                        alt="Foto Tamu" class="tamu-avatar">
                                    <h2 class="tamu-name">{{ $selectedTamu['nama_tamu'] }}</h2>
                                    <span class="tamu-email font-weight-bold">{{ $selectedTamu['email'] }}</span>
                                    <!-- Email di atas status -->
                                    <span class="tamu-status status-{{ strtolower($selectedTamu['status']) }}">
                                        {{ $selectedTamu['status'] }}
                                    </span>
                                </div>

                                <div class="card-body">
                                    <div class="info-list">
                                        <div class="info-item">
                                            <span class="info-label">Alamat</span>
                                            <span class="info-value">{{ $selectedTamu['alamat_tamu'] }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">No Telepon</span>
                                            <span class="info-value">{{ $selectedTamu['no_telp_tamu'] }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Instansi</span>
                                            <span class="info-value">{{ $selectedTamu['instansi'] }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Tujuan</span>
                                            <span class="info-value">{{ $selectedTamu['tujuan'] }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Pegawai yang dituju</span>
                                            <span class="info-value">{{ $selectedTamu['nama_user'] }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Waktu Perjanjian</span>
                                            <span class="info-value">{{ $selectedTamu['waktu_perjanjian'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="m-5 text-center">Pilih tamu untuk melihat detail.</p>
                        @endif
                    </div>
                </div>
                <div class="col-6 mt-4 container-detail">
                    <div class="kunjungan p-4">
                        <p>Aktivitas Kunjungan</p>
                        <div class="d-flex justify-content-between align-items-center mb-5 mt-3">

                            <div class="search d-flex align-items-center ms-auto mb-0 mt-0 me-2">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-search'></i>
                                    <input type="text" id="searchTamu" placeholder="Cari..">
                                </div>
                            </div>
                            {{-- <div class="filterStatus d-flex align-items-center mt-0 mb-0">
                                <div class="filter-container">
                                    <i class='bx bx-filter-alt'></i>
                                    <select id="filterStatus" onchange="filterByStatus()">
                                        <option value="Menunggu konfirmasi" {{ $status === 'Menunggu konfirmasi' ? 'selected' : '' }}>
                                            Menunggu konfirmasi
                                        </option>
                                        <option value="Diterima" {{ $status === 'Diterima' ? 'selected' : '' }}>
                                            Diterima
                                        </option>
                                        <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                    </select>
                                    <i class='bx bx-chevron-down'></i>
                                </div>
                            </div> --}}
                            <div class="refresh-button d-flex  justify-content-center ms-2 mb-0 mt-0 me-2">
                                <a href="{{ route('pegawai.manajemen-kunjungan') }}">
                                    <i class='bx bx-refresh' style="font-size:  35px"></i>
                                </a>
                            </div>

                        </div>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif


                        <div id="visitor-list">
                            {{-- @if ($kedatanganTamu->isEmpty() && request('status') === 'Diterima')
                                <p class="text-center text-sm">Tidak ada tamu yang Diterima</p>
                            @elseif ($kedatanganTamu->isEmpty() && request('status') === 'Ditolak')
                                <p class="text-center text-sm">Tidak ada tamu yang Ditolak</p>
                            @elseif ($kedatanganTamu->isEmpty() && request('status') === 'Menunggu konfirmasi')
                                <p class="text-center text-sm">Tidak ada tamu yang menunggu konfirmasi</p>
                            @elseif ($kedatanganTamu->isEmpty())
                                <p class="text-center text-sm">Tidak ada tamu yang menunggu konfirmasi</p>
                            @else --}}
                            {{-- <hr class="dark horizontal my-0"> --}}
                            @foreach ($kedatanganTamu as $tamu)
                                @php
                                    $waktuPerjanjian = \Carbon\Carbon::parse($tamu->waktu_perjanjian);
                                    $currentTime = \Carbon\Carbon::now();
                                @endphp
                                <div class="visitor-item" data-id="{{ $tamu->id_kedatanganTamu }}"
                                    data-status="{{ $tamu->status }}">
                                    <div class="d-flex align-items-center justify-content-between ">
                                        <div
                                            class="manajemen-tamu d-flex align-items-center justify-content-between mb-3 p-2">
                                            <div class=" d-flex align-items-center">
                                                <form action="{{ route('pegawai.manajemen-kunjungan') }}"
                                                    method="GET" style="display: inline;">
                                                    <input type="hidden" name="selected_tamu"
                                                        value="{{ $tamu->id_kedatanganTamu }}">
                                                    @if ($status !== 'Menunggu konfirmasi')
                                                        <input type="hidden" name="status"
                                                            value="{{ $status }}">
                                                    @endif
                                                    <button type="submit" class="avatar-kunjungan flex-shrink-0 me-3"
                                                        id="detail-tamu"
                                                        style="border: none; background: none; cursor: pointer;">
                                                        <i class="fa-solid fa-address-card"
                                                            style="font-size: 30px"></i>
                                                    </button>
                                                </form>
                                                <div class="p-2">
                                                    <span class="font-weight-bold text-xs">Waktu
                                                        perjanjian:
                                                        {{ \Carbon\Carbon::parse($tamu->waktu_perjanjian)->translatedFormat('l, d/m/Y, H:i') }}</span>
                                                    <p class="font-weight-bold text-sm p-0">
                                                        {{ $tamu->tamu->nama }}
                                                    </p>
                                                    <p class="text-sm mb-0 ml-2 p-0">
                                                        Bertemu dengan
                                                        <span
                                                            class="font-weight-bold text-sm">{{ $tamu->user->name }}</span>
                                                    </p>
                                                    {{-- <p class="p-0 text-sm">{{ $tamu->status }}</p> --}}
                                                    @if ($tamu->status === 'Diterima')
                                                        <span class="bg-gradient-success mt-1">Status
                                                            {{ $tamu->status }}</span>
                                                    @elseif ($tamu->status === 'Ditolak')
                                                        <span class="bg-gradient-danger mt-1">Status
                                                            {{ $tamu->status }}</span>
                                                    @else
                                                        <span class="bg-gradient-dark mt-1">Status
                                                            {{ $tamu->status }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (request('status') !== 'Diterima' && request('status') !== 'Ditolak')
                                                <div class="form-status pe-3">
                                                    <form
                                                        action="{{ route('pegawai.update-status', $tamu->id_kedatanganTamu) }}"
                                                        method="POST" class="form-update-status">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Diterima">
                                                        <button type="submit" class="button-success btn-accept"
                                                            id="terima-button">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('pegawai.update-status', $tamu->id_kedatanganTamu) }}"
                                                        method="POST" class="form-update-status">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <button type="submit" class="button-danger btn-reject"
                                                            id="tolak-button">
                                                            <i class="fa-solid fa-x"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- @endif --}}

                            <div class="footer-detail mt-auto">
                                {{ $kedatanganTamu->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- end container fluid --}}




    </section>

    {{-- ===== section ===== --}}


    <script src="{{ asset('../js/script.js') }}"></script>
    <script src="{{ asset('../js/material-dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9FfN2IO49JWKNj4Xc4lTnL8E+vsgYV8h6i+n81paAnw1Pp8DAfB1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-c0vJ+c44F1c8Upct9c0V6sHFeKt9Wv9m6rKf6BqP8Iq5k5hBf9Wh9oQAK86b8G0E" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script>

        tippy('#terimaButton', {
            content: 'Terima',
        });

        tippy('#tolakButton', {
            content: 'Tolak',
        });

        tippy('#detail', {
            content: 'Click Untuk Detail Tamu',
        })

        // function filterByStatus() {
        //     var filter = document.getElementById("filterStatus").value;
        //     var currentUrl = new URL(window.location.href);
        //     if (filter === "Menunggu konfirmasi") {
        //         currentUrl.searchParams.delete('status');
        //     } else {
        //         currentUrl.searchParams.set('status', filter);
        //     }
        //     window.location.href = currentUrl.toString();
        // }

        document.getElementById('searchTamu').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            const visitorItems = document.querySelectorAll('#visitor-list .visitor-item');
            let found = false;

            visitorItems.forEach(function(item) {
                const namaTamu = item.querySelector('.nama-tamu').textContent.toLowerCase();
                const namaPegawai = item.querySelector('.pegawai').textContent.toLowerCase();
                const waktuPerjanjian = item.querySelector('.waktu-perjanjian').textContent.toLowerCase();

                if (namaTamu.includes(searchQuery) || namaPegawai.includes(searchQuery) || waktuPerjanjian
                    .includes(searchQuery)) {
                    item.style.display = '';
                    found = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Menampilkan pesan jika tidak ada hasil
            let tidakAdaHasil = document.getElementById('noResults');
            if (!tidakAdaHasil) {
                tidakAdaHasil = document.createElement('p');
                tidakAdaHasil.id = 'noResults';
                tidakAdaHasil.className = 'text-center text-sm';
                tidakAdaHasil.textContent = 'Tidak ada hasil ditemukan';
                document.getElementById('visitor-list').appendChild(tidakAdaHasil);
            }

            if (found) {
                tidakAdaHasil.style.display = 'none';
            } else {
                tidakAdaHasil.style.display = 'block';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ asset('js/script.js') }}">
</body>

</html>
