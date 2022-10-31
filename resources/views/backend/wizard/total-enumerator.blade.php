<div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
        <div class="inner">
            <h3>{{ $symptoms ?? 0 }}</h3>

            <p>Symptoms</p>
        </div>
        <div class="icon">
            <i class="fas fa-viruses"></i>
        </div>
        <a href="{{ route('backend.organization.patients.index') }}"
           class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>