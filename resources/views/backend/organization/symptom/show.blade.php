@extends('layouts.app')

@section('title', $symptom->name)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $symptom))

@section('actions')
    {!! Html::backButton('backend.organization.symptoms.index') !!}
    {!! Html::modelDropdown('backend.organization.symptoms', $symptom->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($symptom->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th width="30%">{!!  __('symptom.Name') !!}</th>
                                <td>{!! $symptom->name   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Name(Bangla)') !!}</th>
                                <td>{!! $symptom->name_bd   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Gender') !!}</th>
                                <td>{!! isset($symptom->gender->name) ? $symptom->gender->name : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!!  __('symptom.Date of Birth') !!}</th>
                                <td>@if($symptom->dob != null)
                                        {!! \Carbon\Carbon::parse($symptom->dob)->format('dS F, Y') !!}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{!!  __('symptom.Father Name') !!}</th>
                                <td>{!! $symptom->father   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Mother Name') !!}</th>
                                <td> {!! $symptom->mother   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.NID Number') !!}</th>
                                <td>{!! $symptom->nid   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Present Address') !!}</th>
                                <td>{!! $symptom->present_address   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Permanent Address') !!}</th>
                                <td> {!! $symptom->permanent_address   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Highest Educational Qualification') !!}</th>
                                <td>{!! isset($symptom->examLevel->name) ? $symptom->examLevel->name : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Mobile 1') !!}</th>
                                <td>{!! $symptom->mobile_1   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Mobile 2') !!}</th>
                                <td> {!! $symptom->mobile_2   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Email') !!}</th>
                                <td>{!! $symptom->email   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Whatsapp Number') !!}</th>
                                <td>  {!! $symptom->whatsapp   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Facebook ID') !!}</th>
                                <td>{!! $symptom->facebook   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Select the district(s) where you have worked earlier (it can be multiple)') !!}</th>
                                <td>
                                    @forelse($symptom->previousPostings as $state)
                                        {{  $state->name }},
                                    @empty
                                        No District Available
                                    @endforelse
                                </td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Select the district(s) where you want to work in future (maximum 3)') !!}</th>
                                <td>
                                    <ul>
                                        @forelse($symptom->futurePostings as $state)
                                            <li>{{  $state->name }}</li>
                                        @empty
                                            <li>No District Available</li>
                                        @endforelse
                                    </ul>

                                </td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Are you revenue staff of BBS?') !!}</th>
                                <td>{!! isset($symptom->is_employee) ? ucfirst($symptom->is_employee) : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Designation') !!}</th>
                                <td>{!! ($symptom->is_employee == 'yes') ? $symptom->designation :   'N/A' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Company Name') !!}</th>
                                <td>{!! ($symptom->is_employee == 'yes') ? $symptom->company :   'N/A' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Work Experience in BBS as Enumerator') !!}</th>
                                <td>
                                    <ul>
                                        @forelse($symptom->surveys as $index => $survey)
                                            <li> {{ $index + 1 }}. {{ $survey->name ?? null }}</li>
                                        @empty
                                            <li> No Survey Available</li>
                                        @endforelse
                                    </ul>
                                </td>
                            </tr>

                        </table>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold"></label>
                            </div>
                            <div class="col-md-9">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! \App\Supports\CHTML::confirmModal('Enumerator', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

