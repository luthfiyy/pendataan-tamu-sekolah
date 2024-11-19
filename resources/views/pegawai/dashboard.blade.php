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



    <style>
        .custom-popover {
            background-color: #f4f4f4;
            border-color: #7F82FF;
            color: #333;
        }

        .custom-popover .popover-header {
            background-color: #7F82FF;
            color: #fff;
        }

        .custom-popover .popover-body {
            font-size: 14px;
        }

        #date-filter-form {
            position: absolute;
            z-index: 1000;
            background-color: white;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            right: 0;
        }
    </style>

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


        <div class="row p-3">
            <div class="container mt-4" style="margin-left: 0; margin-right: 0;">
                <x-breadcrumb />

                <div class="row">

                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg gradient-success gradient-shadow-success text-center border-radius-xl mt-n4 position-absolute d-flex align-items-center justify-content-center
                                    ">
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

                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg  gradient-info gradient-shadow-info text-center border-radius-xl mt-n4 position-absolute d-flex align-items-center justify-content-center
                                    ">
                                    <i class='bx bxs-package'></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 ">Total Kurir Hari Ini</p>
                                    <h4 class="mb-0">{{ $totalKurirHariIni }}</h4>
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
                                <div
                                    class="icon icon-lg gradient-success gradient-shadow-success text-center border-radius-xl mt-n4 position-absolute d-flex align-items-center justify-content-center
                                    ">
                                    <i class='bx bx-user'></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 ">Total Tamu Bulan Ini</p>
                                    <h4 class="mb-0">{{ $totalTamuBulanIni }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                {{-- <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg  gradient-info gradient-shadow-info text-center border-radius-xl mt-n4 position-absolute d-flex align-items-center justify-content-center
                                    ">
                                    <i class='bx bxs-package'></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 ">Total Kurir Bulan Ini</p>
                                    <h4 class="mb-0">{{ $totalKurirBulanIni }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p> --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- end container fluid --}}

            <div class="container mt-4">
                <div class="row">
                    <!-- Kolom untuk Diagram -->
                    <div class="col-lg-7 col-md-12 mb-4">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <div class="chart">
                                        <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-5 pb-2 d-flex justify-content-between">
                                <p class="text-lg mb-0 w-60">Grafik Pendaftaran Tamu dan Kurir SMKN 11 Bandung</p>
                                <div class="">

                                    <button id="filter-toggle" style="border: none; background:none;">
                                        <i class="bx bx-calendar" style="font-size: 24px;"></i>
                                    </button>
                                    <form id="date-filter-form" style="display: none;">
                                        <div class="d-flex flex-column mt-2">
                                            <div class="col-md-5 w-100 mb-1">
                                                <input type="month" id="month-select" name="month"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-5 w-100">
                                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr class="dark horizontal">
                            <div class="d-flex">
                                <div class="card-body pt-0">
                                    <p class="text-sm" style="color: #191919">Periode: <span id="date-range"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-12 mb-4">
                        <div class="accordion mt-3" id="accordionExample">
                            <!-- Accordion 1: Tamu yang Akan Datang Hari Ini -->
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                        <h6 class="m-3 w-100" style="color: #191919">Tamu yang Akan Datang Hari Ini</h6>
                                    </button>
                                </h2>
                                <div id="accordionOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                            @if (count($tamuAkanDatang) > 0)
                                                @foreach ($tamuAkanDatang as $tamu)
                                                    <div class="card-body p-2">
                                                        <div class="preview-tamu d-flex align-items-center p-3"
                                                            style="background-color: #E0F7FC;">
                                                            <button type="submit" class="avatar-kunjungan ms-0"
                                                                style="border: none; background: none;">
                                                                <i class="fa-solid fa-address-card"
                                                                    style="font-size: 30px"></i>
                                                            </button>
                                                            <div class="p-2">
                                                                <span class="font-weight-bold text-xs">Waktu perjanjian:
                                                                    {{ \Carbon\Carbon::parse($tamu->waktu_perjanjian)->translatedFormat('l d-m-Y, H:i:s') }}</span>
                                                                <p class="text-sm font-weight-bold mb-0 ml-2">
                                                                    {{ ucwords(strtolower($tamu->tamu->nama)) }}
                                                                </p>
                                                                <p class="text-sm mb-0 ml-2">
                                                                    Bertemu dengan
                                                                    <span
                                                                        class="font-weight-bold text-sm">{{ ucwords(strtolower($tamu->user->name)) }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="card-body p-2">
                                                    <div class="text-center p-3">
                                                        <p class="text-muted mb-0">Tidak ada tamu yang akan datang hari ini
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-3 mt-auto">
                                            {{ $tamuAkanDatang->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionFive" aria-expanded="false"
                                        aria-controls="accordionFive">
                                        <h6 class="m-3 w-100" style="color: #191919">Tamu yang Sudah Datang Hari Ini</h6>
                                    </button>
                                </h2>
                                <div id="accordionFive" class="accordion-collapse collapse "
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                            @if (count($tamuSudahDatang) > 0)
                                                @foreach ($tamuSudahDatang as $tamu)
                                                    <div class="card-body p-2">
                                                        <div class="preview-tamu d-flex align-items-center p-3"
                                                            style="background-color: #E0F7FC;">
                                                            <button type="submit" class="avatar-kunjungan ms-0"
                                                                style="border: none; background: none;">
                                                                <i class="fa-solid fa-address-card"
                                                                    style="font-size: 30px"></i>
                                                            </button>
                                                            <div class="p-2">
                                                                <span class="font-weight-bold text-xs">Waktu perjanjian:
                                                                    {{ $tamu->created_at->translatedFormat('l d-m-Y, H:i:s') }}</span>
                                                                <p class="text-sm font-weight-bold mb-0 ml-2">
                                                                    {{ ucwords(strtolower($tamu->tamu->nama)) }}
                                                                </p>
                                                                <p class="text-sm mb-0 ml-2">
                                                                    Bertemu dengan
                                                                    <span
                                                                        class="font-weight-bold text-sm">{{ ucwords(strtolower($tamu->user->name)) }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="card-body p-2">
                                                    <div class="text-center p-3">
                                                        <p class="text-muted mb-0">Tidak ada tamu yang akan datang hari ini
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-3 mt-auto">
                                            {{ $tamuAkanDatang->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Accordion 2: Tamu yang Menunggu Konfirmasi -->
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionTwo" aria-expanded="false"
                                        aria-controls="accordionTwo">
                                        <h6 class="m-3 w-100" style="color: #191919">Tamu yang Menunggu Konfirmasi</h6>
                                    </button>
                                </h2>
                                <div id="accordionTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @if (count($tamuMenungguKonfirmasi) > 0)
                                            @foreach ($tamuMenungguKonfirmasi as $tamu)
                                                <div class="card-body p-2" style="background-color: #fff">
                                                    <div class="preview-tamu d-flex align-items-center p-3"
                                                        style="background-color: #E0F7FC;">
                                                        <button type="submit" class="avatar-kunjungan ms-0"
                                                            id="detail"
                                                            style="border: none; background: none; cursor: pointer;">
                                                            <i class="fa-solid fa-address-card"
                                                                style="font-size: 30px"></i>
                                                        </button>
                                                        <div class="p-2">
                                                            <span class="font-weight-bold text-xs">Waktu perjanjian:
                                                                {{ \Carbon\Carbon::parse($tamu->waktu_perjanjian)->translatedFormat('l d-m-Y, H:i:s') }}</span>
                                                            <p class="text-sm font-weight-bold mb-0 ml-2">
                                                                {{ ucwords(strtolower($tamu->tamu->nama)) }}</p>
                                                            <p class="text-sm mb-0 ml-2">
                                                                Bertemu dengan
                                                                <span
                                                                    class="font-weight-bold text-sm">{{ $tamu->user->name }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card-body p-2">
                                                <div class="text-center p-3">
                                                    <p class="text-muted mb-0">Tidak ada tamu yang menunggu konfirmasi</p>
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                    <div class="p-3 mt-auto">
                                        {{ $tamuMenungguKonfirmasi->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Accordion 3: Tamu yang Ditolak -->
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionThree" aria-expanded="false"
                                        aria-controls="accordionThree">
                                        <h6 class="m-3 w-100" style="color: #191919">Tamu yang Ditolak Hari Ini</h6>
                                    </button>
                                </h2>
                                <div id="accordionThree" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @if (count($tamuDitolak) > 0)
                                            @foreach ($tamuDitolak as $tamu)
                                                <div class="card-body p-2" style="background-color: #fff">
                                                    <div class="preview-tamu d-flex align-items-center p-3"
                                                        style="background-color: #E0F7FC;">
                                                        <button type="submit" class="avatar-kunjungan ms-0"
                                                            id="detail"
                                                            style="border: none; background: none; cursor: pointer;">
                                                            <i class="fa-solid fa-address-card"
                                                                style="font-size: 30px"></i>
                                                        </button>
                                                        <div class="p-2">
                                                            <span class="font-weight-bold text-xs">Waktu perjanjian:
                                                                {{ \Carbon\Carbon::parse($tamu->waktu_perjanjian)->translatedFormat('l d-m-Y, H:i:s') }}</span>
                                                            <p class="text-sm font-weight-bold mb-0 ml-2">
                                                                {{ ucwords(strtolower($tamu->tamu->nama)) }}</p>
                                                            <p class="text-sm mb-0 ml-2">
                                                                Bertemu dengan
                                                                <span
                                                                    class="font-weight-bold text-sm">{{ $tamu->user->name }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card-body p-2">
                                                <div class="text-center p-3">
                                                    <p class="text-muted mb-0">Tidak ada tamu yang ditolak hari ini</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3 mt-auto">
                                        {{ $tamuDitolak->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Accordion 4: Kurir Hari Ini -->
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionFour" aria-expanded="false"
                                        aria-controls="accordionFour">
                                        <h6 class="m-3 w-100" style="color: #191919">Kurir Hari Ini</h6>
                                    </button>
                                </h2>
                                <div id="accordionFour" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @if (count($kurirHariIni) > 0)
                                            @foreach ($kurirHariIni as $kurir)
                                                <div class="card-body pt-0 pb-2" style="background-color: #fff">
                                                    <div class="preview-tamu d-flex align-items-center p-3"
                                                        style="background-color: #E7E7FF;">
                                                        <button type="button" class="avatar-kunjungan ms-0"
                                                            id="detail-{{ $kurir->id }}"
                                                            style="border: none; background: none; cursor: pointer;"
                                                            data-bs-toggle="popover" data-bs-html="true"
                                                            data-bs-content="<div style='text-align: center;'><img src='{{ asset('storage/img-kurir/' . $kurir->foto) }}' alt='Foto Kurir' width='100px'> <br>Detail kurir: {{ $kurir->ekspedisi->nama_kurir }} bertemu dengan {{ $kurir->user->name }} pada {{ $kurir->created_at->format('d-m-Y H:i:s') }}</div>"
                                                            data-bs-custom-class="custom-popover"
                                                            data-bs-placement="left">
                                                            <i class="bx bxs-package"
                                                                style="font-size: 40px; color: #7F82FF;"></i>
                                                        </button>
                                                        <div class="p-2">
                                                            <span class="font-weight-bold text-xs">Waktu kedatangan:
                                                                {{ $kurir->created_at->translatedFormat('l d-m-Y, H:i:s') }}</span>
                                                            <p class="text-sm font-weight-bold mb-0 ml-2">
                                                                {{ ucwords(strtolower($kurir->ekspedisi->nama_kurir)) }}
                                                            </p>
                                                            <p class="text-sm mb-0 ml-2">
                                                                Bertemu dengan
                                                                <span
                                                                    class="font-weight-bold text-sm">{{ $kurir->user->name }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card-body p-2">
                                                <div class="text-center p-3">
                                                    <p class="text-muted mb-0">Tidak ada kurir yang datang hari ini</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3 mt-auto">
                                        {{ $kurirHariIni->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        {{-- container fluid --}}



    </section>

    {{-- ===== section ===== --}}


    <script src="{{ asset('../js/script.js') }}"></script>
    <script src="{{ asset('../js/material-dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterToggle = document.getElementById('filter-toggle');
            const dateFilterForm = document.getElementById('date-filter-form');
            const monthSelect = document.getElementById('month-select');
            const dateRangeElement = document.getElementById('date-range');
            let chart; // Will store our Chart.js instance

            function updateDateRange(monthYear) {
                const [year, month] = monthYear.split('-');
                const startDate = new Date(year, month - 1, 1);
                const endDate = new Date(year, month, 0);
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dateRangeElement.textContent =
                    `${startDate.toLocaleDateString('id-ID', options)} - ${endDate.toLocaleDateString('id-ID', options)}`;
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                return `${date.getDate()}`;
            }

            // Set initial month value and update date range
            const urlParams = new URLSearchParams(window.location.search);
            const monthParam = urlParams.get('month');
            if (monthParam) {
                monthSelect.value = monthParam;
                updateDateRange(monthParam);
            } else {
                const currentDate = new Date();
                const currentMonthYear =
                    `${currentDate.getFullYear()}-${(currentDate.getMonth() + 1).toString().padStart(2, '0')}`;
                monthSelect.value = currentMonthYear;
                updateDateRange(currentMonthYear);
            }

            filterToggle.addEventListener('click', function() {
                dateFilterForm.style.display = dateFilterForm.style.display === 'none' ? 'block' : 'none';
            });

            dateFilterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const selectedMonth = monthSelect.value;
                updateDateRange(selectedMonth);

                // Update URL with the new month parameter
                const url = new URL(window.location);
                url.searchParams.set('month', selectedMonth);
                window.history.pushState({}, '', url);

                // Fetch new data and update the chart
                fetchDataAndUpdateChart(selectedMonth);
            });

            function fetchDataAndUpdateChart(selectedMonth) {
                fetch(`/pegawai/dashboard?month=${selectedMonth}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update chart with new data
                        chart.data.datasets[0].data = Object.values(data.dataTamu);
                        chart.data.datasets[1].data = Object.values(data.dataKurir);
                        chart.data.labels = Object.keys(data.dataTamu).map(formatDate);
                        chart.update();

                        // Update other elements on the page
                        document.getElementById('totalTamuBulanIni').textContent = data.totalTamuPeriode;
                        document.getElementById('totalKurirBulanIni').textContent = data.totalKurirPeriode;
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Initialize the chart
            function initChart(initialData) {
                var ctx = document.getElementById("chart-bars").getContext("2d");

                chart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: Object.keys(initialData.dataTamu).map(formatDate),
                        datasets: [{
                                label: "Tamu",
                                tension: 0.4,
                                borderWidth: 0,
                                borderRadius: 4,
                                borderSkipped: false,
                                backgroundColor: "rgba(255, 255, 255, .8)",
                                data: Object.values(initialData.dataTamu),
                                maxBarThickness: 8
                            },
                            {
                                label: "Kurir",
                                tension: 0.4,
                                borderWidth: 0,
                                borderRadius: 4,
                                borderSkipped: false,
                                backgroundColor: "rgba(255, 255, 0, .8)",
                                data: Object.values(initialData.dataKurir),
                                maxBarThickness: 8
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#fff',
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(255, 255, 255, .2)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value % 5 === 0 ? value : null;
                                    },
                                    stepSize: 5,
                                    beginAtZero: true,
                                    padding: 10,
                                    font: {
                                        size: 10,
                                        weight: 300,
                                        family: 'Mulish',
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                    color: "#fff"
                                },
                                afterDataLimits: (scale) => {
                                    scale.max = Math.max(Math.ceil(scale.max / 5) * 5, 25);
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(255, 255, 255, .2)'
                                },
                                ticks: {
                                    autoSkip: false,
                                    display: true,
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 10,
                                        weight: 300,
                                        family: 'Mulish',
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    },
                });
            }

            // Initialize chart with initial data
            initChart({
                dataTamu: @json($dataTamu),
                dataKurir: @json($dataKurir)
            });

            // Initialize popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9FfN2IO49JWKNj4Xc4lTnL8E+vsgYV8h6i+n81paAnw1Pp8DAfB1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-c0vJ+c44F1c8Upct9c0V6sHFeKt9Wv9m6rKf6BqP8Iq5k5hBf9Wh9oQAK86b8G0E" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('js/script.js') }}">
</body>

</html>
