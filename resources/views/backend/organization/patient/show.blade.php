@php use App\Supports\CHTML; @endphp
@extends('layouts.app')

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

@section('actions')
    {!! Html::backButton('backend.organization.patients.index') !!}
    {{--    {!! \Html::modelDropdown('backend.organization.patients', $patient->id, ['color' => 'success',
            'actions' => array_merge(['edit'], ($patient->deleted_at == null) ? ['delete'] : ['restore'])]) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body min-vh-100">
                        <div class="row mb-3">
                            <div class="col-md-6"><label class="d-block">Name</label>
                                <p class="font-weight-bold">{{ $patient->name ?? null }}</p></div>
                            <div class="col-md-6">
                                <label class="d-block">Enabled</label>
                                <p class="font-weight-bold"></p>
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

