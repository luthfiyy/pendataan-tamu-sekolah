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

    <title>GuBook</title>
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

                <x-breadcrumb />


                <div class="card my-4">

                    <div class="card-body px-0 pb-2">
                        <div class="m-4 d-flex justify-content-between align-items-center">
                            <div class="search d-flex align-items-center">
                                <i class='bx bx-search'></i>
                                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari..">
                            </div>
                            <div class="export">
                                <a href="{{ route('laporan_tamu.pdf') }}"
                                   class="d-flex align-items-center rounded-lg px-3 py-1 text-green-500 transition-all ease-in-out hover:btn hover:btn-success hover:btn-sm">
                                    <i class="fa-solid fa-file-export"></i>
                                    Export
                                </a>
                            </div>
                        </div>


                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="laporanTable">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Nama & Email</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder  ">
                                            Alamat</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Nomor Telepon</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Instansi</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Pegawai</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Tujuan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Waktu Perjanjian</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Waktu Kedatangan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tamus as $kedatanganTamu)
                                        <tr>
                                            <td>
                                                <div
                                                    class="d-flex px-2 py-1 justify-content-center align-items-center w-100">
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-items-center text-center">
                                                        <img src="{{ asset('img/logo-hitam.png') }}"
                                                            class="avatar avatar-sm mb-2 border-radius-lg"
                                                            alt="user1">
                                                        <h6 class="mb-0 text-sm">{{ $kedatanganTamu->tamu->nama }}</h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            {{ $kedatanganTamu->tamu->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $kedatanganTamu->tamu->alamat }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->tamu->no_telp }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->instansi }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->user->name }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->tujuan }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->format('d/m/Y H:i') }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_kedatangan)->format('d/m/Y H:i') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Online</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-xs font-weight-bold mb-0"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Edit
                                                </a>
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
    </section>
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>
    {{-- section end --}}

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
                document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('imageModal');
            var modalImg = document.getElementById("modalImage");
            var closeBtn = document.getElementsByClassName("close")[0];

            // Ambil semua gambar dengan kelas avatar-l
            var images = document.querySelectorAll('.avatar-sm');

            // Tambahkan event listener untuk setiap gambar
            images.forEach(function(img) {
                img.onclick = function() {
                    modal.style.display = "flex";
                    modalImg.src = this.src;
                    setTimeout(() => {
                        modal.classList.add('show');
                    }, 10);
                }
            });

            // Fungsi untuk menutup modal
            function closeModal() {
                modal.classList.remove('show');
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



        function myFunction() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("laporanTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 1; i < tr.length; i++) { // Start from 1 to skip table header
                tr[i].style.display = "none"; // Hide the row initially
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = ""; // Show the row if a match is found
                            break; // Exit the loop once a match is found
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>
