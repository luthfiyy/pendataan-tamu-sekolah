{{-- <h1>halaman FO</h1>
<form method="POST" action="{{ route('logout') }}">
    @csrf

    <x-dropdown-link :href="route('logout')"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
        {{ __('Log Out') }}
    </x-dropdown-link>
</form> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- icon --}}
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/material-dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>GuBook</title>
</head>

<body>
    {{-- ===== sidebar ===== --}}

    @include('FO.components.sidebar')

    {{-- ===== sidebar ===== --}}


    {{-- ===== section ===== --}}

    <section class="home">
        {{-- <div class="text">Beranda</div> --}}
        @include('FO.components.navbar')

        <x-breadcrumb />


        {{-- container fluid --}}
        <div class="container " style="margin-left: 0; margin-right: 0;">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-custom gradient-success border-radius-xl mt-n4">
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
                            <div class="icon icon-custom gradient-info border-radius-xl mt-n4">
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
                            <div class="icon icon-custom gradient-danger border-radius-xl mt-n4">
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
                            <div class="icon icon-custom gradient-dark border-radius-xl mt-n4">
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
                <div class="col-5 mt-4 container-detail">
                    <div class="detail-kunjungan">
                        <p>Detail Kunjungan</p>
                        @if (isset($selectedTamu))
                            <div id="detail-content">
                                <p><strong>Nama Tamu:</strong> {{ $selectedTamu['nama_tamu'] }}</p>
                                <p><strong>Alamat Tamu:</strong> {{ $selectedTamu['alamat_tamu'] }}</p>
                                <p><strong>No Telepon Tamu:</strong> {{ $selectedTamu['no_telp_tamu'] }}</p>
                                <p><strong>Instansi:</strong> {{ $selectedTamu['instansi'] }}</p>
                                <p><strong>Tujuan:</strong> {{ $selectedTamu['tujuan'] }}</p>
                                <p><strong>Nama Pegawai yang dituju:</strong> {{ $selectedTamu['nama_user'] }}</p>
                                <p><strong>Waktu Perjanjian:</strong> {{ $selectedTamu['waktu_perjanjian'] }}</p>
                                <p><strong>Status:</strong> {{ $selectedTamu['status'] }}</p>
                                <!-- Tambahkan informasi lain yang Anda inginkan -->
                            </div>
                        @else
                            <p>Pilih tamu untuk melihat detail.</p>
                        @endif
                        <div class="footer-detail">
                        </div>
                    </div>
                </div>
                <div class="col-7 mt-4 container-detail">
                    <div class="kunjungan p-4">
                        <p>Aktivitas Kunjungan</p>
                        <div class="d-flex justify-content-between align-items-center mb-5 mt-3">

                            <div class="search d-flex align-items-center ms-auto mb-0 mt-0 me-2">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-search'></i>
                                    <input type="text" id="searchInput" onkeyup="myFunction()" placeholder="Cari..">
                                </div>
                            </div>
                            <div class="filterStatus d-flex align-items-center mt-0 mb-0">
                                <div class="filter-container">
                                    <i class='bx bx-filter-alt'></i>
                                    <select id="filterStatus" onchange="filterByStatus()">
                                        <option value="">Status</option>
                                        <option value="Menunggu konfirmasi">Menunggu konfirmasi</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>
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
                            {{-- <hr class="dark horizontal my-0"> --}}
                            @foreach ($kedatanganTamu as $tamu)
                                <div class="visitor-item"  data-id="{{ $tamu->id }}" data-status="{{ $tamu->status }}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <form action="{{ route('FO.manajemen-kunjungan') }}" method="GET" style="display: inline;">
                                                <input type="hidden" name="selected_tamu"
                                                    value="{{ $tamu->id }}">
                                                <button type="submit" class="avatar-kunjungan flex-shrink-0 me-3" id="detail" style="border: none; background: none; cursor: pointer;">
                                                    <i class="fa-solid fa-address-card"></i>
                                                </button>
                                            </form>
                                            <div class="p-2">
                                                <p class="p-0 text-sm">{{ $tamu->tamu->nama }}</p>
                                                <p class="p-0 text-sm">{{ $tamu->user->name }}</p>
                                                <p class="p-0 text-sm">{{ $tamu->waktu_perjanjian }}</p>
                                                <p class="p-0 text-sm">{{ $tamu->status }}</p>
                                            </div>
                                        </div>
                                        <div class="form-status pe-3">

                                            <form action="{{ route('FO.update-status', $tamu->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="Diterima">
                                                <button type="submit" class="button-success btn-accept"
                                                    id="terimaButton">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('FO.update-status', $tamu->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="button-danger btn-reject"
                                                    id="tolakButton">
                                                    <i class="fa-solid fa-x">
                                                    </i>
                                                </button>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                                <hr class="dark horizontal my-0">
                            @endforeach

                        </div>
                        
                        <div class="footer-detail pe-4 pb-4 pt-4">
                            {{ $kedatanganTamu->links('vendor.pagination.bootstrap-5') }}
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
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const visitorList = document.getElementById('visitor-list');
            const visitorItems = visitorList.getElementsByClassName('visitor-item');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();

                for (let item of visitorItems) {
                    const nama = item.querySelector('.p-2 p:first-child').textContent.toLowerCase();
                    const user = item.querySelector('.p-2 p:nth-child(2)').textContent.toLowerCase();
                    const waktu = item.querySelector('.p-2 p:last-child').textContent.toLowerCase();

                    if (nama.includes(searchTerm) || user.includes(searchTerm) || waktu.includes(
                            searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });

        function filterByStatus() {
    var filter = document.getElementById("filterStatus").value;
    window.location.href = "{{ route('FO.manajemen-kunjungan') }}?status=" + filter;
}

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ asset('js/script.js') }}">
</body>

</html>
