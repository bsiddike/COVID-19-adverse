@php use App\Supports\CHTML; @endphp
@extends('layouts.frontend')

@section('title', 'Symptoms')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" type="text/css">
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
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($symptoms))
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped mb-0" id="employee-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>@sortablelink('vaccine.vax_name', 'Vaccine')</th>
                                        <th>@sortablelink('vaccine.vax_dose_series', 'Dose')</th>
                                        <th>@sortablelink('symptom1', 'symptom 1')</th>
                                        <th>@sortablelink('symptom2', 'symptom 2')</th>
                                        <th>@sortablelink('symptom3', 'symptom 3')</th>
                                        <th>@sortablelink('symptom4', 'symptom 4')</th>
                                        <th>@sortablelink('symptom5', 'symptom 5')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($symptoms as $index => $symptom)
                                        <tr>

                                            <td>{{ $symptom->vaccine->vax_name ?? null }}</td>
                                            <td>{{ $symptom->vaccine->vax_dose_series ?? null }}</td>
                                            <td>{{ $symptom->symptom1 ?? null }}</td>
                                            <td>{{ $symptom->symptom2 ?? null }}</td>
                                            <td>{{ $symptom->symptom3 ?? null }}</td>
                                            <td>{{ $symptom->symptom4 ?? null }}</td>
                                            <td>{{ $symptom->symptom5 ?? null }}</td>
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
    {!! CHTML::confirmModal('Enumerator', ['export', 'delete', 'restore']) !!}
@endsection


@push('plugin-script')
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('page-script')
    <script>

        var work_options = '{{request('work_options')}}';
        var prev_post_state_id = '{{request('prev_post_state_id')}}';
        var future_post_state_id = '{{request('future_post_state_id')}}';

        function toggleDropdowns(work_options) {
            if (work_options == 1) {
                $("#select-section").show();

                $("#future_post_state_id").prop("disabled", true);
                $("#future_post_state_id").parent().parent().hide();

                $("#prev_post_state_id").prop("disabled", false);
                $("#prev_post_state_id").parent().parent().show();

                $("#division_id").prop("disabled", false);
                $("#division_id").parent().parent().show();

            } else if (work_options == 2) {
                $("#select-section").show();
                $("#prev_post_state_id").prop("disabled", true);
                $("#prev_post_state_id").parent().parent().hide();

                $("#future_post_state_id").prop("disabled", false);
                $("#future_post_state_id").parent().parent().show();

                $("#division_id").prop("disabled", false);
                $("#division_id").parent().parent().show();

            } else {
                $("#select-section").hide();
                $("#prev_post_state_id").prop("disabled", true);
                $("#prev_post_state_id").parent().parent().hide();

                $("#future_post_state_id").prop("disabled", true);
                $("#future_post_state_id").parent().parent().hide();

                $("#division_id").prop("disabled", true);
                $("#division_id").parent().parent().hide();
            }
        }

        $(document).ready(function () {
            toggleDropdowns(work_options);


            $('input:radio[name="work_options"]').change(function () {
                $("#select-section").show();
                var value = $(this).val();
                toggleDropdowns(value);
                $("#division_id").val('').trigger('change');
            });

            $("#survey_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('symptom.Select a Survey Option') }}"
            });

            $("#prev_post_state_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('symptom.Select a Worked Earlier Option') }}"
            });
            $("#future_post_state_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('symptom.Select a Work in Future Option') }}"
            });
            $("#division_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('symptom.Select a Division Option') }}"
            });

            $('#clearAll').click(function () {
                $("#survey_id").val('').trigger('change');
                $("#division_id").val('').trigger('change');
                $("#prev_post_state_id").val('').trigger('change');
                $("#future_post_state_id").val('').trigger('change');
                $("#search").val('');
                $('input:radio[name="work_options"]').prop('checked', false);
            });
        });
    </script>
@endpush
