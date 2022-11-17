@extends('layouts.frontend')

@section('title', 'Patient Support')

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
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h2 class="card-title">Share your symptoms, Find appropriate medications</h2>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    {!! Form::open(['route' => 'frontend.patients.register', 'id' => 'patient-form', 'method' => 'get']) !!}
                    {!! Form::hidden('search_column', 'other_meds') !!}
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="symptom1" class="col-sm-3 col-form-label">
                                Vaccine
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="vax_name" id="vax_name" required>
                                    <option value="">Please select a Vaccine</option>
                                    @foreach($vaccines as $vaccine)
                                        <option value="{{ $vaccine }}"
                                                @if(request()->get('vax_name') == $vaccine) selected @endif>
                                            {{ $vaccine }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom1" class="col-sm-3 col-form-label">
                                Gender
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="gender" id="gender" required>
                                    <option value="">Please select a Gender</option>
                                    @foreach(['M' => 'Male', 'F' => 'Female', 'U' => 'Unknown'] as $value => $gender)
                                        <option value="{{ $value }}"
                                                @if(request()->get('gender') == $gender) selected @endif>
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="symptom1" class="col-sm-3 col-form-label">
                                First Symptom
                                <span class="font-weight-bold text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom1" id="symptom1" required>
                                    @if(request()->has('symptom1'))
                                        <option value="{{ request()->get('symptom1') }}"
                                                selected>{{ request()->get('symptom1') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom2" class="col-sm-3 col-form-label">
                                Second Symptom
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom2" id="symptom2">
                                    @if(request()->has('symptom2'))
                                        <option value="{{ request()->get('symptom2') }}"
                                                selected>{{ request()->get('symptom2') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom3" class="col-sm-3 col-form-label">
                                Third Symptom
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom3" id="symptom3">
                                    @if(request()->has('symptom2'))
                                        <option value="{{ request()->get('symptom3') }}"
                                                selected>{{ request()->get('symptom3') }}</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom4" class="col-sm-3 col-form-label">
                                Forth Symptom
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom4" id="symptom4">
                                    @if(request()->has('symptom4'))
                                        <option value="{{ request()->get('symptom4') }}"
                                                selected>{{ request()->get('symptom4') }}</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="symptom5" class="col-sm-3 col-form-label">
                                Fifth Symptom
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control custom-select" name="symptom5" id="symptom5">
                                    @if(request()->has('symptom5'))
                                        <option value="{{ request()->get('symptom5') }}"
                                                selected>{{ request()->get('symptom5') }}</option>
                                    @endif

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
            @if(!empty($symptoms))
                <div class="col-12">
                    <div class="card">
                        <h3 class="card-header">Possible Medications Suggestions</h3>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped mb-0" id="employee-table">
                                    <thead class="thead-light">
                                    <tr>
                                        @if(request()->has('symptom1'))
                                            <th>Symptom 1</th>
                                        @endif
                                        @if(request()->has('symptom2'))
                                            <th>Symptom 2</th>
                                        @endif
                                        @if(request()->has('symptom3'))
                                            <th>Symptom 3</th>
                                        @endif
                                        @if(request()->has('symptom4'))
                                            <th>Symptom 4</th>
                                        @endif
                                        @if(request()->has('symptom5'))
                                            <th>Symptom 5</th>
                                        @endif
                                        <th>Suggestive Medications</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($symptoms as $index => $symptom)
                                        <tr>
                                            @if(request()->has('symptom1'))
                                                <td>{{ $symptom->symptom1 ?? null }}</td>
                                            @endif
                                            @if(request()->has('symptom2'))
                                                <td>{{ $symptom->symptom2 ?? null }}</td>
                                            @endif
                                            @if(request()->has('symptom3'))
                                                <td>{{ $symptom->symptom3 ?? null }}</td>
                                            @endif
                                            @if(request()->has('symptom4'))
                                                <td>{{ $symptom->symptom4 ?? null }}</td>
                                            @endif
                                            @if(request()->has('symptom5'))
                                                <td>{{ $symptom->symptom5 ?? null }}</td>
                                            @endif
                                            <td>{{ $symptom->other_meds ?? null }}</td>
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
                            {!! \App\Supports\CHTML::pagination($symptoms) !!}
                        </div>
                    </div>
                </div>
            @endif
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
                allowClear: true,
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
                allowClear: true,
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
                allowClear: true,
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
                allowClear: true,
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
                allowClear: true,
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
