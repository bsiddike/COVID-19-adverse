@php use Carbon\Carbon; @endphp
@php use App\Supports\CHTML; @endphp
@extends('layouts.app')

@section('title', $vaccine->name)

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

@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName(), $vaccine))

@section('actions')
    {!! Html::backButton('backend.organization.symptoms.index') !!}
    {!! Html::modelDropdown('backend.organization.symptoms', $vaccine->id, ['color' => 'success',
        'actions' => array_merge(['edit'], ($vaccine->deleted_at == null) ? ['delete'] : ['restore'])]) !!}
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
                                <td>{!! $vaccine->name   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Name(Bangla)') !!}</th>
                                <td>{!! $vaccine->name_bd   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Gender') !!}</th>
                                <td>{!! isset($vaccine->gender->name) ? $vaccine->gender->name : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!!  __('symptom.Date of Birth') !!}</th>
                                <td>@if($vaccine->dob != null)
                                        {!! Carbon::parse($vaccine->dob)->format('dS F, Y') !!}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{!!  __('symptom.Father Name') !!}</th>
                                <td>{!! $vaccine->father   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Mother Name') !!}</th>
                                <td> {!! $vaccine->mother   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.NID Number') !!}</th>
                                <td>{!! $vaccine->nid   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Present Address') !!}</th>
                                <td>{!! $vaccine->present_address   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Permanent Address') !!}</th>
                                <td> {!! $vaccine->permanent_address   ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Highest Educational Qualification') !!}</th>
                                <td>{!! isset($vaccine->examLevel->name) ? $vaccine->examLevel->name : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Mobile 1') !!}</th>
                                <td>{!! $vaccine->mobile_1   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Mobile 2') !!}</th>
                                <td> {!! $vaccine->mobile_2   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Email') !!}</th>
                                <td>{!! $vaccine->email   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Whatsapp Number') !!}</th>
                                <td>  {!! $vaccine->whatsapp   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Facebook ID') !!}</th>
                                <td>{!! $vaccine->facebook   ?? null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Select the district(s) where you have worked earlier (it can be multiple)') !!}</th>
                                <td>
                                    @forelse($vaccine->previousPostings as $state)
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
                                        @forelse($vaccine->futurePostings as $state)
                                            <li>{{  $state->name }}</li>
                                        @empty
                                            <li>No District Available</li>
                                        @endforelse
                                    </ul>

                                </td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Are you revenue staff of BBS?') !!}</th>
                                <td>{!! isset($vaccine->is_employee) ? ucfirst($vaccine->is_employee) : null !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Designation') !!}</th>
                                <td>{!! ($vaccine->is_employee == 'yes') ? $vaccine->designation :   'N/A' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Company Name') !!}</th>
                                <td>{!! ($vaccine->is_employee == 'yes') ? $vaccine->company :   'N/A' !!}</td>
                            </tr>
                            <tr>
                                <th>{!! __('symptom.Work Experience in BBS as Enumerator') !!}</th>
                                <td>
                                    <ul>
                                        @forelse($vaccine->surveys as $index => $survey)
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
    {!! CHTML::confirmModal('Enumerator', ['delete', 'restore']) !!}
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush

