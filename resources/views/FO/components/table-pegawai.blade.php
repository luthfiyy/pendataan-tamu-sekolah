<div class="card mb-4 ms-4" style=" max-width: 1185px">
    <div class="card-header p-0 position-relative z-index-2 m-4">
        <div class="d-flex justify-content-between align-items-center">
            {{-- search --}}
            <div class="search d-flex align-items-center">
                <i class='bx bx-search'></i>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari..">
            </div>

            <div class="filterPtk d-flex align-items-center">
                <div class="filter-container">
                    <i class='bx bx-filter-alt'></i>
                    <select id="filterPtk" onchange="filterTableByPtk()">
                        <option value="">PTK</option>
                        <option value="produktif rpl">Produktif RPL</option>
                        <option value="produktif akl">Produktif AKL</option>
                        <option value="pendidikan pencasila">Pendidikan Pancasila</option>
                        <option value="bahasa inggris">Bahasa Inggris</option>
                        <option value="pjok">PJOK</option>
                        <option value="produktif bdp">Produktif BDP</option>
                        <option value="produktif MP">Produktif MP</option>
                        <option value="tendik">Tendik</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card-table px-0 pb-2">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="pegawaiTable">
                <thead>
                    <tr>
                        <th class="text-center text-m font-weight-bolder ">NO</th>
                        <th class="text-center text-m font-weight-bolder ">NIP</th>
                        <th class="text-center text-m font-weight-bolder">Nama & Email
                        </th>
                        <th class="text-center text-m font-weight-bolder ">Nomor
                            Telepon</th>
                        <th class="text-center text-m font-weight-bolder ">PTK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $index => $pgw)
                        <tr>
                            <td class="align-middle text-center ">
                                <span
                                    class="text-center text-xs font-weight-bold">{{ $pegawai->firstItem() + $index }}</span>
                            </td>
                            <td class="align-middle text-center ">
                                <span class="text-center text-xs font-weight-bold">{{ $pgw->nip }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex flex-column justify-content-center">
                                    <span class="text-center font-weight-bold">{{ $pgw->user->name }}</span>
                                    <p class="text-center text-xs mb-0">{{ $pgw->user->email }}</p>
                                </div>
                            </td>
                            <td class="align-middle text-center ">
                                <span class="text-center text-xs font-weight-bold">{{ $pgw->no_telp }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-center text-xs font-weight-bold">{{ $pgw->ptk }}</span>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#pegawaiTable').DataTable({
            "paging": false,
            "searching": true, // Disable DataTables' default search
            "ordering": true,
            "info": false
        });

        // Custom search input functionality
        $('#myInput').on('keyup', function() {
            table.search(this.value).draw(); // Use DataTables' search API
        });

        $('#pegawaiTable_filter').hide();
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

    function myFunction() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("pegawaiTable");
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

    function filterTableByPtk() {
        var filter, table, tr, td, i, txtValue;
        filter = document.getElementById("filterPtk").value.toUpperCase();
        table = document.getElementById("pegawaiTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[4]; // Kolom PTK ada di posisi ke-4 (index 4)
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1 || filter === "") {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
