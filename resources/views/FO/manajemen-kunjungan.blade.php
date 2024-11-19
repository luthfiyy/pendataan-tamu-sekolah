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

        <div class="mt-4 mb-5" style="margin-left: 30px">
            <x-breadcrumb />
        </div>


        {{-- container fluid --}}
        <div class="container " style="margin-left: 0; margin-right: 0;">
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
                    <div class="detail-kunjungan p-4">
                        <p class="p-2">Daftar Kunjungan yang <b>Diterima</b></p>
                        <form method="GET" action="{{ route('FO.manajemen-kunjungan') }}">
                            <!-- Filter Dropdown -->
                            <div class="d-flex justify-content-end">
                                <div class="filterStatus d-flex align-items-center mt-3 mb-4 w-45">
                                    <div class="filter-container w-100">
                                        <i class='bx bx-filter-alt'></i>
                                        <select id="filterStatus" name="filterStatus" onchange="this.form.submit()">
                                            <option value="Belum Datang"
                                                {{ $filterStatus == 'Belum Datang' ? 'selected' : '' }}>
                                                Belum Datang
                                            </option>
                                            <option value="Sudah Datang"
                                                {{ $filterStatus == 'Sudah Datang' ? 'selected' : '' }}>
                                                Sudah Datang
                                            </option>
                                            <option value="Tidak Datang"
                                                {{ $filterStatus == 'Tidak Datang' ? 'selected' : '' }}>
                                                Tidak Datang
                                            </option>
                                        </select>
                                        <i class='bx bx-chevron-down'></i>
                                    </div>
                                </div>
                            </div>
                        </form>




                        @php
                            use Carbon\Carbon;
                        @endphp

                        @foreach ($kedatanganTamuDiterima as $tamu)
                            @php
                                $currentDateTime = Carbon::now();
                                $waktuPerjanjian = Carbon::parse($tamu->waktu_perjanjian);
                                $isTamuLate =
                                    !$tamu->waktu_kedatangan &&
                                    $waktuPerjanjian->copy()->addMinutes(30)->lessThan($currentDateTime);
                            @endphp

                            <div class="visitor-item p-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="manajemen-tamu d-flex align-items-center justify-content-between p-2">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="avatar-kunjungan flex-shrink-0 me-3"
                                                id="detail-tamu"
                                                style="border: none; background: none; cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#tamuModal"
                                                onclick="setTamuDetails({{ json_encode($tamu) }})">
                                                <i class="fa-solid fa-address-card" style="font-size: 30px"></i>
                                            </button>

                                            <div class="p-2">
                                                @if ($tamu->waktu_kedatangan)
                                                    <span class="font-weight-bold text-xs waktu-perjanjian">
                                                        Waktu kedatangan:
                                                        {{ Carbon::parse($tamu->waktu_kedatangan)->translatedFormat('l, d/m/Y, H:i') }}
                                                    </span>
                                                @elseif($isTamuLate)
                                                    <span
                                                        class="font-weight-bold text-xs waktu-perjanjian text-danger">Tidak
                                                        datang</span>
                                                @else
                                                    <span class="font-weight-bold text-xs waktu-perjanjian">Belum
                                                        datang</span>
                                                @endif

                                                <p class="font-weight-bold text-sm p-0 nama-tamu">
                                                    {{ ucwords(strtolower($tamu->tamu->nama)) }}
                                                </p>
                                                <p class="text-sm mb-0 ml-2 p-0">Bertemu dengan
                                                    <span
                                                        class="font-weight-bold text-sm pegawai">{{ $tamu->user->name }}</span>
                                                </p>
                                                <span class="bg-gradient-success mt-1">Status
                                                    {{ $tamu->status }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="footer-detail my-3">
                            {{ $kedatanganTamuDiterima->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
                <div class="col-6 mt-4 container-detail">
                    <div class="kunjungan p-4 d-flex flex-column" style="height: 100%;">
                        <p class="p-2">Aktivitas Kunjungan</p>
                        <div class="d-flex justify-content-between align-items-center ">

                            <div class="search d-flex align-items-center ms-auto me-2 mb-4 mt-3">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-search'></i>
                                    <input type="text" id="searchTamu" placeholder="Cari..">
                                </div>
                            </div>
                            <div class="refresh-button d-flex  justify-content-center ms-2 mb-4 mt-3 me-2">
                                <a href="{{ route('FO.manajemen-kunjungan') }}">
                                    <i class='bx bx-refresh' style="font-size:  35px"></i>
                                </a>
                            </div>

                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif


                        <div id="visitor-list" class="flex-grow-1 overflow-auto">
                            @if ($kedatanganTamuMenunggu->isEmpty())
                                <p class="text-center mt-4">Tidak ada data tamu yang menunggu konfirmasi.</p>
                            @else
                                @foreach ($kedatanganTamuMenunggu as $tamu)
                                    <div class="visitor-item p-2" data-id="{{ $tamu->id_kedatanganTamu }}"
                                        data-status="{{ $tamu->status }}">
                                        <div class="d-flex align-items-center justify-content-between ">
                                            <div
                                                class="manajemen-tamu d-flex align-items-center justify-content-between mb-3 p-2">
                                                <div class=" d-flex align-items-center">
                                                    <button type="button" class="avatar-kunjungan flex-shrink-0 me-3"
                                                        id="detail-tamu"
                                                        style="border: none; background: none; cursor: pointer;"
                                                        data-bs-toggle="modal" data-bs-target="#tamuModal"
                                                        onclick="setTamuDetails({{ json_encode($tamu) }})">
                                                        <i class="fa-solid fa-address-card"
                                                            style="font-size: 30px"></i>
                                                    </button>

                                                    <div class="p-2">
                                                        <span class="font-weight-bold text-xs waktu-perjanjian">Waktu
                                                            perjanjian:
                                                            {{ \Carbon\Carbon::parse($tamu->waktu_perjanjian)->translatedFormat('l, d/m/Y, H:i') }}</span>
                                                        <p class="font-weight-bold text-sm p-0 nama-tamu">
                                                            {{ ucwords(strtolower($tamu->tamu->nama)) }}</p>
                                                        <p class="text-sm mb-0 ml-2 p-0">Bertemu dengan
                                                            <span
                                                                class="font-weight-bold text-sm pegawai">{{ $tamu->user->name }}</span>
                                                        </p>
                                                        <span class="bg-gradient-dark mt-1">Status
                                                            {{ $tamu->status }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-status pe-3">
                                                    <form
                                                        action="{{ route('FO.update-status', $tamu->id_kedatanganTamu) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Diterima">
                                                        <button type="submit" class="button-success btn-accept">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('FO.update-status', $tamu->id_kedatanganTamu) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <input type="hidden" name="keterangan" value="">
                                                        <button type="submit" class="button-danger btn-reject">
                                                            <i class="fa-solid fa-x"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>

                        {{-- <div class="footer-detail pe-2 pb-2 pt-2 fixed-bottom position-relative"> --}}
                        <div class="footer-detail mt-auto">
                            {{ $kedatanganTamuMenunggu->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- end container fluid --}}


        <!-- Replace the existing modal HTML with this -->
        <div id="rejectModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alasan Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea id="keteranganTextarea" name="keterangan" class="form-control" rows="4"
                            placeholder="Masukkan alasan penolakan"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="submitReject">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tamuModal" tabindex="-1" aria-labelledby="tamuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tamuModalLabel">Detail Tamu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="tamuDetails">
                        <!-- Detail tamu akan diisi di sini -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>



    </section>

    {{-- ===== section ===== --}}

    {{-- {{ dd($selectedTamu) }} --}}
    <script src="{{ asset('../js/script.js') }}"></script>
    <script src="{{ asset('../js/material-dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="https://unpkg.com/popper.js@1"></script>
    <script src="https://unpkg.com/tippy.js@5/dist/tippy-bundle.iife.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentForm;
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            const submitReject = document.getElementById('submitReject');
            const keteranganTextarea = document.getElementById('keteranganTextarea');

            // Event listener untuk tombol reject
            document.querySelectorAll('.btn-reject').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentForm = this.closest('form');
                    modal.show();
                });
            });

            // Event listener untuk tombol submit pada modal
            submitReject.addEventListener('click', function() {
                if (currentForm) {
                    // Cari input hidden keterangan di dalam form
                    const keteranganInput = currentForm.querySelector('input[name="keterangan"]');
                    if (keteranganInput) {
                        keteranganInput.value = keteranganTextarea.value;
                        currentForm.submit();
                    }
                    modal.hide();
                }
            });

            // Reset textarea saat modal ditutup
            document.getElementById('rejectModal').addEventListener('hidden.bs.modal', function() {
                keteranganTextarea.value = '';
            });
        });

        tippy('#terima-button', {
            content: 'Terima',
        });

        tippy('#tolak-button', {
            content: 'Tolak',
        });

        tippy('#detail-tamu', {
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

        function filterPastAppointments() {
            const visitorItems = document.querySelectorAll('.visitor-item');
            const currentTime = new Date();
            let visibleItems = 0;

            visitorItems.forEach(item => {
                const appointmentTime = new Date(item.dataset.appointmentTime);
                const status = item.dataset.status;

                if (appointmentTime < currentTime && status === "Menunggu konfirmasi") {
                    item.style.display = 'none';
                } else {
                    item.style.display = '';
                    visibleItems++;
                }
            });

            let tidakAdaHasil = document.getElementById('noResults');
            if (visibleItems === 0) {
                if (!tidakAdaHasil) {
                    tidakAdaHasil = document.createElement('p');
                    tidakAdaHasil.id = 'noResults';
                    tidakAdaHasil.className = 'text-center text-sm';
                    tidakAdaHasil.textContent = 'Tidak ada hasil ditemukan';
                    document.getElementById('visitor-list').appendChild(tidakAdaHasil);
                } else {
                    tidakAdaHasil.style.display = 'block';
                }
            } else if (tidakAdaHasil) {
                tidakAdaHasil.style.display = 'none';
            }
        }

        // Run the filter function when the page loads
        document.addEventListener('DOMContentLoaded', filterPastAppointments);

        // Optionally, run the filter function every minute to keep the list updated
        setInterval(filterPastAppointments, 60000);



        function setTamuDetails(tamu) {
            const tamuDetails = `
                    <div class="tamu-header align-items-center pt-0" style="display: flex; flex-direction: column;">
                        <img src="${tamu.foto ? '/storage/img-tamu/' + tamu.foto : '/img/logo-hitam.png'}" alt="Foto Tamu" class="tamu-avatar">
                        <h2 class="tamu-name">${tamu.tamu.nama || 'Tidak ada'}</h2>
                        <span class="tamu-email font-weight-bold">${tamu.tamu.email || 'Tidak ada'}</span>
                        <span class="tamu-status status-${tamu.status ? tamu.status.toLowerCase() : 'default'}">${tamu.status || 'Tidak ada'}</span>
                    </div>
                    <div class="info-list">
                        <div class="d-flex justify-content-center">
                            <div class="info-item w-100"><span class="info-label">Alamat</span><span class="info-value">${tamu.tamu.alamat || 'Tidak ada'}</span></div>
                            <div class="info-item w-100"><span class="info-label">No Telepon</span><span class="info-value">${tamu.tamu.no_telp || 'Tidak ada'}</span></div>
                        </div>
                        <div class="info-item"><span class="info-label">Instansi</span><span class="info-value">${tamu.instansi || 'Tidak ada'}</span></div>
                        <div class="info-item"><span class="info-label">Tujuan</span><span class="info-value">${tamu.tujuan || 'Tidak ada'}</span></div>
                        <div class="info-item"><span class="info-label">Pegawai yang dituju</span><span class="info-value">${tamu.user.name || 'Tidak ada'}</span></div>
                        <div class="info-item"><span class="info-label">Waktu Perjanjian</span><span class="info-value">${tamu.waktu_perjanjian || 'Tidak ada'}</span></div>
                    </div>
                `;
            document.getElementById('tamuDetails').innerHTML = tamuDetails;
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
