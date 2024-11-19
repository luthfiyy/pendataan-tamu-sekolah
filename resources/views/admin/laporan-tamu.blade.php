<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}">

    {{-- icon --}}
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <title>GuBook</title>

    <style>
        #datePickerContainer {
            z-index: 1000;
            background-color: white;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            right: 0
        }

        .offcanvas-backdrop {
            z-index: 1040 !important;
        }

        .offcanvas {
            z-index: 1050 !important;
        }
    </style>
</head>

<body style="overflow-x:hidden;">

    {{-- sidebar start --}}
    @include('admin.components.sidebar')

    {{-- end sidebar --}}

    {{-- section start --}}
    <section class="home">
        <div class="row">
            <div class="col-12">
                @include('admin.components.navbar')

                <div class="mt-4 mb-5" style="margin-left: 30px">
                    <x-breadcrumb />
                </div>

                <div class="table-container">
                    <div class="card my-4" style="max-width: 1340px">

                        <div class="m-4 d-flex justify-content-between align-items-center">
                            <x-search-filter-tamu :search="request('search')" :searchBy="request('search_by')" :status="request('status')"
                                action="/admin/laporan-tamu" :options="[
                                    'nama_tamu' => 'Nama Tamu',
                                    'email_tamu' => 'Email Tamu',
                                    'nama_pegawai' => 'Pegawai yang dituju',
                                    'instansi' => 'Instansi',
                                    'tujuan' => 'Tujuan',
                                ]" />

                            <div class="d-flex">
                                <div class="position-relative h-100">
                                    <div class="ms-1 filterStatus">
                                        <button id="toggleDatePicker" style="border:none; background:none;"
                                            class="d-flex align-items-center"><i class='bx bxs-calendar m-0'
                                                style="font-size: 30px;"></i></button>
                                    </div>
                                    <div id="datePickerContainer" class=" d-none position-absolute">
                                        <form action="{{ route('admin.laporan-tamu') }}" method="GET"
                                            class="d-flex flex-column w-100">
                                            <div class="input-group me-2 w-100">
                                                <input type="date" name="start_date" class="form-control mb-1"
                                                    placeholder="Tanggal Mulai" value="{{ request('start_date') }}">
                                            </div>
                                            <div class="input-group me-2 w-100 mb-1">
                                                <input type="date" name="end_date" class="form-control"
                                                    placeholder="Tanggal Akhir" value="{{ request('end_date') }}">
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="filterStatus ms-2">
                                    <button style="border:none; background:none;" type="button"
                                        class="d-flex align-items-center" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasDateFilter" aria-controls="offcanvasDateFilter">
                                        <i class='bx bxs-file-pdf m-0' style="color: #707070; font-size: 30px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="offcanvas offcanvas-end" tabindex="0" id="offcanvasDateFilter"
                            aria-labelledby="offcanvasNotificationLabel" data-bs-backdrop="true">

                            <div class="offcanvas-header">
                                <h5 id="offcanvasNotificationLabel">Download Rekapan PDF</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <form id="dateRangeForm">
                                    <div class="mb-3">
                                        <label for="filterType">Pilih Filter:</label>
                                        <select id="filterType" class="form-select" style="border: 1px solid #d9dee3;">
                                            <option value="month" selected>Filter Bulan</option>
                                            <option value="date_range">Filter Rentang Tanggal</option>
                                            <option value="year">Filter Tahun</option>
                                        </select>
                                    </div>

                                    <!-- Month Filter -->
                                    <div id="monthFilter" style="display:none;">
                                        <label for="monthInput">Pilih Bulan:</label>
                                        <input type="month" id="monthInput" class="form-control">
                                    </div>

                                    <!-- Date Range Filter -->
                                    <div id="dateRangeFilter" style="display:none;">
                                        <label for="startDate">Mulai Tanggal:</label>
                                        <input type="date" id="startDate" class="form-control">
                                        <label for="endDate">Sampai Tanggal:</label>
                                        <input type="date" id="endDate" class="form-control">
                                    </div>

                                    <!-- Year Filter -->
                                    <div id="yearFilter" style="display:none;">
                                        <label for="yearInput">Pilih Tahun:</label>
                                        <input type="number" id="yearInput" class="form-control">
                                    </div>

                                    <!-- New: Report Type -->
                                    <div class="mb-3">
                                        <label for="reportType">Jenis Laporan:</label>
                                        <select id="reportType" class="form-select"
                                            style="border: 1px solid #d9dee3;">
                                            <option value="summary">Rekapan</option>
                                            <option value="detail">Detail Tamu</option>
                                        </select>
                                    </div>

                                    <!-- New: Status Filter -->
                                    <div class="mb-3">
                                        <label for="statusFilter">Filter Status:</label>
                                        <select id="statusFilter" class="form-select"
                                            style="border: 1px solid #d9dee3;">
                                            <option value="">Semua Status</option>
                                            <option value="Menunggu konfirmasi">Menunggu konfirmasi</option>
                                            <option value="Diterima">Diterima</option>
                                            <option value="Ditolak">Ditolak</option>

                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3 w-100">Generate PDF</button>
                                </form>
                            </div>
                        </div>


                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 p-3" id="laporanTable">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">No</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">Informasi
                                            Tamu</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">Pegawai
                                        </th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder ">Waktu
                                            Perjanjian</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder ">Waktu
                                            Kedatangan</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder ">Status
                                        </th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder ">Detail
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tamus as $index => $kedatanganTamu)
                                        <tr>
                                            <td class="align-middle text-center text-sm p-4">
                                                <span
                                                    class="text-center text-secondary text-xs font-weight-bold">{{ $tamus->firstItem() + $index }}</span>
                                            </td>
                                            <td>
                                                <div
                                                    class="d-flex px-2 py-1 justify-content-center align-items-center w-100">
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-items-center text-center">


                                                        <h6 class="mb-0 text-sm font-weight-bold">
                                                            {{ ucwords(strtolower($kedatanganTamu->tamu->nama)) }}
                                                        </h6>
                                                        {{-- <span
                                                                    class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->tamu->no_telp }}</span> --}}
                                                        <p class="text-xs mb-0">
                                                            {{ $kedatanganTamu->tamu->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ ucwords(strtolower($kedatanganTamu->user->name)) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span {{-- class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->format('d/m/Y H:i') }}</span> --}}
                                                    class="font-weight-bold text-xs">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->translatedFormat('l, d/m/Y, H:i') }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-xs font-weight-bold mb-0">
                                                    @php
                                                        $isLate =
                                                            $kedatanganTamu->status === 'Diterima' &&
                                                            !$kedatanganTamu->waktu_kedatangan &&
                                                            \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)
                                                                ->addMinutes(30)
                                                                ->lessThan(now());
                                                    @endphp

                                                    @if ($isLate)
                                                        Tamu Tidak Datang
                                                    @elseif ($kedatanganTamu->status === 'Ditolak')
                                                        Tamu Ditolak
                                                    @elseif ($kedatanganTamu->status === 'Menunggu konfirmasi' && $kedatanganTamu->waktu_perjanjian < now())
                                                        Tamu Tidak Dikonfirmasi
                                                    @elseif ($kedatanganTamu->status === 'Menunggu konfirmasi')
                                                        Menunggu Konfirmasi
                                                    @else
                                                        {{ $kedatanganTamu->waktu_kedatangan ? \Carbon\Carbon::parse($kedatanganTamu->waktu_kedatangan)->translatedFormat('l, d/m/Y, H:i') : 'Tamu Belum Datang' }}
                                                    @endif
                                                </span>

                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if ($kedatanganTamu->status === 'Diterima')
                                                    <span
                                                        class="bg-gradient-success">{{ $kedatanganTamu->status }}</span>
                                                @elseif ($kedatanganTamu->status === 'Ditolak')
                                                    <span
                                                        class="bg-gradient-danger">{{ $kedatanganTamu->status }}</span>
                                                @else
                                                    <span
                                                        class="bg-gradient-dark">{{ $kedatanganTamu->status }}</span>
                                                @endif
                                            </td>
                                            {{-- <td class="align-middle text-center">
                                                    <i class="fa-solid fa-image image-icon"
                                                        data-src="{{ $kedatanganTamu->foto ? asset('storage/img-tamu/' . $kedatanganTamu->foto) : asset('img/logo-hitam.png') }}"></i>
                                                </td> --}}
                                            <td class="align-middle text-center">
                                                <button class="detail-button" style="border: none; background:none;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tamuDetailModal-{{ $kedatanganTamu->id }}">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-container">
                                {{ $tamus->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        </div>
        </div>
    </section>

    @foreach ($tamus as $kedatanganTamu)
        <div class="modal fade" id="tamuDetailModal-{{ $kedatanganTamu->id }}" tabindex="-1"
            aria-labelledby="tamuDetailModalLabel-{{ $kedatanganTamu->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="max-width:600px">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="guest-card-compact">
                            <div class="tamu-header align-items-center pt-0"
                                style="display: flex; flex-direction: column;">
                                <img src="{{ $kedatanganTamu->foto ? asset('storage/img-tamu/' . $kedatanganTamu->foto) : asset('img/logo-hitam.png') }}"
                                    alt="Foto Tamu" class="tamu-avatar" data-bs-toggle="modal"
                                    data-bs-target="#imageModal-{{ $kedatanganTamu->id }}">
                                <h2 class="tamu-name">{{ $kedatanganTamu->tamu->nama }}</h2>
                                <span class="tamu-email font-weight-bold">{{ $kedatanganTamu->tamu->email }}</span>
                                <span
                                    class="tamu-status status-{{ Str::slug($kedatanganTamu->status) }}">{{ $kedatanganTamu->status }}</span>
                            </div>
                            <div class="card-body">
                                <div class="info-list">
                                    <div class="d-flex justify-content-center">
                                        <div class="info-item w-100">
                                            <span class="info-label">Alamat</span>
                                            <span class="info-value">{{ $kedatanganTamu->tamu->alamat ?? '-' }}</span>
                                        </div>
                                        <div class="info-item w-100">
                                            <span class="info-label">No Telepon</span>
                                            <span
                                                class="info-value">{{ $kedatanganTamu->tamu->no_telp ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Instansi</span>
                                        <span class="info-value">{{ $kedatanganTamu->instansi ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Tujuan</span>
                                        <span class="info-value">{{ $kedatanganTamu->tujuan ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Pegawai yang dituju</span>
                                        <span class="info-value">{{ $kedatanganTamu->user->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Waktu Perjanjian</span>
                                        <span
                                            class="info-value">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->translatedFormat('l, d/m/Y, H:i') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Waktu Kedatangan</span>
                                        <span class="info-value">
                                            @if ($kedatanganTamu->waktu_kedatangan)
                                                {{ \Carbon\Carbon::parse($kedatanganTamu->waktu_kedatangan)->translatedFormat('l, d/m/Y, H:i') }}
                                            @elseif ($kedatanganTamu->status === 'Ditolak')
                                                Tamu Ditolak
                                            @elseif ($kedatanganTamu->status === 'Menunggu konfirmasi' && $kedatanganTamu->waktu_perjanjian < now())
                                                Tamu Tidak Dikonfirmasi
                                            @elseif ($kedatanganTamu->status === 'Menunggu konfirmasi')
                                                Menunggu Konfirmasi
                                            @elseif (
                                                $kedatanganTamu->status === 'Diterima' &&
                                                    \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->addMinutes(30)->lessThan(now()))
                                                Tamu Tidak Datang
                                            @else
                                                Tamu Belum Datang
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal untuk tampilan gambar full --}}
        <div class="modal fade" id="imageModal-{{ $kedatanganTamu->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered justify-content-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ $kedatanganTamu->foto ? asset('storage/img-tamu/' . $kedatanganTamu->foto) : asset('img/logo-hitam.png') }}"
                            alt="Foto Tamu" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- PDF Preview Modal -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered"
            style="max-width: 60vw; margin: 1rem auto; justify-content: center;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfPreviewModalLabel">Preview PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                    <!-- PDF Preview Container -->
                    <div class="pdf-preview-container"
                        style="height: calc(85vh - 180px); width: 100%; border: 1px solid #dee2e6; margin-bottom: 1rem;">
                        <iframe id="pdfPreviewFrame" style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <i class='bx bx-info-circle me-2'></i>
                        PDF telah berhasil dibuat. Anda dapat melihat preview di atas atau mengunduhnya.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x'></i> Tutup
                    </button>
                    <button type="button" class="btn btn-primary" id="downloadPdfBtn">
                        <i class='bx bx-download'></i> Unduh PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- section end --}}

    <script src="{{ asset('js/script2.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi datepicker
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd", // Format sesuai yang Anda inginkan
                autoclose: true, // Menutup Datepicker setelah memilih tanggal
                todayHighlight: true, // Menyoroti tanggal hari ini
            });

            // Menampilkan dan menyembunyikan input tanggal
            $("#toggleDatePicker").on("click", function() {
                $("#datePickerContainer").toggleClass("d-none");
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const filterType = document.getElementById('filterType');
            const monthFilter = document.getElementById('monthFilter');
            const dateRangeFilter = document.getElementById('dateRangeFilter');
            const yearFilter = document.getElementById('yearFilter');
            const form = document.getElementById('dateRangeForm');
            const pdfPreviewModal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
            let currentPdfUrl = null;

            // Show default filter when page loads
            if (filterType.value === 'month') {
                monthFilter.style.display = 'block';
                dateRangeFilter.style.display = 'none';
                yearFilter.style.display = 'none';
            }

            filterType.addEventListener('change', function() {
                monthFilter.style.display = 'none';
                dateRangeFilter.style.display = 'none';
                yearFilter.style.display = 'none';

                switch (this.value) {
                    case 'month':
                        monthFilter.style.display = 'block';
                        break;
                    case 'date_range':
                        dateRangeFilter.style.display = 'block';
                        break;
                    case 'year':
                        yearFilter.style.display = 'block';
                        break;
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let data = {
                    type: document.getElementById('filterType').value,
                    report_type: document.getElementById('reportType').value,
                    status: document.getElementById('statusFilter').value
                };

                // Get the appropriate value based on filter type
                switch (data.type) {
                    case 'month':
                        data.value = document.getElementById('monthInput').value;
                        break;
                    case 'date_range':
                        data.start = document.getElementById('startDate').value;
                        data.end = document.getElementById('endDate').value;
                        break;
                    case 'year':
                        data.value = document.getElementById('yearInput').value;
                        break;
                }

                // Show loading state
                const downloadPdfBtn = document.getElementById('downloadPdfBtn');
                downloadPdfBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Generating PDF...';
                downloadPdfBtn.disabled = true;

                fetch('/generate-pdf-tamu', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.blob();
                    })
                    .then(blob => {
                        // Create a URL for the PDF blob
                        if (currentPdfUrl) {
                            URL.revokeObjectURL(currentPdfUrl);
                        }
                        currentPdfUrl = URL.createObjectURL(blob);

                        // Set the PDF preview in the iframe
                        const previewFrame = document.getElementById('pdfPreviewFrame');
                        previewFrame.src = currentPdfUrl;

                        // Reset download button state
                        downloadPdfBtn.innerHTML = '<i class="bx bx-download"></i> Unduh PDF';
                        downloadPdfBtn.disabled = false;

                        // Set up download button
                        downloadPdfBtn.onclick = function() {
                            const link = document.createElement('a');
                            link.href = currentPdfUrl;
                            link.download = 'rekap_tamu.pdf';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        };

                        // Close the filter offcanvas
                        const offcanvasElement = document.getElementById('offcanvasDateFilter');
                        const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                        if (offcanvas) {
                            offcanvas.hide();
                        }

                        // Show the PDF preview modal
                        pdfPreviewModal.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengunduh PDF: ' + error.message);

                        // Reset download button state on error
                        downloadPdfBtn.innerHTML = '<i class="bx bx-download"></i> Unduh PDF';
                        downloadPdfBtn.disabled = false;
                    });
            });

            // Clean up object URL when modal is hidden
            document.getElementById('pdfPreviewModal').addEventListener('hidden.bs.modal', function() {
                if (currentPdfUrl) {
                    URL.revokeObjectURL(currentPdfUrl);
                    currentPdfUrl = null;
                }
            });
        });
    </script>
</body>

</html>
