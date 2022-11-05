<div class="col-lg-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Monthly Affected</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="chart">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="lineChart"
                        style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 580px;"
                        class="chartjs-render-monitor" width="725" height="312"></canvas>
            </div>
        </div>

    </div>
</div>

@push('page-script')
    <script>

        $(function () {
            var lineChart = new Chart($('#lineChart').get(0).getContext('2d'),
                    {!! json_encode($affectedMonth) !!}
            );
        });
    </script>
@endpush