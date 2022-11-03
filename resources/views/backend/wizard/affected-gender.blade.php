<div class="col-md-6 col-sm-12">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">Gender Wise Affected</h3>
        </div>
        <div class="card-body">
            <canvas id="affectedGender"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
            </canvas>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            var doughnut = new Chart($('#affectedGender').get(0).getContext('2d'), {
                type: 'doughnut',
                data: {!!  json_encode($affectedGender) !!},
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        position: 'left'
                    }

                }
            });
        });
    </script>
@endpush