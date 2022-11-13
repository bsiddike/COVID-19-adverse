@can('backend.settings.users.index')
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 id="total_patient_died">{{ $patientsDied ?? 0 }}</h3>

                <p>Died</p>
            </div>
            <div class="icon">
                <i class="fas fa-sad-tear"></i>
            </div>
            <a href="{{ route('backend.organization.patients.died', array_merge(request()->all(), ['died'=>true])) }}"
               class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endcan

@push('page-script')
    <script>
        $(document).ready(function () {
            $.get('{{ route('backend.model.count', 'patient') }}?died=1', function (data) {
                $("#total_patient_died").html(data.count ?? 0);
            });
        });
    </script>
@endpush