<div class="col-lg-4 col-md-6">
    <div class="card">
        <div class="card-header border-bottom-0">
            <h3 class="card-title">State wise Patients count</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="d-md-flex">
                <div class="p-1 flex-fill" style="overflow: hidden">
                    <div id="world-map-markers" style="overflow: hidden" class="mapael">
                        <div class="map" style="height: 260px !important;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('plugin-script')
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
@endpush

@push('page-script')
    <script>
        $(document).ready(function () {
            $.get('{{ route('backend.patient.charts', 'patient-state-map') }}',
                    {!! json_encode(request()->all()) !!},
                function (data) {
                    $('#world-map-markers').mapael(data);
                });
        });
    </script>
@endpush