<div class="col-md-6 col-sm-12">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">Most Repeated Outcomes</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <canvas id="top10VaccineOutcomes"
                    style="min-height: 458px; height: 458px; max-height: 458px; max-width: 100%;">
            </canvas>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            var doughnut = new Chart($('#top10VaccineOutcomes').get(0).getContext('2d'),
                    {!!  json_encode($vaccineOutcomes) !!}
            );
        });
    </script>
@endpush

