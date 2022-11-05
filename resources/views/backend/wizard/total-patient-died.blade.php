@can('backend.settings.users.index')
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $patientsDied ?? 0 }}</h3>

                <p>Deaths</p>
            </div>
            <div class="icon">
                <i class="fas fa-sad-tear"></i>
            </div>
            <a href="{{ route('backend.organization.patients.index') }}"
               class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endcan