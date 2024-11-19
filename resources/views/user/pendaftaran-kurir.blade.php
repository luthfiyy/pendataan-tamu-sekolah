<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GuBook SMKN 11 Bandung - Pendaftaran Kurir</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/core.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-search__field {
            outline: none
        }

        .select2-container .select2-selection__arrow {
            display: none;
        }

        .select2-container .select2-selection--single {
            height: 45px;
            /* Atur tinggi sesuai kebutuhan */
            display: flex;
            align-items: center;
            /* Agar teks tetap berada di tengah vertikal */
        }

        .select2-container .select2-selection__rendered {
            line-height: 50px;
            /* Samakan dengan nilai height untuk pusat vertikal */
        }

        #video,
        #foto-preview {
            width: 100%;
            max-width: 320px;
        }


        .btn:hover {
            color: #4461F2
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .select-wrapper {
            position: relative;
        }

        .select-container {
            position: relative;
        }

        .select-container select {
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding: 10px;
            /* border: 1px solid #ccc; */
            border-radius: 4px;
        }

        .select-container i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .ekspedisi-wrapper {
            display: flex;
            flex-direction: column;
        }

        #otherInput {
            display: none;
            width: 100%;
            /* margin-top: 10px; */
            padding: 10px;
            /* border: 1px solid #ccc; */
            border-radius: 4px;
        }

        #otherInput.visible {
            display: block;
        }

        #snap:hover {
            color: #4461F2;
            background-color: #fff;
            box-shadow: 1px solid rgb(68, 97, 242, 0.1);
            border: 1px solid #4461F2;
        }

        #backToCamera:hover {
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #6c757d
        }

        #save-photo:hover {
            color: #4461F2;
            background-color: #fff;
            border: 1px solid #4461F2;
        }
    </style>
</head>

