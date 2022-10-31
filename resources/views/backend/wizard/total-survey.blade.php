@can('backend.organization.surveys.index')
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $vaccines ?? 0 }}</h3>

                <p>Vaccines</p>
            </div>
            <div class="icon">
                <i class="fas fa-first-aid"></i>
            </div>
            <a href="{{ route('backend.organization.patients.index') }}"
               class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endcan