<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        #video,
        #foto-preview {
            width: 100%;
            max-width: 320px;
        }
    </style>
</head>

<body style="background-color: #f4f4f4;">
    @include('user.components.background')
    @include('user.components.navbar')
    <!-- Content of the landing page -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
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
                                <div class="grid-item select-wrapper">
                                    <input type="text" id="otherInput" class="hidden" name="ekspedisi"
                                        placeholder="Masukkan opsi lainnya...">
                                    <select id="options" onchange="showInput(this)" name="ekspedisi">
                                        <option value="">Ekspedisi</option>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="grid-container">
                                {{-- <div class="grid-item">
                                    <video id="video" width="320" height="240" autoplay></video>
                                    <button type="button" id="snap">Ambil Foto</button>
                                    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                                    <input type="hidden" id="foto-data" name="foto_data">
                                    <img id="foto-preview" src="" alt="Foto Preview" style="display: none; margin-top: 10px; width: 100%; max-width: 200px;">
                                </div> --}}
                                <div class="container mt-5">
                                    <div class="form-group">
                                        <label for="foto-data">Foto:</label>
                                        <input type="text" class="form-control" id="foto-name" readonly>
                                        <button type="button" class="btn btn-primary mt-2" data-toggle="modal"
                                            data-target="#cameraModal">Ambil Foto</button>
                                        <input type="hidden" id="foto-data" name="foto_data">
                                    </div>
                                </div>

                                <div class="grid-item select-wrapper">
                                    <select name="id_user" id="pegawai" class="form-control" required>
                                        <option value="" selected disabled>Pegawai yang dituju</option>
                                        @foreach ($pegawai as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class='bx bx-chevron-down'></i>
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Submit" class="shadow-primary">
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" id="cameraSection">
                    <video id="video" autoplay></video>
                    <button type="button" id="snap" class="btn btn-primary mt-2">Ambil Foto</button>
                </div>
                <div class="modal-body text-center" id="previewSection" style="display: none;">
                    <img id="foto-preview" src="" alt="Foto Preview" style="margin-top: 10px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backToCamera" style="display: none;">Foto
                        Kembali</button>
                    <button type="button" class="btn btn-primary" id="save-photo" style="display: none;"
                        data-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript and other scripts -->
    <script>
        function showInput(select) {
            var selectedOption = select.value;
            var otherInput = document.getElementById('otherInput');

            if (selectedOption === 'other') {
                otherInput.classList.remove('hidden');
            } else {
                otherInput.classList.add('hidden');
            }
        }

        // Akses elemen video, canvas, dan tombol

        // Akses elemen video, canvas, dan tombol
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

        // Minta izin untuk menggunakan kamera dan tampilkan stream video
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function(err) {
                console.log("Error: " + err);
            });

        // Ambil foto ketika tombol diklik
        snap.addEventListener('click', function() {
            // Gambar video ke canvas
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert canvas ke data URL dan tampilkan gambar di img
            var dataURL = canvas.toDataURL('image/png');
            fotoPreview.src = dataURL;
            fotoData.value = dataURL;

            // Tampilkan pratinjau dan tombol simpan
            cameraSection.style.display = 'none';
            previewSection.style.display = 'block';
            savePhoto.style.display = 'block';
            backToCamera.style.display = 'block';
        });

        // Simpan foto dan tampilkan nama file ketika tombol simpan diklik
        savePhoto.addEventListener('click', function() {
            if (fotoData.value) {
                var fileName = 'foto_' + new Date().getTime() + '.png';
                fotoName.value = fileName;
                $('#cameraModal').modal('hide');
            } else {
                alert('Ambil foto terlebih dahulu.');
            }
        });

        // Kembali ke kamera untuk ambil foto ulang
        backToCamera.addEventListener('click', function() {
            cameraSection.style.display = 'block';
            previewSection.style.display = 'none';
            savePhoto.style.display = 'none';
            backToCamera.style.display = 'none';
        });

        // Reset modal ketika ditutup
        $('#cameraModal').on('hidden.bs.modal', function() {
            cameraSection.style.display = 'block';
            previewSection.style.display = 'none';
            savePhoto.style.display = 'none';
            backToCamera.style.display = 'none';
            fotoPreview.src = '';
            fotoData.value = '';
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-yFjHf3V/PBw1fVfXfX5wuKkpP+yYHT8QAEwb8k2+XJ3FdZyhax2o1b+qkEVsFGoC" crossorigin="anonymous">
    </script>
</body>

</html>