<body style="background-color: #fefefe;">
    @include('user.components.background')
    @include('user.components.navbar')
    <!-- Content of the landing page -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 pt-5">
                <div class="form-tamu">
                    <div class="card-header-kurir">
                        <i class='bx bx-package'></i>
                        <h4>Data Kurir</h4>
                    </div>

                    <form id="addForm" action="{{ route('kurir.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="grid-container">
                                <div class="grid-item">
                                    <input type="text" id="nama" name="nama_kurir" placeholder=" " required>
                                    <label for="nama">Nama</label>
                                </div>
                                <div class="grid-item">
                                    <input type="text" id="no_telp" name="no_telp" placeholder=" " required>
                                    <label for="nama">No Telepon</label>
                                </div>
                                <div class="grid-item select-wrapper ekspedisi-wrapper">
                                    <div class="select-container">
                                        <select id="options" onchange="showInput(this)" name="ekspedisi"
                                            class="ekspedisi">
                                            <option value="" selected disabled>Ekspedisi</option>
                                            <option value="JNE">JNE</option>
                                            <option value="J&T">J&T</option>
                                            <option value="POS Indonesia">POS Indonesia</option>
                                            <option value="TiKi">TiKi</option>
                                            <option value="SiCepat">SiCepat</option>
                                            <option value="Wahana">Wahana</option>
                                            <option value="Shopee">Shopee</option>
                                            <option value="Gojek">Gojek</option>
                                            <option value="Grab">Grab</option>
                                            <option value="other">Lainnya...</option>
                                        </select>
                                        <i class='bx bx-chevron-down'></i>
                                    </div>
                                    {{-- <input type="text" id="otherInput" class="hidden" name="ekspedisi_other"
                                        placeholder="Masukkan opsi lainnya..."> --}}
                                </div>
                                <div class="grid-item select-wrapper">
                                    <div class="select-container">
                                        <select name="id_user" id="pegawai" class="form-control pegawai-dituju"
                                            required>
                                            <option value="" selected disabled>Pegawai yang dituju</option>
                                            @foreach ($user as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <i class='bx bx-chevron-down'></i>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item mt-4 p-0" id="otherInput">
                                <input type="text" class="" name="ekspedisi_other" placeholder="">
                                <label for="otherInput">Masukkan opsi ekspedisi lainnya...</label>
                            </div>
                            <div class="container p-0 mt-3">
                                <div class="form-group position-relative">
                                    <label for="foto-data"></label>
                                    <input type="text" class="form-control" id="foto-name" readonly
                                        placeholder="Ambil Foto" data-toggle="modal" data-target="#cameraModal">
                                    <input type="hidden" id="foto-data" name="foto_data">
                                    <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y"
                                        data-toggle="modal" data-target="#cameraModal">
                                        <i class='bx bx-camera' style="font-size: 24px"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            {{-- <div class="grid-item">
                                    <video id="video" width="320" height="240" autoplay></video>
                                    <button type="button" id="snap">Ambil Foto</button>
                                    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                                    <input type="hidden" id="foto-data" name="foto_data">
                                    <img id="foto-preview" src="" alt="Foto Preview" style="display: none; margin-top: 10px; width: 100%; max-width: 200px;">
                                </div> --}}

                        </div>
                        <input type="submit" value="Kirim" class="shadow-primary ms-0 me-0 mt-2 mb-2">
                    </form>


                </div>
            </div>
        </div>
    </div>


    <!-- Modal Kamera -->
    <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cameraModalLabel">Ambil Foto</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="cameraSection">
                    <video id="video" autoplay></video>
                    <div class="footer d-flex flex-column align-items-center pb-0 pt-0">
                        <button type="button" id="snap" class="btn btn-primary mt-2 d-flex align-items-center">
                            <i class='bx bxs-camera'></i>
                            Ambil Foto</button>
                    </div>
                </div>
                <div class="modal-body text-center" id="previewSection" style="display: none;">
                    <img id="foto-preview" src="" alt="Foto Preview" style="margin-top: 10px;">
                </div>
                <div class="d-flex justify-content-center pe-3 mb-3">
                    <button type="button" class="btn btn-secondary me-3" id="backToCamera"
                        style="display: none;">Foto
                        Kembali</button>
                    <button type="button" class="btn btn-primary" id="save-photo" style="display: none;"
                        data-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="daftarModal" tabindex="-1" aria-labelledby="daftarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header d-flex flex-column align-items-center">
                    <img src="{{ asset('img/success.svg') }}" alt="" width="300px" id="successImage"
                        style="margin-left: 0; margin-top: -13rem;">
                    <img src="{{ asset('img/error.svg') }}" alt="" width="300px" id="errorImage"
                        style="display: none;">
                    <div id="modalMessage">
                        <h3 id="modalTitle">Terima Kasih!</h3>
                        <p class="mb-0" id="modalText">Data berhasil terkirim.</p>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript and other scripts -->
    <script>
        $(document).ready(function() {
            $('.pegawai-dituju').select2();
        });

        $(document).ready(function() {
            $('.ekspedisi').select2();
        });

        function showInput(select) {
            var otherInput = document.getElementById('otherInput');
            if (select.value === 'other') {
                otherInput.classList.add('visible');
            } else {
                otherInput.classList.remove('visible');
            }
        }

        var video = document.getElementById('video');
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        var snap = document.getElementById('snap');
        var fotoPreview = document.getElementById('foto-preview');
        var fotoData = document.getElementById('foto-data');
        var fotoName = document.getElementById('foto-name');
        var savePhoto = document.getElementById('save-photo');
        var backToCamera = document.getElementById('backToCamera');
        var cameraSection = document.getElementById('cameraSection');
        var previewSection = document.getElementById('previewSection');

        document.addEventListener('DOMContentLoaded', function() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                document.getElementById('cameraModal').addEventListener('shown.bs.modal', initializeCamera);
            } else {
                console.error("getUserMedia not supported");
                alert("Maaf, browser Anda tidak mendukung akses kamera.");
            }
        });

        function initializeCamera() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        video.srcObject = stream;
                        video.play();
                    })
                    .catch(function(err) {
                        console.error("Error accessing camera: ", err);
                        alert("Gagal mengakses kamera. Error: " + err.message);
                    });
            } else {
                console.error("getUserMedia not supported");
                alert("Maaf, browser Anda tidak mendukung akses kamera.");
            }
        }

        // Ambil referensi ke tombol yang membuka modal kamera
        var openCameraButton = document.querySelector('[data-toggle="modal"][data-target="#cameraModal"]');

        // Tambahkan event listener ke tombol
        openCameraButton.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah tindakan default tombol
            var modal = document.getElementById('cameraModal');

            // Buka modal
            var modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();

            // Tunggu sebentar sebelum menginisialisasi kamera
            setTimeout(function() {
                initializeCamera();
            }, 500); // Delay 500ms
        });

        let stream;

        function initializeCamera() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(mediaStream) {
                        stream = mediaStream;
                        video.srcObject = stream;
                        video.play();
                    })
                    .catch(function(err) {
                        console.error("Error accessing camera: ", err);
                        alert("Gagal mengakses kamera. Error: " + err.message);
                    });
            } else {
                console.error("getUserMedia not supported");
                alert("Maaf, browser Anda tidak mendukung akses kamera.");
            }
        }

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            if (video.srcObject) {
                video.srcObject = null;
            }
        }

        function resetCameraUI() {
            cameraSection.style.display = 'block';
            previewSection.style.display = 'none';
            savePhoto.style.display = 'none';
            backToCamera.style.display = 'none';
            fotoPreview.src = '';
            fotoData.value = '';
        }

        openCameraButton.addEventListener('click', function(e) {
            e.preventDefault();
            var modal = document.getElementById('cameraModal');
            var modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        });

        document.getElementById('cameraModal').addEventListener('shown.bs.modal', function() {
            initializeCamera();
        });

        document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
            stopCamera();
            resetCameraUI();
        });

        snap.addEventListener('click', function() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            var dataURL = canvas.toDataURL('image/png');
            fotoPreview.src = dataURL;
            fotoData.value = dataURL;

            cameraSection.style.display = 'none';
            previewSection.style.display = 'block';
            savePhoto.style.display = 'block';
            backToCamera.style.display = 'block';
        });

        savePhoto.addEventListener('click', function() {
            if (fotoData.value) {
                var fileName = 'foto_' + new Date().getTime() + '.png';
                fotoName.value = fileName;
                stopCamera();
                bootstrap.Modal.getInstance(document.getElementById('cameraModal')).hide();
            } else {
                alert('Ambil foto terlebih dahulu.');
            }
        });

        backToCamera.addEventListener('click', function() {
            stopCamera();
            resetCameraUI();
            initializeCamera();
        });

        // Modify the stopCamera function to ensure all tracks are stopped
        function stopCamera() {
            if (video.srcObject) {
                let tracks = video.srcObject.getTracks();
                tracks.forEach(function(track) {
                    track.stop();
                });
                video.srcObject = null;
            }
        }

        // Update the modal hidden event listener
        document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
            stopCamera();
            resetCameraUI();
        });

        function resetCameraUI() {
            cameraSection.style.display = 'block';
            previewSection.style.display = 'none';
            savePhoto.style.display = 'none';
            backToCamera.style.display = 'none';
            fotoPreview.src = '';
            fotoData.value = '';
        }

        document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
            stopCamera();
            resetCameraUI();
        });

        // document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
        //     if (video.srcObject) {
        //         video.srcObject.getTracks().forEach(track => track.stop());
        //     }
        //     cameraSection.style.display = 'block';
        //     previewSection.style.display = 'none';
        //     savePhoto.style.display = 'none';
        //     backToCamera.style.display = 'none';
        //     fotoPreview.src = '';
        //     fotoData.value = '';
        // });

        // document.getElementById('addForm').addEventListener('submit', function(e) {
        //     var select = document.getElementById('options');
        //     var otherInput = document.getElementById('otherInput');

        //     if (select.value === 'other') {
        //         select.disabled = true;
        //     } else {
        //         otherInput.disabled = true;
        //     }
        // });

        
        document.getElementById('addForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    var daftarModal = new bootstrap.Modal(document.getElementById('daftarModal'));

                    if (data.success) {
                        document.getElementById('successImage').style.display = 'block';
                        document.getElementById('errorImage').style.display = 'none';
                        document.getElementById('modalTitle').textContent = 'Terima Kasih!';
                        document.getElementById('modalText').textContent = 'Data berhasil terkirim.';

                        // Reset form dan elemen terkait
                        form.reset();

                        // Reset Select2 untuk pegawai
                        $('.pegawai-dituju').val('').trigger('change');

                        // Reset Select2 untuk ekspedisi
                        $('.ekspedisi').val('').trigger('change');

                        // Reset foto preview dan input
                        document.getElementById('foto-name').value = '';
                        document.getElementById('foto-data').value = '';
                        document.getElementById('foto-preview').src = '';

                        // Reset other input jika visible
                        var otherInput = document.getElementById('otherInput');
                        otherInput.classList.remove('visible');
                        otherInput.querySelector('input').value = '';

                    } else {
                        document.getElementById('successImage').style.display = 'none';
                        document.getElementById('errorImage').style.display = 'block';
                        document.getElementById('modalTitle').textContent = 'Oops!';
                        document.getElementById('modalText').textContent =
                            'Terjadi kesalahan. Silakan coba lagi.';
                    }

                    daftarModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    var daftarModal = new bootstrap.Modal(document.getElementById('daftarModal'));
                    document.getElementById('successImage').style.display = 'none';
                    document.getElementById('errorImage').style.display = 'block';
                    document.getElementById('modalTitle').textContent = 'Error!';
                    document.getElementById('modalText').textContent =
                        'Terjadi kesalahan. Silakan coba lagi nanti.';
                    daftarModal.show();
                });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-yFjHf3V/PBw1fVfXfX5wuKkpP+yYHT8QAEwb8k2+XJ3FdZyhax2o1b+qkEVsFGoC" crossorigin="anonymous">
    </script>
</body>

</html>
