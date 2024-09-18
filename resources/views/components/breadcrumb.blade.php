@unless ($breadcrumbs->isEmpty())
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4 px-2">
        <ol class="breadcrumb bg-transparent pb-0 pt-1 px-0 mb-0">
            @foreach ($breadcrumbs as $breadcrumb)
                @if (!$loop->last)
                    <li class="breadcrumb-item text-m">
                        <a class="opacity-5 text-dark" href="{{ $breadcrumb->url }}">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item text-m text-dark active" aria-current="page">
                        {{ $breadcrumb->title }}
                    </li>
                @endif
            @endforeach
        </ol>

        @php
            $role = Auth::user()->role; // Ambil peran pengguna yang login
            $namaPegawai = Auth::user()->name; // Ambil nama pengguna yang login
        @endphp

        @if ($role == 'admin')
            <p class="breadcrumb-item text-m text-dark active mb-0">Selamat datang, Min!</p>
        @elseif ($role == 'pegawai')
            <p class="breadcrumb-item text-m text-dark active mb-0">Selamat datang, {{ $namaPegawai }}</p>
        @elseif ($role == 'FO')
            <p class="breadcrumb-item text-m text-dark active mb-0">Selamat datang, Front Office!</p>
        @endif
    </div>
@endunless
