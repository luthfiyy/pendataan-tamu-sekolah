<link rel="stylesheet" href="{{ asset('css/core.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <div class="me-2">
                        <button style="border:none; background:none;" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNotification" aria-controls="offcanvasNotification">

                            <i class='bx bx-bell' style="color: #000; font-size: 30px;"></i>
                        </button>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNotification"
    aria-labelledby="offcanvasNotificationLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasNotificationLabel">Notifikasi Tamu Baru</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Konten notifikasi akan dimasukkan di sini -->
    </div>
</div>


<div class="modal fade" id="qrScanModal" tabindex="-1" aria-labelledby="qrScanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrScanModalLabel">Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="reader" style="width:100%; height: 259px;"></div>
                <div id="result" style="margin-top: 10px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Tamu -->
<div class="modal fade" id="tamuDetailModal" tabindex="-1" aria-labelledby="tamuDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tamuDetailModalLabel">Detail Tamu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> <span id="modalTamuName"></span></p>
                <p><strong>Email:</strong> <span id="modalTamuEmail"></span></p>
                <p><strong>No Telepon:</strong> <span id="modalTamuPhone"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="takePhotoBtn">Ambil Foto</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="id_tamu" name="id_tamu">

<!-- Modal Kamera -->
<div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cameraModalLabel">Ambil Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="cameraSection">
                <video id="video" autoplay style="width: 100%; height: auto;"></video>
            </div>
            <div class="modal-body text-center" id="previewSection" style="display: none;">
                <img id="foto-preview" src="" alt="Foto Preview" style="width: 100%; margin-top: 10px;">
            </div>
            <div class="modal-footer">
                <button type="button" id="snap" class="btn btn-primary mt-2">Ambil Foto</button>
                <button type="button" id="backToCamera" class="btn btn-secondary" style="display: none;">Foto
                    Kembali</button>
                <button type="button" id="save-photo" class="btn btn-primary"
                    style="display: none;">Simpan</button>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript">
    // <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js">
</script>
<link rel="stylesheet" href="{{ asset('js/script.js') }}">

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz4fnFO9FfN2IO49JWKNj4Xc4lTnL8E+vsgYV8h6i+n81paAnw1Pp8DAfB1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-c0vJ+c44F1c8Upct9c0V6sHFeKt9Wv9m6rKf6BqP8Iq5k5hBf9Wh9oQAK86b8G0E" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz4fnFO9FfN2IO49JWKNj4Xc4lTnL8E+vsgYV8h6i+n81paAnw1Pp8DAfB1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-c0vJ+c44F1c8Upct9c0V6sHFeKt9Wv9m6rKf6BqP8Iq5k5hBf9Wh9oQAK86b8G0E" crossorigin="anonymous">
</script>
</script>
<script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('vendor/js/helpers.js') }}"></script>
<script src="{{ asset('vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('js-sneat/config.js') }}"></script>
<script src="{{ asset('js-sneat/main.js') }}"></script>
<script src="{{ asset('vendor/js/menu.js') }}"></script>

{{-- <script>
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
</script> --}}

