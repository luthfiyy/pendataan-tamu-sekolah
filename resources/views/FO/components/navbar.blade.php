<link rel="stylesheet" href="{{ asset('css/core.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .dropdown-menu-end {
        right: 0;
        left: auto;
    }
</style>



<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." />
            </div>
        </div>
        <!-- /Search -->


        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->

            <!-- User -->

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <div class="avatar">
                        <i class='bx bx-qr-scan' style="color: #000; font-size: 30px;"></i>

                    </div>
                </a>
            </li>
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="../../img/logo-hitam.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="../../img/logo-hitam.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">John Doe</span>
                                    <small class="text-muted">Admin</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                <span class="flex-grow-1 align-middle">Billing</span>
                                <span
                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="auth-login-basic.html">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

<div class="modal fade" id="qrScanModal" tabindex="-1" aria-labelledby="qrScanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrScanModalLabel">Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="reader" style="width:100%; height: 400px;"></div>
                <div id="result" style="margin-top: 10px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript">

// <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrScanModal = new bootstrap.Modal(document.getElementById('qrScanModal'));
        document.querySelector('.nav-link[data-bs-toggle="dropdown"]').addEventListener('click', function(event) {
            event.preventDefault();
            qrScanModal.show();
        });

        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('result').innerText = `QR Code detected: ${decodedText}`;
            console.log(`QR Code matched: ${decodedText}`);
            // Optional: Stop scanning when a QR code is successfully scanned
            html5QrCode.stop().then(() => {
                console.log('QR Code scanning stopped.');
            }).catch(err => {
                console.error('Unable to stop scanning.', err);
            });
        }

        function onScanError(errorMessage) {
            console.error(`QR Code scan error: ${errorMessage}`);
        }

        const html5QrCode = new Html5QrcodeScanner("reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);
        console.log(html5QrCode);

        // Start QR code scanning when the modal is shown
        document.getElementById('qrScanModal').addEventListener('shown.bs.modal', function () {
            html5QrCode.render(
                onScanSuccess,
                onScanError
            ).catch(err => {
                console.error('Unable to start scanning:', err);
            });
        });

        // Ensure that the QR code scanner stops when the modal is closed
        document.getElementById('qrScanModal').addEventListener('hidden.bs.modal', function () {
            html5QrCode.stop().catch(err => {
                console.error('Failed to stop scanning:', err);
            });
        });
    });
</script>

