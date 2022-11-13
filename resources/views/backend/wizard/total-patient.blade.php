@can('backend.settings.users.index')
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3 id="total_patient">0</h3>

                <p>Patients</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-nurse"></i>
            </div>
            <a href="{{ query('backend.organization.patients.index', request()) }}"
               class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endcan

@push('page-script')
    <script>
        $(document).ready(function () {
            $.get('{{ route('backend.model.count', 'patient') }}', function (data) {
                $("#total_patient").html(data.count ?? 0);
            });
        });
    </script>
@endpush