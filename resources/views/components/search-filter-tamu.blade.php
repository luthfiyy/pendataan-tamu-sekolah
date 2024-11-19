@props([
    'search' => '',
    'searchBy' => '',
    'status' => '',
    'startDate' => '',
    'endDate' => '',
    'action' => '',
    'options' => [],
])

<form method="GET" action="{{ $action }}">
    <div class="d-flex">
        <div class="d-flex justify-content-center align-items-center">
            <!-- Search Input -->
            <div class="search d-flex align-items-center"
                style="border-bottom-right-radius: 0px; border-top-right-radius: 0px;">
                <i class='bx bx-search'></i>
                <input type="text" id="myInput" name="search" value="{{ request('search') }}" placeholder="Cari..">
            </div>

            <!-- Search By Filter -->
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

            <!-- Status Filter -->
            <div class="filterStatus d-flex align-items-center ms-2">
                <div class="filter-container">
                    <i class='bx bx-filter-alt' style="color: #707070;"></i>
                    <select id="filterStatus" name="status">
                        <option value="">Semua status</option>
                        <option value="Menunggu konfirmasi"
                            {{ request('status') == 'Menunggu konfirmasi' ? 'selected' : '' }}>
                            Menunggu konfirmasi
                        </option>
                        <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>
                            Diterima
                        </option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>
                    </select>
                    <i class='bx bx-chevron-down'></i>
                </div>
            </div>

            <!-- Date Range Filter -->
            <div class="filterStatus ms-2">
                <div class="position-relative">
                    <button type="button" id="toggleDatePicker" style="border:none; background:none;"
                        class="d-flex align-items-center">
                        <i class='bx bxs-calendar m-0' style="font-size: 24px; color: #707070;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Picker Container (Moved outside the flex container) -->
    <div id="datePickerContainer" class="position-absolute d-none"
        style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 1000; width: 300px; right: 0; margin-top: 10px;">
        <div class="mb-3">
            <label class="form-label d-block mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}"
                style="width: 100%;">
        </div>
        <div class="mb-3">
            <label class="form-label d-block mb-2">Tanggal Akhir</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}"
                style="width: 100%;">
        </div>
        <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
    </div>
</form>

<style>
    /* Add these styles to your CSS */
    #datePickerContainer {
        background: white;
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #datePickerContainer input[type="date"] {
        border: 1px solid #dee2e6;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        width: 100%;
    }

    #datePickerContainer label {
        font-size: 0.875rem;
        color: #495057;
    }

    #datePickerContainer button[type="submit"] {
        margin-top: 0.5rem;
    }

    /* Ensure the date picker container is above other elements */
    .position-relative {
        position: relative !important;
    }

    /* Animation for the date picker */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #datePickerContainer:not(.d-none) {
        animation: fadeIn 0.2s ease-out;
    }
</style>

<script>
    // Handle form submission on input/change events
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
