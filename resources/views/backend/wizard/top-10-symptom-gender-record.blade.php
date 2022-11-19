<div class="col-lg-12">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">Gender Wise Symptoms</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <canvas id="genderOutcomesVaccine"
                    style="min-height: 458px; height: 458px; max-height: 458px; max-width: 100%;">
            </canvas>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            $.get('{{ route('backend.symptom.charts', 'vaccine-outcome') }}',
                    {!!  json_encode(request()->all()) !!},
                function (data) {
                    var doughnut = new Chart($('#genderOutcomesVaccine')
                        .get(0)
                        .getContext('2d'), data);
                });
        });
    </script>
@endpush

