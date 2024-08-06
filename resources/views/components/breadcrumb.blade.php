@unless ($breadcrumbs->isEmpty())
    <ol class="breadcrumb bg-transparent m-4 pb-0 pt-1 px-0 me-sm-6 me-5">
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
@endunless
