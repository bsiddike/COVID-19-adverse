@extends('layouts.app')

@section('title', 'Edit Vaccine')

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
    {!! Html::backButton('backend.organization.vaccines.index') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {!! Form::open(['route' => ['backend.organization.vaccines.update', $vaccine->id], 'method' => 'put', 'id' => 'vaccine-form']) !!}
                    @include('backend.organization.vaccine.form')
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
