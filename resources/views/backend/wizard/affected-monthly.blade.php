<div class="col-lg-12">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">Monthly Affected</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
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
        $(document).ready(function () {
            $.get('{{ route('backend.patient.charts', 'asset-month') .'?' . http_build_query(request()->all()) }}',
                function (data) {
                    var doughnut = new Chart($('#lineChart')
                        .get(0)
                        .getContext('2d'), data);
                });
        });
    </script>
@endpush