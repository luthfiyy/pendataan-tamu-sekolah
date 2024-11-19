<div class="card mb-4 ms-4" style=" max-width: 1185px">
    <div class="card-header p-0 position-relative z-index-2 m-4">
        <div class="d-flex justify-content-between align-items-center">
            {{-- search --}}
            <x-search-filter-pegawai :search="request('search')" :searchBy="request('search_by')" :status="request('status')" action="/FO/pegawai"
            :options="[
                'nip' => 'NIP',
                'nama_pegawai' => 'Nama Pegawai',
                'email_pegawai' => 'Email Pegawai',
                'no_telp' => 'Nomor Telepon Pegawai',
                'ptk' => 'PTK',
            ]" />

{{--
            <div class="filterPtk d-flex align-items-center">
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
                                    <span
                                        class="text-center font-weight-bold">{{ ucwords(strtolower($pgw->user->name)) }}</span>
                                    <p class="text-center text-xs mb-0">{{ $pgw->user->email }}</p>
                                </div>
                            </td>
                            <td class="align-middle text-center ">
                                <span class="text-center text-xs font-weight-bold">{{ $pgw->no_telp }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span
                                    class="text-center text-xs font-weight-bold">{{ ucwords(strtolower($pgw->ptk)) }}</span>
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

        $('#pegawaiTable_filter').hide();
    });
</script>
