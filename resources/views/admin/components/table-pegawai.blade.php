<style>
    .swal2-container {
        position: fixed;
    }
</style>

<div class="card mb-4 p-4 ms-0" style="max-width: 1185px ">
    <div class="d-flex align-items-center justify-content-between">
        <x-search-filter-pegawai :search="request('search')" :searchBy="request('search_by')" :status="request('status')" action="/admin/pegawai"
            :options="[
                'nip' => 'NIP',
                'nama_pegawai' => 'Nama Pegawai',
                'email_pegawai' => 'Email Pegawai',
                'no_telp' => 'Nomor Telepon Pegawai',
                'ptk' => 'PTK',
            ]" />
        <div class="mt-3 d-flex justify-content-end align-items-center">
            {{-- search --}}

            {{-- <div class="filterPtk d-flex align-items-center">
                <div class="filter-container">
                    <i class='bx bx-filter-alt'></i>
                    <select id="filterPtk">
                        <option value="">PTK</option>
                        <option value="produktif rpl" {{ request('ptk') == 'produktif rpl' ? 'selected' : '' }}>
                            Produktif RPL</option>
                        <option value="produktif akl" {{ request('ptk') == 'produktif akl' ? 'selected' : '' }}>
                            Produktif AKL</option>
                        <option value="pendidikan pencasila"
                            {{ request('ptk') == 'pendidikan pencasila' ? 'selected' : '' }}>Pendidikan Pancasila
                        </option>
                        <option value="bahasa inggris" {{ request('ptk') == 'bahasa inggris' ? 'selected' : '' }}>Bahasa
                            Inggris</option>
                        <option value="pjok" {{ request('ptk') == 'pjok' ? 'selected' : '' }}>PJOK</option>
                        <option value="produktif bdp" {{ request('ptk') == 'produktif bdp' ? 'selected' : '' }}>
                            Produktif BDP</option>
                        <option value="produktif MP" {{ request('ptk') == 'produktif MP' ? 'selected' : '' }}>Produktif
                            MP</option>
                        <option value="tendik" {{ request('ptk') == 'tendik' ? 'selected' : '' }}>Tendik</option>
                    </select>
                </div>
            </div> --}}
            <a href="{{ route('pegawai.download-format') }}" class="container-btn-file me-2 ms-2">
                <svg class="svg-icon" fill="#307750" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    viewBox="0 0 24 24">
                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z" />
                </svg>
                Format Import
            </a>

            <div class="mx-1">

                <form id="uploadForm" action="{{ route('pegawai.import') }}" method="POST"
                    enctype="multipart/form-data" class="d-flex align-items-center">
                    @csrf
                    <input name="file" type="file" id="fileInput" class="d-none" />
                    <label for="fileInput" class="container-btn-file">
                        <svg class="svg-icon" fill="#307750" xmlns="http://www.w3.org/2000/svg" width="20"
                            height="20" viewBox="0 0 50 50">
                            <path
                                d="M28.8125 .03125L.8125 5.34375C.339844 5.433594 0 5.863281 0 6.34375L0 43.65625C0 44.136719 .339844 44.566406 .8125 44.65625L28.8125 49.96875C28.875 49.980469 28.9375 50 29 50C29.230469 50 29.445313 49.929688 29.625 49.78125C29.855469 49.589844 30 49.296875 30 49L30 1C30 .703125 29.855469 .410156 29.625 .21875C29.394531 .0273438 29.105469 -.0234375 28.8125 .03125ZM32 6L32 13L34 13L34 15L32 15L32 20L34 20L34 22L32 22L32 27L34 27L34 29L32 29L32 35L34 35L34 37L32 37L32 44L47 44C48.101563 44 49 43.101563 49 42L49 8C49 6.898438 48.101563 6 47 6ZM36 13L44 13L44 15L36 15ZM6.6875 15.6875L11.8125 15.6875L14.5 21.28125C14.710938 21.722656 14.898438 22.265625 15.0625 22.875L15.09375 22.875C15.199219 22.511719 15.402344 21.941406 15.6875 21.21875L18.65625 15.6875L23.34375 15.6875L17.75 24.9375L23.5 34.375L18.53125 34.375L15.28125 28.28125C15.160156 28.054688 15.035156 27.636719 14.90625 27.03125L14.875 27.03125C14.8125 27.316406 14.664063 27.761719 14.4375 28.34375L11.1875 34.375L6.1875 34.375L12.15625 25.03125ZM36 20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z">
                            </path>
                        </svg>

                        Import
                    </label>
                    <button type="submit" class="d-none">Submit</button>
                </form>
            </div>
            {{-- export --}}
            {{-- <div class="export">
                <a href="{{ route('pegawai.export') }}" class="rounded-lg px-3 py-1">
                    <i class="fa-solid fa-file-export"></i>
                    Export
                </a>
            </div> --}}
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
                        <th class="text-center text-uppercase text-xs font-weight-bolder">NO</th>
                        <th class="text-center text-uppercase text-xs font-weight-bolder">NIP</th>
                        <th class="text-center text-uppercase text-xs font-weight-bolder">Nama & Email
                        </th>
                        <th class="text-center text-uppercase text-xs font-weight-bolder ">Nomor
                            Telepon</th>
                        {{-- <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nomor
                            WhatsApp</th> --}}
                        <th class="text-center text-uppercase text-xs font-weight-bolder ">PTK</th>
                        <th class="text-center text-uppercase text-xs font-weight-bolder ">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $index => $pgw)
                        <tr>
                            <td class="align-middle text-center text-sm">
                                <span
                                    class="text-center text-sm font-weight-bold">{{ $pegawai->firstItem() + $index }}</span>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="text-center text-sm font-weight-bold">{{ $pgw->nip }}</span>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <div class="d-flex flex-column justify-content-center">
                                    <span class=" text-center text-sm font-weight-bold">{{ $pgw->user->name }}</span>
                                    <p class="text-center text-sm text-secondary mb-0">{{ $pgw->user->email }}</p>
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="text-center text-sm font-weight-bold">{{ $pgw->no_telp }}</span>
                            </td>
                            {{-- <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $pgw->no_wa }}</span>
                            </td> --}}
                            <td class="align-middle text-center">
                                <span
                                    class="text-center text-sm font-weight-bold">{{ ucwords(strtolower($pgw->ptk)) }}</span>
                            </td>
                            <td class="align-middle">
                                <button class="text-center text-secondary font-weight-bold text-xs btn-edit ms-4"
                                    onclick="showUpdateForm('{{ $pgw->nip }}', '{{ $pgw->user->name }}', '{{ $pgw->user ? $pgw->user->email : '' }}', '{{ $pgw->no_telp }}', '{{ $pgw->ptk }}')"
                                    data-id="{{ $pgw->id }}" data-nama="{{ $pgw->user->name }}"
                                    data-email="{{ $pgw->user ? $pgw->user->email : '' }}"
                                    data-nip="{{ $pgw->nip }}" data-no_telp="{{ $pgw->no_telp }}"
                                    data-ptk="{{ $pgw->ptk }}">
                                    <i class="bx bx-edit ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Edit"></i>
                                </button>


                                <button class="text-secondary font-weight-bold text-xs delete-pegawai "
                                    data-nip="{{ $pgw->nip }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Hapus" id="deletePegawai" onclick=""
                                    style="border: none; background: none">
                                    <i class="bx bx-trash ms-auto text-dark cursor-pointer"></i>
                                </button>


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

    {{-- <div class=" mx-1">
        <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data"
            class="d-flex align-items-center">
            @csrf
            <input type="file" name="file" required>
            <button type="submit" class="btn-import">
                <i class="fa-solid fa-upload"></i>
                Import
            </button>
        </form>
    </div> --}}

