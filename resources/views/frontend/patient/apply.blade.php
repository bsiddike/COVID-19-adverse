@extends('layouts.frontend')

@section('title', 'Some Title')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('page-style')

@endpush


@section('breadcrumbs', Breadcrumbs::render(Route::getCurrentRoute()->getName()))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h2 class="card-title">Share your symptoms, Find appropriate medications</h2>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    {!! Form::open(['route' => 'frontend.patients.register', 'id' => 'patient-form']) !!}
                    @include('frontend.patient.form')
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection


@push('plugin-script')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endpush

@push('page-script')
    <script>
        $(document).ready(function () {
            $("#symptom1").select2({
                width: '100%',
                theme: 'bootstrap4',
                placeholder: "Please type or select your symptom",
                minimumInputLength: 5,
                clearSelection: true,
                templateResult: function (option) {
                    return option.text;
                },
                templateSelection: function (option) {
                    return option.text;
                },
                ajax: {
                    url: '{{ route('frontend.symptoms.search', 1) }}',
                    dataType: 'json',
                    delay: 100,
                    data: function (params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function (data) {
                        var results = data.map(option => {
                            return {id: option, text: option};
                        });

                        return {
                            'results': results
                        };
                    }
                }
            });
        });
    </script>
@endpush
