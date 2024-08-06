<nav>
    <div class="logo">
        <img src="img/gubook-hitam.png" alt="">
    </div>
    <ul>
        <li>
            <a href="{{ route('landing-page') }}" class="{{ Request::routeIs('landing-page') ? 'active' : '' }}">
                Beranda
            </a>
        </li>
        <li>
            <a href="{{ route('guru') }}" class="{{ Request::routeIs('guru') ? 'active' : '' }}">
                Pegawai
            </a>
        </li>
        <li>
            <a href="{{ route('tentang-kami') }}" class="{{ Request::routeIs('tentang-kami') ? 'active' : '' }}">
                Tentang Kami
            </a>
        </li>
        <li>
            <a href="{{ route('tentang-kami') }}#kontak-kami"
                class="{{ Request::routeIs('tentang-kami') ? 'active' : '' }}">
                Kontak Kami
            </a>
        </li>
    </ul>
    <a href="#" class="a-custom" id="loginButton">
        Login
    </a>
</nav>

<!-- Modal HTML -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header d-flex flex-column align-items-center">
                <img src="{{ asset('img/warning.png') }}" alt="" width="300px">
                <div>
                    <h3>Oops!</h3>
                    <p class="mb-0">Akses login ini khusus untuk Admin.</p>
                    <p class="mb-0">Jika Anda bukan Admin, silakan tutup pemberitahuan ini.</p>
                    <p class="mb-0">Terima kasih.</p>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('login') }}" class="btn btn-primary">Lanjutkan Login</a>
            </div>
        </div>
    </div>
</div>


<style>
    .active {
        color: var(--primary-color);
        border-bottom: 1px solid #191919;
    }

    .modal-header img {
        margin-top: -130px;
    }

    .loginModal {}

    .btn-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var loginButton = document.querySelector('.a-custom');
        loginButton.addEventListener('click', function(e) {
            e.preventDefault();
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
