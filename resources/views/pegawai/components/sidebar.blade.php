<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/core.css') }}">
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<nav class="sidebar">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="../img/logo-hitam.png" alt="" id="logo">
            </span>
            <div class="text header-text">
                <span class="font-weight-bolder">GuBook</span>
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

                <li class="nav-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.dashboard') }}">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Beranda</span>
                    </a>
                </li>
                <li class="nav-link {{ request()->routeIs('pegawai.laporan-tamu') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.laporan-tamu') }}">
                        <i class='bx bx-file icon'></i>
                        <span class="text nav-text">Laporan Tamu</span>
                    </a>
                </li>
                <li class="nav-link {{ request()->routeIs('pegawai.laporan-kurir') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.laporan-kurir') }}">
                        <i class='bx bx-file icon'></i>
                        <span class="text nav-text">Laporan Kurir</span>
                    </a>
                </li>
                <li class="nav-link {{ request()->routeIs('pegawai.manajemen-kunjungan') ? 'active' : ''}}">
                    <a href="{{ route('pegawai.manajemen-kunjungan') }}">
                        <i class='bx bx-calendar-check icon'></i>
                        <span class="text nav-text">Manajemen Kunjungan</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="bottom-content">
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
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

<script>
const body = document.querySelector("body"),
    sidebar = document.querySelector(".sidebar"),
    toggle = document.querySelector(".toggle"),
    searchBtn = document.querySelector(".search-box"),
    modeSwitch = document.querySelector(".toggle-switch"),
    modeText = document.querySelector(".mode-text"),
    logo = document.getElementById('logo');

toggle.addEventListener("click", () =>{
  sidebar.classList.toggle("close");
});

searchBtn.addEventListener("click", () =>{
  sidebar.classList.remove("close");
});

modeSwitch.addEventListener("click", () =>{
  body.classList.toggle("dark");
  if(body.classList.contains("dark")) {
    modeText.innerText = "Mode Terang";
    logo.src = '../img/logo-putih.png';
  } else {
    modeText.innerText = "Mode Gelap";
    logo.src = '../img/logo-hitam.png'; // Path ke logo untuk light mode
  }
});
</script>