</div>

<div class="modal fade " id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered d-flex justify-content-center" style="max-width: 1200px">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="updateModalLabel">Update Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Update -->
                <form id="formAccountSettings" action="{{ route('pegawai.update') }}" method="POST"
                    onsubmit="return validateUpdateForm()">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="newNama" class="form-label">Nama</label>
                            <input class="form-control" type="text" id="newNama" name="newNama" value="John"
                                autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <input class="form-control" type="text" id="nip" name="nip" value="Doe"
                                readonly />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="newEmail" class="form-label">E-mail</label>
                            <input class="form-control" type="email" id="newEmail" name="newEmail"
                                value="john.doe@example.com" placeholder="john.doe@example.com" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="newNotelp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="newNotelp" name="newNotelp"
                                value="123456789" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="newPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword"
                                placeholder="Password" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="newPtk" class="form-label">PTK</label>
                            <select id="newPtk" name="newPtk" class="select2 form-select">
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
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2" style="width: 180px">Simpan
                            Perubahan</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            style="width: 100px">Kembali</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


{{-- <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Update -->
                <form id="updateForm" action="{{ route('pegawai.update') }}" method="POST"
                    onsubmit="return validateUpdateForm()">
                    @csrf
                    <input type="hidden" name="nipToUpdate" id="nipToUpdate">
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newNama">Nama</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="bx bx-user"></i></span>
                                <input type="text" name="newNama" class="form-control" id="newNama"
                                    placeholder="John Doe" />
                            </div>
                        </div>
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newNip">NIP</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"> <i
                                        class='bx bx-id-card'></i> </span>
                                <input type="text" name="newNip" class="form-control" id="newNip"
                                    placeholder="1234567890" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newEmail">Email</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" id="newEmail" class="form-control"
                                    placeholder="contoh@gmail.com" name="newEmail" aria-label="john.doe"
                                    aria-describedby="basic-default-email2" />
                            </div>
                        </div>
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newNo_telp">Nomor Telepon</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i
                                        class="bx bx-phone"></i></span>
                                <input type="text" name="newNo_telp" id="newNo_telp"
                                    class="form-control phone-mask" placeholder="0822 6432 9327" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newPtk">PTK</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i
                                        class='bx bx-chalkboard'></i></span>
                                <select name="newPtk" id="newPtk" class="form-control phone-mask" required>
                                    <option value="" selected disabled>PTK</option>
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
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newPassword">Password</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-password2" class="input-group-text"><i
                                        class='bx bx-lock'></i></span>
                                <input type="password" id="newPassword" name="newPassword"
                                    class="form-control phone-mask" placeholder="********" />
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary shadow-primary w-100">
                </form>
            </div>
        </div>
    </div>
</div> --}}


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable tanpa menggunakan search dari DataTables
        var table = $('#pegawaiTable').DataTable({
            "paging": false,
            "searching": false, // Nonaktifkan pencarian default DataTables
            "ordering": true,
            "info": false
        });

        // function updateUrlAndReload(paramName, paramValue) {
        //     var url = new URL(window.location.href);
        //     if (paramValue) {
        //         url.searchParams.set(paramName, paramValue);
        //     } else {
        //         url.searchParams.delete(paramName);
        //     }
        //     window.location.href = url.toString();
        // }

        // // Custom search input functionality
        // $('#myInput').on('keyup', function() {
        //     var searchValue = $(this).val();
        //     updateUrlAndReload('search', searchValue);
        // });

        // // PTK filter functionality
        // $('#filterPtk').on('change', function() {
        //     var ptkValue = $(this).val();
        //     updateUrlAndReload('ptk', ptkValue);
        // });

        // $('#pegawaiTable_filter').hide();
    });


    function showUpdateForm(nip, name, email, phone, ptk) {
        // Isi input dengan nilai yang diberikan
        document.getElementById('nip').value = nip;
        document.getElementById('newNama').value = name;
        document.getElementById('newEmail').value = email;
        document.getElementById('newNotelp').value = phone;
        document.getElementById('newPtk').value = ptk;

        // Tampilkan modal
        $('#updateModal').modal('show');
    }

    function validateUpdateForm() {
        var newNama = document.getElementById('newNama').value.trim();
        var newEmail = document.getElementById('newEmail').value.trim();
        var newNip = document.getElementById('newNip').value.trim();
        var newNo_telp = document.getElementById('newNo_telp').value.trim();
        var newPtk = document.getElementById('newPtk').value.trim();

        if (newNama === '' || newEmail === '' || newNip === '' || newNo_telp === '' || newPtk === '') {
            alert('Mohon isi semua kolom yang dibutuhkan.');
            return false;
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('#deletePegawai');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const nip = this.getAttribute('data-nip');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'

                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('pegawai.delete', '') }}/" +
                            nip;
                    }
                });
            });
        });
    });

    document.getElementById('fileInput').addEventListener('change', function() {
        document.getElementById('uploadForm').submit();
    });

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
