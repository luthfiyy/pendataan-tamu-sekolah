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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">



    <title>GuBook</title>
</head>

<body style="overflow-x:hidden;">

    {{-- sidebar start --}}
    @include('pegawai.components.sidebar')

    {{-- end sidebar --}}

    <section class="home">
        {{-- <div class="text">Beranda</div> --}}
        @include('pegawai.components.navbar')


        <div class="row p-3">
            <div class="container mt-4">
                <x-breadcrumb />

                <div class="card my-4" style="max-width: 1380px">

                    <div class="card-body px-0 pb-2" style="width: 100%">
                        <div class="m-4 d-flex justify-content-between align-items-center">
                            <div class="search d-flex align-items-center">
                                <i class='bx bx-search'></i>
                                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari..">
                            </div>
                            <div class="export">
                                <a href="{{ route('pegawai.kurir.export') }}"
                                    class="d-flex align-items-center rounded-lg px-3 py-1 text-green-500 transition-all ease-in-out hover:btn hover:btn-success hover:btn-sm">
                                    <i class="fa-solid fa-file-export"></i>
                                    Export
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive p-4">
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
                                    @if ($ekspedisi->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center p-4 text-sm">
                                                <h6 class="text-center p-2 text-sm">Tidak Ada Laporan Ekspedisi</h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($ekspedisi as $index => $kedatanganEkspedisi)
                                            <tr>
                                                <td>
                                                    <h6 class="p-3 mb-0 text-sm">
                                                        {{ $index + 1 }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="p-3 mb-0 text-sm">
                                                        {{ $kedatanganEkspedisi->ekspedisi->nama_kurir }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="p-3 mb-0 text-sm">
                                                        {{ $kedatanganEkspedisi->ekspedisi->ekspedisi }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="p-3 mb-0 text-sm">
                                                        {{ $kedatanganEkspedisi->ekspedisi->no_telp }}</h6>
                                                </td>
                                                <td class="align-middle text-center">


                                                    <h6 class="p-3 mb-0 text-sm">
                                                        {{ $kedatanganEkspedisi->user->name }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="p-3 mb-0 text-sm">
                                                        {{ $kedatanganEkspedisi->tanggal_waktu ? \Carbon\Carbon::parse($kedatanganEkspedisi->tanggal_waktu)->translatedFormat('l, d/m/Y H:i') : '' }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    <i class="fa-solid fa-image image-icon" style="color: #707070"
                                                        data-src="{{ $kedatanganEkspedisi->foto ? asset('storage/img-kurir/' . $kedatanganEkspedisi->foto) : asset('img/logo-hitam.png') }}"></i>
                                                </td>
                                        @endforeach
                                    @endif
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
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('../js/material-dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9FfN2IO49JWKNj4Xc4lTnL8E+vsgYV8h6i+n81paAnw1Pp8DAfB1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-c0vJ+c44F1c8Upct9c0V6sHFeKt9Wv9m6rKf6BqP8Iq5k5hBf9Wh9oQAK86b8G0E" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#laporanTable').DataTable({
                "paging": false,
                "searching": true, // Disable DataTables' default search
                "ordering": true,
                "info": false
            });

            // Custom search input functionality
            $('#myInput').on('keyup', function() {
                table.search(this.value).draw(); // Use DataTables' search API
            });

            $('#laporanTable_filter').hide();
        });


        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('#laporanTable');
            const headers = table.querySelectorAll('th');
            const rows = Array.from(table.querySelectorAll('tbody tr'));

            headers.forEach((header, index) => {
                header.addEventListener('click', () => {
                    const isAscending = header.classList.contains('sorted-asc');
                    const newRows = rows.sort((rowA, rowB) => {
                        const cellA = rowA.children[index].innerText.trim();
                        const cellB = rowB.children[index].innerText.trim();
                        return isAscending ? cellB.localeCompare(cellA) : cellA
                            .localeCompare(cellB);
                    });

                    table.querySelector('tbody').append(...newRows);

                    headers.forEach(th => th.classList.remove('sorted-asc', 'sorted-desc'));
                    header.classList.toggle('sorted-asc', !isAscending);
                    header.classList.toggle('sorted-desc', isAscending);
                });
            });
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
    </script>
</body>

</html>
