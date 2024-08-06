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
                                        <th class="text-uppercase text-secondary text-l font-weight-bolder text-black">
                                            Nama</th>
                                        <th
                                            class="text-uppercase text-secondary text-l font-weight-bolder ps-2 text-black">
                                            Ekspedisi</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-l font-weight-bolder text-black">
                                            Pegawai yang dituju</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-l font-weight-bolder text-black">
                                            Tanggal & Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ekspedisi as $kedatanganEkspedisi)
                                        <tr>
                                            <td class="d-flex align-items-center justify-content-center">
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <div>
                                                        <img src="{{ asset('storage/img-kurir/' . $kedatanganEkspedisi->foto) }}"
                                                            class="avatar-l me-3 border-radius-lg"
                                                            alt="user1" width="100px">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-m">
                                                            {{ $kedatanganEkspedisi->ekspedisi->nama_kurir }}</h6>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-m">
                                                        {{ $kedatanganEkspedisi->ekspedisi->ekspedisi }}</h6>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">

                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-m">
                                                        {{ $kedatanganEkspedisi->user->name }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-m">
                                                        {{ $kedatanganEkspedisi->tanggal_waktu }}</h6>
                                                </div>
                                            </td>
                                            {{-- <td class="align-middle">
                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                              Edit
                            </a>
                          </td> --}}
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
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('imageModal');
            var modalImg = document.getElementById("modalImage");
            var closeBtn = document.getElementsByClassName("close")[0];

            // Ambil semua gambar dengan kelas avatar-l
            var images = document.querySelectorAll('.avatar-l');

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
