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
        /* Custom styles for modal */
        .modal-content {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
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
                    <div class="card-header-tamu">
                        <i class='bx bx-user'></i>
                        <h4>Data Tamu</h4>
                    </div>

                    <form id="tamuForm" action="{{ route('tamu.store') }}" method="POST">
                        @csrf
                        <!-- Input fields for tamu information -->
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
                                    <input type="text" id="instansi" name="instansi" placeholder=" " required>
                                    <label for="instansi">Instansi</label>
                                </div>
                                <div class="grid-item select-wrapper">
                                    <select name="id_pegawai" id="pegawai" class="form-control" required>
                                        <option value="" selected disabled>Pegawai yang dituju</option>
                                        @foreach ($pegawai as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                        <input type="submit" value="Submit" class="shadow-primary">
                    </form>

                </div>
                <!-- Modal HTML -->
                <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-purple align-items-center justify-content-center"
                                id="qrCodeContent" style="width: 50%;margin: 10px;">
                                <!-- QR Code will be inserted here -->
                            </div>
                            <div class="modal-footer">
                                <a id="downloadBtn" href="#" class="btn btn-primary">Download QR Code</a>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- jQuery -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    document.getElementById('tamuForm').addEventListener('submit', function(event) {
                        event.preventDefault();

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
                                    // Update QR code modal
                                    const qrCodeImg = document.createElement('img');
                                    qrCodeImg.src = 'data:image/png;base64,' + data.qr_code;
                                    qrCodeImg.alt = 'QR Code';
                                    qrCodeImg.style.width = '100%'; // Adjust size as needed

                                    const qrCodeContent = document.getElementById('qrCodeContent');
                                    qrCodeContent.innerHTML = ''; // Clear previous content
                                    qrCodeContent.appendChild(qrCodeImg);

                                    // Set download link
                                    const downloadBtn = document.getElementById('downloadBtn');
                                    downloadBtn.href = qrCodeImg.src;
                                    downloadBtn.download = 'qr_code.png';

                                    // Show the modal
                                    const qrCodeModal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
                                    qrCodeModal.show();
                                } else {
                                    alert('Gagal menambahkan kedatangan tamu.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    });

                    document.getElementById('qrCodeModal').addEventListener('hidden.bs.modal', function() {
                        document.getElementById('tamuForm').reset();
                    });
                </script>

</body>

</html>