{{-- <script>
    fetch('/get-notifications')
    .then(response => response.json())
    .then(notifications => {
        notifications.forEach(notification => {
            console.log(notification.message);
            console.log(notification.tamu); // Menampilkan data tamu
            // Tampilkan notifikasi di UI, misalnya menggunakan alert atau modal
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const qrScanModal = new bootstrap.Modal(document.getElementById('qrScanModal'));
        const tamuDetailModal = new bootstrap.Modal(document.getElementById('tamuDetailModal'));
        const cameraModal = new bootstrap.Modal(document.getElementById('cameraModal'));
        const video = document.getElementById('video');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        const fotoPreview = document.getElementById('foto-preview');
        const cameraSection = document.getElementById('cameraSection');
        const previewSection = document.getElementById('previewSection');
        const snapButton = document.getElementById('snap');
        const backToCameraButton = document.getElementById('backToCamera');
        const savePhotoButton = document.getElementById('save-photo');

        console.log('Save Photo Button:', savePhotoButton); // Untuk debugging

        document.querySelector('.nav-link .bx-qr-scan').closest('.nav-link').addEventListener('click', function(
            event) {
            event.preventDefault();
            qrScanModal.show();
            startQRScanner();
        });

        // function onScanSuccess(decodedText, decodedResult) {
        //     console.log(`QR Code detected: ${decodedText}`);
        //     fetch(`/tamu/detail/${decodedText}`)
        //         .then(response => response.json())
        //         .then(data => {
        //             document.getElementById('modalTamuName').innerText = data.name;
        //             document.getElementById('modalTamuEmail').innerText = data.email;
        //             document.getElementById('modalTamuPhone').innerText = data.phone;
        //             document.getElementById('id_tamu').value = decodedText; // Tambahkan ini
        //             tamuDetailModal.show();
        //             qrScanModal.hide();
        //             stopQRScanner();
        //         })
        //         .catch(error => console.error('Error fetching tamu details:', error));
        // }

        // function onScanSuccess(decodedText, decodedResult) {
        //     console.log(`QR Code detected: ${decodedText}`);
        //     fetch(`/tamu/detail/${decodedText}`)
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 document.getElementById('modalTamuName').innerText = data.name;
        //                 document.getElementById('modalTamuEmail').innerText = data.email;
        //                 document.getElementById('modalTamuPhone').innerText = data.phone;
        //                 document.getElementById('id_tamu').value = decodedText;
        //                 tamuDetailModal.show();
        //                 qrScanModal.hide();
        //                 stopQRScanner();
        //             } else {
        //                 alert(data.message);
        //                 qrScanModal.hide();
        //                 stopQRScanner();
        //             }
        //         });
        // }

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`QR Code detected: ${decodedText}`);
            fetch(`/tamu/detail/${decodedText}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modalTamuName').innerText = data.name;
                        document.getElementById('modalTamuEmail').innerText = data.email;
                        document.getElementById('modalTamuPhone').innerText = data.phone;
                        document.getElementById('id_tamu').value = decodedText;
                        tamuDetailModal.show();
                        qrScanModal.hide();
                        stopQRScanner();
                    } else {
                        alert(data.message);
                        qrScanModal.hide();
                        stopQRScanner();
                    }
                })
            // .catch(error => {
            //     console.error('Error fetching tamu details:', error);
            //     alert('Terjadi kesalahan saat memproses QR code.');
            //     qrScanModal.hide();
            //     stopQRScanner();
            // });
        }

        function onScanError(errorMessage) {
            console.error(`QR Code scan error: ${errorMessage}`);
        }

        let html5QrCode;

        function startQRScanner() {
            html5QrCode = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            }, false);
            html5QrCode.render(onScanSuccess, onScanError).catch(err => {
                console.error('Unable to start scanning:', err);
            });
        }

        function stopQRScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    console.log('QR Code scanning stopped.');
                }).catch(err => {
                    console.error('Failed to stop scanning:', err);
                });
            }
        }

        document.getElementById('qrScanModal').addEventListener('hidden.bs.modal', function() {
            stopQRScanner();
        });

        document.getElementById('tamuDetailModal').addEventListener('hidden.bs.modal', function() {
            startQRScanner();
        });

        document.getElementById('takePhotoBtn').addEventListener('click', function() {
            cameraModal.show();
            startCamera();
        });

        document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
            stopCamera();
        });

        function startCamera() {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(err => console.error('Error accessing camera:', err));
        }

        function stopCamera() {
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
            }
        }

        function capturePhoto() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            const dataUrl = canvas.toDataURL('image/png');
            fotoPreview.src = dataUrl;
            cameraSection.style.display = 'none';
            previewSection.style.display = 'block';
        }

        snapButton.addEventListener('click', function() {
            capturePhoto();
            backToCameraButton.style.display = 'block';
            savePhotoButton.style.display = 'block';
            console.log('Save button should be visible now'); // Untuk debugging
        });

        backToCameraButton.addEventListener('click', function() {
            cameraSection.style.display = 'block';
            previewSection.style.display = 'none';
            backToCameraButton.style.display = 'none';
            savePhotoButton.style.display = 'none';
        });

        if (savePhotoButton) {
            savePhotoButton.addEventListener('click', function(event) {
                event.preventDefault();
                console.log('Save button clicked'); // Untuk debugging

                canvas.toBlob(function(blob) {
                    const formData = new FormData();
                    formData.append('foto', blob, 'foto.png');
                    formData.append('id_tamu', document.getElementById('id_tamu').value);

                    console.log('FormData:', formData); // Untuk debugging

                    fetch('{{ route('update-kedatangan') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Response Data:', data); // Debugging response data
                            if (data.success) {
                                alert('Data berhasil diperbarui.');
                                cameraModal.hide();
                                tamuDetailModal.hide();
                                qrScanModal.hide();
                                startQRScanner();
                            } else {
                                console.error('Update failed:', data
                                    .message); // Log error message
                                alert('Terjadi kesalahan: ' + data.message);
                            }
                        })

                }, 'image/png');
            });
        } else {
            console.error('Save Photo Button not found'); // Untuk debugging
        }
    });
</script> --}}

<script>
    //     $(document).ready(function() {
    //     function fetchNewGuests() {
    //         $.ajax({
    //             url: '/tamu-baru', // Endpoint API Laravel
    //             method: 'GET',
    //             success: function(data) {
    //                 if (data.length > 0) {
    //                     var notificationBell = $('.bx-bell');
    //                     notificationBell.find('.badge').remove(); // Hapus badge sebelumnya jika ada

    //                     var notificationCount = $('<span>')
    //                         .addClass('badge bg-danger')
    //                         .text(data.length);

    //                     // Tambahkan notifikasi count ke icon bell
    //                     notificationBell.append(notificationCount);

    //                     // Masukkan tamu baru ke dalam offcanvas
    //                     var offcanvasContent = $('#offcanvasNotification .offcanvas-body');
    //                     offcanvasContent.empty(); // Kosongkan konten sebelumnya

    //                     data.forEach(function(tamu) {
    //                         offcanvasContent.append('<p>Tamu baru: ' + tamu.nama + '</p>');
    //                     });

    //                     // Tampilkan offcanvas
    //                     var offcanvasNotification = new bootstrap.Offcanvas('#offcanvasNotification');
    //                     offcanvasNotification.show();
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('Error fetching new guests:', error);
    //             }
    //         });
    //     }

    //     // Polling setiap 30 detik untuk memeriksa tamu baru
    //     setInterval(fetchNewGuests, 30000);

    //     // Panggil fungsi pertama kali saat halaman dimuat
    //     fetchNewGuests();
    // });



    document.addEventListener('DOMContentLoaded', function() {
        const qrScanModal = new bootstrap.Modal(document.getElementById('qrScanModal'));
        const tamuDetailModal = new bootstrap.Modal(document.getElementById('tamuDetailModal'));
        const cameraModal = new bootstrap.Modal(document.getElementById('cameraModal'));
        const video = document.getElementById('video');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        const fotoPreview = document.getElementById('foto-preview');
        const cameraSection = document.getElementById('cameraSection');
        const previewSection = document.getElementById('previewSection');
        const snapButton = document.getElementById('snap');
        const backToCameraButton = document.getElementById('backToCamera');
        const savePhotoButton = document.getElementById('save-photo');

        console.log('Save Photo Button:', savePhotoButton);

        let html5QrCode;

        function initializeQRScanner() {
            if (html5QrCode) {
                html5QrCode.clear();
            }
            html5QrCode = new Html5Qrcode("reader");
        }

        function startQRScanner() {
            initializeQRScanner();
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                onScanSuccess,
                onScanError
            ).catch(err => {
                console.error('Unable to start scanning:', err);
            });
        }

        function stopQRScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    console.log('QR Code scanning stopped.');
                    html5QrCode.clear();
                }).catch(err => {
                    console.error('Failed to stop scanning:', err);
                });
            }
        }

        document.querySelector('.nav-link .bx-qr-scan').closest('.nav-link').addEventListener('click', function(
            event) {
            event.preventDefault();
            qrScanModal.show();
            startQRScanner();
        });

        document.getElementById('qrScanModal').addEventListener('hidden.bs.modal', function() {
            stopQRScanner();
        });

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`QR Code detected: ${decodedText}`);
            stopQRScanner();
            fetch(`/tamu/detail/${decodedText}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const appointmentTime = new Date(data.waktu_perjanjian);
                        const currentTime = new Date();
                        const timeDifferenceInHours = (currentTime - appointmentTime) / (1000 * 60 * 60);

                        if (timeDifferenceInMinutes > 30) {
                            alert('QR Code tidak valid. Waktu perjanjian telah lewat lebih dari 30 menit.');
                            qrScanModal.hide();
                            return;
                        }
                        document.getElementById('modalTamuName').innerText = data.name;
                        document.getElementById('modalTamuEmail').innerText = data.email;
                        document.getElementById('modalTamuPhone').innerText = data.phone;
                        document.getElementById('id_tamu').value = decodedText;
                        qrScanModal.hide();
                        tamuDetailModal.show();
                    } else {
                        alert(data.message);
                        qrScanModal.hide();
                    }
                })
                .catch(error => {
                    console.error('Error fetching tamu details:', error);
                    alert('Terjadi kesalahan saat memproses QR code.');
                    qrScanModal.hide();
                });
        }

        function onScanError(errorMessage) {
            console.error(`QR Code scan error: ${errorMessage}`);
        }

        document.getElementById('takePhotoBtn').addEventListener('click', function() {
            cameraModal.show();
            startCamera();
        });

        document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
            stopCamera();
        });

        function startCamera() {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(err => console.error('Error accessing camera:', err));
        }

        function stopCamera() {
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
            }
        }

        function capturePhoto() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            const dataUrl = canvas.toDataURL('image/png');
            fotoPreview.src = dataUrl;
            cameraSection.style.display = 'none';
            previewSection.style.display = 'block';
        }

        snapButton.addEventListener('click', function() {
            capturePhoto();
            backToCameraButton.style.display = 'block';
            savePhotoButton.style.display = 'block';
            console.log('Save button should be visible now');
        });

        backToCameraButton.addEventListener('click', function() {
            cameraSection.style.display = 'block';
            previewSection.style.display = 'none';
            backToCameraButton.style.display = 'none';
            savePhotoButton.style.display = 'none';
        });

        if (savePhotoButton) {
            savePhotoButton.addEventListener('click', function(event) {
                event.preventDefault();
                console.log('Save button clicked');

                canvas.toBlob(function(blob) {
                    const formData = new FormData();
                    formData.append('foto', blob, 'foto.png');
                    formData.append('id_tamu', document.getElementById('id_tamu').value);

                    console.log('FormData:', formData);

                    fetch('{{ route('update-kedatangan') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Response Data:', data);
                            if (data.success) {
                                alert('Data berhasil diperbarui.');
                                cameraModal.hide();
                                tamuDetailModal.hide();
                                qrScanModal.hide();
                                stopCamera();
                                stopQRScanner();
                            } else {
                                throw new Error(data.message ||
                                    'Terjadi kesalahan saat memperbarui data.');
                            }
                        })
                    // .catch(error => {
                    //     console.error('Error updating data:', error);
                    //     alert(error.message ||
                    //         'Terjadi kesalahan saat memperbarui data.');
                    // });
                }, 'image/png');
            });
        } else {
            console.error('Save Photo Button not found');
        }
    });
</script>
