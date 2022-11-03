<div class="card-body">
    <div class="row">
        <div class="col-md-6">{!! Form::nText('vaers_id', 'vaers_id', old('vaers_id', $patient->vaers_id ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_type', 'vax_type', old('vax_type', $patient->vax_type ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_manu', 'vax_manu', old('vax_manu', $patient->vax_manu ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_lot', 'vax_lot', old('vax_lot', $patient->vax_lot ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_dose_series', 'vax_dose_series', old('vax_dose_series', $patient->vax_dose_series ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_route', 'vax_route', old('vax_route', $patient->vax_route ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_site', 'vax_site', old('vax_site', $patient->vax_site ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_name', 'vax_name', old('vax_name', $patient->vax_name ?? null), true) !!}</div>
    </div>
    <div class="row mt-3">
        <div class="col-12 justify-content-between d-flex">
            {!! Form::nCancel(__('common.Cancel')) !!}
            {!! Form::nSubmit('submit', __('common.Save')) !!}
        </div>
    </div>
</div>


@push('page-script')
    <script>
        $(function () {
            $("#survey-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    enabled: {
                        required: true
                    },
                    remarks: {},
                }
            });
        });
    </script>
@endpush
