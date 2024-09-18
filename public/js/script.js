
// Show/hide password functionality
let password = document.getElementById("password");

eyeicon.onclick = function() {
    if (password.type === "password") {
        password.type = "text";
        eyeicon.src = "../img/mdi-light--eye.png";
    } else {
        password.type = "password";
        eyeicon.src = "../img/mdi-light--eye-off.png";
    }
}

const body = document.querySelector("body"),
      sidebar = document.querySelector(".sidebar"),
      toggle = document.querySelector(".toggle"),
      searchBtn = document.querySelector(".search-box"),
      modeSwitch = document.querySelector(".toggle-switch"),
      modeText = document.querySelector(".mode-text");
      logo = document.getElementById('logo');

      toggle.addEventListener("click", () =>{
        sidebar.classList.toggle("close");
      });

      searchBtn.addEventListener("click", () =>{
        sidebar.classList.remove("close");
      });

      modeSwitch.addEventListener("click", () =>{
        body.classList.toggle("dark");
      });


      modeSwitch.addEventListener("click", () => {
        if(body.classList.contains("dark")) {
            modeText.innerText = "Light Mode"
            logo.src = '../img/logo-putih.png';
          } else {
            modeText.innerText = "Dark Mode"
            logo.src = '../img/logo-hitam.png'; // Path ke logo untuk light mode
          }
      });


      function myFunction() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("pegawaiTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 1; i < tr.length; i++) { // Start from 1 to skip table header
            tr[i].style.display = "none"; // Hide the row initially
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = ""; // Show the row if a match is found
                        break; // Exit the loop once a match is found
                    }
                }
            }
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap semua tombol edit
        let editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Ambil data dari tombol edit
                let id = this.getAttribute('data-id');
                let nama = this.getAttribute('data-nama');
                let email = this.getAttribute('data-email');
                let nip = this.getAttribute('data-nip');
                let no_telp = this.getAttribute('data-no_telp');
                let no_wa = this.getAttribute('data-no_wa');
                let ptk = this.getAttribute('data-ptk');

                // Isi nilai form edit
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nama').value = nama;
                document.getElementById('edit-email').value = email;
                document.getElementById('edit-nip').value = nip;
                document.getElementById('edit-no_telp').value = no_telp;
                document.getElementById('edit-no_wa').value = no_wa;
                document.getElementById('edit-ptk').value = ptk;

                // Sembunyikan form tambah pegawai dan tampilkan form edit
                document.querySelector('.form-pegawai').style.display = 'none';
                document.querySelector('.form-pegawai-edit').style.display = 'block';
            });
        });
    });




// ini untuk refresh

// const body = document.querySelector("body"),
//       sidebar = document.querySelector(".sidebar"),
//       toggle = document.querySelector(".toggle"),
//       searchBtn = document.querySelector(".search-box"),
//       modeSwitch = document.querySelector(".toggle-switch"),
//       modeText = document.querySelector(".mode-text"),
//       logo = document.getElementById('logo');

// // Cek dan terapkan preferensi mode dari localStorage saat halaman dimuat
// document.addEventListener("DOMContentLoaded", () => {
//     const currentMode = localStorage.getItem("mode");
//     if (currentMode === "dark") {
//         body.classList.add("dark");
//         logo.src = '../img/logo-putih.png';
//         modeText.innerText = "Light Mode";
//     } else {
//         // Default mode adalah light mode
//         localStorage.setItem("mode", "light");
//         modeText.innerText = "Dark Mode";
//     }
// });

// // Fungsi untuk mengubah mode dan menyimpan preferensi ke localStorage
// function toggleMode() {
//     body.classList.toggle("dark");
//     if (body.classList.contains("dark")) {
//         localStorage.setItem("mode", "dark");
//         logo.src = '../img/logo-putih.png';
//         modeText.innerText = "Light Mode";
//     } else {
//         localStorage.setItem("mode", "light");
//         logo.src = '../img/logo-hitam.png';
//         modeText.innerText = "Dark Mode";
//     }
// }

// // Event listener untuk tombol toggle
// toggle.addEventListener("click", () => {
//     sidebar.classList.toggle("close");
// });

// searchBtn.addEventListener("click", () => {
//     sidebar.classList.remove("close");
// });

