@extends('layouts.master')

@push('meta')

@endpush

@push('icon')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
@endpush

@push('plugin-style')

@endpush

@push('theme-style')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
@endpush

@section('body')
    <body class="layout-top-nav">

    @include('layouts.includes.preloader')

    <div class="wrapper">
        @include('layouts.partials.navbar-frontend')
        <div class="content-wrapper" style="min-height: 388.4px;">
            @yield('breadcrumbs')
            <div class="content">
                @yield('content')
            </div>
        </div>
        @include('layouts.partials.main-footer')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Plugin JS -->
    @include('layouts.includes.plugin-script')
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/js/utility.min.js') }}"></script>
    <!-- inline js -->
    @include('layouts.includes.page-script')
    </body>
@endsection
