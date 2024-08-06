<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}">

    {{-- icon --}}
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>GuBook</title>
</head>

<body>

    {{-- sidebar start --}}
    <x-sidebar />
    {{-- end sidebar --}}

    {{-- section start --}}
    <section class="home">
        <div class="row">
            <div class="col-12">
              <div class="card my-4">

                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="laporanTable">
                      <thead>
                        <tr>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama & Email</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Alamat</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Telepon</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Instansi</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pegawai</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tujuan</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu Perjanjian</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu Kedatangan</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                          <th class="text-secondary opacity-7"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($tamus as $kedatanganTamu)
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1 justify-content-center align-items-center w-100">
                              <div class="d-flex flex-column justify-content-center align-items-center text-center">
                                <img src="{{ asset('img/logo-hitam.png') }}" class="avatar avatar-sm mb-2 border-radius-lg" alt="user1">
                                <h6 class="mb-0 text-sm">{{ $kedatanganTamu->tamu->nama }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $kedatanganTamu->tamu->email }}</p>
                              </div>
                            </div>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $kedatanganTamu->tamu->alamat }}</p>
                          </td>
                          <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $kedatanganTamu->tamu->no_telp }}</span>
                          </td>
                          <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $kedatanganTamu->instansi }}</span>
                          </td>
                          <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $kedatanganTamu->user->name }}</span>
                          </td>
                          <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $kedatanganTamu->tujuan }}</span>
                          </td>
                          <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_perjanjian)->format('d/m/Y H:i') }}</span>
                          </td>
                          <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($kedatanganTamu->waktu_kedatangan)->format('d/m/Y H:i') }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">Online</span>
                          </td>
                          <td class="align-middle">
                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                              Edit
                            </a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </section>


</body>

</html>
