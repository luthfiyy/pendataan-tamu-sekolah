<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GuBook SMKN 11 Bandung - Tentang Kami</title>

    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}"> --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    @include('user.components.background')
    @include('user.components.navbar')

    <div class="container">
        <img src="img/smkn.png" width="100%">
        <div class="card-about">
            <h2 class="custom-h2 text-black">Datanglah dengan senang hati! Kami layani sepenuh hati</h2>
            <p class="p-custom text-black">Mari kita membuat pengalaman kunjungan anda lebih mudah dan aman.</p>
            <a href="{{ route('landing-page') }}" class="a-custom">Buat Pertemuan</a>
        </div>
    </div>

    <div class="container-2">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <img src="img/thinking.svg" class="img-thinking">
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <h2 class="section-title">Mengapa kami penting?</h2> <!-- New h2 element -->
                    </div>
                    <div class="col-md-4">
                        <div class="card-mengapa">
                            <div class="card-body">
                                <i class='bx bx-shield-quarter'></i>
                                <h5 class="card-title">Keamanan Terjamin</h5>
                                <p class="card-text">Dengan mendaftar, Anda membantu kami menjaga keamanan lingkungan
                                    sekolah.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-mengapa">
                            <div class="card-body">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M9.5 5.5a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0-5 0M12 21.368l5.095-5.096a3.088 3.088 0 1 0-4.367-4.367l-.728.727l-.728-.727a3.088 3.088 0 1 0-4.367 4.367z" />
                                </svg>
                                <h5 class="card-title">Kenyamanan Kunjungan</h5>
                                <p class="card-text">Membantu kami menyambut Anda dengan lebih baik dan mempersingkat
                                    waktu tunggu.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-mengapa">
                            <div class="card-body">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M7 1h10v2h4v9h-2V5h-2v2H7V5H5v16h7v2H3V3h4zm2 4h6V3H9zm11 8.75v1.376c.715.184 1.352.56 1.854 1.072l1.193-.689l1 1.732l-1.192.688a4 4 0 0 1 0 2.142l1.192.688l-1 1.732l-1.193-.689A4 4 0 0 1 20 22.874v1.376h-2v-1.376a4 4 0 0 1-1.854-1.072l-1.193.689l-1-1.732l1.192-.688a4 4 0 0 1 0-2.142l-1.192-.688l1-1.732l1.193.689A4 4 0 0 1 18 15.126V13.75zm-2.751 4.283a2 2 0 0 0-.25.967c0 .35.091.68.25.967l.036.063a2 2 0 0 0 3.43 0l.036-.063A2 2 0 0 0 21 19c0-.35-.09-.68-.249-.967l-.036-.063a2 2 0 0 0-3.43 0z" />
                                </svg>
                                <h5 class="card-title">Pemenuhan Regulasi</h5>
                                <p class="card-text">Menyokong komitmen kami dalam mematuhi standar keamanan dan
                                    regulasi sekolah.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="kontak-kami">
        <div class="row justify-content-center">
            <h2 style="color: #000">Kontak Kami</h2>
            <p style="color: #000">Terima kasih atas kerjasama Anda dalam menjaga keamanan dan kenyamanan sekolah kami.
                Jika Anda memiliki pertanyaan atau butuh bantuan, jangan ragu untuk menghubungi kami</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 ">
                <div id="map-container" class="embed-responsive embed-responsive-16by9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.00062464909!2d107.55575517504346!3d-6.890527093108549!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6bd6aaaaaab%3A0xf843088e2b5bf838!2sSMKN%2011%20Bandung!5e0!3m2!1sid!2sid!4v1720757151517!5m2!1sid!2sid"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center ">
                <div class="info-item1">
                    <i class="fa-solid fa-location-dot" "></i>
                    <p>Jln Budhi Cilember, Kota Bandung</p>
                </div>
                <div class="info-item2">
                    <i class="fa-solid fa-envelope"></i>
                    <p><a href="mailto:smkn11bdg@gmail.com">smkn11bdg@gmail.com</a></p>
                </div>
                <div class="info-item3">
                    <i class="fa-solid fa-phone"></i>
                    <p><a href="tel:022-6652442">022-6652442</a></p>
                </div>
            </div>
        </div>
    </div>

    @include('user.components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-yFjHf3V/PBw1fVfXfX5wuKkpP+yYHT8QAEwb8k2+XJ3FdZyhax2o1b+qkEVsFGoC" crossorigin="anonymous">
    </script>
</body>
</html>