// modeSwitch.addEventListener("click", () => {
//     toggleMode();
// });

// Mendapatkan akses kamera
// navigator.mediaDevices.getUserMedia({ video: true })
//   .then(function(stream) {
//     var video = document.querySelector('video');
//     video.srcObject = stream;
//     video.onloadedmetadata = function(e) {
//       video.play();
//     };
//   })
//   .catch(function(err) {
//     console.log("Gagal mengakses kamera: " + err);
//   });

// // Mengambil gambar dari video
// function takePicture() {
//   var canvas = document.createElement('canvas');
//   var video = document.querySelector('video');
//   canvas.width = video.videoWidth;
//   canvas.height = video.videoHeight;
//   var ctx = canvas.getContext('2d');
//   ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
//   var dataURL = canvas.toDataURL('image/jpeg');
//   // Kirim dataURL ke server untuk disimpan
// }



        // Mengambil konteks grafik
        // var ctx = document.getElementById("chart-bars").getContext("2d");

        // // Nama hari dalam bahasa Indonesia
        // var daysOfWeek = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"];

        // // Mendapatkan data dari Blade
        // var dataTamu = @json($dataTamu);
        // var dataKurir = @json($dataKurir);

        // // Membuat grafik bar dengan Chart.js
        // new Chart(ctx, {
        //     type: "bar",
        //     data: {
        //         labels: daysOfWeek, // Menggunakan nama hari dalam bahasa Indonesia
        //         datasets: [{
        //                 label: "Tamu",
        //                 tension: 0.4,
        //                 borderWidth: 0,
        //                 borderRadius: 4,
        //                 borderSkipped: false,
        //                 backgroundColor: "rgba(255, 255, 255, .8)",
        //                 data: dataTamu, // Data tamu
        //                 maxBarThickness: 50
        //             },
        //             {
        //                 label: "Kurir",
        //                 tension: 0.4,
        //                 borderWidth: 0,
        //                 borderRadius: 4,
        //                 borderSkipped: false,
        //                 backgroundColor: "rgba(255, 255, 0, .8)",
        //                 data: dataKurir, // Data kurir
        //                 maxBarThickness: 50
        //             }
        //         ],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: true,
        //                 labels: {
        //                     color: '#fff', // Warna marker label
        //                 }
        //             }
        //         },
        //         interaction: {
        //             intersect: false,
        //             mode: 'index',
        //         },
        //         scales: {
        //             y: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: true,
        //                     drawOnChartArea: true,
        //                     drawTicks: false,
        //                     borderDash: [5, 5],
        //                     color: 'rgba(255, 255, 255, .2)'
        //                 },
        //                 ticks: {
        //                     suggestedMin: 0,
        //                     suggestedMax: 500,
        //                     beginAtZero: true,
        //                     padding: 10,
        //                     font: {
        //                         size: 14,
        //                         weight: 300,
        //                         family: 'Mulish',
        //                         style: 'normal',
        //                         lineHeight: 2
        //                     },
        //                     color: "#fff"
        //                 },
        //             },
        //             x: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: true,
        //                     drawOnChartArea: true,
        //                     drawTicks: false,
        //                     borderDash: [5, 5],
        //                     color: 'rgba(255, 255, 255, .2)'
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: '#f8f9fa',
        //                     padding: 10,
        //                     font: {
        //                         size: 14,
        //                         weight: 300,
        //                         family: 'Mulish',
        //                         style: 'normal',
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //         },
        //     },
        // });


        function getDateRange() {
            const startDate = new Date();
            const endDate = new Date();
            // Set the start date to the most recent Monday
            startDate.setDate(startDate.getDate() - startDate.getDay() + 1);
            // Set the end date to the most recent Friday
            endDate.setDate(startDate.getDate() + 4);

            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('date-range').textContent =
                `${startDate.toLocaleDateString('en-GB', options)} - ${endDate.toLocaleDateString('en-GB', options)}`;
        }

        document.addEventListener('DOMContentLoaded', getDateRange);



        document.addEventListener('DOMContentLoaded', function() {
            const menuToggles = document.querySelectorAll('.menu-toggle');

            menuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.toggle('active');
                    const subMenu = this.nextElementSibling;
                    subMenu.classList.toggle('show');
                });
            });
        });
