<div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
        <div class="inner">
            <h3 id="total_vaccine">{{ $vaccines ?? 0 }}</h3>

            <p>Vaccines</p>
        </div>
        <div class="icon">
            <i class="fas fa-first-aid"></i>
        </div>
        <a href="{{ route('backend.organization.vaccines.index', request()->all()) }}"
           class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            $.get('{{ route('backend.model.count', 'vaccine') }}', function (data) {
                $("#total_vaccine").html(data.count ?? 0);
            });
        });
    </script>
@endpush
