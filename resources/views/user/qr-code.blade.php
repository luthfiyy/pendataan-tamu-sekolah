{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Tamu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for modal */
        .modal-content {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    {{-- {{ !! DNS2D::getBarcodeHTML("$kedatanganTamu->qr_code", 'QRCODE') }} --}}
    <!-- Modal -->
    <!-- Modal HTML -->
    {{-- <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('qrCodeUrl')) --}}
    {{-- <img src="{{ session('qrCodeUrl') }}" alt="QR Code"> --}}
    {{-- {{ !! DNS2D::getBarcodeHTML("$kedatanganTamu->qr_code", 'QRCODE') }}
                @endif
            </div>
        </div>
    </div>
</div> --}}

    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="qrCodeContent">
                    <!-- QR Code will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        $('#qrCodeContent').html(response.qrCodeHtml);
                        $('#qrCodeModal').modal('show');
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            });
        });
    </script>
</body>

</html> --}}
