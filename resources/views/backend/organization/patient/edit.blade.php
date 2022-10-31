@extends('layouts.app')

@section('title', __('patient.Edit Survey'))

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

{{\Route::getCurrentRoute()->getName()}}

{{--@section('breadcrumbs', Breadcrumbs::render(, $patient))--}}

@section('actions')
    {!! Html::backButton('backend.organization.patients.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! Form::open(['route' => ['backend.organization.patients.update', $patient->id], 'method' => 'put', 'id' => 'patient-form']) !!}
                    @include('backend.organization.patient.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
