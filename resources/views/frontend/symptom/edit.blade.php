@extends('layouts.frontend')

@section('title', 'Edit Symptom')

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
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! Form::open(['route' => ['backend.organization.symptoms.update', $symptom->id], 'method' => 'put', 'id' => 'symptom-form']) !!}
                    @include('backend.organization.symptom.form')
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
