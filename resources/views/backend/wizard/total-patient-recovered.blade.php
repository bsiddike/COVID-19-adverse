@can('backend.settings.users.index')
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-indigo">
            <div class="inner">
                <h3>{{ $patientsRecovered ?? 0 }}</h3>

                <p>Re-Covid19</p>
            </div>
            <div class="icon">
                <i class="fas fa-smile"></i>
            </div>
            <a href="{{ route('backend.organization.patients.index', array_merge(request()->all(), ['recovered'=>true])) }}"
               class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endcan