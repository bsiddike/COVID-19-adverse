<div class="col-lg-4 col-md-6 col-sm-12">
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
            <canvas id="symptomGender"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
            </canvas>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            $.get('{{ route('backend.symptom.charts', 'symptom-piechart-gender') }}',
                {!! json_encode(request()->all()) !!},
                function (data) {
                    var doughnut = new Chart($('#symptomGender')
                        .get(0)
                        .getContext('2d'), data);
                });
        });
    </script>
@endpush