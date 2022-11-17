@php use App\Supports\Constant; @endphp
@php use App\Supports\CHTML; @endphp
@extends('layouts.frontend')

@section('title', $patient->vaers_id)

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('page-style')

@endpush

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $patient))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <fieldset>
                            <h2 class="font-italic pb-3 mb-3 font-weight-bold border-bottom">
                                Patient Details
                            </h2>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Patient's ID</label>
                                    <p class="border p-2">{!! ($patient->vaers_id ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Receive Date</label>
                                    <p class="border p-2">
                                        @if(isset($patient->recive_date))
                                            {{ Carbon\Carbon::parse($patient->recive_date)->format('d-M-Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">State</label>
                                    <p class="border p-2">{!! ($patient->state ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Age Year</label>
                                    <p class="border p-2">{!! ($patient->age_yrs ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Cage Year</label>
                                    <p class="border p-2">{!! ($patient->cage_yr ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Cage Month</label>
                                    <p class="border p-2">{!! ($patient->cage_mo ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Sex</label>
                                    <p class="border p-2">
                                        @if($patient->sex == 'M')
                                            Male
                                        @elseif($patient->sex =='F')
                                            Female
                                        @else
                                            Unknown
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Report Date</label>
                                    <p class="border p-2">
                                        @if(isset($patient->recive_daterpt_date))
                                            {{ Carbon\Carbon::parse($patient->rpt_date)->format('d-M-Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Died</label>
                                    <p class="border p-2">{!! ($patient->died ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">datedied</label>
                                    <p class="border p-2">{!! ($patient->datedied ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Life threat</label>
                                    <p class="border p-2">{!! ($patient->l_threat ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Emergency Visit</label>
                                    <p class="border p-2">{!! ($patient->er_visit ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Hospital(Days)</label>
                                    <p class="border p-2">
                                        {!! ($patient->hospital ?? 'N/A') !!}
                                        @if(isset($patient->hospdays))
                                            {!! ($patient->hospdays) !!}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Previous Condition</label>
                                    <p class="border p-2">{!! ($patient->x_stay ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Disable</label>
                                    <p class="border p-2">{!! ($patient->disable ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Re-Covid19</label>
                                    <p class="border p-2">{!! ($patient->recovd ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Vaccine date</label>
                                    <p class="border p-2">
                                        @if(isset($patient->recive_datevax_date))
                                            {{ Carbon\Carbon::parse($patient->vax_date)->format('d-M-Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">onset_date</label>
                                    <p class="border p-2">
                                        @if(isset($patient->onset_date))
                                            {{ Carbon\Carbon::parse($patient->onset_date)->format('d-M-Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">numdays</label>
                                    <p class="border p-2">{!! ($patient->numdays ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Lab Data</label>
                                    <p class="border p-2">{!! ($patient->lab_data ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">v_adminby</label>
                                    <p class="border p-2">{!! ($patient->v_adminby ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">v_fundby</label>
                                    <p class="border p-2">{!! ($patient->v_fundby ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">other_meds</label>
                                    <p class="border p-2">{!! ($patient->other_meds ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Current Illness</label>
                                    <p class="border p-2">{!! ($patient->cur_ill ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Prior Vaccine</label>
                                    <p class="border p-2">{!! ($patient->prior_vax ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">splttype</label>
                                    <p class="border p-2">{!! ($patient->splttype ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">form_vers</label>
                                    <p class="border p-2">{!! ($patient->form_vers ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Todays Date</label>
                                    <p class="border p-2">{!! ($patient->todays_date ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Birth Defect</label>
                                    <p class="border p-2">{!! ($patient->birth_defect ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Office Visit</label>
                                    <p class="border p-2">{!! ($patient->ofc_visit ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">er_ed_visit</label>
                                    <p class="border p-2">{!! ($patient->er_ed_visit ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Allergies</label>
                                    <p class="border p-2">{!! ($patient->allergies ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-12">
                                    <label class="font-weight-bold d-block">Symptoms History</label>
                                    <p class="border p-2">{!! ($patient->symptom_text ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-12">
                                    <label class="font-weight-bold d-block">History</label>
                                    <p class="border p-2">{!! ($patient->history ?? 'N/A') !!}</p>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <h2 class="font-italic pb-3 mb-3 font-weight-bold border-bottom">
                                Symptom & Vaccine Details
                            </h2>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold d-block">Vaccine Label</label>
                                    <p class="border p-2">{!! ($patient->vaccine->vax_name ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Vaccine Type</label>
                                    <p class="border p-2">{!! ($patient->vaccine->vax_type ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">Vaccine Dos Series</label>
                                    <p class="border p-2">{!! ($patient->vaccine->vax_dose_series ?? 'N/A') !!}</p>
                                </div>
                                <div class="col-md-12">
                                    <label class="font-weight-bold d-block">Symptoms</label>
                                    <ul class="list-group-item">
                                        @if(!empty($patient->symptom->symptom1))
                                            <li class="ml-2">
                                                {!! $patient->symptom->symptom1  !!}
                                            </li>
                                        @endif
                                        @if(!empty($patient->symptom->symptom2))
                                            <li class="ml-2">
                                                {!! $patient->symptom->symptom2  !!}
                                            </li>
                                        @endif
                                        @if(!empty($patient->symptom->symptom3))
                                            <li class="ml-2">
                                                {!! $patient->symptom->symptom3  !!}
                                            </li>
                                        @endif
                                        @if(!empty($patient->symptom->symptom4))
                                            <li class="ml-2">
                                                {!! $patient->symptom->symptom4  !!}
                                            </li>
                                        @endif
                                        @if(!empty($patient->symptom->symptom5))
                                            <li class="ml-2">
                                                {!! $patient->symptom->symptom5  !!}
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

