{{-- resources/views/components/search-filter.blade.php --}}
@props([
    'search' => '',
    'searchBy' => '',
    'action' => '',
    'startDate' => '',
    'endDate' => '',
    'options' => [],
])

<form method="GET" action="{{ $action }}" id="searchFilterForm">
    <div class="d-flex">
        <div class="search d-flex align-items-center"
            style="border-bottom-right-radius: 0px; border-top-right-radius: 0px;">
            <i class='bx bx-search'></i>
            <input type="text" id="myInput" name="search" value="{{ $search }}" placeholder="Cari..">
        </div>
        <div class="filterStatus" style="width: 50px; border-bottom-left-radius: 0px; border-top-left-radius: 0px;">
            <div class="filter-container">
                <i class='bx bx-slider'></i>
                <select name="search_by" id="searchBy" style="color: #707070">
                    <option value="">Pilih Filter</option>
                    @foreach ($options as $value => $label)
                        <option value="{{ $value }}" {{ $searchBy == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="position-relative h-100">
        <div class="ms-1 filterStatus">
            <button type="button" id="toggleDatePicker" style="border:none; background:none;" class="d-flex align-items-center">
                <i class='bx bxs-calendar m-0' style="font-size: 30px;"></i>
            </button>
        </div>
        <div id="datePickerContainer" class="d-none position-absolute bg-white shadow p-3" style="z-index: 1000;">
            <div class="d-flex flex-column w-100">
                <div class="input-group me-2 w-100">
                    <input type="date" name="start_date" class="form-control mb-1" placeholder="Tanggal Mulai"
                        value="{{ request('start_date') }}">
                </div>
                <div class="input-group me-2 w-100 mb-1">
                    <input type="date" name="end_date" class="form-control" placeholder="Tanggal Akhir"
                        value="{{ request('end_date') }}">
                </div>
                <button type="submit" class="btn btn-primary w-100">Filter</button>
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

        document.getElementById('filterStatus').addEventListener('change', function() {
            this.form.submit();
        });

        // Improved date picker toggle functionality
        const toggleDatePicker = document.getElementById('toggleDatePicker');
        const datePickerContainer = document.getElementById('datePickerContainer');
        let isDatePickerOpen = false;

        toggleDatePicker.addEventListener('click', function(e) {
            e.stopPropagation();
            if (isDatePickerOpen) {
                datePickerContainer.classList.add('d-none');
            } else {
                datePickerContainer.classList.remove('d-none');
                // Position the date picker relative to the button
                const buttonRect = toggleDatePicker.getBoundingClientRect();
                datePickerContainer.style.top = (buttonRect.bottom + window.scrollY) + 'px';
                datePickerContainer.style.right = (window.innerWidth - buttonRect.right) + 'px';
            }
            isDatePickerOpen = !isDatePickerOpen;
        });

        document.addEventListener('click', function(e) {
            if (!datePickerContainer.contains(e.target) && e.target !== toggleDatePicker) {
                datePickerContainer.classList.add('d-none');
                isDatePickerOpen = false;
            }
        });

        // Prevent form submission when clicking inside date picker
        datePickerContainer.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (isDatePickerOpen) {
                const buttonRect = toggleDatePicker.getBoundingClientRect();
                datePickerContainer.style.top = (buttonRect.bottom + window.scrollY) + 'px';
                datePickerContainer.style.right = (window.innerWidth - buttonRect.right) + 'px';
            }
        });

        // Handle scroll
        window.addEventListener('scroll', function() {
            if (isDatePickerOpen) {
                const buttonRect = toggleDatePicker.getBoundingClientRect();
                datePickerContainer.style.top = (buttonRect.bottom + window.scrollY) + 'px';
            }
        });
    </script>
</form>
