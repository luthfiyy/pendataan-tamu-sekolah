// script laporan tamu


$(document).ready(function () {
    // Inisialisasi datepicker
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd", // Format sesuai yang Anda inginkan
        autoclose: true, // Menutup Datepicker setelah memilih tanggal
        todayHighlight: true, // Menyoroti tanggal hari ini
    });

    // Menampilkan dan menyembunyikan input tanggal
    $("#toggleDatePicker").on("click", function () {
        $("#datePickerContainer").toggleClass("d-none");
    });
});

$(document).ready(function () {
    // Initialize DataTable
    var table = $("#laporanTable").DataTable({
        paging: false,
        ordering: true,
        info: false,
        searching: false,
    });

    $("#laporanTable_filter").hide();
});

document.addEventListener('DOMContentLoaded', function() {
    const detailButtons = document.querySelectorAll('.detail-button');
    const modal = new bootstrap.Modal(document.getElementById('tamuDetailModal'));
    const imageModal = document.getElementById('imageModal');
    const modalImg = document.getElementById("modalImage");
    const closeBtn = document.querySelector("#imageModal .close");

    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tamuData = JSON.parse(this.getAttribute('data-tamu'));

            const avatarSrc = tamuData.foto ?
                `/storage/img-tamu/${tamuData.foto}` :
                '/img/logo-hitam.png';

            const tamuAvatar = document.getElementById('tamuAvatar');
            tamuAvatar.src = avatarSrc;
            tamuAvatar.setAttribute('data-src', avatarSrc);

            modal.show();
        });
    });

    // Event listener untuk membuka modal gambar
    document.getElementById('tamuAvatar').addEventListener('click', function() {
        imageModal.style.display = "flex";
        modalImg.src = this.getAttribute('data-src');
        setTimeout(() => {
            imageModal.classList.add('show');
        }, 10);
    });

    // Event listener untuk menutup modal gambar
    closeBtn.onclick = function() {
        imageModal.classList.remove('show');
        setTimeout(() => {
            imageModal.style.display = "none";
        }, 300);
    }

    // Menutup modal gambar saat klik di luar gambar
    window.onclick = function(event) {
        if (event.target == imageModal) {
            imageModal.classList.remove('show');
            setTimeout(() => {
                imageModal.style.display = "none";
            }, 300);
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const modalDetail = document.getElementById("modalDetail");

    modalDetail.addEventListener("hidden.bs.modal", function () {
        // Remove the modal backdrop
        const backdrop = document.querySelector(".modal-backdrop");
        if (backdrop) {
            backdrop.remove();
        }

        // Reset body styles
        document.body.classList.remove("modal-open");
        document.body.style.removeProperty("padding-right");
        document.body.style.removeProperty("overflow");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let offcanvasEl = document.getElementById("offcanvasDateFilter");
    let bsOffcanvas = null;
    let isAnimating = false;

    // Function to remove extra backdrops and clean up the DOM
    function cleanupOffcanvas() {
        // Remove only extra backdrops, keeping the active one
        const backdrops = document.querySelectorAll(".offcanvas-backdrop");
        if (backdrops.length > 1) {
            for (let i = 1; i < backdrops.length; i++) {
                backdrops[i].remove();
            }
        }

        // Reset body classes and styles only if offcanvas is actually closed
        if (!document.querySelector(".offcanvas.show")) {
            document.body.classList.remove("modal-open");
            document.body.style.removeProperty("padding-right");
            document.body.style.removeProperty("overflow");
        }
    }

    // Function to initialize offcanvas with proper event handling
    function initializeOffcanvas() {
        if (bsOffcanvas) {
            bsOffcanvas.dispose();
        }

        bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl, {
            backdrop: true,
            keyboard: true,
        });

        // Handle offcanvas events
        offcanvasEl.addEventListener("show.bs.offcanvas", function (e) {
            if (isAnimating) {
                e.preventDefault();
                return;
            }
            isAnimating = true;
            cleanupOffcanvas();
        });

        offcanvasEl.addEventListener("hidden.bs.offcanvas", function () {
            isAnimating = false;
            cleanupOffcanvas();
        });

        return bsOffcanvas;
    }

    // Initialize offcanvas on page load
    initializeOffcanvas();
    // Handle offcanvas trigger buttons
    document
        .querySelectorAll(
            '[data-bs-toggle="offcanvas"][data-bs-target="#offcanvasDateFilter"]'
        )
        .forEach((button) => {
            button.addEventListener("click", function (e) {
                e.preventDefault();

                if (isAnimating) {
                    return;
                }

                if (offcanvasEl.classList.contains("show")) {
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
    window.addEventListener("click", function () {
        setTimeout(cleanupOffcanvas, 100);
    });

    // Cleanup on page visibility change
    document.addEventListener("visibilitychange", function () {
        if (document.visibilityState === "visible") {
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

    // Show default filter when page loads
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
            type: document.getElementById('filterType').value,
            report_type: document.getElementById('reportType').value,
            status: document.getElementById('statusFilter').value
        };

        // Get the appropriate value based on filter type
        switch (data.type) {
            case 'month':
                data.value = document.getElementById('monthInput').value;
                break;
            case 'date_range':
                data.start = document.getElementById('startDate').value;
                data.end = document.getElementById('endDate').value;
                break;
            case 'year':
                data.value = document.getElementById('yearInput').value;
                break;
        }

        // Show loading state
        const downloadPdfBtn = document.getElementById('downloadPdfBtn');
        downloadPdfBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Generating PDF...';
        downloadPdfBtn.disabled = true;

        fetch('/generate-pdf-tamu', {
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
                    link.download = 'rekap_tamu.pdf';
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
