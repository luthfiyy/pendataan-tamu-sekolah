<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/core.css') }}">

    {{-- icon --}}
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <style>
        #datePickerContainer {
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

<body style="overflow-x:hidden;">

    {{-- sidebar start --}}
    @include('admin.components.sidebar')

    {{-- end sidebar --}}

    {{-- section start --}}
    <section class="home">
        <div class="container mt-4 ps-3">
            @include('admin.components.navbar')
            <x-breadcrumb />
        </div>
        <div class="row">
            <div class="col-12 ms-3">

                <div class="card ms-0" style="max-width: 1185px">

                    <div class="card-body px-0 pb-2">
                        <div class="m-4 d-flex justify-content-between align-items-center">
                            {{-- resources/views/admin/laporan-kurir.blade.php --}}
                            <x-search-filter-kurir :search="request('search')" :searchBy="request('search_by')" action="/admin/laporan-kurir"
                                :options="[
                                    'nama_kurir' => 'Nama Kurir',
                                    'ekspedisi' => 'Ekspedisi',
                                    'no_telp' => 'No Telepon Kurir',
                                    'pegawai' => 'Pegawai yang dituju',
                                ]" />
                            <div class="d-flex align-items-center">
                               

                                <div class="filterStatus ms-2">
                                    <button style="border:none; background:none;" type="button"
                                        class="d-flex align-items-center" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasDateFilte" aria-controls="offcanvasDateFilter">
                                        <i class='bx bxs-file-pdf m-0' style="color: #707070; font-size: 30px;"></i>
                                    </button>
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
                                            <label for="reportType">Jenis Laporan:</label>
                                            <select id="reportType" class="form-select mb-3">
                                                <option value="summary">Rekapan Kurir</option>
                                                <option value="detail">Detail Kurir</option>
                                            </select>
                                        </div>

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


                                        <button type="submit" class="btn btn-primary mt-3 w-100">Generate
                                            PDF</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-0" id="laporanTable">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                            No</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                            Nama</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                            Ekspedisi</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                            No Telepon</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                            Pegawai yang dituju</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                            Tanggal & Waktu</th>
                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                            Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ekspedisi as $index => $kedatanganEkspedisi)
                                        <tr>
                                            <td>
                                                <h6 class="text-center p-3 mb-0 text-sm">
                                                    {{ $ekspedisi->firstItem() + $index }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center p-3 mb-0 text-sm">
                                                    {{ ucwords(strtolower($kedatanganEkspedisi->ekspedisi->nama_kurir)) }}
                                                </h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center p-3 mb-0 text-sm">
                                                    {{ $kedatanganEkspedisi->ekspedisi->ekspedisi }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center p-3 mb-0 text-sm">
                                                    {{ $kedatanganEkspedisi->ekspedisi->no_telp }}</h6>
                                            </td>
                                            <td class="align-middle text-center">


                                                <h6 class="text-center p-3 mb-0 text-sm">
                                                    {{ $kedatanganEkspedisi->user->name }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="p-3 mb-0 text-sm text-center">
                                                    {{ $kedatanganEkspedisi->tanggal_waktu ? \Carbon\Carbon::parse($kedatanganEkspedisi->tanggal_waktu)->translatedFormat('l, d/m/Y H:i') : '' }}
                                                </h6>
                                            </td>
                                            <td>
                                                <i class="fa-solid fa-image image-icon ms-3" style="color: #707070"
                                                    data-src="{{ $kedatanganEkspedisi->foto ? asset('storage/img-kurir/' . $kedatanganEkspedisi->foto) : asset('img/logo-hitam.png') }}"></i>
                                            </td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pagination-container">
                                {{ $ekspedisi->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- section end --}}
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
    <script src="{{ asset('js/laporan-kurir.js') }}"></script>
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
            // Initialize DataTable tanpa menggunakan search dari DataTables
            var table = $('#laporanTable').DataTable({
                "paging": false,
                "searching": false, // Nonaktifkan pencarian default DataTables
                "ordering": true,
                "info": false
            });
            x

            // Custom search input functionality
            $('#myInput').on('keyup', function() {
                $('#searchForm').submit(); // Submit form ketika user mengetik
            });

            $('#laporanTable_filter').hide();
        });

        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('imageModal');
            var modalImg = document.getElementById("modalImage");
            var closeBtn = document.getElementsByClassName("close")[0];

            // Ambil semua elemen dengan kelas avatar-l
            var images = document.querySelectorAll('.image-icon');

            // Tambahkan event listener untuk setiap gambar
            images.forEach(function(img) {
                img.onclick = function() {
                    modal.style.display = "flex";
                    modalImg.src = this.getAttribute(
                        'data-src'); // Ambil URL gambar dari atribut data-src
                    setTimeout(() => {
                        modal.classList.add('show'); // Tambahkan kelas show untuk animasi
                    }, 10);
                }
            });

            // Fungsi untuk menutup modal
            function closeModal() {
                modal.classList.remove('show'); // Hapus kelas show untuk animasi
                setTimeout(() => {
                    modal.style.display = "none";
                }, 300); // Sesuaikan dengan durasi transisi
            }

            // Tutup modal saat tombol close diklik
            closeBtn.onclick = closeModal;

            // Tutup modal saat klik di luar gambar
            window.onclick = function(event) {
                if (event.target == modal) {
                    closeModal();
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
                    reportType: document.getElementById('reportType').value
                };

                switch (filterType.value) {
                    case 'month':
                        data = {
                            ...data,
                            type: 'month',
                            value: document.getElementById('monthInput').value
                        };
                        break;
                    case 'date_range':
                        data = {
                            ...data,
                            type: 'date_range',
                            start: document.getElementById('startDate').value,
                            end: document.getElementById('endDate').value
                        };
                        break;
                    case 'year':
                        data = {
                            ...data,
                            type: 'year',
                            value: document.getElementById('yearInput').value
                        };
                        break;
                    default:
                        alert('Pilih jenis filter terlebih dahulu');
                        return;
                }

                // Show loading state
                const downloadPdfBtn = document.getElementById('downloadPdfBtn');
                downloadPdfBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Generating PDF...';
                downloadPdfBtn.disabled = true;

                fetch('/generate-pdf-kurir', {
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
                            link.download = 'rekap_kurir.pdf';
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
