<div class="card" style="margin-left: 40px; width: 1100px">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

    </div>
    <div class="mt-3 d-flex justify-content-between align-items-center">
        {{-- search --}}
        <div class="search d-flex align-items-center">
            <i class='bx bx-search'></i>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari.." class="form-control ml-2">
        </div>

        <div class="search d-flex align-items-center">
            
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

        {{-- export --}}
        <div class="export">
            <a href="{{ route('pegawai.export') }}"
                class="rounded-lg px-3 py-1 text-green-500 transition-all ease-in-out hover:btn hover:btn-success hover:btn-sm">
                <i class="fa-solid fa-file-export"></i>
                Export
            </a>
        </div>
    </div>
    <div class="card-table px-0 pb-2 ">
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
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">NO</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">NIP</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Nama & Email
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nomor
                            Telepon</th>
                        {{-- <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nomor
                            WhatsApp</th> --}}
                        <th class="text-center text-uppercase text-xs font-weight-bolder opacity-7">PTK</th>
                        <th class="text-center text-uppercase text-xs font-weight-bolder opacity-7">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $index => $pgw)
                        <tr>
                            <td>
                                <span
                                    class="text-secondary text-xs font-weight-bold">{{ $pegawai->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <span class="text-secondary text-xs font-weight-bold">{{ $pgw->nip }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column justify-content-center">
                                    <span class="text-secondary text-sm font-weight-bold">{{ $pgw->user->name }}</span>
                                    <p class="text-xs text-secondary mb-0">{{ $pgw->user->email }}</p>
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="text-secondary text-xs font-weight-bold">{{ $pgw->no_telp }}</span>
                            </td>
                            {{-- <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $pgw->no_wa }}</span>
                            </td> --}}
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $pgw->ptk }}</span>
                            </td>
                            <td class="align-middle">
                                <button class="text-secondary font-weight-bold text-xs btn-edit"
                                    onclick="showUpdateForm('{{ $pgw->nip }}', '{{ $pgw->user->name }}', '{{ $pgw->user ? $pgw->user->email : '' }}', '{{ $pgw->no_telp }}', '{{ $pgw->ptk }}')"
                                    data-id="{{ $pgw->id }}" data-nama="{{ $pgw->user->name }}"
                                    data-email="{{ $pgw->user ? $pgw->user->email : '' }}"
                                    data-nip="{{ $pgw->nip }}" data-no_telp="{{ $pgw->no_telp }}"
                                    data-ptk="{{ $pgw->ptk }}">
                                    <i class="bx bx-edit ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Edit"></i>
                                </button>


                                <a href="{{ route('pegawai.delete', ['nip' => $pgw->nip]) }}"
                                    class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                    data-original-title="Hapus User">
                                    <i class="bx bx-trash ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Hapus"></i>
                                </a>


                                {{-- <a href="{{ route('') }}"> --}}
                                {{-- <p>export</p>
                                </a> --}}
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

    <div class=" mx-1">
        <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data"
            class="d-flex align-items-center">
            @csrf
            <input type="file" name="file" required>
            <button type="submit" class="btn-import">
                <i class="fa-solid fa-upload"></i>
                Import
            </button>
        </form>
    </div>
</div>

<script>
    let password = document.getElementById("password");

    eyeicon.onclick = function() {
        if (password.type === "password") {
            password.type = "text";
            eyeicon.src = "../img/mdi-light--eye.png";
        } else {
            password.type = "password";
            eyeicon.src = "../img/mdi-light--eye-off.png";
        }
    }

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
