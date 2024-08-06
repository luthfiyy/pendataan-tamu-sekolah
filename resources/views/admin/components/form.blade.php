{{-- <div class="form-pegawai">
    <div class="form">
        <div class="icon-container icon-lg icon-shape text-center border-radius-xl mt-n4 position-absolute"
            style="background: #FFE97A; box-shadow: 0 0 10px rgba(255, 221, 28, 0.1);">
            <i class='bx bx-user-plus'></i>
            <p>Tambah Pegawai</p>
        </div>

        <!-- Form Tambah Pegawai -->
        {{-- <form id="addForm" action="{{ route('pegawai.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <div class="grid-container">
                    <div class="grid-item">
                        <input type="text" id="nama" name="nama" placeholder=" " required>
                        <label for="nama">Nama</label>
                    </div>
                    <div class="grid-item">
                        <input type="text" id="nip" name="nip" placeholder=" " required>
                        <label for="nip">NIP</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="grid-container">
                    <div class="grid-item">
                        <input type="email" id="email" name="email" placeholder=" " required>
                        <label for="email">Email</label>
                    </div>
                    <div class="grid-item">
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder=" " required>
                            <label for="password">Password</label>
                            <img src="../img/mdi-light--eye-off.png" alt="Toggle visibility" id="eyeicon"
                                class="eye-icon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="grid-container">
                    <div class="grid-item">
                        <input type="text" id="no_telp" name="no_telp" placeholder=" " required>
                        <label for="no_telp">No Telepon</label>
                    </div>
                    <div class="grid-item select-wrapper">
                        <select name="ptk" id="ptk" class="form-control" required>
                            <option value="" selected disabled>PTK</option>
                            <option value="produktif rpl">Produktif RPL</option>
                            <option value="produktif akl">Produktif AKL</option>
                            <option value="pendidikan pancasila">Pendidikan Pancasila</option>
                            <option value="bahasa inggris">Bahasa Inggris</option>
                            <option value="pjok">PJOK</option>
                            <option value="produktif bdp">Produktif BDP</option>
                            <option value="produktif MP">Produktif MP</option>
                            <option value="tendik">Tendik</option>
                        </select>
                        <i class='bx bx-chevron-down'></i>
                    </div>
                </div>
            </div>
            <input type="submit" value="Submit" class="shadow-primary">
        </form> --}}


        <!-- Form Update -->
        {{-- <form id="updateForm" action="{{ route('pegawai.update') }}" method="POST" onsubmit="return validateUpdateForm()"
            style="display: none;">
            @csrf
            <input type="hidden" name="nipToUpdate" id="nipToUpdate">
            <div class="form-group">
                <div class="grid-container">
                    <div class="grid-item">
                        <input type="text" id="newNama" name="newNama" required>
                        <label for="newNama">Nama</label>
                    </div>
                    <div class="grid-item">
                        <input type="text" id="newNip" name="newNip" required>
                        <label for="newNip">NIP</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="grid-container">
                    <div class="grid-item">
                        <input type="email" id="newEmail" name="newEmail" required>
                        <label for="newEmail">Email</label>
                    </div>
                    <div class="grid-item">
                        <div class="password-wrapper">
                            <input type="password" id="password" name="newPassword" required>
                            <label for="newPassword">Password</label>
                            <img src="../img/mdi-light--eye-off.png" alt="Toggle visibility" id="eyeicon"
                                class="eye-icon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="grid-container">
                    <div class="grid-item">
                        <input type="text" id="newNo_telp" name="newNo_telp" required>
                        <label for="newNo_telp">No Telepon</label>
                    </div>
                    <div class="grid-item select-wrapper">
                        <select name="newPtk" id="newPtk" class="form-control" required>
                            <option value="" selected disabled>PTK</option>
                            <option value="produktif rpl">Produktif RPL</option>
                            <option value="produktif akl">Produktif AKL</option>
                            <option value="pendidikan pencasila">Pendidikan Pancasila</option>
                            <option value="bahasa inggris">Bahasa Inggris</option>
                            <option value="pjok">PJOK</option>
                            <option value="produktif bdp">Produktif BDP</option>
                            <option value="produktif MP">Produktif MP</option>
                            <option value="tendik">Tendik</option>
                        </select>
                        <i class='bx bx-chevron-down'></i>
                    </div>
                </div>
            </div>
            <button type="submit">Update</button>
            <button type="button" onclick="closeUpdateForm()">Cancel</button>
        </form> --}}

    {{-- </div> --}}

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <i class='bx bx-user-plus' style="font-size: 50px; margin-right: 10px;"></i>
                <div>
                    <p class="mb-0 font-weight-bolder">Tambah</p>
                    <small>Pegawai</small>
                </div>
            </div>
            <div class="card-body">
                <form id="addForm" action="{{ route('pegawai.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="basic-default-fullname">Nama</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" name="nama" class="form-control" id="basic-default-fullname" placeholder="John Doe" />
                            </div>
                        </div>
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="basic-default-company">NIP</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"> <i class='bx bx-id-card'></i> </span>
                                <input type="text" name="nip" class="form-control" id="basic-default-company" placeholder="1234567890" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="basic-default-email">Email</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" id="basic-default-email" class="form-control" placeholder="contoh@gmail.com" name="email" aria-label="john.doe" aria-describedby="basic-default-email2" />
                            </div>
                        </div>
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="basic-default-phone">Nomor Telepon</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="text" name="no_telp" id="basic-default-phone" class="form-control phone-mask" placeholder="0822 6432 9327" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="basic-default-phone">PTK</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i class='bx bx-chalkboard'></i></span>
                                <select name="ptk" id="ptk" class="form-control phone-mask" required>
                                    <option value="" selected disabled>PTK</option>
                                    <option value="produktif rpl">Produktif RPL</option>
                                    <option value="produktif akl">Produktif AKL</option>
                                    <option value="pendidikan pencasila">Pendidikan Pancasila</option>
                                    <option value="bahasa inggris">Bahasa Inggris</option>
                                    <option value="pjok">PJOK</option>
                                    <option value="produktif bdp">Produktif BDP</option>
                                    <option value="produktif MP">Produktif MP</option>
                                    <option value="tendik">Tendik</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="basic-default-password">Password</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-password2" class="input-group-text"><i class='bx bx-lock'></i></span>
                                <input type="password" id="basic-default-password" class="form-control phone-mask" name="password" placeholder="********" />
                                {{-- <span id="eyeicon" class="input-group-text"><i class="bx bx-show"></i></span> --}}
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary shadow-primary">
                </form>

                <form id="updateForm" action="{{ route('pegawai.update') }}" method="POST" onsubmit="return validateUpdateForm()" style="display: none;">
                    @csrf
                    <input type="hidden" name="nipToUpdate" id="nipToUpdate">
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newNama">Nama</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" name="newNama" class="form-control" id="newNama" placeholder="John Doe" />
                            </div>
                        </div>
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newNip">NIP</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"> <i class='bx bx-id-card'></i> </span>
                                <input type="text" name="newNip" class="form-control" id="newNip" placeholder="1234567890" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newEmail">Email</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" id="newEmail" class="form-control" placeholder="contoh@gmail.com" name="newEmail" aria-label="john.doe" aria-describedby="basic-default-email2" />
                            </div>
                        </div>
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newNo_telp">Nomor Telepon</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="text" name="newNo_telp" id="newNo_telp" class="form-control phone-mask" placeholder="0822 6432 9327" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newPtk">PTK</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i class='bx bx-chalkboard'></i></span>
                                <select name="newPtk" id="newPtk" class="form-control phone-mask" required>
                                    <option value="" selected disabled>PTK</option>
                                    <option value="produktif rpl">Produktif RPL</option>
                                    <option value="produktif akl">Produktif AKL</option>
                                    <option value="pendidikan pencasila">Pendidikan Pancasila</option>
                                    <option value="bahasa inggris">Bahasa Inggris</option>
                                    <option value="pjok">PJOK</option>
                                    <option value="produktif bdp">Produktif BDP</option>
                                    <option value="produktif MP">Produktif MP</option>
                                    <option value="tendik">Tendik</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 input-group-hover">
                            <label class="form-label" for="newPassword">Password</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-password2" class="input-group-text"><i class='bx bx-lock'></i></span>
                                <input type="password" id="newPassword" name="newPassword" class="form-control phone-mask" placeholder="********" />
                                {{-- <span id="eyeiconUpdate" class="input-group-text"><i class="bx bx-show"></i></span> --}}
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary shadow-primary">
                </form>
            </div>
        </div>
    </div>


    {{-- Script di bagian bawah HTML --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let eyeicon = document.getElementById("eyeicon");
            let password = document.getElementById("basic-default-password");
            let eyeiconUpdate = document.getElementById("eyeiconUpdate");
            let newPassword = document.getElementById("newPassword");

            eyeicon.onclick = function () {
                if (password.type === "password") {
                    password.type = "text";
                    eyeicon.innerHTML = '<i class="bx bx-hide"></i>';
                } else {
                    password.type = "password";
                    eyeicon.innerHTML = '<i class="bx bx-show"></i>';
                }
            }

            eyeiconUpdate.onclick = function () {
                if (newPassword.type === "password") {
                    newPassword.type = "text";
                    eyeiconUpdate.innerHTML = '<i class="bx bx-hide"></i>';
                } else {
                    newPassword.type = "password";
                    eyeiconUpdate.innerHTML = '<i class="bx bx-show"></i>';
                }
            }
        });

        function showUpdateForm(nip, nama, email, no_telp, ptk) {
            document.getElementById('nipToUpdate').value = nip;
            document.getElementById('newNama').value = nama;
            document.getElementById('newEmail').value = email;
            document.getElementById('newNip').value = nip;
            document.getElementById('newNo_telp').value = no_telp;
            document.getElementById('newPtk').value = ptk;

            document.getElementById('addForm').style.display = 'none';
            document.getElementById('updateForm').style.display = 'block';
        }

        function validateUpdateForm() {
            var newNama = document.getElementById('newNama').value.trim();
            var newEmail = document.getElementById('newEmail').value.trim();
            var newNip = document.getElementById('newNip').value.trim();
            var newNo_telp = document.getElementById('newNo_telp').value.trim();
            var newPtk = document.getElementById('newPtk').value.trim();

            if (newNama === '' || newEmail === '' || newNip === '' || newNo_telp === '' || newPtk === '') {
                alert('Mohon isi semua kolom yang dibutuhkan.');
                return false;
            }

            return true;
        }



    document.addEventListener('DOMContentLoaded', function() {
        const inputGroups = document.querySelectorAll('.input-group-hover');

        inputGroups.forEach(group => {
            const inputs = group.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    group.classList.add('is-focused');
                });
                input.addEventListener('blur', () => {
                    group.classList.remove('is-focused');
                });
            });

            // Menambahkan event listener untuk klik pada label
            const label = group.querySelector('label');
            if (label) {
                label.addEventListener('click', () => {
                    const input = group.querySelector('input, textarea, select');
                    if (input) {
                        input.focus();
                    }
                });
            }
        });
    });
</script>
