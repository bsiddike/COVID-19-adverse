<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">Gender Wise Affected</h3>
        </div>
        <div class="card-body">
            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

{{--            <div class="row">
                <div class="col-md-5">
                    <ul class="chart-legend clearfix">
                        @php $total = array_sum($pieData['datasets'][0]['data']); @endphp
                        <li><i class="far fa-circle text-danger"></i>
                            Female ({{ percent($total, $pieData['datasets'][0]['data'][0]) }})
                        </li>
                        <li><i class="far fa-circle text-success"></i>
                            Male ({{ percent($total, $pieData['datasets'][0]['data'][1]) }})
                        </li>
                        <li><i class="far fa-circle text-warning"></i>
                            Unknown ({{ percent($total, $pieData['datasets'][0]['data'][2]) }})
                        </li>
                    </ul>
                </div>
                <div class="col-md-7">
                    <div class="chart-responsive">
                        <canvas id="pieChart" ></canvas>
                    </div>
                </div>
            </div>--}}
            <!-- /.row -->
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            var doughnut = new Chart($('#pieChart').get(0).getContext('2d'), {
                type: 'pie',
                data: {!!  json_encode($pieData) !!},
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend : {
                        position : 'left'
                    }
                }
            });
        });
    </script>
@endpush