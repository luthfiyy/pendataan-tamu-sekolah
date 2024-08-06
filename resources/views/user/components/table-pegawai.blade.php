

<div class="card">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-capitalize ps-3" style="font-size: 20px">Tabel Pegawai</h6>
        </div>
    </div>



     {{-- search --}}
    <div class="search">
        <i class='bx bx-search' ></i>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari..">
    </div>
    {{-- search end --}}

    <div class="card-body px-0 pb-2">
        <div class="table-pegawai">
            <table class="table align-items-center mb-0" id="pegawaiTable">
                <thead>
                    <tr>
                        <th class=" text-secondary text-m font-weight-bolder opacity-7">No</th>
                        <th class=" text-secondary text-m font-weight-bolder opacity-7">NIP</th>
                        <th class=" text-secondary text-m font-weight-bolder opacity-7 ps-2">Nama & Email</th>
                        <th class=" text-secondary text-m font-weight-bolder opacity-7 ps-2">PTK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawai as $index => $guru)
                        <tr>
                            <td>
                                <span class="text-secondary text-m font-weight-bold">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <span class="text-secondary text-m font-weight-bold">{{ $guru->nip }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column justify-content-center">
                                    <span class="text-secondary text-m font-weight-bold">{{ $guru->user->name }}</span>
                                    <p class="text-m text-secondary mb-0">{{ $guru->user->email }}</p>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-m font-weight-bold">{{ $guru->ptk }}</span>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="pagination-container">
            {{ $pegawai->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

<script>

function filterTendik() {
        var table, tr, td, i, txtValue;
        table = document.getElementById("pegawaiTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the PTK 'Tendik'
        for (i = 1; i < tr.length; i++) { // Start from 1 to skip table header
            tr[i].style.display = "none"; // Hide the row initially
            td = tr[i].getElementsByTagName("td");
            if (td[3]) { // The PTK column is the 4th column (index 3)
                txtValue = td[3].textContent || td[3].innerText;
                if (txtValue.toUpperCase() === 'tendik') {
                    tr[i].style.display = ""; // Show the row if it is 'Tendik'
                }
            }
        }
    }
</script>
