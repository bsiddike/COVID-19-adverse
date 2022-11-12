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
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="symptom1" class="col-sm-3 col-form-label">
                                First Symptom
                                <span class="font-weight-bold text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom1" id="symptom1" required>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom2" class="col-sm-3 col-form-label">
                                Second Symptom
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom2" id="symptom2">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom3" class="col-sm-3 col-form-label">
                                Third Symptom
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom3" id="symptom3">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom4" class="col-sm-3 col-form-label">
                                Forth Symptom
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom4" id="symptom4">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom5" class="col-sm-3 col-form-label">
                                Fifth Symptom
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom5" id="symptom5">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        {!! Form::nSubmit('submit', 'Search') !!}
                    </div>
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
                tags: true,
                placeholder: "Please type or select your symptom",
                minimumInputLength: 3,
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
            $("#symptom2").select2({
                width: '100%',
                theme: 'bootstrap4',
                tags: true,
                placeholder: "Please type or select your symptom",
                minimumInputLength: 3,
                clearSelection: true,
                templateResult: function (option) {
                    return option.text;
                },
                templateSelection: function (option) {
                    return option.text;
                },
                ajax: {
                    url: '{{ route('frontend.symptoms.search', 2) }}',
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
            $("#symptom3").select2({
                width: '100%',
                theme: 'bootstrap4',
                tags: true,
                placeholder: "Please type or select your symptom",
                minimumInputLength: 3,
                clearSelection: true,
                templateResult: function (option) {
                    return option.text;
                },
                templateSelection: function (option) {
                    return option.text;
                },
                ajax: {
                    url: '{{ route('frontend.symptoms.search', 3) }}',
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
            $("#symptom4").select2({
                width: '100%',
                theme: 'bootstrap4',
                tags: true,
                placeholder: "Please type or select your symptom",
                minimumInputLength: 3,
                clearSelection: true,
                templateResult: function (option) {
                    return option.text;
                },
                templateSelection: function (option) {
                    return option.text;
                },
                ajax: {
                    url: '{{ route('frontend.symptoms.search', 4) }}',
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
            $("#symptom5").select2({
                width: '100%',
                theme: 'bootstrap4',
                tags: true,
                placeholder: "Please type or select your symptom",
                minimumInputLength: 3,
                clearSelection: true,
                templateResult: function (option) {
                    return option.text;
                },
                templateSelection: function (option) {
                    return option.text;
                },
                ajax: {
                    url: '{{ route('frontend.symptoms.search', 5) }}',
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
