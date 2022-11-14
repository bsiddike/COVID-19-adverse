@can('backend.settings.users.index')
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3 id="total_patient_hospitilized">{{ $patientsHospitalized ?? 0 }}</h3>

                <p>Hospitalized</p>
            </div>
            <div class="icon">
                <i class="fas fa-bed"></i>
            </div>
            <a href="{{ route('backend.organization.patients.hospitalized', array_merge(request()->all(), ['hospitalized'=>true])) }}"
               class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endcan

@push('page-script')
    <script>
        $(document).ready(function () {
            $.get('{{ route('backend.model.count', 'patient') }}?hospitalized=1', function (data) {
                $("#total_patient_hospitilized").html(data.count ?? 0);
            });
        });
    </script>
@endpush