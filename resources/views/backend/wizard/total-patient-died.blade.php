@can('backend.settings.users.index')
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $patientsDied ?? 0 }}</h3>

                <p>Died</p>
            </div>
            <div class="icon">
                <i class="fas fa-sad-tear"></i>
            </div>
            <a href="{{ query('backend.organization.patients.index', request()) }}"
               class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endcan