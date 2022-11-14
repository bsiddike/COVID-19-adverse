<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">Age(s) Wise Affected</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <canvas id="affectedAgeWise"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
            </canvas>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            var doughnut = new Chart($('#affectedAgeWise').get(0).getContext('2d'),
                    {!!  json_encode($affectedAge) !!}
            );
        });
    </script>
@endpush