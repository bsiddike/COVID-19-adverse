@extends('layouts.app')

@section('title', __('menu-sidebar.Dashboard'))

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('page-style')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" type="text/css">
@endpush

@push('head-script')

@endpush

@section('breadcrumbs', Breadcrumbs::render())

@section('actions'){{--
    <div class="input-group">
        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
        </div>
        <input type="text" class="form-control float-right" id="reservation">
    </div>
    <!-- /.input group -->--}}
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            @include('backend.wizard.total-user')
            @include('backend.wizard.total-enumerator')
            @include('backend.wizard.total-survey')
        </div>
        <div class="row">
            @include('backend.wizard.affected-gender')
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@push('plugin-script')
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
@endpush
