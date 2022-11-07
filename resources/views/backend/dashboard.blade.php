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
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Filter Options</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                    </div>
                    {!! Form::open(['route' => 'backend.dashboard', 'method'=> 'get']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                {!! \Form::nText('year', 'Year', request()->get('year'), false) !!}
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nText('age', 'Age', request()->get('age'), false) !!}
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nSelect('sex', 'Sex',
                                ['M' => 'Male', 'F' => 'Female', 'U' => 'Unknown'],
                                 request()->get('sex'), false, [ 'placeholder' => 'Select a sex']) !!}
                            </div>
                            <div class="col-md-4">
                                {{--{!! \Form::nSelect('vaccine_id', 'Vaccine',
                                \App\Models\Vaccine::all()->pluck('vax_name', 'vaers_id')->toArray(),
                                 request()->get('vaccine_id'), false, [
                                     'placeholder' => 'Select a vaccine Brand name'
                                 ]) !!}--}}
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nText('symptom', 'Symptom', request()->get('symptom'), false) !!}
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nText('state', 'State', request()->get('state'), false) !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    {!! \Form::close() !!}
                </div>
            </div>
        </div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            @include('backend.wizard.total-patient')
            @include('backend.wizard.total-symptom')
            @include('backend.wizard.total-vaccine')
            @include('backend.wizard.total-patient-hospital')
            @include('backend.wizard.total-patient-recovered')
            @include('backend.wizard.total-patient-died')
        </div>
        <div class="row">
            @include('backend.wizard.affected-gender')
            @include('backend.wizard.affected-age-wise')
            @include('backend.wizard.affected-monthly')
            @include('backend.wizard.affected-state')
            @include('backend.wizard.top-10-vaccine-record')
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
