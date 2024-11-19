<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    -- css --}}
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
    </style>
</head>

<body style="overflow-x:hidden;">

    {{-- sidebar start --}}
    @include('pegawai.components.sidebar')

    {{-- end sidebar --}}

    {{-- section start --}}
    <section class="home">
        @include('pegawai.components.navbar')
        <div class="row p-3">
            <div class="container mt-4">
                <x-breadcrumb />

                <div class="table-container">
                    <div class="card ms-0" style="max-width: 1360px">

                        <div class="card-body px-0 pb-2" style="width: 100%">
                            <div class="m-4 d-flex justify-content-between align-items-center">
                                <x-search-filter-tamu :search="request('search')" :searchBy="request('search_by')" :status="request('status')"
                                action="/pegawai/laporan-tamu" :options="[
                                    'nama_tamu' => 'Nama Tamu',
                                    'email_tamu' => 'Email Tamu',
                                    'nama_pegawai' => 'Pegawai yang dituju',
                                    'instansi' => 'Instansi',
                                    'tujuan' => 'Tujuan',
                                ]" />


                                <div class="d-flex">

                                    <div class="filterStatus ms-2">
                                        <button style="border:none; background:none;" type="button"
                                            class="d-flex align-items-center" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasDateFilte" aria-controls="offcanvasDateFilter">
                                            <i class='bx bxs-file-pdf m-0' style="color: #707070; font-size: 30px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDateFilte"
                                aria-labelledby="offcanvasNotificationLabel">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasNotificationLabel">Download Rekapan PDF</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form id="dateRangeForm">
                                        <div class="mb-3">
                                            <label for="filterType">Pilih Filter:</label>
                                            <select id="filterType" class="form-select"
                                                style="border: 1px solid #d9dee3;">
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

                                        <button type="submit" class="btn btn-primary mt-3 w-100">Generate
                                            PDF</button>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive p-4">
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
                                                            <p class="text-xs mb-0">
                                                                {{ $kedatanganTamu->tamu->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->user->name }}</span>
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
                                                <td class="align-middle text-center">
                                                    <button class="detail-button"
                                                        style="border: none; background:none;"
                                                        data-tamu="{{ json_encode($kedatanganTamu) }}">
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
    </section>
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width:600px">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="tamuDetailModalLabel">Detail Tamu</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="guest-card-compact">
                        <div class="tamu-header align-items-center pt-0"
                            style="display: flex; flex-direction: column;">
                            <img id="tamuAvatar" src="" alt="Foto Tamu" class="tamu-avatar">
                            <h2 id="tamuNama" class="tamu-name"></h2>
                            <span id="tamuEmail" class="tamu-email font-weight-bold"></span>
                            <span id="tamuStatus" class="tamu-status"></span>
                        </div>
                        <div class="card-body">
                            <div class="info-list">
                                <div class="d-flex justify-content-center">
                                    <div class="info-item w-100">
                                        <span class="info-label">Alamat</span>
                                        <span id="tamuAlamat" class="info-value"></span>
                                    </div>
                                    <div class="info-item w-100">
                                        <span class="info-label">No Telepon</span>
                                        <span id="tamuTelepon" class="info-value"></span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Instansi</span>
                                    <span id="tamuInstansi" class="info-value"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Tujuan</span>
                                    <span id="tamuTujuan" class="info-value"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Pegawai yang dituju</span>
                                    <span id="tamuPegawai" class="info-value"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Waktu Perjanjian</span>
                                    <span id="tamuWaktu" class="info-value"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Waktu Kedatangan</span>
                                    <span id="tamuDatang" class="info-value"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

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

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd', // Format sesuai yang Anda inginkan
                autoclose: true, // Menutup Datepicker setelah memilih tanggal
                todayHighlight: true // Menyoroti tanggal hari ini
            });

            // Menampilkan dan menyembunyikan input tanggal
            $('#toggleDatePicker').on('click', function() {
                $('#datePickerContainer').toggleClass('d-none');
            });
        });

        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#laporanTable').DataTable({
                "paging": false,
                "ordering": true,
                "info": false,
                "searching": false,
            });

            function updateUrlAndReload(paramName, paramValue) {
                var url = new URL(window.location.href);
                if (paramValue) {
                    url.searchParams.set(paramName, paramValue);
                } else {
                    url.searchParams.delete(paramName);
                }
                window.location.href = url.toString();
            }

            // Custom search input functionality
            $('#myInput').on('keyup', function() {
                var searchValue = $(this).val();
                updateUrlAndReload('search', searchValue);
            });

            // PTK filter functionality
            $('#filterStatus').on('change', function() {
                var statusValue = $(this).val();
                updateUrlAndReload('status', statusValue);
            });

            $('#laporanTable_filter').hide();
        });



        document.addEventListener('DOMContentLoaded', function() {
            const detailButtons = document.querySelectorAll('.detail-button');
            const modal = new bootstrap.Modal(document.getElementById('modalDetail'));

            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tamuData = JSON.parse(this.getAttribute('data-tamu'));


                    document.getElementById('tamuNama').textContent = tamuData.tamu.nama;
                    document.getElementById('tamuEmail').textContent = tamuData.tamu.email;
                    document.getElementById('tamuStatus').textContent = tamuData.status;
                    document.getElementById('tamuStatus').className =
                        `tamu-status status-${tamuData.status.toLowerCase()}`;

                    document.getElementById('tamuAlamat').textContent = tamuData.tamu.alamat;
                    document.getElementById('tamuTelepon').textContent = tamuData.tamu.no_telp;
                    document.getElementById('tamuInstansi').textContent = tamuData.instansi;
                    document.getElementById('tamuTujuan').textContent = tamuData.tujuan;

                    document.getElementById('tamuPegawai').textContent = tamuData.user.name;
                    document.getElementById('tamuWaktu').textContent = tamuData.waktu_perjanjian;
                    document.getElementById('tamuDatang').textContent = tamuData.waktu_kedatangan;

                    // Perbaikan: Set src untuk avatar
                    document.getElementById('tamuAvatar').src = tamuData.foto ?
                        `/storage/img-tamu/${tamuData.foto}` :
                        '/img/logo-hitam.png';

                    modal.show();
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const modalDetail = document.getElementById('modalDetail');

            modalDetail.addEventListener('hidden.bs.modal', function() {
                // Remove the modal backdrop
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }

                // Reset body styles
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('padding-right');
                document.body.style.removeProperty('overflow');
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const detailButtons = document.querySelectorAll('.detail-button');
            const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
            const imageModal = document.getElementById('imageModal');
            const modalImg = document.getElementById("modalImage");
            const closeBtn = document.querySelector("#imageModal .close");

            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tamuData = JSON.parse(this.getAttribute('data-tamu'));

                    const avatarSrc = tamuData.foto ?
                        `/storage/img-tamu/${tamuData.foto}` :
                        '/img/logo-hitam.png';

                    const tamuAvatar = document.getElementById('tamuAvatar');
                    tamuAvatar.src = avatarSrc;
                    tamuAvatar.setAttribute('data-src', avatarSrc);

                    modal.show();
                });
            });

            // Event listener untuk membuka modal gambar
            document.getElementById('tamuAvatar').addEventListener('click', function() {
                imageModal.style.display = "flex";
                modalImg.src = this.getAttribute('data-src');
                setTimeout(() => {
                    imageModal.classList.add('show');
                }, 10);
            });

            // Event listener untuk menutup modal gambar
            closeBtn.onclick = function() {
                imageModal.classList.remove('show');
                setTimeout(() => {
                    imageModal.style.display = "none";
                }, 300);
            }

            // Menutup modal gambar saat klik di luar gambar
            window.onclick = function(event) {
                if (event.target == imageModal) {
                    imageModal.classList.remove('show');
                    setTimeout(() => {
                        imageModal.style.display = "none";
                    }, 300);
                }
            }
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

                fetch('/pegawai/generate-pdf-tamu', {
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
