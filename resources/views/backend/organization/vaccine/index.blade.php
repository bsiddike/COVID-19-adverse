@extends('layouts.app')

@section('title', 'Vaccines')

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
    {!! Html::linkButton( 'Add Vaccine', 'backend.organization.vaccines.create', [], 'fas fa-plus', 'success') !!}
{{--    {!! Html::bulkDropdown('backend.organization.vaccines', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    @if(!empty($vaccines))
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="employee-table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">{!! __('common.Actions') !!}</th>
                                        <th class="align-middle">
                                            @sortablelink('id', '#')</th>
                                        <th>@sortablelink('vaers_id', 'Patient\'s ID')</th>
                                        <th>@sortablelink('vax_name', 'Label')</th>
                                        <th>@sortablelink('vax_type', 'Type')</th>
                                        <th>@sortablelink('vax_manu', 'Manufacture')</th>
                                        <th>@sortablelink('vax_lot', 'Number')</th>
                                        <th>@sortablelink('vax_dose_series', 'Dose')</th>
                                        <th>@sortablelink('vax_route', 'Route')</th>
                                        <th>@sortablelink('vax_site', 'Site')</th>
                                        <th class="text-center">@sortablelink('created_at', __('common.Created'))</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($vaccines as $index => $vaccine)
                                        <tr @if($vaccine->deleted_at != null) class="table-danger" @endif>
                                            <td class="exclude-search pr-3 text-center align-middle">
                                                {!! Html::actionDropdown('backend.organization.vaccines', $vaccine->id, array_merge(['show', 'edit'], ($vaccine->deleted_at == null) ? ['delete'] : ['restore'])) !!}
                                            </td>

                                            <td class="exclude-search align-middle">
                                                {{ $vaccine->id }}
                                            </td>
                                            <td>{{ $vaccine->vaers_id }}</td>
                                            <td>{{ $vaccine->vax_type }}</td>
                                            <td>{{ $vaccine->vax_name }}</td>
                                            <td>{{ $vaccine->vax_manu }}</td>
                                            <td>{{ $vaccine->vax_lot }}</td>
                                            <td>{{ $vaccine->vax_dose_series }}</td>
                                            <td>{{ $vaccine->vax_route }}</td>
                                            <td>{{ $vaccine->vax_site }}</td>
                                            <td class="text-center">{{ $vaccine->created_at->format(config('backend.datetime')) ?? '' }}</td>
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
                            {!! \App\Supports\CHTML::pagination($vaccines) !!}
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
    {!! \App\Supports\CHTML::confirmModal('Enumerator', ['export', 'delete', 'restore']) !!}
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
                placeholder: "{{ __('vaccine.Select a Survey Option') }}"
            });

            $("#prev_post_state_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('vaccine.Select a Worked Earlier Option') }}"
            });
            $("#future_post_state_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('vaccine.Select a Work in Future Option') }}"
            });
            $("#division_id").select2({
                width: "100%",
                allowClear: true,
                placeholder: "{{ __('vaccine.Select a Division Option') }}"
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
