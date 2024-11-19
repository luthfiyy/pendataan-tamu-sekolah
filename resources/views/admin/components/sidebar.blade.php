<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<nav class="sidebar">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="../img/logo-hitam.png" alt="" id="logo">
            </span>
            <div class="text header-text">
                <span class="name">GuBook</span>
                <span class="profession">SMKN 11 Bandung</span>
            </div>
        </div>
        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

            <ul class="menu-links" style="padding-left: 0;">
                <li class="menu-head small text-uppercase">
                    <span class="menu-header-line"></span>

                    <span class="menu-header-text">Pages</span>
                </li>

                <li class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Beranda</span>
                    </a>
                </li>
                <li class="nav-link {{ request()->routeIs('admin.pegawai') ? 'active' : '' }}">
                    <a href="{{ route('admin.pegawai') }}">
                        <i class='bx bx-user icon'></i>
                        <span class="text nav-text">Pegawai</span>
                    </a>
                </li>
                <li class="nav-link {{ request()->routeIs('admin.laporan-tamu') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan-tamu') }}">
                        <i class='bx bx-file icon'></i>
                        <span class="text nav-text">Laporan Tamu</span>
                    </a>
                </li>
                <li class="nav-link {{ request()->routeIs('admin.laporan-kurir') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan-kurir') }}">
                        <i class='bx bx-file icon'></i>
                        <span class="text nav-text">Laporan Kurir</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="bottom-content">
            <li>
                <a href="#" class="d-flex align-items-center" onclick="showLogoutAlert(event)">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </li>
            {{-- <li class="mode">
                <div class="moon-sun">
                    <i class="bx bx-moon moon"></i>
                    <i class="bx bx-sun sun"></i>
                </div>
                <span class="mode-text text">Mode Gelap</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li> --}}
        </div>
    </div>
</nav>


<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
    const body = document.querySelector("body"),
        sidebar = document.querySelector(".sidebar"),
        toggle = document.querySelector(".toggle"),
        searchBtn = document.querySelector(".search-box"),
        modeSwitch = document.querySelector(".toggle-switch"),
        modeText = document.querySelector(".mode-text"),
        logo = document.getElementById('logo');

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });

    searchBtn.addEventListener("click", () => {
        sidebar.classList.remove("close");
    });

    modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");
        if (body.classList.contains("dark")) {
            modeText.innerText = "Mode Terang";
            logo.src = '../img/logo-putih.png';
        } else {
            modeText.innerText = "Mode Gelap";
            logo.src = '../img/logo-hitam.png'; // Path ke logo untuk light mode
        }
    });

    function showLogoutAlert(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin keluar dari sistem?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
            // Tambahkan properti berikut
            scrollbarPadding: false,
            heightAuto: false,
            customClass: {
                popup: 'swal2-show',
                title: 'text-lg font-semibold mb-2',
                content: 'text-gray-600',
                actions: 'swal-buttons-container',
                confirmButton: 'swal-confirm-button',
                cancelButton: 'swal-cancel-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Updated custom styling for SweetAlert
    const style = document.createElement('style');
    style.textContent = `
    .swal2-popup {
        border-radius: 15px !important;
        padding: 2rem !important;
    }

    .swal2-title {
        font-size: 1.5rem !important;
        color: #333 !important;
    }
        
    .swal2-text {
        color: #666 !important;
        margin-bottom: 1rem !important;
    }

    .swal-buttons-container {
        display: flex !important;
        justify-content: center !important;
        gap: 1rem !important;
        padding: 0 1rem !important;
    }

    .swal2-actions {
        width: 100% !important;
        justify-content: center !important;
        margin-top: 1.5rem !important;
    }

    .swal-confirm-button, .swal-cancel-button {
        margin: 0 !important;
        padding: 8px 24px !important;
        font-weight: 500 !important;
        flex: 0 0 auto !important;
        min-width: 120px !important;
    }

    .swal2-icon {
        margin: 1.5rem auto !important;
    }
`;
    document.head.appendChild(style);
</script>
