@extends('layouts.app')

@section('title', __('menu-sidebar.Surveys'))

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



@section('breadcrumbs', Breadcrumbs::render())

@section('actions')
    {!! Html::linkButton(__('survey.Add Survey'), 'backend.organization.patients.create', [], 'fas fa-plus', 'success') !!}
    {{--{!! \Html::bulkDropdown('backend.organization.surveys', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($patients))
                        <div class="card-body p-0">
                            {!! Html::cardSearch('search', 'backend.organization.patients.index',
                            ['placeholder' => 'Search Survey Name etc.',
                            'class' => 'form-control', 'id' => 'search', 'data-target-table' => 'survey-table']) !!}
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="branch-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">@sortablelink('id', 'id')</th>
                                        <th class="text-center">@sortablelink('vaers_id', 'vaers_id')</th>
                                        <th class="text-center">@sortablelink('recive_date', 'recive_date')</th>
                                        <th class="text-center">@sortablelink('state', 'state')</th>
                                        <th class="text-center">@sortablelink('age_yrs', 'age_yrs')</th>
                                        <th class="text-center">@sortablelink('cage_yr', 'cage_yr')</th>
                                        <th class="text-center">@sortablelink('cage_mo', 'cage_mo')</th>
                                        <th class="text-center">@sortablelink('sex', 'sex')</th>
                                        <th class="text-center">@sortablelink('rpt_date', 'rpt_date')</th>
{{--                                        <th class="text-center">@sortablelink('symptom_text', 'symptom_text')</th>--}}
                                        <th class="text-center">@sortablelink('died', 'died')</th>
                                        <th class="text-center">@sortablelink('datedied', 'datedied')</th>
                                        <th class="text-center">@sortablelink('l_threat', 'l_threat')</th>
                                        <th class="text-center">@sortablelink('er_visit', 'er_visit')</th>
                                        <th class="text-center">@sortablelink('hospital', 'hospital')</th>
                                        <th class="text-center">@sortablelink('hospdays', 'hospdays')</th>
                                        <th class="text-center">@sortablelink('x_stay', 'x_stay')</th>
                                        <th class="text-center">@sortablelink('disable', 'disable')</th>
                                        <th class="text-center">@sortablelink('recovd', 'recovd')</th>
                                        <th class="text-center">@sortablelink('vax_date', 'vax_date')</th>
                                        <th class="text-center">@sortablelink('onset_date', 'onset_date')</th>
                                        <th class="text-center">@sortablelink('numdays', 'numdays')</th>
                                        <th class="text-center">@sortablelink('lab_data', 'lab_data')</th>
                                        <th class="text-center">@sortablelink('v_adminby', 'v_adminby')</th>
                                        <th class="text-center">@sortablelink('v_fundby', 'v_fundby')</th>
                                        <th class="text-center">@sortablelink('other_meds', 'other_meds')</th>
                                        <th class="text-center">@sortablelink('cur_ill', 'cur_ill')</th>
                                        <th class="text-center">@sortablelink('history', 'history')</th>
                                        <th class="text-center">@sortablelink('prior_vax', 'prior_vax')</th>
                                        <th class="text-center">@sortablelink('splttype', 'splttype')</th>
                                        <th class="text-center">@sortablelink('form_vers', 'form_vers')</th>
                                        <th class="text-center">@sortablelink('todays_date', 'todays_date')</th>
                                        <th class="text-center">@sortablelink('birth_defect', 'birth_defect')</th>
                                        <th class="text-center">@sortablelink('ofc_visit', 'ofc_visit')</th>
                                        <th class="text-center">@sortablelink('er_ed_visit', 'er_ed_visit')</th>
                                        <th class="text-center">@sortablelink('allergies', 'allergies')</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($patients as $index => $patient)
                                        <tr @if($patient->deleted_at != null) class="table-danger" @endif>
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
                                            <td class="text-center">{{ $patient->lab_data ?? null }}</td>
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
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! Html::actionDropdown('backend.organization.patients', $patient->id, array_merge(['show', 'edit'], ($patient->deleted_at == null) ? ['delete'] : ['restore'])) !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="exclude-search text-center">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pb-0">
                            {!! \App\Supports\CHTML::pagination($patients) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Patient', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
