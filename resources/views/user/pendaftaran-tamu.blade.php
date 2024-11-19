    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>GuBook SMKN 11 Bandung - Pendaftaran Tamu</title>
        <link rel="stylesheet" href="{{ asset('css/user.css') }}">
        <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <style>
            /* Custom styles for modal */
            .modal-content {
                background-color: #f8f9fa;
                border-radius: 10px;
                box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            }

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
                        <div class="card-header-tamu p-2">
                            <i class='bx bx-user'></i>
                            <h4>Data Tamu</h4>
                        </div>

                        <form id="tamuForm" action="{{ route('tamu.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="grid-container">
                                    <div class="grid-item">
                                        <input type="text" id="nama" name="nama" placeholder=" " required>
                                        <label for="nama">Nama</label>
                                    </div>
                                    <div class="grid-item">
                                        <input type="text" id="alamat" name="alamat" placeholder=" " required>
                                        <label for="alamat">Alamat</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="grid-container">
                                    <div class="grid-item">
                                        <input type="text" id="no_telp" name="no_telp" placeholder=" " required>
                                        <label for="no_telp">Nomor Telepon</label>
                                    </div>
                                    <div class="grid-item">
                                        <input type="email" id="email" name="email" placeholder=" " required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="grid-container">
                                    <div class="grid-item">
                                        <input type="text" id="instansi" name="instansi" placeholder="">
                                        <label for="instansi">Asal Instansi (Kosongkan jika tidak ada)</label>
                                    </div>
                                    <div class="grid-item select-wrapper">
                                        <select name="id_pegawai" id="pegawai" class="form-control pegawai-dituju"
                                            required>
                                            <option value="" selected disabled>Pegawai yang dituju</option>
                                            @foreach ($pegawai as $p)
                                                <option value="{{ $p->nip }}">{{ $p->user->name }}</option>
                                            @endforeach
                                        </select>
                                        <i class='bx bx-chevron-down'></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="grid-container">
                                    <div class="grid-item">
                                        <input type="text" id="tujuan" name="tujuan" placeholder=" " required>
                                        <label for="tujuan">Tujuan</label>
                                    </div>
                                    <div class="grid-item">
                                        <input type="datetime-local" id="waktu_perjanjian" name="waktu_perjanjian"
                                            placeholder=" " required>
                                        <label for="waktu_perjanjian">Waktu Perjanjian</label>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="Kirim" class="shadow-primary">
                        </form>
                    </div>

                    <div class="modal fade" id="daftarModal" tabindex="-1" aria-labelledby="daftarModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-center">
                                <div class="modal-header d-flex flex-column align-items-center">
                                    <div id="loadingSpinner" class="spinner-border text-primary mb-3" role="status"
                                        style="display: none;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <img src="{{ asset('img/jam-pasir.svg') }}" alt="" width="300px"
                                        id="successImage" style="display: none; margin-top: -160px;">
                                    <div id="modalMessage">
                                        <h3>Mohon Tunggu</h3>
                                        <p class="mb-0">Sedang memproses pendaftaran Anda...</p>
                                    </div>
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- jQuery -->
                    <!-- Bootstrap JavaScript -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                    {{-- <script>
                        $(document).ready(function() {
                            $('#addForm').on('submit', function(e) {
                                e.preventDefault();
                                var formData = $(this).serialize();

                                $.ajax({
                                    type: 'POST',
                                    url: $(this).attr('action'),
                                    data: formData,
                                    success: function(response) {
                                        console.log(response); // Debugging
                                        $('#qrCodeContent').html(response.qr_code);

                                        // Check if response.idTamu is defined
                                        if (response.idTamu) {
                                            var downloadUrl = '{{ route('qrcode.download', ['idTamu' => ':idTamu']) }}';
                                            downloadUrl = downloadUrl.replace(':idTamu', response.idTamu);
                                            $('#downloadBtn').attr('href', downloadUrl);
                                        } else {
                                            console.error('idTamu is undefined');
                                        }

                                        $('#qrCodeModal').modal('show');
                                    },
                                    error: function(response) {
                                        // Debugging response
                                        console.error('Response Error:', response);
                                        var errorMessage = 'An error occurred';
                                        if (response.responseJSON && response.responseJSON.message) {
                                            errorMessage = response.responseJSON.message;
                                        }
                                        alert('Error: ' + errorMessage);
                                    }
                                });
                            });
                        });
                    </script> --}}

                    <script>
                        $(document).ready(function() {
                            $('.pegawai-dituju').select2();
                        });

                        document.getElementById('waktu_perjanjian').addEventListener('change', function() {
                            const input = this;
                            const value = new Date(input.value);

                            const hours = value.getHours();
                            const minutes = value.getMinutes();

                            // Batasan waktu: dari jam 08:00 sampai 15:00
                            if (hours < 8 || (hours >= 15 && minutes > 0)) {
                                alert("Waktu perjanjian harus antara jam 8 pagi sampai jam 3 sore.");
                                input.value = ""; // Reset nilai input
                            }
                        });

                        document.getElementById('tamuForm').addEventListener('submit', function(event) {
                            event.preventDefault();


                            // Show the modal
                            const daftarModal = new bootstrap.Modal(document.getElementById('daftarModal'));
                            daftarModal.show();

                            // Show loading spinner, hide other elements
                            document.getElementById('loadingSpinner').style.display = 'block';
                            document.getElementById('successImage').style.display = 'none';
                            document.getElementById('modalMessage').innerHTML =
                                '<h3>Mohon Tunggu</h3><p class="mb-0">Sedang memproses pendaftaran Anda...</p>';

                            fetch(this.action, {
                                method: this.method,
                                body: new FormData(this),
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Hide loading spinner, show success image
                                    document.getElementById('loadingSpinner').style.display = 'none';
                                    document.getElementById('successImage').style.display = 'block';
                                    document.getElementById('modalMessage').innerHTML =
                                        '<h3>Pendaftaran Berhasil</h3><p class="mb-0">Silahkan tunggu konfirmasi di email.</p>';

                                    // Reset the form only on success

                                    this.reset();
                                } else {
                                    // Hide loading spinner, show error message
                                    document.getElementById('loadingSpinner').style.display = 'none';
                                    document.getElementById('modalMessage').innerHTML =
                                        '<h3>Gagal</h3><p class="mb-0">Gagal menambahkan kedatangan tamu. ' + (data.message || '') + '</p>';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Hide loading spinner, show error message
                                document.getElementById('loadingSpinner').style.display = 'none';
                                document.getElementById('modalMessage').innerHTML =
                                    '<h3>Error</h3><p class="mb-0">Terjadi kesalahan. Silakan coba lagi.</p>';
                            });
                        });

                        // Modify modal close event to not reset the form
                        document.getElementById('daftarModal').addEventListener('hidden.bs.modal', function() {
                            // Reset only the modal content, not the form
                            document.getElementById('loadingSpinner').style.display = 'none';
                            document.getElementById('successImage').style.display = 'none';
                            document.getElementById('modalMessage').innerHTML =
                                '<h3>Mohon Tunggu</h3><p class="mb-0">Sedang memproses pendaftaran Anda...</p>';
                        });
                    </script>

    </body>

    </html>
