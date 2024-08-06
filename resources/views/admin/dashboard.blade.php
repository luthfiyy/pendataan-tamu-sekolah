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

    <title>GuBook</title>
</head>

<body>
    {{-- ===== sidebar ===== --}}

    @include('admin.components.sidebar')


    {{-- ===== sidebar ===== --}}


    {{-- ===== section ===== --}}

    <section class="home">
        {{-- <div class="text">Beranda</div> --}}
        @include('admin.components.navbar')

        <x-breadcrumb />


        {{-- container fluid --}}
        <div class="container mt-4" style="margin-left: 0; margin-right: 0;">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
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

                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
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
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class='bx bxs-graduation'></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0">Total Guru</p>
                                <h4 class="mb-0">{{ $totalEmployees }}</h4>
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
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class='bx bxs-graduation'></i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 ">Total Tenaga Kependidikan</p>
                                <h4 class="mb-0">{{ $totalTendik }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than lask month</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- end container fluid --}}

        <div class="container mt-4">
            <div class="row">
                <!-- Kolom untuk Diagram -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card z-index-2">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-0 pt-5">
                            <h6 class="mb-0">Grafik Tamu dan Kurir SMKN 11 Bandung</h6>
                            <hr class="dark horizontal">
                        </div>
                        <div class="d-flex">
                            <div class="card-body pt-0">
                                <p class="text-sm" style="color: #191919">Periode: <span id="date-range"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom untuk Preview -->
                <div class="col-lg-6 col-md-12">
                    <!-- Daftar Kunjungan Tamu Terbaru -->
                    <div class="card pb-3 mb-4" style="width: 100%;">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 w-40" style="color: #191919">Daftar Kunjungan Tamu Terbaru</h6>
                            <div class="d-flex align-items-center">
                                <p class="text-sm mb-0 ml-2">
                                    <a href="{{ route('admin.laporan-tamu') }}">
                                    <span class="font-weight-bold">Lihat Semua</span>
                                    </a>
                                </p>
                                <i class='bx bx-chevron-right' style="font-size: 30px"></i>
                            </div>
                        </div>

                        @foreach ($tamuTerbaru as $tamu)
                            <div class="card-body pt-0 pb-2" style="background-color: #fff">
                                <div class="preview-tamu">
                                    <span
                                        class="font-weight-bold text-xs">{{ $tamu->created_at->format('d-m-Y H:i:s') }}</span>
                                    <p class="text-m font-weight-bold mb-0 ml-2">{{ $tamu->tamu->nama }}</p>
                                    <p class="text-sm mb-0 ml-2">
                                        Bertemu dengan
                                        <span class="font-weight-bold text-m">{{ $tamu->user->name }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Daftar Kunjungan Kurir Terbaru -->
                    <div class="card pb-3" style="width: 100%;">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 w-40" style="color: #191919">Daftar Kunjungan Kurir Terbaru</h6>
                            <div class="d-flex align-items-center">
                                <p class="text-sm mb-0 ml-2">
                                    <a href="{{ route('admin.laporan-kurir') }}">
                                    <span class="font-weight-bold">Lihat Semua</span>
                                    </a>
                                </p>
                                <i class='bx bx-chevron-right' style="font-size: 30px"></i>
                            </div>
                        </div>

                        @foreach ($kurirTerbaru as $kurir)
                            <div class="card-body pt-0 pb-2" style="background-color: #fff">
                                <div class="preview-tamu">
                                    <span
                                        class="font-weight-bold text-xs">{{ $kurir->created_at->format('d-m-Y H:i:s') }}</span>
                                    <p class="text-m font-weight-bold mb-0 ml-2">{{ $kurir->ekspedisi->nama_kurir }}</p>
                                    <p class="text-sm mb-0 ml-2">
                                        Bertemu dengan
                                        <span class="font-weight-bold text-m">{{ $kurir->user->name }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>



    </section>

    {{-- ===== section ===== --}}


    <script src="{{ asset('../js/script.js') }}"></script>
    <script src="{{ asset('../js/material-dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script>
        // Mengambil konteks grafik
        var ctx = document.getElementById("chart-bars").getContext("2d");

        // Nama hari dalam bahasa Indonesia
        var daysOfWeek = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"];

        // Mendapatkan data dari Blade
        var dataTamu = @json($dataTamu);
        var dataKurir = @json($dataKurir);

        // Membuat grafik bar dengan Chart.js
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: daysOfWeek, // Menggunakan nama hari dalam bahasa Indonesia
                datasets: [{
                        label: "Tamu",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: dataTamu, // Data tamu
                        maxBarThickness: 50
                    },
                    {
                        label: "Kurir",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 0, .8)",
                        data: dataKurir, // Data kurir
                        maxBarThickness: 50
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
                            color: '#fff', // Warna marker label
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
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: 'Mulish',
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
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
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
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

        // Menampilkan rentang tanggal
        function getDateRange() {
            const startDate = new Date();
            const endDate = new Date();
            // Set the start date to the most recent Monday
            startDate.setDate(startDate.getDate() - startDate.getDay() + 1);
            // Set the end date to the most recent Friday
            endDate.setDate(startDate.getDate() + 4);

            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('date-range').textContent =
                `${startDate.toLocaleDateString('id-ID', options)} - ${endDate.toLocaleDateString('id-ID', options)}`;
        }

        // Menjalankan fungsi saat DOM dimuat
        document.addEventListener('DOMContentLoaded', getDateRange);
    </script>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('js/script.js') }}">
</body>

</html>
