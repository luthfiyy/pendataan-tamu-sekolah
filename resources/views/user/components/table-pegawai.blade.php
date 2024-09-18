<style>

    th {
        position: relative;
        cursor: pointer;
        color: #707070
    }

    .table>:not(caption)>*>* {
        color: #707070;
    }

    th::before,
    th::after {
        content: '';
        position: absolute;
        right: 8px;
        border: solid transparent;
        border-width: 0 4px 6px 4px;
        top: 50%;
        transform: translateY(-150%);
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }

    th::after {
        border-width: 6px 4px 0 4px;
        transform: translateY(50%);
    }

    th.sorted-asc::before {
        border-bottom-color: black;
        opacity: 1;
    }

    th.sorted-asc::after {
        opacity: 0.2;
    }

    th.sorted-desc::before {
        opacity: 0.2;
    }

    th.sorted-desc::after {
        border-top-color: black;
        opacity: 1;
    }

    /* Display both arrows for all headers by default */
    th::before {
        border-bottom-color: black;
    }

    th::after {
        border-top-color: black;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: rgba(105, 108, 255, 0.08);
        border: 1px solid rgba(105, 108, 255, 0.08);
        margin-inline: 5px;
    }
</style>

<div class="card p-3" style="width: 1000px">

    <div class="d-flex align-item-center justify-content-end">

        {{-- search --}}
        <div class="search">
            <i class='bx bx-search'></i>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari..">
        </div>

        {{-- PTK Filter --}}
        @if(request()->is('guru*'))
        <div class="filter-container">
            <i class='bx bx-filter-alt ms-3 me-3'></i>
            <select id="ptkFilter">
                <option value="">PTK</option>
                @foreach($pegawai->unique('ptk') as $pgw)
                    <option value="{{ $pgw->ptk }}">{{ ucwords(strtolower($pgw->ptk)) }}</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>

    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="pegawaiTable">
                <thead>
                    <tr>
                        <th class="text-center text-uppercase text-xs font-weight-bolder pe-3">NO</th>
                        <th class="text-center text-uppercase text-xs font-weight-bolder">NIP</th>
                        <th class="text-center text-uppercase text-xs font-weight-bolder">Nama & Email</th>
                        <th class="text-center text-uppercase text-xs font-weight-bolder ">PTK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $index => $pgw)
                        <tr>
                            <td class="align-middle text-center text-sm">
                                <span class="text-center text-sm font-weight-bold">{{ $pegawai->firstItem() + $index }}</span>
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
                            <td class="align-middle text-center">
                                <span class="text-center text-sm font-weight-bold">{{ ucwords(strtolower($pgw->ptk)) }}</span>
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
            var table = $('#pegawaiTable').DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "order": [
                    [0, 'asc']
                ]
            });

            // Custom search input functionality
            $('#myInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Custom PTK filter functionality
            $('#ptkFilter').on('change', function() {
                var searchValue = this.value;
                table.column(3).search(searchValue).draw();
            });

            $('#pegawaiTable_filter').hide(); // Hide default search box

            // Handle sorting indicator for all headers
            $('#pegawaiTable th').on('click', function() {
                $('#pegawaiTable th').removeClass('sorted-asc sorted-desc');

                if ($(this).hasClass('sorting_asc')) {
                    $(this).addClass('sorted-asc');
                } else if ($(this).hasClass('sorting_desc')) {
                    $(this).addClass('sorted-desc');
                }
            });

            // Initially add sorting classes based on default order
            $('#pegawaiTable th').first().addClass('sorted-asc');
        });
    </script>
