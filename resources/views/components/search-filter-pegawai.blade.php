{{-- resources/views/components/search-filter.blade.php --}}
@props([
    'search' => '',
    'searchBy' => '',
    'action' => '',
    'options' => [],
])

<form method="GET" action="{{ $action }}">
    <div class="d-flex">
        <div class="search d-flex align-items-center" style="border-bottom-right-radius: 0px; border-top-right-radius: 0px;">
            <i class='bx bx-search'></i>
            <input type="text" id="myInput" name="search" value="{{ $search }}" placeholder="Cari..">
        </div>
        <div class="filterStatus" style="width: 50px; border-bottom-left-radius: 0px; border-top-left-radius: 0px;">
            <div class="filter-container">
                <i class='bx bx-slider'></i>
                <select name="search_by" id="searchBy" style="color: #707070">
                    <option value="">Pilih Filter</option>
                    @foreach($options as $value => $label)
                        <option value="{{ $value }}" {{ $searchBy == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('myInput').addEventListener('input', function() {
            this.form.submit();
        });

        document.getElementById('searchBy').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</form>
