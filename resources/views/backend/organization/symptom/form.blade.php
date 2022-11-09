<div class="card-body">
    <div class="row">
        <div class="col-md-12">{!! Form::nText('vaers_id', 'Patient's ID', old('vaers_id', $symptom->vaers_id ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptom1', 'symptom 1', old('symptom1', $symptom->symptom1 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptomversion1', 'symptomversion1', old('symptomversion1', $symptom->symptomversion1 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptom2', 'symptom 2', old('symptom2', $symptom->symptom2 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptomversion2', 'symptomversion2', old('symptomversion2', $symptom->symptomversion2 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptom3', 'symptom 3', old('symptom3', $symptom->symptom3 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptomversion3', 'symptomversion3', old('symptomversion3', $symptom->symptomversion3 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptom4', 'symptom 4', old('symptom4', $symptom->symptom4 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptomversion4', 'symptomversion4', old('symptomversion4', $symptom->symptomversion4 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptom5', 'symptom 5', old('symptom5', $symptom->symptom5 ?? null), true) !!}</div>
 <div class="col-md-6">{!! Form::nText('symptomversion5', 'symptomversion5', old('symptomversion5', $symptom->symptomversion5 ?? null), true) !!}</div>
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


