@extends('layouts.frontend')

@section('title', 'Home')

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



{{--@section('breadcrumbs', Breadcrumbs::render())--}}

@section('actions')
    {{--
    {!! Html::linkButton(__('enumerator.Add Enumerator'), 'backend.organization.enumerators.create', [], 'fas fa-plus', 'success') !!}
    {!! \Html::bulkDropdown('backend.organization.enumerators', 0, ['color' => 'warning']) !!}
    --}}
@endsection

@section('content')

@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
