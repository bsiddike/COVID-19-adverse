<div class="card-body">
    <div class="row">
        <div class="col-md-6">{!! Form::nText('vaers_id', 'Patient's ID', old('vaers_id', $patient->vaers_id ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('recive_date', 'Receive Date', old('recive_date', $patient->recive_date ?? null), true) !!}</div>
	<div class="col-md-6">{!! Form::nText('state', 'State', old('state', $patient->state ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('age_yrs', 'Age Year', old('age_yrs', $patient->age_yrs ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('cage_yr', 'Cage Year', old('cage_yr', $patient->cage_yr ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('cage_mo', 'Cage Month', old('cage_mo', $patient->cage_mo ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('sex', 'Sex', old('sex', $patient->sex ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('rpt_date', 'Report Date', old('rpt_date', $patient->rpt_date ?? null), true) !!}</div>
        {{--<div class="col-md-6">{!! Form::nText('symptom_text', 'Symptoms History', old('symptom_text', $patient->symptom_text ?? null), true) !!}</div>--}}
        <div class="col-md-6">{!! Form::nText('died', 'Died', old('died', $patient->died ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('datedied', 'datedied', old('datedied', $patient->datedied ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('l_threat', 'Life threat', old('l_threat', $patient->l_threat ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('er_visit', 'Emergency Visit', old('er_visit', $patient->er_visit ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('hospital', 'Hospital', old('hospital', $patient->hospital ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('hospdays', 'hospdays', old('hospdays', $patient->hospdays ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('x_stay', 'Previous Condition', old('x_stay', $patient->x_stay ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('disable', 'Disable', old('disable', $patient->disable ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('recovd', 'Re-Covid19', old('recovd', $patient->recovd ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('vax_date', 'Vaccine date', old('vax_date', $patient->vax_date ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('onset_date', 'onset_date', old('onset_date', $patient->onset_date ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('numdays', 'numdays', old('numdays', $patient->numdays ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('lab_data', 'Lab Data', old('lab_data', $patient->lab_data ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('v_adminby', 'v_adminby', old('v_adminby', $patient->v_adminby ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('v_fundby', 'v_fundby', old('v_fundby', $patient->v_fundby ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('other_meds', 'other_meds', old('other_meds', $patient->other_meds ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('cur_ill', 'Current Illness', old('cur_ill', $patient->cur_ill ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('history', 'History', old('history', $patient->history ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('prior_vax', 'Prior Vaccine', old('prior_vax', $patient->prior_vax ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('splttype', 'splttype', old('splttype', $patient->splttype ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('form_vers', 'form_vers', old('form_vers', $patient->form_vers ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('todays_date', 'Todays Date', old('todays_date', $patient->todays_date ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('birth_defect', 'Birth Defect', old('birth_defect', $patient->birth_defect ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('ofc_visit', 'Office Visit', old('ofc_visit', $patient->ofc_visit ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('er_ed_visit', 'er_ed_visit', old('er_ed_visit', $patient->er_ed_visit ?? null), true) !!}</div>
        <div class="col-md-6">{!! Form::nText('allergies', 'Allergies', old('allergies', $patient->allergies ?? null), true) !!}</div>
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
