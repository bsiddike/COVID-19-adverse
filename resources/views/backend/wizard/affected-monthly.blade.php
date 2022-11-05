<div class="col-lg-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Monthly Affected</h3>
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
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 580px;"
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