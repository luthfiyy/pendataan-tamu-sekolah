$(document).ready(function() {
    // Inisialisasi datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd', // Format sesuai yang Anda inginkan
        autoclose: true, // Menutup Datepicker setelah memilih tanggal
        todayHighlight: true // Menyoroti tanggal hari ini
    });

    // Menampilkan dan menyembunyikan input tanggal
    $('#toggleDatePicker').on('click', function() {
        $('#datePickerContainer').toggleClass('d-none');
    });
});

$(document).ready(function() {
    // Initialize DataTable tanpa menggunakan search dari DataTables
    var table = $('#laporanTable').DataTable({
        "paging": false,
        "searching": false, // Nonaktifkan pencarian default DataTables
        "ordering": true,
        "info": false
    });x

    // Custom search input functionality
    $('#myInput').on('keyup', function() {
        $('#searchForm').submit(); // Submit form ketika user mengetik
    });

    $('#laporanTable_filter').hide();
});

document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('imageModal');
    var modalImg = document.getElementById("modalImage");
    var closeBtn = document.getElementsByClassName("close")[0];

    // Ambil semua elemen dengan kelas avatar-l
    var images = document.querySelectorAll('.image-icon');

    // Tambahkan event listener untuk setiap gambar
    images.forEach(function(img) {
        img.onclick = function() {
            modal.style.display = "flex";
            modalImg.src = this.getAttribute(
                'data-src'); // Ambil URL gambar dari atribut data-src
            setTimeout(() => {
                modal.classList.add('show'); // Tambahkan kelas show untuk animasi
            }, 10);
        }
    });

    // Fungsi untuk menutup modal
    function closeModal() {
        modal.classList.remove('show'); // Hapus kelas show untuk animasi
        setTimeout(() => {
            modal.style.display = "none";
        }, 300); // Sesuaikan dengan durasi transisi
    }

    // Tutup modal saat tombol close diklik
    closeBtn.onclick = closeModal;

    // Tutup modal saat klik di luar gambar
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    let offcanvasEl = document.getElementById('offcanvasDateFilter');
    let bsOffcanvas = null;
    let isAnimating = false;

    // Function to remove extra backdrops and clean up the DOM
    function cleanupOffcanvas() {
        // Remove only extra backdrops, keeping the active one
        const backdrops = document.querySelectorAll('.offcanvas-backdrop');
        if (backdrops.length > 1) {
            for (let i = 1; i < backdrops.length; i++) {
                backdrops[i].remove();
            }
        }

        // Reset body classes and styles only if offcanvas is actually closed
        if (!document.querySelector('.offcanvas.show')) {
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
            document.body.style.removeProperty('overflow');
        }
    }

    // Function to initialize offcanvas with proper event handling
    function initializeOffcanvas() {
        if (bsOffcanvas) {
            bsOffcanvas.dispose();
        }

        bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl, {
            backdrop: true,
            keyboard: true
        });

        // Handle offcanvas events
        offcanvasEl.addEventListener('show.bs.offcanvas', function(e) {
            if (isAnimating) {
                e.preventDefault();
                return;
            }
            isAnimating = true;
            cleanupOffcanvas();
        });


        offcanvasEl.addEventListener('hidden.bs.offcanvas', function() {
            isAnimating = false;
            cleanupOffcanvas();
        });

        return bsOffcanvas;
    }

    // Initialize offcanvas on page load
    initializeOffcanvas();
    // Handle offcanvas trigger buttons
    document.querySelectorAll('[data-bs-toggle="offcanvas"][data-bs-target="#offcanvasDateFilter"]')
        .forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                if (isAnimating) {
                    return;
                }

                if (offcanvasEl.classList.contains('show')) {
                    bsOffcanvas.hide();
                } else {
                    // Ensure clean state before showing
                    cleanupOffcanvas();
                    bsOffcanvas = initializeOffcanvas();
                    bsOffcanvas.show();
                }
            });
        });


    // Handle any stray backdrops on page events
    window.addEventListener('click', function() {
        setTimeout(cleanupOffcanvas, 100);
    });

    // Cleanup on page visibility change
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            cleanupOffcanvas();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const filterType = document.getElementById('filterType');
    const monthFilter = document.getElementById('monthFilter');
    const dateRangeFilter = document.getElementById('dateRangeFilter');
    const yearFilter = document.getElementById('yearFilter');
    const form = document.getElementById('dateRangeForm');
    const pdfPreviewModal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
    let currentPdfUrl = null;

    if (filterType.value === 'month') {
        monthFilter.style.display = 'block';
        dateRangeFilter.style.display = 'none';
        yearFilter.style.display = 'none';
    }

    filterType.addEventListener('change', function() {
        monthFilter.style.display = 'none';
        dateRangeFilter.style.display = 'none';
        yearFilter.style.display = 'none';

        switch (this.value) {
            case 'month':
                monthFilter.style.display = 'block';
                break;
            case 'date_range':
                dateRangeFilter.style.display = 'block';
                break;
            case 'year':
                yearFilter.style.display = 'block';
                break;
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let data = {
            reportType: document.getElementById('reportType').value
        };

        switch (filterType.value) {
            case 'month':
                data = {
                    ...data,
                    type: 'month',
                    value: document.getElementById('monthInput').value
                };
                break;
            case 'date_range':
                data = {
                    ...data,
                    type: 'date_range',
                    start: document.getElementById('startDate').value,
                    end: document.getElementById('endDate').value
                };
                break;
            case 'year':
                data = {
                    ...data,
                    type: 'year',
                    value: document.getElementById('yearInput').value
                };
                break;
            default:
                alert('Pilih jenis filter terlebih dahulu');
                return;
        }

        // Show loading state
        const downloadPdfBtn = document.getElementById('downloadPdfBtn');
        downloadPdfBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Generating PDF...';
        downloadPdfBtn.disabled = true;

        fetch('/generate-pdf-kurir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.blob();
            })
            .then(blob => {
                // Create a URL for the PDF blob
                if (currentPdfUrl) {
                    URL.revokeObjectURL(currentPdfUrl);
                }
                currentPdfUrl = URL.createObjectURL(blob);

                // Set the PDF preview in the iframe
                const previewFrame = document.getElementById('pdfPreviewFrame');
                previewFrame.src = currentPdfUrl;

                // Reset download button state
                downloadPdfBtn.innerHTML = '<i class="bx bx-download"></i> Unduh PDF';
                downloadPdfBtn.disabled = false;

                // Set up download button
                downloadPdfBtn.onclick = function() {
                    const link = document.createElement('a');
                    link.href = currentPdfUrl;
                    link.download = 'rekap_kurir.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                };

                // Close the filter offcanvas
                const offcanvasElement = document.getElementById('offcanvasDateFilter');
                const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (offcanvas) {
                    offcanvas.hide();
                }

                // Show the PDF preview modal
                pdfPreviewModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengunduh PDF: ' + error.message);

                // Reset download button state on error
                downloadPdfBtn.innerHTML = '<i class="bx bx-download"></i> Unduh PDF';
                downloadPdfBtn.disabled = false;
            });
    });

    // Clean up object URL when modal is hidden
    document.getElementById('pdfPreviewModal').addEventListener('hidden.bs.modal', function() {
        if (currentPdfUrl) {
            URL.revokeObjectURL(currentPdfUrl);
            currentPdfUrl = null;
        }
    });
});
