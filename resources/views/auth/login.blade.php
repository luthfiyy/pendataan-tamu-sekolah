<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <title>Document</title>

    <style>
        .back {
            position: absolute;
            z-index: 10;
            top: 30px;
            right: 30px;
        }

        /* From Uiverse.io by vinodjangid07 */
        .Btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: #4461f2;
        }

        /* plus sign */
        .sign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sign svg {
            width: 12px;
        }

        .sign svg path {
            fill: white;
        }

        /* text */
        .text {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: white;
            font-size: 1.2em;
            font-weight: 600;
            transition-duration: .3s;
        }

        /* hover effect on button width */
        .Btn:hover {
            width: 135px;
            border-radius: 40px;
            transition-duration: .3s;
        }

        .Btn:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 5px;
        }

        /* hover effect button's text */
        .Btn:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }

        /* button click effect*/
        .Btn:active {
            transform: translate(2px, 2px);
        }
    </style>
</head>

<body>
    <div class="back">

        <a href="{{ route('landing-page') }}">
            <button class="Btn">

                <div class="text">Kembali</div>
                <div class="sign"><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 320 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path
                            d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
                    </svg></div>
            </button>

        </a>
    </div>

    <div class="absolute">
        <div class="absolute inset-0 justify-center">
            <div class="bg-shape1 bg-yellow opacity-50 bg-blur"></div>
            <div class="bg-shape2 bg-primary opacity-50 bg-blur"></div>
            <h2 class="custom-h2">Selamat Datang Kembali!</h2>
            <img src="img/kalender.svg" alt="" width="400px" style="margin: 35px">



            <div class="card">
                <img src="img/gubook-hitam.png" class="logo" alt="">
                <h3 class="custom-h3">SMKN 11 Bandung</h3>
                <form method="POST" action="{{ route('login') }}" class="form-center">
                    @csrf
                    <div class="input-box">
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <img src="img/circle-thin.png" alt="" id="clear" style="cursor: pointer;">
                    </div>

                    <div class="input-box">
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" placeholder="Password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <img src="img/mdi-light--eye-off.png" alt="" id="eyeicon" style="cursor: pointer;">
                    </div>

                    <div class="flex justify-between items-center" style="left: 80px;">

                        @if (Route::has('password.request'))
                            <a class="forgot underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="btn-submit ms-3">
                            <p>{{ __('Log in') }}</p>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Clear button functionality
        let clearButton = document.getElementById("clear");
        let emailInput = document.getElementById("email");

        clearButton.onclick = function() {
            emailInput.value = "";
        }

        // Show/hide password functionality
        let eyeicon = document.getElementById("eyeicon");
        let password = document.getElementById("password");

        eyeicon.onclick = function() {
            if (password.type === "password") {
                password.type = "text";
                eyeicon.src = "img/mdi-light--eye.png";
            } else {
                password.type = "password";
                eyeicon.src = "img/mdi-light--eye-off.png";
            }
        }
    </script>
</body>

</html>
