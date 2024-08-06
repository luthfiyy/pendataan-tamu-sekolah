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

    {{-- <style>
        .back{
            position: absolute;
            z-index: 10;
            top: 10px;
            left: 10px;
        }

        .button-back {
            padding: 0;
            margin: 0;
            border: none;
            background: none;
            cursor: pointer;
            --primary-color: #111;
            --hovered-color: #4461f2;
            position: relative;
            display: flex;
            font-weight: 600;
            font-size: 20px;
            gap: 0.5rem;
            align-items: center;
        }

        .button-back p {
            margin: 0;
            position: relative;
            font-size: 20px;
            color: var(--primary-color);
        }

        .button-back::after {
            position: absolute;
            content: "";
            width: 0;
            left: 0;
            bottom: -7px;
            background: var(--hovered-color);
            height: 2px;
            transition: 0.3s ease-out;
        }

        .button-back p::before {
            position: absolute;
            /*   box-sizing: border-box; */
            content: "Kembali";
            width: 0%;
            inset: 0;
            color: var(--hovered-color);
            overflow: hidden;
            transition: 0.3s ease-out;
        }

        .button-back:hover::after {
            width: 100%;
        }

        .button-back:hover p::before {
            width: 100%;
        }

        .button-back:hover svg {
            transform: translateX(4px);
            color: var(--hovered-color);
        }

        .button-back svg {
            color: var(--primary-color);
            transition: 0.2s;
            position: relative;
            width: 15px;
            transition-delay: 0.2s;
        }

    </style> --}}
</head>

<body>
    {{-- <div class="back">
        <button class="button-back">
            <p>Kembali</p>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </button>
    </div> --}}

    <div class="absolute">
        <div class="absolute inset-0 justify-center">
            <div class="bg-shape1 bg-yellow opacity-50 bg-blur"></div>
            <div class="bg-shape2 bg-primary opacity-50 bg-blur"></div>
            <h2 class="custom-h2">Selamat Datang Kembali!</h2>
            <img src="img/kalender.png" alt="" width="400px" style="margin: 35px">



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
