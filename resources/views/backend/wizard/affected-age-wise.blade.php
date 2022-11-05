<div class="col-md-6 col-sm-12">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">Age(s) Wise Affected</h3>
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