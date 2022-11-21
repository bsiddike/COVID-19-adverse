@php use App\Supports\CHTML; @endphp
@extends('layouts.frontend')

@section('title', 'Symptoms & Outcomes')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}" type="text/css">
@endpush

@push('page-style')

@endpush



@section('breadcrumbs', Breadcrumbs::render())

@section('actions')
    {!! Html::linkButton('Add Symptoms', 'backend.organization.symptoms.create', [], 'fas fa-plus', 'success') !!}
    {{--    {!! Html::bulkDropdown('backend.organization.symptoms', 0, ['color' => 'warning']) !!}--}}
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
                    {!! Form::open(['route' => 'frontend.symptoms.index', 'method'=> 'get']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
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
                                {!! Form::nSelect('gender', 'Sex',
                                ['M' => 'Male', 'F' => 'Female'],
                                 request()->get('gender'), false, [ 'placeholder' => 'Select a sex']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::nSelect('vax_name', 'Vaccine',
                                \App\Models\Vaccine::all()->where('vax_type','COVID19')->pluck('vax_name', 'vax_name')->toArray(),
                                 request()->get('vax_name'), false, [
                                     'placeholder' => 'Select a vaccine Brand name'
                                 ]) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::nText('symptom', 'Symptom', request()->get('symptom'), false) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::nSelect('state', 'State',
                                \App\Supports\Constant::USA_STATE,
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
            {{--            @include('backend.wizard.affected-gender')
                        @include('backend.wizard.affected-age-wise')
                        @include('backend.wizard.affected-state')--}}
            @include('backend.wizard.top-10-vaccine-record')
            @include('backend.wizard.top-10-symptom-gender-record')
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($symptoms))
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped mb-0" id="employee-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>@sortablelink('patient.vaers_id', 'Patient\'s ID')</th>
                                        <th>@sortablelink('vaccine.vax_name', 'Vaccine')</th>
                                        <th>@sortablelink('vaccine.vax_dose_series', 'Dose')</th>
                                        <th>@sortablelink('patient.cur_ill', 'Current Illness')</th>
                                        <th>@sortablelink('symptom1', 'symptom 1')</th>
                                        <th>@sortablelink('symptom2', 'symptom 2')</th>
                                        <th>@sortablelink('symptom3', 'symptom 3')</th>
                                        <th>@sortablelink('symptom4', 'symptom 4')</th>
                                        <th>@sortablelink('symptom5', 'symptom 5')</th>
                                        <th>@sortablelink('patient.recovd', 'Re-Covid')</th>
                                        <th>@sortablelink('patient.hospital', 'Hospitalised')</th>
                                        <th>@sortablelink('patient.disable', 'Disabled')</th>
                                        <th>@sortablelink('patient.died', 'Died')</th>
                                        <th>@sortablelink('patient.allergies', 'Allergies')</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($symptoms as $index => $symptom)
                                        <tr>
                                            <td>
                                                @if($symptom->patient()->exists())

                                                    <a href="{{ route('frontend.patients.show', $symptom->patient->id) }}">
                                                        {{ $symptom->patient->vaers_id ?? null }}
                                                    </a>
                                                @else
                                                    {{ $symptom->patient->vaers_id ?? null }}
                                                @endif
                                            </td>
                                            <td>{{ $symptom->vaccine->vax_name ?? null }}</td>
                                            <td>{{ $symptom->vaccine->vax_dose_series ?? null }}</td>
                                            <td>{{ $symptom->patient->cur_ill ?? null }}</td>
                                            <td>{{ $symptom->symptom1 ?? null }}</td>
                                            <td>{{ $symptom->symptom2 ?? null }}</td>
                                            <td>{{ $symptom->symptom3 ?? null }}</td>
                                            <td>{{ $symptom->symptom4 ?? null }}</td>
                                            <td>{{ $symptom->symptom5 ?? null }}</td>
                                            <td>{{ $symptom->patient->recovd ?? null }}</td>
                                            <td>{{ $symptom->patient->hospital ?? null }}</td>
                                            <td>{{ $symptom->patient->disable ?? null }}</td>
                                            <td>{{ $symptom->patient->died ?? null }}</td>
                                            <td>{{ $symptom->patient->allergies ?? null }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="20" class="exclude-search text-center">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pb-0">
                            {!! CHTML::pagination($symptoms) !!}
                        </div>
                    @else
                        <div class="card-body min-vh-100">

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection


@push('plugin-script')
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        /* BOOTSTRAP SLIDER */
        $('.slider').bootstrapSlider();
        //Date range picker
        $('#recive_date').daterangepicker({
            autoUpdateInput: true,
            showDropdowns: true,
            minYear: 2018,
            maxYear: parseInt(moment().format('YYYY'), 10),
            startDate: '2019-01-01',
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });
    </script>
@endpush

