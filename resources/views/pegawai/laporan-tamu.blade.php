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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">


    <title>GuBook</title>
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
                                <div class="search d-flex align-items-center">
                                    <i class='bx bx-search'></i>
                                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari..">
                                </div>
                                <div class="export">
                                    <a href="{{ route('pegawai.tamu.export') }}"
                                        class="d-flex align-items-center rounded-lg px-3 py-1 text-green-500 transition-all ease-in-out hover:btn hover:btn-success hover:btn-sm">
                                        <i class="fa-solid fa-file-export"></i>
                                        Export
                                    </a>
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
                                                        class="text-center text-secondary text-xs font-weight-bold">{{ $index + 1 }}</span>
                                                </td>
                                                <td>
                                                    <div
                                                        class="d-flex px-2 py-1 justify-content-center align-items-center w-100">
                                                        <div
                                                            class="d-flex flex-column justify-content-center align-items-center text-center">


                                                            <h6 class="mb-0 text-sm font-weight-bold">
                                                                {{ $kedatanganTamu->tamu->nama }}</h6>
                                                            {{-- <span
                                                                class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->tamu->no_telp }}</span> --}}
                                                            <p class="text-xs mb-0">
                                                                {{ $kedatanganTamu->tamu->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                {{-- <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $kedatanganTamu->tamu->alamat }}</p>
                                            </td> --}}
                                                {{-- <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->tamu->no_telp }}</span>
                                            </td> --}}
                                                {{-- <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->instansi }}</span>
                                            </td> --}}
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->user->name }}</span>
                                                </td>
                                                {{-- <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->tujuan }}</span>
                                            </td> --}}
                                                <td class="align-middle text-center">
                                                    <span {{-- class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->format('d/m/Y H:i') }}</span> --}}
                                                        class="font-weight-bold text-xs">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->translatedFormat('l, d/m/Y, H:i') }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-xs font-weight-bold mb-0">
                                                        {{ $kedatanganTamu->waktu_kedatangan ? \Carbon\Carbon::parse($kedatanganTamu->waktu_kedatangan)->translatedFormat('l, d/m/Y, H:i') : 'Tamu Belum Datang' }}
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
                        <div class="tamu-header align-items-center pt-0" style="display: flex; flex-direction: column;">
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
    {{-- section end --}}

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9FfN2IO49JWKNj4Xc4lTnL8E+vsgYV8h6i+n81paAnw1Pp8DAfB1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-c0vJ+c44F1c8Upct9c0V6sHFeKt9Wv9m6rKf6BqP8Iq5k5hBf9Wh9oQAK86b8G0E" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
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


    </script>
</body>

</html>
