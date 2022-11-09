<div class="card-body">
    <div class="row">
        <div class="col-md-6">{!! Form::nText('vaers_id', 'Patient\'s ID', old('vaers_id', $vaccine->vaers_id ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_name', 'Vaccine Label', old('vax_name', $vaccine->vax_name ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_type', 'Vaccine Type', old('vax_type', $vaccine->vax_type ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_manu', 'Vaccine Manufacture', old('vax_manu', $vaccine->vax_manu ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_lot', 'Vaccine Number ', old('vax_lot', $vaccine->vax_lot ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_dose_series', 'Vaccine Dose', old('vax_dose_series', $vaccine->vax_dose_series ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_route', 'Vaccine Route', old('vax_route', $vaccine->vax_route ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_site', 'Vaccine Site', old('vax_site', $vaccine->vax_site ?? null), true) !!}</div>
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
