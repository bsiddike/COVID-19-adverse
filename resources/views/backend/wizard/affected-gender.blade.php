
<div class="col-md-4">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">Gender Wise Affected</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <ul class="chart-legend clearfix">
                        <li><i class="far fa-circle text-danger"></i>
                            Female ({{ $pieData['datasets'][0]['data'][0] }})
                        </li>
                        <li><i class="far fa-circle text-success"></i>
                            Male ({{ $pieData['datasets'][0]['data'][1] }})
                        </li>
                        <li><i class="far fa-circle text-warning"></i>
                            Unknown ({{ $pieData['datasets'][0]['data'][2] }})
                        </li>
                    </ul>
                </div>
                <div class="col-md-7">
                    <div class="chart-responsive">
                        <canvas id="pieChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            //-------------
            // - PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData = {!!  json_encode($pieData) !!};/*{
                            labels: [
                                'Chrome',
                                'IE',
                                'FireFox',
                                'Safari',
                                'Opera',
                                'Navigator'
                            ],
                            datasets: [
                                {
                                    data: [700, 500, 400, 600, 300, 100],
                                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
                                }
                            ]
                        }*/
            var pieOptions = {
                legend: {
                    display: false
                }
            }
            // Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            // eslint-disable-next-line no-unused-vars
            var pieChart = new Chart(pieChartCanvas, {
                type: 'doughnut',
                data: pieData,
                options: pieOptions
            })

            //-----------------
            // - END PIE CHART -
            //-----------------
        });
    </script>
@endpush