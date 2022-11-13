@php use App\Models\Vaccine; @endphp
@php use App\Supports\Constant; @endphp
@php use App\Supports\CHTML; @endphp
@extends('layouts.frontend')

@section('title', 'Patients')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}" type="text/css">
@endpush

@push('page-style')

@endpush



@section('breadcrumbs', Breadcrumbs::render())

@section('actions')
    {{--    {!! Html::linkButton('Add Patient', 'frontend.patients.create', [], 'fas fa-plus', 'success') !!}--}}
    {{--{!! \Html::bulkDropdown('frontend.surveys', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container">
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
                    {!! Form::open(['route' => 'frontend.patients.index', 'method'=> 'get']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                {{--{!! \Form::nText('year', 'Year', request()->get('year'), false) !!}--}}
                                <div class="form-group">
                                    <label>Date range:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control float-right"
                                               value="{{request()->get('recive_date')}}" name="recive_date"
                                               id="recive_date">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                {{--{!! \Form::nText('age', 'Age', request()->get('age'), false) !!}--}}
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <div class="slider-blue">
                                        <input type="text" value="" class="slider form-control" data-slider-min="0"
                                               data-slider-max="100"
                                               data-slider-step="5"
                                               data-slider-value="[{{request()->get('age')??('0,100')}}]"
                                               data-slider-orientation="horizontal"
                                               data-slider-selection="before" data-slider-tooltip="show" name="age">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! Form::nSelect('sex', 'Sex',
                                ['M' => 'Male', 'F' => 'Female', 'U' => 'Unknown'],
                                 request()->get('sex'), false, [ 'placeholder' => 'Select a sex']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::nSelect('vax_name', 'Vaccine',
                                Vaccine::all()->where('vax_type','COVID19')->pluck('vax_name', 'vax_name')->toArray(),
                                 request()->get('vax_name'), false, [
                                     'placeholder' => 'Select a vaccine Brand name'
                                 ]) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::nText('symptom', 'Symptom', request()->get('symptom'), false) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::nText('vax_dose_series', 'Dose Series', request()->get('vax_dose_series'), false) !!}
                            </div>
                            <div class="col-md-3">
                                {{--{!! \Form::nText('state', 'State', request()->get('state'), false) !!}--}}
                                {!! Form::nSelect('state', 'State',
                                Constant::USA_STATE,
                                 request()->get('state'), false, [
                                     'placeholder' => 'Select a State'
                                 ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @include('backend.wizard.affected-gender')
            @include('backend.wizard.affected-age-wise')
            @include('backend.wizard.affected-monthly')
            @include('backend.wizard.affected-state')
            @include('backend.wizard.top-10-vaccine-record')
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection


@push('plugin-script')
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
    <script>
        /* BOOTSTRAP SLIDER */
        $('.slider').bootstrapSlider()
        //Date range picker
        $('#recive_date').daterangepicker(
            {
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 2018,
                maxYear: parseInt(moment().format('YYYY'), 10),
                startDate: '2019-01-01',
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                }
            }
        )
    </script>
@endpush
