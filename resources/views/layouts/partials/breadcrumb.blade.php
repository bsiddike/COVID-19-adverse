@unless ($breadcrumbs->isEmpty())
    @if(\Route::is('backend.*'))
        <nav aria-label="breadcrumb">
            <h4 class="mb-0">@yield('title')</h4>
            <ol class="breadcrumb bg-transparent p-0 mb-0 d-none d-sm-flex">
                @foreach ($breadcrumbs as $breadcrumb)

                    @if ($breadcrumb->url && !$loop->last)
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                    @else
                        <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                    @endif

                @endforeach
            </ol>
        </nav>
    @else
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @foreach ($breadcrumbs as $breadcrumb)

                                @if ($breadcrumb->url && !$loop->last)
                                    <li class="breadcrumb-item"><a
                                                href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                                @else
                                    <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                                @endif

                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endunless
