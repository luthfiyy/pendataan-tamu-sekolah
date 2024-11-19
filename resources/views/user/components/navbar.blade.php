<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar with Smooth Overlay Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #007bff;
            --sidebar-bg-color: #f8f9fa;
            --sidebar-width: 250px;
        }

        .navbar {
            background: transparent;
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            max-height: 40px;
        }

        .nav-link {
            color: #191919;
        }

        .nav-active {
            color: var(--primary-color);
            border-bottom: 1px solid var(--primary-color);
        }

        .navbar-toggler {
            border: none;
        }

        .sidebar {
            height: 100%;
            width: var(--sidebar-width);
            position: fixed;
            z-index: 1000;
            top: 0;
            left: calc(var(--sidebar-width) * -1);
            background-color: var(--sidebar-bg-color);
            overflow-x: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.1, 0.25, 1);
            padding-top: 60px;
        }

        .sidebar.open {
            left: 0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #333;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: var(--primary-color);
        }

        .sidebar .close-btn {
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            cursor: pointer;
        }

        .content {
            transition: all 0.3s cubic-bezier(0.25, 0.1, 0.25, 1);
        }

        .content.dimmed {
            opacity: 0.7;
            pointer-events: none;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .side-active {
            background-color: var(--primary-color);
            border-radius: 10px;
            margin-inline: 20px;
            margin-top: 10px
        }

        .side-active .bx,
        .side-active .text {
            color: white;
        }

        .side-active a {
            padding: 8px 0px 8px 12px;
        }

        .btn-login {
            background: none;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-login:hover {
            background: var(--primary-color);
            color:#fff;
        }


    </style>
</head>

<body>
    <div class="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="img/gubook-hitam.png" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse ms-5" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('landing-page') ? 'nav-active' : '' }}"
                                href="{{ route('landing-page') }}" style=" color: #191919;">Beranda</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('guru', 'tendik') ? 'nav-active' : '' }}"
                                href="{{ route('guru') }}" style=" color: #191919;">Pegawai</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('tentang-kami') ? 'nav-active' : '' }}"
                                href="{{ route('tentang-kami') }}" style=" color: #191919;">Tentang Kami</a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-login" id="loginButton">Login</a>
                </div>
            </div>
        </nav>

        <!-- Your main content goes here -->
    </div>

    <div id="mySidebar" class="sidebar">
        <span class="close-btn" onclick="closeNav()">&times;</span>
        <ul class="menu-links" style="padding-left: 0;">
            <li class="nav-link {{ request()->routeIs('landing-page') ? 'side-active' : '' }}">
                <a href="{{ route('landing-page') }}">
                    <i class='bx bx-home-alt icon'></i>
                    <span class="text nav-text">Beranda</span>
                </a>
            </li>
            {{-- <li class="nav-link {{ request()->routeIs('guru', 'tendik') ? 'side-active' : '' }}">
                <a href="{{ route('guru') }}">
                    <i class='bx bxs-graduation'></i>
                    <span class="text nav-text">Pegawai</span>
                </a>
            </li> --}}
            <li class="nav-link {{ request()->routeIs('tentang-kami') ? 'side-active' : '' }}">
                <a href="{{ route('tentang-kami') }}">
                    <i class='bx bx-info-circle'></i>
                    <span class="text nav-text">Tentang Kami</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="#" id="sidebarLoginButton">
                    <i class="bx bx-log-in"></i>
                    <span class="text nav-text">Login</span>
                </a>
            </li>
        </ul>
    </div>

    <div id="overlay" class="overlay"></div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header d-flex flex-column align-items-center">
                    <img src="{{ asset('img/warning.svg') }}" alt="" style="margin-top: -200px; margin-left: 50px;" width="300px">
                    <div>
                        <h3 style="margin-top: -1rem">Oops!</h3>
                        <p class="mb-0">Akses login ini khusus untuk <b>Pegawai</b>.</p>
                        <p class="mb-0">Jika Anda bukan <b>Pegawai</b>, silakan tutup pemberitahuan ini.</p>
                        <p class="mb-0">Terima kasih.</p>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ route('login') }}" class="btn btn-primary">Lanjutkan Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loginButton = document.getElementById('loginButton');
            var sidebarLoginButton = document.getElementById('sidebarLoginButton');
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            var content = document.querySelector('.content');
            var sidebar = document.getElementById('mySidebar');
            var overlay = document.getElementById('overlay');

            function showLoginModal(e) {
                e.preventDefault();
                loginModal.show();
            }

            loginButton.addEventListener('click', showLoginModal);
            sidebarLoginButton.addEventListener('click', showLoginModal);

            var sidebarToggle = document.getElementById('sidebarToggle');
            sidebarToggle.addEventListener('click', function() {
                openNav();
            });

            overlay.addEventListener('click', closeNav);
        });

        function openNav() {
            document.getElementById("mySidebar").classList.add('open');
            document.querySelector('.content').classList.add('dimmed');
            document.getElementById('overlay').classList.add('active');
        }

        function closeNav() {
            document.getElementById("mySidebar").classList.remove('open');
            document.querySelector('.content').classList.remove('dimmed');
            document.getElementById('overlay').classList.remove('active');
        }
    </script>
</body>

</html>
