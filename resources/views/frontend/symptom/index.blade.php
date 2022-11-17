@php use App\Supports\CHTML; @endphp
@extends('layouts.frontend')

@section('title', 'Symptoms & Outcomes')

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



@section('breadcrumbs', Breadcrumbs::render())

@section('actions')
    {!! Html::linkButton('Add Symptoms', 'backend.organization.symptoms.create', [], 'fas fa-plus', 'success') !!}
    {{--    {!! Html::bulkDropdown('backend.organization.symptoms', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('backend.wizard.top-10-vaccine-record')
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($symptoms))
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped mb-0" id="employee-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>@sortablelink('patient.vaers_id', 'Patient\'s ID')</th>
                                        <th>@sortablelink('vaccine.vax_name', 'Vaccine')</th>
                                        <th>@sortablelink('vaccine.vax_dose_series', 'Dose')</th>
                                        <th>@sortablelink('patient.cur_ill', 'Current Illness')</th>
                                        <th>@sortablelink('symptom1', 'symptom 1')</th>
                                        <th>@sortablelink('symptom2', 'symptom 2')</th>
                                        <th>@sortablelink('symptom3', 'symptom 3')</th>
                                        <th>@sortablelink('symptom4', 'symptom 4')</th>
                                        <th>@sortablelink('symptom5', 'symptom 5')</th>
                                        <th>@sortablelink('patient.recovd', 'Re-Covid')</th>
                                        <th>@sortablelink('patient.hospital', 'Hospitalised')</th>
                                        <th>@sortablelink('patient.disable', 'Disabled')</th>
                                        <th>@sortablelink('patient.died', 'Died')</th>
                                        <th>@sortablelink('patient.allergies', 'Allergies')</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($symptoms as $index => $symptom)
                                        <tr>
                                            <td>
                                                <a href="{{ route('frontend.patients.show', $symptom->patient->id) }}">
                                                    {{ $symptom->patient->vaers_id ?? null }}
                                                </a>
                                            </td>
                                            <td>{{ $symptom->vaccine->vax_name ?? null }}</td>
                                            <td>{{ $symptom->vaccine->vax_dose_series ?? null }}</td>
                                            <td>{{ $symptom->patient->cur_ill ?? null }}</td>
                                            <td>{{ $symptom->symptom1 ?? null }}</td>
                                            <td>{{ $symptom->symptom2 ?? null }}</td>
                                            <td>{{ $symptom->symptom3 ?? null }}</td>
                                            <td>{{ $symptom->symptom4 ?? null }}</td>
                                            <td>{{ $symptom->symptom5 ?? null }}</td>
                                            <td>{{ $symptom->patient->recovd ?? null }}</td>
                                            <td>{{ $symptom->patient->hospital ?? null }}</td>
                                            <td>{{ $symptom->patient->disable ?? null }}</td>
                                            <td>{{ $symptom->patient->died ?? null }}</td>
                                            <td>{{ $symptom->patient->allergies ?? null }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="exclude-search text-center">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent pb-0">
                            {!! CHTML::pagination($symptoms) !!}
                        </div>
                    @else
                        <div class="card-body min-vh-100">

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection


@push('plugin-script')
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
@endpush

