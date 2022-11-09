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

@endpush

@push('page-style')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}" type="text/css">

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
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($patients))
                        <div class="card-body p-0">
                            {{--                            {!! Html::cardSearch('search', 'frontend.patients.index',
                                                        ['placeholder' => 'Search Survey Name etc.',
                                                        'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'survey-table']) !!}--}}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                        <th class="text-center">@sortablelink('id', '#')</th>
                                        <th class="text-center">@sortablelink('vaers_id', 'Vaers ID')</th>
                                        <th class="text-center">@sortablelink('recive_date', 'Receive Date')</th>
                                        <th class="text-center">@sortablelink('state', 'State')</th>
                                        <th class="text-center">@sortablelink('age_yrs', 'Age(Year)')</th>
                                        <th class="text-center">@sortablelink('cage_yr', 'Cage(Year)')</th>
                                        <th class="text-center">@sortablelink('cage_mo', 'Cage month')</th>
                                        <th class="text-center">@sortablelink('sex', 'Sex')</th>
                                        <th class="text-center">@sortablelink('rpt_date', 'Report Date')</th>
                                        {{--                                        <th class="text-center">@sortablelink('symptom_text', 'symptom_text')</th>--}}
                                        <th class="text-center">@sortablelink('died', 'Died')</th>
                                        <th class="text-center">@sortablelink('datedied', 'datedied')</th>
                                        <th class="text-center">@sortablelink('l_threat', 'Life threat')</th>
                                        <th class="text-center">@sortablelink('er_visit', 'Emergency visit')</th>
                                        <th class="text-center">@sortablelink('hospital', 'Hospital')</th>
                                        <th class="text-center">@sortablelink('hospdays', 'hospdays')</th>
                                        <th class="text-center">@sortablelink('x_stay', 'Previous Condition')</th>
                                        <th class="text-center">@sortablelink('disable', 'Disable')</th>
                                        <th class="text-center">@sortablelink('recovd', 'Re-Covid19')</th>
                                        <th class="text-center">@sortablelink('vax_date', 'Vaccine Data')</th>
                                        <th class="text-center">@sortablelink('onset_date', 'onset_date')</th>
                                        <th class="text-center">@sortablelink('numdays', 'numdays')</th>
                                        {{--                                        <th class="text-center">@sortablelink('lab_data', 'Lab_data')</th>--}}
                                        <th class="text-center">@sortablelink('v_adminby', 'v_adminby')</th>
                                        <th class="text-center">@sortablelink('v_fundby', 'v_fundby')</th>
                                        <th class="text-center">@sortablelink('other_meds', 'other_meds')</th>
                                        <th class="text-center">@sortablelink('cur_ill', 'Current Illness')</th>
                                        <th class="text-center">@sortablelink('history', 'History')</th>
                                        <th class="text-center">@sortablelink('prior_vax', 'prior_vax')</th>
                                        <th class="text-center">@sortablelink('splttype', 'splttype')</th>
                                        <th class="text-center">@sortablelink('form_vers', 'form_vers')</th>
                                        <th class="text-center">@sortablelink('todays_date', 'Todays Date')</th>
                                        <th class="text-center">@sortablelink('birth_defect', 'Birth Defect')</th>
                                        <th class="text-center">@sortablelink('ofc_visit', 'Office Visit')</th>
                                        <th class="text-center">@sortablelink('er_ed_visit', 'er_ed_visit')</th>
                                        <th class="text-center">@sortablelink('Allergies', 'allergies')</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($patients as $index => $patient)
                                        <tr @if($patient->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! Html::actionDropdown('frontend.patients', $patient->id, array_merge(['show', 'edit'], ($patient->deleted_at == null) ? ['delete'] : ['restore'])) !!}
                                            </td>
                                            <td class="exclude-search align-middle">
                                                {{ $patient->id }}
                                            </td>
                                            <td class="text-center">{{ $patient->vaers_id ?? null }}</td>
                                            <td class="text-center">{{ $patient->recive_date ?? null }}</td>
                                            <td class="text-center">{{ $patient->state ?? null }}</td>
                                            <td class="text-center">{{ $patient->age_yrs ?? null }}</td>
                                            <td class="text-center">{{ $patient->cage_yr ?? null }}</td>
                                            <td class="text-center">{{ $patient->cage_mo ?? null }}</td>
                                            <td class="text-center">{{ $patient->sex ?? null }}</td>
                                            <td class="text-center">{{ $patient->rpt_date ?? null }}</td>
                                            {{--                                            <td class="text-center">{{ $patient->symptom_text ?? null }}</td>--}}
                                            <td class="text-center">{{ $patient->died ?? null }}</td>
                                            <td class="text-center">{{ $patient->datedied ?? null }}</td>
                                            <td class="text-center">{{ $patient->l_threat ?? null }}</td>
                                            <td class="text-center">{{ $patient->er_visit ?? null }}</td>
                                            <td class="text-center">{{ $patient->hospital ?? null }}</td>
                                            <td class="text-center">{{ $patient->hospdays ?? null }}</td>
                                            <td class="text-center">{{ $patient->x_stay ?? null }}</td>
                                            <td class="text-center">{{ $patient->disable ?? null }}</td>
                                            <td class="text-center">{{ $patient->recovd ?? null }}</td>
                                            <td class="text-center">{{ $patient->vax_date ?? null }}</td>
                                            <td class="text-center">{{ $patient->onset_date ?? null }}</td>
                                            <td class="text-center">{{ $patient->numdays ?? null }}</td>
                                            {{--                                            <td class="text-center">{{ $patient->lab_data ?? null }}</td>--}}
                                            <td class="text-center">{{ $patient->v_adminby ?? null }}</td>
                                            <td class="text-center">{{ $patient->v_fundby ?? null }}</td>
                                            <td class="text-center">{{ $patient->other_meds ?? null }}</td>
                                            <td class="text-center">{{ $patient->cur_ill ?? null }}</td>
                                            <td class="text-center">{{ $patient->history ?? null }}</td>
                                            <td class="text-center">{{ $patient->prior_vax ?? null }}</td>
                                            <td class="text-center">{{ $patient->splttype ?? null }}</td>
                                            <td class="text-center">{{ $patient->form_vers ?? null }}</td>
                                            <td class="text-center">{{ $patient->todays_date ?? null }}</td>
                                            <td class="text-center">{{ $patient->birth_defect ?? null }}</td>
                                            <td class="text-center">{{ $patient->ofc_visit ?? null }}</td>
                                            <td class="text-center">{{ $patient->er_ed_visit ?? null }}</td>
                                            <td class="text-center">{{ $patient->allergies ?? null }}</td>
                                            <td class="text-center">{{ $patient->created_at->format(config('backend.datetime')) ?? '' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="40" class="exclude-search text-center">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pb-0">
                            {!! CHTML::pagination($patients) !!}
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
    {!! CHTML::confirmModal('Patient', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')
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

@push('page-script')

@endpush
